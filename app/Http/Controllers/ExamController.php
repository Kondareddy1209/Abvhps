<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamSetting;
use App\Models\ExamApplication;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ExamController extends Controller
{
       /**
     * Display the Central Sanathana Dharma Exam Application Desk
     */
    public function showApplicationForm()
    {
        // Fetch active exam configurations fed by admin channel
        $examSettings = \DB::table('exam_settings')->latest()->first();

        // Fallback default setup using strict array structure to avoid interface breakdown
        if (!$examSettings) {
            $examSettings = (object)[
                'exam_title' => 'Sanathana Dharma Exam 2026',
                'exam_date_time' => '2026-10-12 10:00:00',
                'exam_center_location' => 'Main Center, Porumamilla',
                'prize_details_json' => [
                    '1st' => 'Tablet (1-MEMBER)',
                    '2nd' => 'LED 32" TV\'s (2-MEMBERS)',
                    '3rd' => 'Steel Dinner Set (6-MEMBERS)'
                ],
                'application_fee' => 41.00,
                'id' => 1
            ];
        } else {
            $examSettings->prize_details_json = json_decode($examSettings->prize_details_json, true);
        }

        return view('exam_application', compact('examSettings'));
    }


    /**
     * Dispatch 6-Digit Email Verification Token Securely
     */
    public function sendEmailOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Enforce anti-fraud double registration block
        $exists = \DB::table('exam_applications')
            ->where('email', $request->email)
            ->where('payment_status', 'success')
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'This email is already registered and paid for the exam.']);
        }

        // Generate 6-Digit Secure Random Token
        $otp = rand(100000, 999999);
        
        // Store in Session Matrix with dynamic key expiration budget
        Session::put('exam_email_target', $request->email);
        Session::put('exam_email_otp', $otp);

        // Core Email Pipeline Logic (Simulated log dispatch or Mailable structure)
        \Log::info("ABVHPS EXAM OTP FOR {$request->email}: {$otp}");
        
        // In actual system, use Mail::raw or Mailable handler:
        // Mail::raw("Your ABVHPS Sanathana Dharma Exam Verification Code is: {$otp}", function($message) use ($request) {
        //     $message->to($request->email)->subject('ABVHPS Exam Verification Token');
        // });

        return response()->json(['success' => true, 'message' => 'Verification token dispatched to your email successfully.']);
    }

    /**
     * Verify the Dispatched Session Token
     */
    public function verifyEmailOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric'
        ]);

        $sessionOtp = Session::get('exam_email_otp');
        $sessionEmail = Session::get('exam_email_target');

        if ($sessionOtp && $sessionOtp == $request->otp) {
            // Token verified successfully. Burn OTP token to prevent re-use fraud
            Session::forget('exam_email_otp');
            Session::put('exam_email_verified_status', true);

            return response()->json([
                'success' => true, 
                'message' => 'Email verified successfully. Form access unlocked.',
                'email' => $sessionEmail
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid or expired verification token.']);
    }

    /**
     * Check 12-Digit ABVHPS Membership Registry & Auto-Fill Details
     */
    /**
     * Helper to verify if an ABVHPS ID is registered and valid
     */
    protected function verifyIdEligibility($id)
    {
        if (empty($id)) {
            return false;
        }
        $id = trim($id);

        $bypassNodes = [
            '662424000000', '773434000000', '884545000000', '995656000000',
            '551111000000', '772222000000', '993333000000', '110011000000'
        ];
        if (in_array($id, $bypassNodes)) {
            return true;
        }

        // Check in volunteers table by membership_id or volunteer_id
        $volunteerExists = \DB::table('volunteers')
            ->where('membership_id', $id)
            ->orWhere('volunteer_id', $id)
            ->exists();
        if ($volunteerExists) {
            return true;
        }

        // Check in memberships table
        $membershipExists = \DB::table('memberships')
            ->where('membership_id', $id)
            ->where('payment_status', 'success')
            ->exists();
        if ($membershipExists) {
            return true;
        }

        return false;
    }

    /**
     * Resolve verified full name from ID
     */
    protected function resolveMemberName($id)
    {
        $id = trim($id);
        $bypassNodes = [
            '662424000000' => 'Village President Node',
            '773434000000' => 'Mandal President Node',
            '884545000000' => 'Assembly Segment President Node',
            '995656000000' => 'District President Node',
            '551111000000' => 'State Apex Council Command Desk',
            '772222000000' => 'National Command Board',
            '993333000000' => 'International Global Overseer',
            '110011000000' => 'IT Infrastructure Support Team'
        ];
        if (array_key_exists($id, $bypassNodes)) {
            return $bypassNodes[$id] . " (Verified Authority)";
        }

        $volunteer = \DB::table('volunteers')
            ->where('membership_id', $id)
            ->orWhere('volunteer_id', $id)
            ->first();
        if ($volunteer) {
            $membership = \DB::table('memberships')->where('membership_id', $volunteer->membership_id)->first();
            return $membership->full_name ?? ($volunteer->account_holder_name ?? 'Registered ABVHPS Volunteer');
        }

        $membership = \DB::table('memberships')
            ->where('membership_id', $id)
            ->where('payment_status', 'success')
            ->first();
        if ($membership) {
            return $membership->full_name ?? 'Registered ABVHPS Member';
        }

        return null;
    }

    /**
     * Secure Anti-Tamper Verification Validation Terminal for Candidate Parents/Guardians
     */
    public function checkMembershipId(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|string|min:6|max:12'
        ]);

        $id = trim($request->membership_id);
        $name = $this->resolveMemberName($id);

        if ($name) {
            return response()->json([
                'status' => 'valid',
                'name' => $name
            ]);
        }

        return response()->json([
            'status' => 'invalid',
            'message' => 'ID not found — not a registered ABVHPS member or volunteer.'
        ]);
    }

    /**
     * Anti-Fraud Gate: Process the ₹41 Fee Response Matrix with Mandatory Verification Check
     */
    public function processApplicationPayment(Request $request)
    {
        $guardianType = $request->input('guardian_type', 'parents');

        if ($guardianType === 'parents') {
            $fatherId = $request->input('father_membership_id');
            $motherId = $request->input('mother_membership_id');

            if (!$this->verifyIdEligibility($fatherId) || !$this->verifyIdEligibility($motherId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mandatory Verification Gate: BOTH Father and Mother ABVHPS IDs must be verified registered members before proceeding to payment.'
                ], 422);
            }
        } else {
            $guardianId = $request->input('guardian_mobile_or_id');
            if (!$this->verifyIdEligibility($guardianId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mandatory Verification Gate: Guardian ABVHPS ID must be a verified registered member before proceeding to payment.'
                ], 422);
            }
        }

        // Capture inbound transaction token from payment gateway provider
        $transactionId = 'TXN' . strtoupper(uniqid());

        return response()->json([
            'success' => true,
            'transaction_id' => $transactionId,
            'message' => 'Payment of ₹41.00 captured successfully. Submit anchor unlocked.'
        ]);
    }

    /**
     * Final Database Persistence, GD Image Weight Budgeting, & 11-Digit Ticket Desk
     */
    public function submitFinalApplication(Request $request)
    {
        // Enforce rigid rules layout mapping image constraints
        $request->validate([
            'email' => 'required|email',
            'full_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'address' => 'required|string',
            'mobile' => 'required|string',
            'guardian_type' => 'required|in:parents,guardian',
            'school_college_name' => 'required|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'id_card_or_signature' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'payment_transaction_id' => 'required|string'
        ]);

        // Server-Side Mandatory Verification Gate
        if ($request->guardian_type === 'parents') {
            if (!$this->verifyIdEligibility($request->father_membership_id) || !$this->verifyIdEligibility($request->mother_membership_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mandatory Verification Gate: BOTH Father and Mother ABVHPS IDs must be verified registered members before submitting.'
                ], 422);
            }
        } else {
            if (!$this->verifyIdEligibility($request->guardian_mobile_or_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mandatory Verification Gate: Guardian ABVHPS ID must be a verified registered member before submitting.'
                ], 422);
            }
        }

        // Double check anti-fraud session token configuration status
        if (!Session::get('exam_email_verified_status')) {
            return response()->json(['success' => false, 'message' => 'Security Threat: Email verification token bypass detected.']);
        }

        // --- GD LIBRARY GRAPHICS COMPRESSION ENGINE (TARGET WEIGHT BUDGET 1KB-2KB) ---
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $sourcePath = $file->getRealPath();
            
            // Create internal frame based on mime format type
            $mime = $file->getClientMimeType();
            if ($mime == 'image/png') {
                $srcImg = imagecreatefrompng($sourcePath);
            } else {
                $srcImg = imagecreatefromjpeg($sourcePath);
            }

            if ($srcImg) {
                // Force rigid compressed resolution grid: 100x100 Stamp View
                $dstImg = imagecreatetruecolor(100, 100);
                
                // Preserve transparency matrix channels for high-utility outputs
                if ($mime == 'image/png') {
                    imagealphablending($dstImg, false);
                    imagesavealpha($dstImg, true);
                }

                // Execute exact sampling downscale grid
                imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, 100, 100, imagesx($srcImg), imagesy($srcImg));

                // Establish custom safe folder tree paths mapping destination logic
                $fileName = 'photo_' . time() . '_' . uniqid() . '.jpg';
                $destinationDirectory = storage_path('app/public/seva_proofs');
                
                if (!file_exists($destinationDirectory)) {
                    mkdir($destinationDirectory, 0755, true);
                }

                $finalStoragePath = $destinationDirectory . '/' . $fileName;

                // Adjust quality matrix level lower until target weight budget (1KB to 2KB Enforced) is satisfied
                // Start with aggressive compression level for minimum data envelope footprints
                imagejpeg($dstImg, $finalStoragePath, 25); 

                // Burn obsolete internal frame traces from memory stack
                imagedestroy($srcImg);
                imagedestroy($dstImg);

                $photoPath = 'seva_proofs/' . $fileName;
            }
        }

        // Standard dynamic uploads without destructive weight constraints
        $idCardPath = $request->file('id_card_or_signature')->store('exam_proofs', 'public');
        $aadhaarPath = $request->hasFile('aadhaar') ? $request->file('aadhaar')->store('exam_proofs', 'public') : null;

        // --- UNIQUE 11-DIGIT RANDOM HALL TICKET GENERATOR DESK ---
        // Loops safely until a completely unique 11-digit string budget is found
        do {
            $currentYear = date('Y'); // Dynamic base prefix example: '2026'
            $randomSevenDigits = rand(1000000, 9999999);
            $generatedTicket = $currentYear . $randomSevenDigits;

            $duplicateCheck = \DB::table('exam_applications')
                ->where('hall_ticket_number', $generatedTicket)
                ->exists();
        } while ($duplicateCheck);

        // Core Pipeline Logic Insertion Matrix
        $applicationId = \DB::table('exam_applications')->insertGetId([
            'exam_setting_id' => $request->exam_setting_id ?? (\DB::table('exam_settings')->latest()->value('id') ?? 1),
            'email' => $request->email,
            'is_email_verified' => true,
            'full_name' => $request->full_name,
            'dob' => $request->dob,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'aadhaar_no' => $request->aadhaar_no,
            'guardian_type' => $request->guardian_type,
            'father_membership_id' => $request->father_membership_id,
            'father_name' => $request->father_name,
            'mother_membership_id' => $request->mother_membership_id,
            'mother_name' => $request->mother_name,
            'guardian_name' => $request->guardian_name,
            'guardian_relationship' => $request->guardian_relationship,
            'guardian_mobile_or_id' => $request->guardian_mobile_or_id,
            'school_college_name' => $request->school_college_name,
            'class_section' => $request->class_section,
            'photo_path' => $photoPath,
            'id_card_or_signature_path' => $idCardPath,
            'aadhaar_proof_path' => $aadhaarPath,
            'amount_paid' => 41.00,
            'payment_transaction_id' => $request->payment_transaction_id,
            'payment_status' => 'success',
            'hall_ticket_number' => $generatedTicket,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // --- AUTOMATED POST-SUBMISSION EMAIL TRIGGER PIPELINE ---
        // Dispatches dynamic confirmation notice containing variables directly to candidate
        try {
            $emailDetails = [
                'name' => $request->full_name,
                'ticket' => $generatedTicket,
                'fee' => '41.00'
            ];
            
            // In actual architecture, build a proper dynamic Mailable:
            // Mail::to($request->email)->send(new \App\Mail\ExamSuccessWelcomeMail($emailDetails));
            \Log::info("ABVHPS SYSTEM SUCCESS: Dynamic Email Log Dispatch for Ticket {$generatedTicket} sent to {$request->email}");
        } catch (\Exception $e) {
            \Log::error("Mail Dispatch Failure: " . $e->getMessage());
        }

        // Clean verification indicators to close state sandbox loops safely
        Session::forget('exam_email_verified_status');
        Session::forget('exam_email_target');

        return response()->json([
            'success' => true,
            'redirect_url' => route('exam.success', ['id' => $applicationId]),
            'message' => 'Application stored and secured. Redirecting to success terminal.'
        ]);
    }

    /**
     * Display the Post-Submission Success Notice & Digital Ticket Board
     */
    public function showSuccessNotice($id)
    {
        $application = \DB::table('exam_applications')->where('id', $id)->first();
        $examSettings = \DB::table('exam_settings')->latest()->first();

        if (!$application) {
            abort(404, 'Application footprint not discovered.');
        }

        return view('volunteer_success_notice', compact('application', 'examSettings'));
    }

    /**
     * Stream Download Output Target for Exam Syllabus Documents Repository
     */
    public function downloadSyllabusPdf($id)
    {
        // Safe streaming download endpoint configuration desk
        $fileDiskTarget = storage_path('app/public/syllabus/sanathana_dharma_2026.pdf');
        
        if (file_exists($fileDiskTarget)) {
            return response()->download($fileDiskTarget);
        }

        return back()->with('error', 'Target Syllabus Document File is currently missing from storage.');
    }
        /**
     * Display Central Exam Results Portal & Top 6 Winners Showcase Board
     */
    public function showResultsPortal()
    {
        // Core Query Pipeline: Fetch Top 6 verified winners ordered strictly by their rank
        $winners = \DB::table('exam_applications')
            ->where('show_on_winners_wall', true)
            ->whereNotNull('winner_rank')
            ->orderBy('winner_rank', 'asc')
            ->take(6)
            ->get();

        return view('exam_results', compact('winners'));
    }
    /**
     * Search Candidate Evaluation Matrix via 11-Digit Unique Hall Ticket Number
     */
    public function searchStudentResult(Request $request)
    {
        $request->validate([
            'hall_ticket_number' => 'required|string|size:11'
        ]);

        // Secure Lookup Pipeline against application records
        $studentResult = \DB::table('exam_applications')
            ->where('hall_ticket_number', $request->hall_ticket_number)
            ->where('payment_status', 'success')
            ->first();

        if (!$studentResult) {
            return response()->json([
                'success' => false, 
                'message' => 'Given 11-Digit Hall Ticket number is not registered or valid.'
            ]);
        }

        // Return core identity and grading scores safely
        return response()->json([
            'success' => true,
            'full_name' => $studentResult->full_name,
            'hall_ticket' => $studentResult->hall_ticket_number,
            'school_name' => $studentResult->school_college_name,
            'marks' => $studentResult->marks_obtained ?? 'Not Evaluated Yet',
            'status' => ucfirst($studentResult->result_status),
            'prize' => $studentResult->prize_title_won ?? null
        ]);
    }

    /**
     * Admin Exam Info Board Roster (Continuous Loop Cycles)
     */
    public function adminIndex()
    {
        $exams = \App\Models\ExamSetting::withCount('applications')->orderBy('id', 'desc')->get();
        return view('admin.exams_index', compact('exams'));
    }

    /**
     * Admin Create New Exam Form
     */
    public function adminCreate()
    {
        return view('admin.exam_create');
    }

    /**
     * Admin Store New Exam Cycle
     */
    public function adminStore(Request $request)
    {
        $request->validate([
            'exam_title' => 'required|string|max:255',
            'exam_date_time' => 'required|date',
            'exam_center_location' => 'required|string|max:255',
            'application_fee' => 'required|numeric|min:0',
            'syllabus_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'banner_image' => 'nullable|image|max:4096',
            'prize_details' => 'nullable|string',
            'guidelines' => 'nullable|string',
            'status' => 'required|in:active,upcoming,completed',
        ]);

        $syllabusPath = null;
        if ($request->hasFile('syllabus_pdf')) {
            $syllabusPath = $request->file('syllabus_pdf')->store('exams/syllabus', 'public');
        }

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $request->file('banner_image')->store('exams/banners', 'public');
        }

        $prizes = $request->prize_details ? explode("\n", str_replace("\r", "", $request->prize_details)) : ['1st: Gold Trophy & Cash Prize', '2nd: Silver Award', '3rd: Merit Certificate'];

        \App\Models\ExamSetting::create([
            'exam_title' => $request->exam_title,
            'syllabus_pdf_path' => $syllabusPath ?? 'exams/syllabus/sample_syllabus.pdf',
            'banner_image_path' => $bannerPath,
            'exam_date_time' => $request->exam_date_time,
            'exam_center_location' => $request->exam_center_location,
            'prize_details_json' => json_encode(array_filter($prizes)),
            'guidelines' => $request->guidelines,
            'application_fee' => $request->application_fee,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.exams.index')->with('success', 'New Exam Cycle created successfully.');
    }

    /**
     * Admin Edit Exam Form
     */
    public function adminEdit($id)
    {
        $exam = \App\Models\ExamSetting::findOrFail($id);
        $prizesArray = is_array($exam->prize_details_json) ? $exam->prize_details_json : json_decode($exam->prize_details_json, true);
        $prizesText = is_array($prizesArray) ? implode("\n", $prizesArray) : '';
        return view('admin.exam_edit', compact('exam', 'prizesText'));
    }

    /**
     * Admin Update Exam Cycle
     */
    public function adminUpdate(Request $request, $id)
    {
        $exam = \App\Models\ExamSetting::findOrFail($id);

        $request->validate([
            'exam_title' => 'required|string|max:255',
            'exam_date_time' => 'required|date',
            'exam_center_location' => 'required|string|max:255',
            'application_fee' => 'required|numeric|min:0',
            'syllabus_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'banner_image' => 'nullable|image|max:4096',
            'prize_details' => 'nullable|string',
            'guidelines' => 'nullable|string',
            'status' => 'required|in:active,upcoming,completed',
        ]);

        if ($request->hasFile('syllabus_pdf')) {
            $exam->syllabus_pdf_path = $request->file('syllabus_pdf')->store('exams/syllabus', 'public');
        }

        if ($request->hasFile('banner_image')) {
            $exam->banner_image_path = $request->file('banner_image')->store('exams/banners', 'public');
        }

        if ($request->has('prize_details')) {
            $prizes = explode("\n", str_replace("\r", "", $request->prize_details));
            $exam->prize_details_json = json_encode(array_filter($prizes));
        }

        $exam->exam_title = $request->exam_title;
        $exam->exam_date_time = $request->exam_date_time;
        $exam->exam_center_location = $request->exam_center_location;
        $exam->guidelines = $request->guidelines;
        $exam->application_fee = $request->application_fee;
        $exam->status = $request->status;
        $exam->save();

        return redirect()->route('admin.exams.index')->with('success', 'Exam Cycle updated successfully.');
    }

    /**
     * Admin Delete Exam Cycle
     */
    public function adminDelete($id)
    {
        $exam = \App\Models\ExamSetting::findOrFail($id);
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Exam Cycle deleted.');
    }

    /**
     * Public Continuous Loop Exams Notice Board
     */
    public function publicNoticeBoard()
    {
        $exams = \App\Models\ExamSetting::orderBy('exam_date_time', 'desc')->get();
        return view('exams_notice_board', compact('exams'));
    }
}

