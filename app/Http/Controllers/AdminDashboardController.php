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
        $stats = [];

        // ── CORE MEMBER COUNTS ────────────────────────────────────────────
        try { $stats['total_members']          = DB::table('memberships')->count(); }                          catch (\Exception $e) { $stats['total_members'] = 0; }
        try { $stats['pending_memberships']    = DB::table('memberships')->where('status', 'pending')->count(); } catch (\Exception $e) { $stats['pending_memberships'] = 0; }
        try { $stats['total_volunteers']       = DB::table('volunteers')->where('status', 'approved')->count(); } catch (\Exception $e) { $stats['total_volunteers'] = 0; }
        try { $stats['pending_volunteers']     = DB::table('volunteers')->where('status', 'pending')->count(); } catch (\Exception $e) { $stats['pending_volunteers'] = 0; }

        // ── RUDRA SENA ────────────────────────────────────────────────────
        try { $stats['rudrasena_count']        = DB::table('rudrasena_members')->count(); }
        catch (\Exception $e) {
            try { $stats['rudrasena_count']    = DB::table('rudrasenas')->count(); }
            catch (\Exception $ex) { $stats['rudrasena_count'] = 0; }
        }
        try { $stats['pending_rudrasena']      = DB::table('volunteers')->where('status', 'pending')->where('volunteer_type', 'rudrasena')->count(); } catch (\Exception $e) { $stats['pending_rudrasena'] = 0; }

        // ── KALA BRUNDHAM ─────────────────────────────────────────────────
        try { $stats['kala_brundam_count']     = DB::table('kala_brundam_members')->count(); } catch (\Exception $e) { $stats['kala_brundam_count'] = 0; }

        // ── GRAMA SEVA DAL ────────────────────────────────────────────────
        try { $stats['grama_seva_dal_count']   = DB::table('grama_seva_dals')->count(); }  catch (\Exception $e) { $stats['grama_seva_dal_count'] = 0; }

        // ── ORGANIC FARMERS ───────────────────────────────────────────────
        try { $stats['organic_farmers_count']  = DB::table('organic_farmers')->count(); }  catch (\Exception $e) { $stats['organic_farmers_count'] = 0; }

        // ── EXAMS ─────────────────────────────────────────────────────────
        try { $stats['total_exams']            = DB::table('exam_settings')->count(); }                        catch (\Exception $e) { $stats['total_exams'] = 0; }
        try { $stats['active_exams']           = DB::table('exam_settings')->where('is_active', true)->count(); } catch (\Exception $e) { $stats['active_exams'] = 0; }
        try { $stats['published_results']      = DB::table('exam_applications')->where('result_publication_status', 'published')->distinct('exam_setting_id')->count('exam_setting_id'); } catch (\Exception $e) { $stats['published_results'] = 0; }
        try { $stats['pending_exam_applications'] = DB::table('exam_applications')->where('result_publication_status', '!=', 'published')->orWhereNull('result_publication_status')->count(); } catch (\Exception $e) { $stats['pending_exam_applications'] = 0; }
        try { $stats['total_exam_applications']= DB::table('exam_applications')->count(); } catch (\Exception $e) { $stats['total_exam_applications'] = 0; }

        // ── FUNDRAISING ───────────────────────────────────────────────────
        try { $stats['active_campaigns']       = DB::table('fundraisings')->where('is_active', true)->count(); }  catch (\Exception $e) { try { $stats['active_campaigns'] = DB::table('fundraising_campaigns')->where('status', 'active')->count(); } catch (\Exception $ex) { $stats['active_campaigns'] = 0; } }
        try { $stats['total_campaigns']        = DB::table('fundraisings')->count(); }                            catch (\Exception $e) { try { $stats['total_campaigns'] = DB::table('fundraising_campaigns')->count(); } catch (\Exception $ex) { $stats['total_campaigns'] = 0; } }
        try { $stats['total_funds_raised']     = DB::table('fundraisings')->sum('raised_amount') ?? 0; }          catch (\Exception $e) { try { $stats['total_funds_raised'] = DB::table('fundraising_campaigns')->sum('raised_amount') ?? 0; } catch (\Exception $ex) { $stats['total_funds_raised'] = 0; } }
        try { $stats['total_donors']           = DB::table('donations')->count(); }                               catch (\Exception $e) { $stats['total_donors'] = 0; }

        // ── CONTENT ───────────────────────────────────────────────────────
        try { $stats['total_blogs']            = DB::table('blogs')->count(); }            catch (\Exception $e) { $stats['total_blogs'] = 0; }
        try { $stats['published_blogs']        = DB::table('blogs')->where('status', 'published')->count(); } catch (\Exception $e) { $stats['published_blogs'] = 0; }
        try { $stats['gallery_media']          = DB::table('galleries')->count(); }        catch (\Exception $e) { $stats['gallery_media'] = 0; }

        // ── RECENT AUDIT ACTIVITY (last 8 entries) ────────────────────────
        try {
            $recentActivity = DB::table('audit_logs')
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get(['action', 'actor_type', 'actor_identifier', 'target_type', 'target_id', 'created_at']);
        } catch (\Exception $e) {
            $recentActivity = collect([]);
        }

        // ── RECENT MEMBERS ────────────────────────────────────────────────
        try {
            $recentMembers = DB::table('memberships')->orderBy('id', 'desc')->limit(5)->get(['id', 'full_name', 'membership_id', 'status', 'created_at']);
        } catch (\Exception $e) {
            $recentMembers = collect([]);
        }

        // ── ACTIVE CAMPAIGNS ──────────────────────────────────────────────
        try {
            $activeCampaigns = DB::table('fundraisings')->where('is_active', true)->orderBy('id', 'desc')->get(['id', 'title', 'raised_amount', 'goal_amount']);
        } catch (\Exception $e) {
            try {
                $activeCampaigns = DB::table('fundraising_campaigns')->where('status', 'active')->orderBy('id', 'desc')->get(['id', 'title', 'raised_amount', 'goal_amount']);
            } catch (\Exception $ex) {
                $activeCampaigns = collect([]);
            }
        }

        return view('admin.dashboard', compact('stats', 'recentMembers', 'activeCampaigns', 'recentActivity'));
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
