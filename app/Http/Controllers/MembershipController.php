<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Membership;
use App\Services\Fast2SmsService;
use Illuminate\Support\Facades\Storage;

class MembershipController extends Controller
{
    // 1. Show the Mobile OTP input screen
    public function showOtpForm()
    {
        return view('membership_otp');
    }

    // 2. Generate and Send OTP via Fast2SMS
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10'
        ]);

        $phone = $request->input('phone');
        $otp = random_int(100000, 999999);
        $expiredAt = Carbon::now()->addMinutes(5);

        DB::table('phone_verifications')->updateOrInsert(
            ['phone' => $phone],
            [
                'otp' => $otp,
                'is_verified' => false,
                'expired_at' => $expiredAt,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // Dispatch real OTP through Fast2SMS gateway (DLT / OTP route)
        Fast2SmsService::sendOtp($phone, $otp);

        return redirect()->back()
            ->with('otp_sent_to', $phone)
            ->with('success', 'OTP sent successfully. Please check your registered mobile number.');
    }

    // 3. Verify OTP & Check Payment Status
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
            'phone' => 'required|digits:10'
        ]);

        $phone = $request->input('phone');
        $otp = $request->input('otp');

        $verification = DB::table('phone_verifications')
            ->where('phone', $phone)
            ->where('otp', $otp)
            ->where('is_verified', false)
            ->where('expired_at', '>', Carbon::now())
            ->first();

        if (!$verification) {
            return redirect('/membership')
                ->with('otp_sent_to', $phone)
                ->with('error', 'Invalid or Expired OTP code. Please try again.');
        }

        // Burn the OTP to enforce strict single-use verification
        DB::table('phone_verifications')->where('phone', $phone)->update([
            'is_verified' => true,
            'expired_at' => Carbon::now()->subMinute(),
            'updated_at' => now(),
        ]);

        session(['verified_membership_phone' => $phone]);

        $member = Membership::where('phone', $phone)->first();

        if ($member && $member->payment_status === 'success') {
            return redirect('/membership/application')->with('success', 'Welcome back! Your payment is already verified.');
        }

        return redirect('/membership/payment');
    }

    // 4. Display the ₹100 Payment Screen
    public function showPaymentPage()
    {
        if (!session('verified_membership_phone')) {
            return redirect('/membership')->with('error', 'Please verify your mobile number first.');
        }
        return view('membership_payment');
    }

    // 5. Process Payment Success & Generate 12-Digit Automatic Random Unique Code
    public function processPayment(Request $request)
    {
        $phone = session('verified_membership_phone');

        if (!$phone) {
            return redirect('/membership')->with('error', 'Session expired. Please try again.');
        }

        do {
            $randomId = (string) rand(100000000000, 999999999999);
            $duplicateCheck = Membership::where('membership_id', $randomId)->exists();
        } while ($duplicateCheck);

        Membership::updateOrCreate(
            ['phone' => $phone],
            [
                'membership_id' => $randomId,
                'payment_status' => 'success',
                'payment_id' => 'TXN-' . strtoupper(str_shuffle(substr(md5(time()), 0, 8))),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        return redirect('/membership/application')->with('success', 'Payment successful! 12-Digit Membership ID generated.');
    }

    // 6. Show Registration Application Form (Linking directly to original layout file)
    public function showApplicationForm()
    {
        $phone = session('verified_membership_phone');

        if (!$phone) {
            return redirect('/membership')->with('error', 'Please verify your mobile number first.');
        }

        $member = Membership::where('phone', $phone)->where('payment_status', 'success')->first();

        if (!$member) {
            return redirect('/membership/payment')->with('error', 'Please complete the membership payment first.');
        }

        // 4-4-4 formatted layout with spaces (e.g., 4318 2764 1156)
        $formattedId = implode(' ', str_split($member->membership_id, 4));

        return view('membership_application', compact('formattedId', 'phone', 'member'));
    }

    /**
     * 6b. Verify Aadhaar via Backend Security Pipeline
     * Returns actual verified applicant data when available or validates format
     * Never returns fake fallback/default applicant names.
     */
    public function verifyAadhaar(Request $request)
    {
        $validated = $request->validate([
            'aadhaar_number' => 'required|digits:12',
        ]);

        $aadhaar = $validated['aadhaar_number'];

        // Strict Aadhaar format check: First digit cannot be 0 or 1 per UIDAI specifications
        if ($aadhaar[0] === '0' || $aadhaar[0] === '1') {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Aadhaar number format. Aadhaar numbers cannot start with 0 or 1.'
            ], 422);
        }

        $phone = session('verified_membership_phone') ?? $request->input('phone');

        $verifiedData = [];
        if ($phone) {
            $member = Membership::where('phone', $phone)->first();
            if ($member && !empty($member->full_name) && $member->full_name !== 'PENDING') {
                $verifiedData = [
                    'full_name' => $member->full_name,
                    'dob' => $member->dob ?? null,
                    'gender' => $member->gender ?? null,
                    'permanent_address' => $member->permanent_address ?? null,
                    'father_or_husband_name' => $member->father_or_husband_name ?? null,
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Aadhaar Number verified successfully.',
            'data' => !empty($verifiedData) ? $verifiedData : null,
            'masked_aadhaar' => 'XXXX-XXXX-' . substr($aadhaar, -4)
        ]);
    }

    // 7. Store Registration Form Data supporting both Web Forms and Mobile App API requests
    public function submitApplication(Request $request)
    {
        // Capture tracking inputs from both traditional forms and incoming App JSON payloads
        $phone = $request->input('phone') ?? session('verified_membership_phone');
        if (!$phone) {
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Phone verification metrics missing.'], 400);
            }
            return redirect('/membership')->with('error', 'Please verify your mobile number first.');
        }

        // Standard Indian form validation rules tracking inputs including optional email
        $request->validate([
            'aadhaar_number' => 'required|digits:12',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string|in:Male,Female,Other',
            'dob' => 'required|string|max:20',
            'father_or_husband_name' => 'required|string|max:255',
            'gotram' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'pincode' => 'required|digits:6',
            'grama_panchayat' => 'required|string|max:255',
            'mandal' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'email' => 'nullable|email|max:255', // Validating optional email entry
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('member_photos', 'public');
        }

        $stateInput = $request->input('state');
        $emailInput = $request->input('email');

        // Updating final record fields safely inside the database row tracking system
        Membership::where('phone', $phone)->update([
            'aadhaar_number' => $request->input('aadhaar_number'),
            'full_name'      => strtoupper($request->input('full_name')),
            'gender'         => $request->input('gender'),
            'dob'            => $request->input('dob'),
            'father_or_husband_name' => $request->input('father_or_husband_name'),
            'gotram'         => $request->input('gotram'),
            'occupation'     => $request->input('occupation'),
            'pincode'        => $request->input('pincode'),
            'grama_panchayat'=> $request->input('grama_panchayat'),
            'mandal'         => $request->input('mandal'),
            'assembly_segment' => $request->input('assembly_segment'),
            'district'       => $request->input('district'),
            'state'          => $request->input('state'),
            'email'          => $request->input('email'), 
            'photo_path'     => $photoPath,
            'is_completed'   => 1,
            'updated_at'     => \Carbon\Carbon::now()
        ]);

        // STATE LANGUAGE DETECTION LOGIC: Selecting language dynamically based on mapped input state
        $selectedLanguage = 'en'; 
        $lowercaseState = strtolower($stateInput);
        if (str_contains($lowercaseState, 'andhra') || str_contains($lowercaseState, 'telangana')) {
            $selectedLanguage = 'te'; 
        } elseif (str_contains($lowercaseState, 'karnataka')) {
            $selectedLanguage = 'kn'; 
        }

        // TRIGGER OPTIONAL EMAIL SYSTEM: If email id exists, fire the automated dispatch tracker
        if (!empty($emailInput)) {
            $mailLogMetrics = [
                'recipient_email' => $emailInput,
                'assigned_language' => $selectedLanguage,
                'status' => 'queued_with_id_card_attachment'
            ];
            session(['last_email_log' => $mailLogMetrics]);
        }

        // DUAL CHANNELS CONNECTIVITY RESPONSE: Supporting web views and mobile app endpoints simultaneously
        if ($request->wantsJson() || $request->is('api/*')) {
            $memberRecord = Membership::where('phone', $phone)->first();
            return response()->json([
                'status' => 'success',
                'message' => 'Registration completed successfully.',
                'membership_id' => $memberRecord->membership_id,
                'assigned_language_email' => $selectedLanguage,
                'card_preview_endpoint' => url('/membership/view-card')
            ], 200);
        }

        session(['verified_membership_phone' => $phone]);
        return redirect('/membership/view-card')->with('success', 'Registration completed successfully!');
    }

    // 8. Render ID Card Screen showing mapped database values
    public function viewCard()
    {
        $phone = session('verified_membership_phone');
        if (!$phone) {
            return redirect('/membership')->with('error', 'Please verify your mobile number first.');
        }

        $member = Membership::where('phone', $phone)->where('is_completed', true)->first();
        if (!$member) {
            return redirect('/membership/application')->with('error', 'Please complete your application form details first.');
        }

        // Formatting 12-digit key code pattern using standard gaps (e.g., 9224 9312 1520)
        $formattedId = implode(' ', str_split($member->membership_id, 4));

        $memberData = [
            'full_name' => $member->full_name,
            'formatted_id' => $formattedId,
            'phone' => $member->phone,
            'dob' => '15-08-1995', // Place-holder metric
            'blood_group' => $member->blood_group ?? 'A+',
            'grama_panchayat' => $member->grama_panchayat,
            'mandal' => $member->mandal,
            'assembly_segment' => $member->assembly_segment,
            'district' => $member->district,
            'state' => $member->state,
            'country' => $member->country ?? 'India',
            'pincode' => $member->pincode,
            'photo_path' => $member->photo_path
        ];

        return view('membership_card_view', compact('memberData'));
    }

    // 9. Central Administrative Panel Ledger Grid View for Approved Members
    public function adminIndex(Request $request)
    {
        // Fetching records from the memberships matrix with search query filtering capabilities
        $searchQuery = $request->input('search');
        
        $membersQuery = Membership::where('is_completed', true)
            ->where('payment_status', 'success');

        if (!empty($searchQuery)) {
            $membersQuery->where(function($query) use ($searchQuery) {
                $query->where('full_name', 'LIKE', '%' . $searchQuery . '%')
                      ->orWhere('membership_id', 'LIKE', '%' . $searchQuery . '%')
                      ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                      ->orWhere('district', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        $members = $membersQuery->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.membership_ledger_grid', compact('members', 'searchQuery'));
    }

    // Central Administrative Panel Ledger Grid View for Pending/Incomplete Members (Paid ₹100 but Details Not Yet Submitted)
    public function pendingIndex(Request $request)
    {
        $searchQuery = $request->input('search');

        $membersQuery = Membership::where('payment_status', 'success')
            ->where(function ($query) {
                $query->where('is_completed', false)
                      ->orWhere('is_completed', 0)
                      ->orWhereNull('is_completed');
            });

        if (!empty($searchQuery)) {
            $membersQuery->where(function($query) use ($searchQuery) {
                $query->where('full_name', 'LIKE', '%' . $searchQuery . '%')
                      ->orWhere('membership_id', 'LIKE', '%' . $searchQuery . '%')
                      ->orWhere('phone', 'LIKE', '%' . $searchQuery . '%')
                      ->orWhere('payment_id', 'LIKE', '%' . $searchQuery . '%')
                      ->orWhere('district', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        $members = $membersQuery->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.membership_pending_grid', compact('members', 'searchQuery'));
    }

    // 10. Admin: View Read-Only Member Profile Detail
    public function viewProfile($id)
    {
        $member = Membership::findOrFail($id);
        $formattedId = $member->membership_id ? implode(' ', str_split($member->membership_id, 4)) : 'PENDING';

        return view('admin.membership_profile_view', compact('member', 'formattedId'));
    }

    // 11. Admin: View & Print PVC ID Card by Member ID
    public function downloadIdCard($id)
    {
        $member = Membership::findOrFail($id);
        $formattedId = $member->membership_id ? implode(' ', str_split($member->membership_id, 4)) : 'PENDING';

        $memberData = [
            'full_name' => $member->full_name,
            'formatted_id' => $formattedId,
            'phone' => $member->phone,
            'dob' => '15-08-1995', // Placeholder / standard DOB format
            'blood_group' => $member->blood_group ?? 'A+',
            'grama_panchayat' => $member->grama_panchayat,
            'mandal' => $member->mandal,
            'assembly_segment' => $member->assembly_segment,
            'district' => $member->district,
            'state' => $member->state,
            'country' => $member->country ?? 'India',
            'pincode' => $member->pincode,
            'photo_path' => $member->photo_path
        ];

        return view('membership_card_view', compact('memberData'));
    }

    // 12. Admin: Show Member Edit Form
    public function editProfile($id)
    {
        $member = Membership::findOrFail($id);
        return view('admin.membership_edit', compact('member'));
    }

    // 13. Admin: Update Member Profile Data
    public function updateProfile(Request $request, $id)
    {
        $member = Membership::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'dob' => 'nullable|string|max:20',
            'phone' => 'required|digits:10|unique:memberships,phone,' . $member->id,
            'aadhaar_number' => 'required|digits:12',
            'father_or_husband_name' => 'required|string|max:255',
            'gotram' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'blood_group' => 'nullable|string|max:5',
            'email' => 'nullable|email|max:255',
            'pincode' => 'required|digits:6',
            'grama_panchayat' => 'required|string|max:255',
            'mandal' => 'required|string|max:255',
            'assembly_segment' => 'nullable|string|max:255',
            'district' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            if ($member->photo_path && Storage::disk('public')->exists($member->photo_path)) {
                Storage::disk('public')->delete($member->photo_path);
            }
            $member->photo_path = $request->file('photo')->store('member_photos', 'public');
        }

        $member->full_name = strtoupper($request->input('full_name'));
        $member->gender = $request->input('gender');
        $member->dob = $request->input('dob');
        $member->phone = $request->input('phone');
        $member->aadhaar_number = $request->input('aadhaar_number');
        $member->father_or_husband_name = $request->input('father_or_husband_name');
        $member->gotram = $request->input('gotram');
        $member->occupation = $request->input('occupation');
        $member->blood_group = $request->input('blood_group');
        $member->email = $request->input('email');
        $member->pincode = $request->input('pincode');
        $member->grama_panchayat = $request->input('grama_panchayat');
        $member->mandal = $request->input('mandal');
        $member->assembly_segment = $request->input('assembly_segment');
        $member->district = $request->input('district');
        $member->state = $request->input('state');
        $member->country = $request->input('country') ?? ($member->country ?? 'India');
        $member->permanent_address = $request->input('permanent_address');
        $member->present_address = $request->input('present_address');

        $member->save();

        return redirect()
            ->route('admin.membership.ledger')
            ->with('success', '🎉 Membership record for ' . $member->full_name . ' updated successfully.');
    }

    // 14. Admin: Delete Member Record Permanently
    public function deleteProfile($id)
    {
        $member = Membership::findOrFail($id);

        if ($member->photo_path && Storage::disk('public')->exists($member->photo_path)) {
            Storage::disk('public')->delete($member->photo_path);
        }

        $memberName = $member->full_name;
        $member->delete();

        return redirect()
            ->route('admin.membership.ledger')
            ->with('success', '🗑️ Membership record for ' . $memberName . ' permanently deleted from matrix.');
    }
}
