<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
        /**
     * Display the Central Master Administrative Dashboard Grid with Secure Analytics Fallbacks
     */
    public function showMasterDashboard()
    {
        // --- 1. SECURE ANALYTICAL WIDGETS DATA COUNTERS WITH TABLE SAFEFALLS ---
        $stats = [];
        
        try { $stats['total_members'] = DB::table('memberships')->count(); } catch (\Exception $e) { $stats['total_members'] = 0; }
        
        // Dynamic detection matrix using multi-name fallbacks to prevent SQL state collapses
        try { 
            $stats['rudrasena_count'] = DB::table('rudrasenas')->count(); 
        } catch (\Exception $e) { 
            try { $stats['rudrasena_count'] = DB::table('rudrasena_applications')->count(); } catch (\Exception $ex) { $stats['rudrasena_count'] = 0; }
        }
        
        try { $stats['kala_brundam_count'] = DB::table('kala_brundam_members')->count(); } catch (\Exception $e) { $stats['kala_brundam_count'] = 0; }
        try { $stats['grama_seva_dal_count'] = DB::table('grama_seva_dals')->count(); } catch (\Exception $e) { $stats['grama_seva_dal_count'] = 0; }
        try { $stats['organic_farmers_count'] = DB::table('organic_farmers')->count(); } catch (\Exception $e) { $stats['organic_farmers_count'] = 0; }
        try { $stats['total_funds_raised'] = DB::table('fundraising_campaigns')->sum('raised_amount') ?? 0.00; } catch (\Exception $e) { $stats['total_funds_raised'] = 0.00; }

        // --- 2. EXTRACT RECENT TRANSACTIONS & ACTIVE ROSTERS ---
        try {
            $recentMembers = DB::table('memberships')->orderBy('id', 'desc')->limit(5)->get();
        } catch (\Exception $e) {
            $recentMembers = collect([]);
        }

        try {
            $activeCampaigns = DB::table('fundraising_campaigns')->where('status', 'active')->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {
            $activeCampaigns = collect([]);
        }

        return view('admin.dashboard', compact('stats', 'recentMembers', 'activeCampaigns'));
    }

    /**
     * Process Administrative Ingestion Gateways to Approve or Defer Application Packets
     */
    public function processWingApproval(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|string|size:12',
            'wing_type' => 'required|string|in:rudrasena,kala_brundam,grama_seva_dal,organic_farmers',
            'action_status' => 'required|string|in:approve,reject'
        ]);

        // Validate if the targeted member is legitimately present inside central database registries
        $member = DB::table('memberships')->where('membership_id', $request->membership_id)->first();
        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Action Blocked: Targeted identity does not match central database footprints.'
            ]);
        }

        // Execute dynamic state routing parameters within transaction blocks
        DB::beginTransaction();
        try {
            if ($request->action_status === 'approve') {
                switch ($request->wing_type) {
                    case 'rudrasena':
                        // Inject into Rudrasena active military roster vault if absent
                        $exists = DB::table('rudrasenas')->where('membership_id', $request->membership_id)->exists();
                        if (!$exists) {
                            DB::table('rudrasenas')->insert([
                                'membership_id' => $request->membership_id,
                                'full_name' => $member->full_name,
                                'phone' => $member->phone,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                        break;

                    case 'kala_brundam':
                        $exists = DB::table('kala_brundam_members')->where('membership_id', $request->membership_id)->exists();
                        if (!$exists) {
                            DB::table('kala_brundam_members')->insert([
                                'membership_id' => $request->membership_id,
                                'full_name' => $member->full_name,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now()
                            ]);
                        }
                        break;
                }
            } else {
                // Execute rollback delete removals if action state is set to explicit reject
                switch ($request->wing_type) {
                    case 'rudrasena':
                        DB::table('rudrasenas')->where('membership_id', $request->membership_id)->delete();
                        break;
                    case 'kala_brundam':
                        DB::table('kala_brundam_members')->where('membership_id', $request->membership_id)->delete();
                        break;
                }
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => '🎉 Administrative status updated and broadcasted inside core system registries.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Critical infrastructure deadlock failure during transmission validation.'
            ]);
        }
    }
}
