<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GramaSevaDalController extends Controller
{
    /**
     * Display the Official Grama Seva Dal Application Desk
     */
    public function showApplicationDesk()
    {
        return view('grama_seva_dal_application');
    }

    /**
     * Fetch Individual Member Details via 12-Digit ID to inject into Leader Box or Team Grid
     */
    public function fetchMemberForDal(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|string|size:12'
        ]);

        // Secure Lookup against central membership database matrix
        $member = DB::table('memberships')
            ->where('membership_id', $request->membership_id)
            ->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Given 12-Digit Membership ID is not registered in our central portal.'
            ]);
        }

        // Carbon calculation layers for structural verification
        $dobField = $member->date_of_birth ?? '1995-01-01'; // Safe testing fallback structure
        $dob = Carbon::parse($dobField);
        $age = $dob->age;

        // Dispatch full certified asset profile mapping directly to the dynamic frontend template
        return response()->json([
            'success' => true,
            'message' => 'Candidate identity verified successfully!',
            'member' => [
                'membership_id' => $member->membership_id,
                'full_name' => $member->full_name,
                'age' => $age,
                'mobile' => $member->phone, // Bound column mapping parameter
                'photo_url' => $member->photo_path ? asset('storage/' . $member->photo_path) : 'https://placeholder.com'
            ]
        ]);
    }
    /**
     * Secure and Process Multi-Layer Relational Ingestion for Grama Seva Dal Team Matrix
     */
    public function submitDalPacket(Request $request)
    {
        $request->validate([
            'state' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'mandal' => 'required|string|max:255',
            'village_or_gp' => 'required|string|max:255',
            
            // Team Leader Parameters
            'leader_membership_id' => 'required|string|size:12',
            'leader_name' => 'required|string|max:255',
            'leader_mobile' => 'required|string',
            
            'charter_accepted' => 'required|accepted',
            'members' => 'required|array|min:1' // Validating team must contain at least 1 verified youth asset
        ]);

        // Generate official unique non-sequential Grama Seva Dal Group ID (e.g. GSD-583214)
        do {
            $candidateNum = random_int(100000, 999999);
            $gongRegistrationId = 'GSD-' . $candidateNum;
        } while (DB::table('grama_seva_dals')->where('gong_registration_id', $gongRegistrationId)->exists());

        // Execute Transaction Block to ensure database absolute synchronization
        DB::beginTransaction();

        try {
            // Write Primary Registry Entry into Parent Master Table Vault
            $masterDalId = DB::table('grama_seva_dals')->insertGetId([
                'gong_registration_id' => $gongRegistrationId,
                'state' => $request->state,
                'district' => $request->district,
                'mandal' => $request->mandal,
                'village_or_gp' => strtoupper($request->village_or_gp),
                
                'leader_membership_id' => $request->leader_membership_id,
                'leader_name' => strtoupper($request->leader_name),
                'leader_mobile' => $request->leader_mobile,
                
                'charter_accepted' => true,
                'charter_accepted_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Iterate and map unbounded arrays inside child structural matrix rows (Youth Force)
            foreach ($request->members as $row) {
                if (!empty($row['membership_id']) && !empty($row['full_name'])) {
                    
                    // Clean and strip server root assets path from photo url structure
                    $cleanPhotoPath = null;
                    if (!empty($row['photo_url'])) {
                        $parsedUrl = parse_url($row['photo_url'], PHP_URL_PATH);
                        $urlSegments = explode('/storage/', $parsedUrl);
                        $cleanPhotoPath = end($urlSegments);
                    }

                    DB::table('grama_seva_dal_members')->insert([
                        'grama_seva_dal_id' => $masterDalId, // Foreign key link anchor node
                        'membership_id' => $row['membership_id'],
                        'full_name' => $row['full_name'],
                        'age' => (int) $row['age'],
                        'mobile' => $row['mobile'],
                        'photo_path' => $cleanPhotoPath,
                        'is_active_force' => true, // Active force deployment configuration
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            DB::commit();

            // Fetch and dispatch fully structured response to build the dynamic live Certificate Charter UI
            $finalDalPayload = DB::table('grama_seva_dals')->where('id', $masterDalId)->first();
            $finalMembersPayload = DB::table('grama_seva_dal_members')->where('grama_seva_dal_id', $masterDalId)->get();

            return response()->json([
                'success' => true,
                'message' => '🎉 Grama Seva Dal Force Registered Successfully! Official Service Charter Issued.',
                'charter_id' => $gongRegistrationId,
                'dal' => $finalDalPayload,
                'members' => $finalMembersPayload
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Critical dynamic transaction block error occurred. Refused packet transmission.'
            ]);
        }
    }
}
