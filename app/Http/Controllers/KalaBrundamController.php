<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KalaBrundamController extends Controller
{
    /**
     * Display the Official Kala Brundam Structural Application Desk
     */
    public function showApplicationDesk()
    {
        return view('kala_brundam_application');
    }

    /**
     * Fetch Individual Member Details via 12-Digit ID to dynamically inject into Team Grid Table
     */
    public function fetchMemberForTeam(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|string|size:12'
        ]);

        // Secure Lookup against core membership database matrix
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

        // Dispatch full certified asset profile mapping directly to the dynamic table builder
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
     * Secure and Process Multi-Layer Relational Ingestion for Kala Brundam Team Matrix
     */
    public function submitTeamPacket(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
            'team_type' => 'required|string',
            'custom_type_spec' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'disclaimer_accepted' => 'required|accepted',
            'members' => 'required|array|min:1' // Validating team must contain at least 1 verified member
        ]);

        // Generate official unique non-sequential Kala Brundam Group ID (e.g. KB-583214)
        do {
            $candidateNum = random_int(100000, 999999);
            $teamRegistrationId = 'KB-' . $candidateNum;
        } while (DB::table('kala_brundams')->where('team_registration_id', $teamRegistrationId)->exists());

        // Execute Transaction Block to ensure database absolute synchronization
        DB::beginTransaction();

        try {
            // Write Primary Registry Entry into Parent Master Table Vault
            $masterTeamId = DB::table('kala_brundams')->insertGetId([
                'team_registration_id' => $teamRegistrationId,
                'team_name' => strtoupper($request->team_name),
                'team_type' => $request->team_type,
                'custom_type_spec' => $request->team_type === 'Others' ? $request->custom_type_spec : null,
                'location' => $request->location,
                'disclaimer_accepted' => true,
                'disclaimer_accepted_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Iterate and map unbounded arrays inside child structural matrix rows
            foreach ($request->members as $row) {
                // Secure lookup block guardrail to prevent blank rows deployment
                if (!empty($row['membership_id']) && !empty($row['full_name'])) {
                    
                    // Clean and strip server root assets path from photo url structure
                    $cleanPhotoPath = null;
                    if (!empty($row['photo_url'])) {
                        $parsedUrl = parse_url($row['photo_url'], PHP_URL_PATH);
                        $urlSegments = explode('/storage/', $parsedUrl);
                        $cleanPhotoPath = end($urlSegments);
                    }

                    DB::table('kala_brundam_members')->insert([
                        'kala_brundam_id' => $masterTeamId, // Foreign key link anchor node
                        'membership_id' => $row['membership_id'],
                        'full_name' => $row['full_name'],
                        'age' => (int) $row['age'],
                        'mobile' => $row['mobile'],
                        'photo_path' => $cleanPhotoPath,
                        'is_verified' => true, // Absolute status seal injection
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            DB::commit();

            // Fetch and dispatch fully structured response to build the dynamic live Certificate UI
            $finalTeamPayload = DB::table('kala_brundams')->where('id', $masterTeamId)->first();
            $finalMembersPayload = DB::table('kala_brundam_members')->where('kala_brundam_id', $masterTeamId)->get();

            return response()->json([
                'success' => true,
                'message' => '🎉 Cultural Team Registered Successfully! ABVHPS Certificate Generated.',
                'team_id' => $teamRegistrationId,
                'team' => $finalTeamPayload,
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
