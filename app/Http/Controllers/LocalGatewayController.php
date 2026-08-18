<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Volunteer;

class LocalGatewayController extends Controller
{
    /**
     * Display Unified Local GP Gateways Roster
     */
    public function index(Request $request)
    {
        $category = $request->input('category', 'all'); // 'all', 'kala_brundam', 'grama_seva_dal', 'organic_farmers'
        $status = $request->input('status', 'all'); // 'all', 'pending', 'approved'

        $kalaBrundams = collect();
        $gramaSevaDals = collect();
        $organicFarmers = collect();

        // 1. Kala Brundam Groups
        if ($category === 'all' || $category === 'kala_brundam') {
            $q = DB::table('kala_brundams')
                ->leftJoin('kala_brundam_members', 'kala_brundams.id', '=', 'kala_brundam_members.kala_brundam_id')
                ->select(
                    'kala_brundams.id',
                    'kala_brundams.team_registration_id as reg_id',
                    'kala_brundams.team_name as name',
                    'kala_brundams.team_type as sub_type',
                    'kala_brundams.location as gp_location',
                    'kala_brundams.status',
                    'kala_brundams.created_at',
                    DB::raw('COUNT(kala_brundam_members.id) as members_count')
                )
                ->groupBy('kala_brundams.id', 'kala_brundams.team_registration_id', 'kala_brundams.team_name', 'kala_brundams.team_type', 'kala_brundams.location', 'kala_brundams.status', 'kala_brundams.created_at');

            if ($status !== 'all') {
                $q->where('kala_brundams.status', $status);
            }
            $kalaBrundams = $q->get()->map(function ($item) {
                $item->wing = 'Kala Brundam';
                $item->wing_key = 'kala_brundam';
                return $item;
            });
        }

        // 2. Grama Seva Dal Groups
        if ($category === 'all' || $category === 'grama_seva_dal') {
            $q = DB::table('grama_seva_dals')
                ->leftJoin('grama_seva_dal_members', 'grama_seva_dals.id', '=', 'grama_seva_dal_members.grama_seva_dal_id')
                ->select(
                    'grama_seva_dals.id',
                    'grama_seva_dals.gong_registration_id as reg_id',
                    'grama_seva_dals.leader_name as name',
                    'grama_seva_dals.leader_mobile as sub_type',
                    'grama_seva_dals.village_or_gp',
                    'grama_seva_dals.mandal',
                    'grama_seva_dals.status',
                    'grama_seva_dals.created_at',
                    DB::raw('COUNT(grama_seva_dal_members.id) as members_count')
                )
                ->groupBy('grama_seva_dals.id', 'grama_seva_dals.gong_registration_id', 'grama_seva_dals.leader_name', 'grama_seva_dals.leader_mobile', 'grama_seva_dals.village_or_gp', 'grama_seva_dals.mandal', 'grama_seva_dals.status', 'grama_seva_dals.created_at');

            if ($status !== 'all') {
                $q->where('grama_seva_dals.status', $status);
            }
            $gramaSevaDals = $q->get()->map(function ($item) {
                $item->wing = 'Grama Seva Dal';
                $item->wing_key = 'grama_seva_dal';
                $item->gp_location = trim(($item->village_or_gp ?? '') . ', ' . ($item->mandal ?? ''), ', ');
                return $item;
            });
        }

        // 3. Organic Farmers Groups
        if ($category === 'all' || $category === 'organic_farmers') {
            $q = DB::table('organic_farmers')
                ->select(
                    'organic_farmers.id',
                    'organic_farmers.farmer_registration_id as reg_id',
                    'organic_farmers.farmer_name as name',
                    'organic_farmers.farmer_mobile as sub_type',
                    'organic_farmers.land_size_acres',
                    'organic_farmers.water_source',
                    'organic_farmers.status',
                    'organic_farmers.created_at',
                    DB::raw('1 as members_count')
                );

            if ($status !== 'all') {
                $q->where('organic_farmers.status', $status);
            }
            $organicFarmers = $q->get()->map(function ($item) {
                $item->wing = 'Organic Farmers';
                $item->wing_key = 'organic_farmers';
                $item->gp_location = ($item->land_size_acres ? $item->land_size_acres . ' Acres (' . ($item->water_source ?? 'Rainfed') . ')' : 'Farmland');
                return $item;
            });
        }

        $allGroups = $kalaBrundams->concat($gramaSevaDals)->concat($organicFarmers)->sortByDesc('created_at');

        $stats = [
            'total_groups' => $allGroups->count(),
            'pending_groups' => $allGroups->where('status', 'pending')->count(),
            'approved_groups' => $allGroups->where('status', 'approved')->count(),
            'total_kala_brundam' => $kalaBrundams->count(),
            'total_grama_seva_dal' => $gramaSevaDals->count(),
            'total_organic_farmers' => $organicFarmers->count(),
        ];

        $volunteers = Volunteer::where('status', 'approved')->get();

        return view('admin.local_gateways_index', compact('allGroups', 'stats', 'category', 'status', 'volunteers'));
    }

    /**
     * Approve GP Group (Admin or Volunteer Assignment)
     */
    public function approveGroup(Request $request, $wing, $id)
    {
        $volunteerId = $request->input('volunteer_id');

        if ($wing === 'kala_brundam') {
            DB::table('kala_brundams')->where('id', $id)->update([
                'status' => 'approved',
                'approved_by_volunteer_id' => $volunteerId,
                'updated_at' => now()
            ]);
        } elseif ($wing === 'grama_seva_dal') {
            DB::table('grama_seva_dals')->where('id', $id)->update([
                'status' => 'approved',
                'approved_by_volunteer_id' => $volunteerId,
                'updated_at' => now()
            ]);
        } elseif ($wing === 'organic_farmers') {
            DB::table('organic_farmers')->where('id', $id)->update([
                'status' => 'approved',
                'approved_by_volunteer_id' => $volunteerId,
                'updated_at' => now()
            ]);
        }

        return redirect()->back()->with('success', 'Group successfully verified and activated.');
    }

    /**
     * View Single GP Group Roster
     */
    public function viewGroup($wing, $id)
    {
        $group = null;
        $members = collect();

        if ($wing === 'kala_brundam') {
            $group = DB::table('kala_brundams')->where('id', $id)->first();
            if ($group) {
                $group->wing_title = 'Kala Brundam Cultural Wing';
                $group->wing_key = 'kala_brundam';
                $members = DB::table('kala_brundam_members')->where('kala_brundam_id', $id)->get();
            }
        } elseif ($wing === 'grama_seva_dal') {
            $group = DB::table('grama_seva_dals')->where('id', $id)->first();
            if ($group) {
                $group->wing_title = 'Grama Seva Dal Youth Service Wing';
                $group->wing_key = 'grama_seva_dal';
                $members = DB::table('grama_seva_dal_members')->where('grama_seva_dal_id', $id)->get();
            }
        } elseif ($wing === 'organic_farmers') {
            $group = DB::table('organic_farmers')->where('id', $id)->first();
            if ($group) {
                $group->wing_title = 'Organic Farmers Agriculture Wing';
                $group->wing_key = 'organic_farmers';
                $members = DB::table('farmer_crops')->where('farmer_id', $id)->get();
            }
        }

        if (!$group) {
            return redirect()->route('admin.local_gateways.index')->with('error', 'Group not found.');
        }

        return view('admin.local_gateways_view', compact('group', 'members', 'wing'));
    }

    /**
     * Delete Group
     */
    public function destroyGroup($wing, $id)
    {
        if ($wing === 'kala_brundam') {
            DB::table('kala_brundam_members')->where('kala_brundam_id', $id)->delete();
            DB::table('kala_brundams')->where('id', $id)->delete();
        } elseif ($wing === 'grama_seva_dal') {
            DB::table('grama_seva_dal_members')->where('grama_seva_dal_id', $id)->delete();
            DB::table('grama_seva_dals')->where('id', $id)->delete();
        } elseif ($wing === 'organic_farmers') {
            DB::table('farmer_crops')->where('farmer_id', $id)->delete();
            DB::table('organic_farmers')->where('id', $id)->delete();
        }

        return redirect()->route('admin.local_gateways.index')->with('success', 'Group deleted successfully.');
    }
}
