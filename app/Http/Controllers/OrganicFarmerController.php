<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrganicFarmerController extends Controller
{
    /**
     * Display the Official Organic Farmers Application Desk
     */
    public function showApplicationDesk()
    {
        return view('organic_farmer_application');
    }

    /**
     * Fetch Individual Member Details via 12-Digit ID to populate Farmer Registration Profile
     */
    public function fetchMemberForFarming(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|string|size:12'
        ]);

        // Secure Lookup against central membership database registry matrix
        $member = DB::table('memberships')
            ->where('membership_id', $request->membership_id)
            ->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Given 12-Digit Membership ID is not registered in our central portal.'
            ]);
        }

        // Dispatch full certified asset profile mapping directly to the organic frontend panel
        return response()->json([
            'success' => true,
            'message' => 'Farmer identity verified successfully!',
            'member' => [
                'membership_id' => $member->membership_id,
                'full_name' => $member->full_name,
                'mobile' => $member->phone, // Bound column mapping parameter
                'photo_url' => $member->photo_path ? asset('storage/' . $member->photo_path) : 'https://placeholder.com'
            ]
        ]);
    }
    /**
     * Secure and Process Multi-Layer Relational Ingestion for Organic Farmers Team Matrix
     */
    public function submitFarmerPacket(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|string|size:12',
            'farmer_name' => 'required|string|max:255',
            'farmer_mobile' => 'required|string',
            
            // Agricultural Profile Parameters
            'land_size_acres' => 'required|numeric|min:0.01',
            'water_source' => 'required|string',
            'indigenous_cows_count' => 'required|integer|min:0',
            
            'uses_jeevamrutham' => 'nullable|boolean',
            'uses_ghana_jeevamrutham' => 'nullable|boolean',
            'organic_oath_accepted' => 'required|accepted',
            'crops' => 'required|array|min:1' // Validating farmer must register at least 1 certified crop node
        ]);

        // Anti-Fraud Duplication Layer Check
        $exists = DB::table('organic_farmers')
            ->where('membership_id', $request->membership_id)
            ->first();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'You have already submitted an active organic agriculture registry packet.'
            ]);
        }

        // Dynamic Prefix Serial Number Generator Engine (E.g. ABVHPS-OF-001 Tracking Node)
        $latestRecord = DB::table('organic_farmers')
            ->orderBy('id', 'desc')
            ->first();

        if ($latestRecord) {
            $stringParts = explode('-', $latestRecord->farmer_registration_id);
            $lastSequence = (int) end($stringParts);
            $nextSequence = $lastSequence + 1;
        } else {
            $nextSequence = 1; // Default fallback initialization
        }

        $farmerRegistrationId = 'ABVHPS-OF-' . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);

        // Execute Transaction Block to ensure database absolute synchronization
        DB::beginTransaction();

        try {
            // Write Primary Registry Entry into Parent Master Table Vault
            $masterFarmerId = DB::table('organic_farmers')->insertGetId([
                'farmer_registration_id' => $farmerRegistrationId,
                'membership_id' => $request->membership_id,
                'farmer_name' => strtoupper($request->farmer_name),
                'farmer_mobile' => $request->farmer_mobile,
                
                'land_size_acres' => $request->land_size_acres,
                'water_source' => $request->water_source,
                'indigenous_cows_count' => $request->indigenous_cows_count,
                
                'uses_jeevamrutham' => $request->has('uses_jeevamrutham'),
                'uses_ghana_jeevamrutham' => $request->has('uses_ghana_jeevamrutham'),
                'organic_oath_accepted' => true,
                'organic_oath_accepted_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            // Iterate and map unbounded arrays inside child structural matrix rows (Crops Force)
            foreach ($request->crops as $row) {
                if (!empty($row['crop_name'])) {
                    DB::table('farmer_crops')->insert([
                        'organic_farmer_id' => $masterFarmerId, // Foreign key link anchor node
                        'crop_name' => $row['crop_name'],
                        'variety_spec' => $row['variety_spec'] ?? null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            DB::commit();

            // Fetch and dispatch fully structured response to build the dynamic live Certificate UI
            $finalFarmerPayload = DB::table('organic_farmers')->where('id', $masterFarmerId)->first();
            $finalCropsPayload = DB::table('farmer_crops')->where('organic_farmer_id', $masterFarmerId)->get();

            return response()->json([
                'success' => true,
                'message' => '🎉 Nature Agriculture Registry Secured Successfully! Official Green Certificate Issued.',
                'farmer_id' => $farmerRegistrationId,
                'farmer' => $finalFarmerPayload,
                'crops' => $finalCropsPayload
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
