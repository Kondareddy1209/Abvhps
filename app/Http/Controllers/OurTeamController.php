<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OurTeam;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OurTeamController extends Controller
{
    /**
     * Display the Global Cadre Leader Roster Grid with Filter Channels
     */
    public function index(Request $request)
    {
        $searchToken = $request->input('search');
        $cadreFilter = $request->input('cadre_level');

        // Dynamic Query Builder Matrix with Hierarchical Filtering Vector Pipelines
        $query = OurTeam::query();

        if (!empty($searchToken)) {
            $query->where(function ($q) use ($searchToken) {
                $q->where('name', 'LIKE', '%' . $searchToken . '%')
                  ->orWhere('designation', 'LIKE', '%' . $searchToken . '%')
                  ->orWhere('locality', 'LIKE', '%' . $searchToken . '%')
                  ->orWhere('membership_id', 'LIKE', '%' . $searchToken . '%');
            });
        }

        if (!empty($cadreFilter)) {
            $query->where('cadre_level', $cadreFilter);
        }

        $teamMembers = $query->orderBy('cadre_level', 'asc')->orderBy('id', 'asc')->get();

        return view('admin.our_team.index', compact('teamMembers', 'searchToken', 'cadreFilter'));

    }

    /**
     * Display the Official View Screen to Onboard a New Hierarchical Leader
     */
    public function create()
    {
        return view('admin.our_team.create');
    }

    /**
     * Store and Upload New Global Leader Roster Packet into Core Repositories
     */
    public function store(Request $request)
    {
        $request->validate([
            'membership_id' => 'nullable|string|size:12',
            'name' => 'required|string|max:255',
            'cadre_level' => 'required|string|in:grama_panchayat,mandal_level,assembly_segment,district_level,state_level,national_level,international_level',
            'designation' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        // Secure file system storage upload packet routing
        $uploadedPath = null;
        if ($request->hasFile('image')) {
            $uploadedPath = $request->file('image')->store('teams', 'public');
        }

        OurTeam::create([
            'membership_id' => $request->membership_id,
            'name' => strtoupper($request->name), // Enforce strict uppercase uniformity bounds
            'cadre_level' => $request->cadre_level,
            'designation' => $request->designation,
            'locality' => strtoupper($request->locality),
            'image_path' => $uploadedPath
        ]);

        return redirect()
            ->route('admin.our_team.index')
            ->with('success', '🎉 New Global Committee Leader successfully onboarded into central roster matrix.');
    }

    /**
     * Display the Edit/Modification Interface for an Existing Hierarchical Leader Profile
     */
    public function edit($id)
    {
        $member = OurTeam::findOrFail($id);
        return view('admin.our_team.edit', compact('member'));
    }

    /**
     * Update and Modify Existing Global Leader Record Matrix Parameters safely
     */
    public function update(Request $request, $id)
    {
        $member = OurTeam::findOrFail($id);

        $request->validate([
            'membership_id' => 'nullable|string|size:12',
            'name' => 'required|string|max:255',
            'cadre_level' => 'required|string|in:grama_panchayat,mandal_level,assembly_segment,district_level,state_level,national_level,international_level',
            'designation' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $member->membership_id = $request->membership_id;
        $member->name = strtoupper($request->name);
        $member->cadre_level = $request->cadre_level;
        $member->designation = $request->designation;
        $member->locality = strtoupper($request->locality);

        if ($request->hasFile('image')) {
            if (!empty($member->image_path)) {
                Storage::disk('public')->delete($member->image_path);
            }
            $member->image_path = $request->file('image')->store('teams', 'public');
        }

        $member->save();

        return redirect()
            ->route('admin.our_team.index')
            ->with('success', '🎉 Global Leader hierarchy records modified and locked successfully.');
    }

    /**
     * Permanent Purge Elimination Removal of a Leader Record from Central Core Database Vaults
     */
    public function destroy($id)
    {
        $member = OurTeam::findOrFail($id);

        if (!empty($member->image_path)) {
            Storage::disk('public')->delete($member->image_path);
        }

        $member->delete();

        return redirect()
            ->route('admin.our_team.index')
            ->with('success', '🗑️ Leader roster record permanently erased from central database repositories.');
    }
        /**
     * Public Absolute Live Verification Gateway Triggered via Global Leader QR Code Scans
     */
    public function publicLiveVerification($membership_id)
    {
        // Lookup against global leaders matrix table database registry
        $member = OurTeam::where('membership_id', $membership_id)->first();

        // Fallback interface block if data token configuration is fraudulent or direct onboarded without ID
        if (!$member) {
            return response("🔱 ABVHPS SYSTEM REPORT:\n-------------------------\nCRITICAL WARNING: Scanned token verification failed. No active global leader credentials exist under this identity node.", 404)
                ->header('Content-Type', 'text/plain');
        }

        // Mapping human-readable cadre text indicators smoothly
        $cadreLabels = [
            'grama_panchayat' => 'Grama Panchayat Level Committee',
            'mandal_level' => 'Mandal Level Committee Executive',
            'assembly_segment' => 'Taluka / Assembly Segment Team',
            'district_level' => 'District Level Committee Executive',
            'state_level' => 'State Level Committee Member',
            'national_level' => 'National Level Committee Commander',
            'international_level' => 'Global International Country In-charge'
        ];

        $displayCadre = $cadreLabels[$member->cadre_level] ?? 'Verified Active Leader';
        $photoAsset = $member->image_path ? asset('storage/' . $member->image_path) : 'https://placeholder.com';
        $logoAsset = asset('images/ABVHPS_LOGO.jpg');
        
        $htmlOutput = "
        <div style='max-width: 450px; margin: 30px auto; font-family: sans-serif; padding: 20px; border: 4px solid #EA580C; border-radius: 12px; text-align: center; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);'>
            <div style='margin-bottom: 8px;'><img src='{$logoAsset}' style='width: 56px; height: 56px; border-radius: 50%; object-fit: cover; border: 2px solid #EA580C; display: inline-block;' alt='ABVHPS Logo'></div>
            <h2 style='color: #1F2937; margin: 5px 0; font-size: 16px; font-weight: 900; letter-spacing: 0.5px;'>AKHANDA BHARATA VISWA HINDU PARIRAKSHANA SAMITI</h2>
            <span style='background: #16A34A; color: white; font-size: 10px; font-weight: 900; padding: 3px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 1px; display: inline-block; margin-top: 5px;'>✓ Verified Official Leader</span>
            
            <div style='margin: 20px 0;'>
                <img src='{$photoAsset}' style='width: 110px; height: 130px; object-fit: cover; border-radius: 8px; border: 3px solid #EA580C; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);'>
            </div>
            
            <div style='background: #F9FAFB; padding: 12px; border-radius: 8px; border: 1px solid #E5E7EB; text-align: left; font-size: 13px; font-weight: 700; color: #374151;'>
                <div style='border-bottom: 1px solid #F3F4F6; padding-bottom: 5px; margin-bottom: 5px;'>Full Name: <span style='color: #111827; float: right;'>{$member->name}</span></div>
                <div style='border-bottom: 1px solid #F3F4F6; padding-bottom: 5px; margin-bottom: 5px;'>Assigned Role: <span style='color: #EA580C; float: right;'>".strtoupper($member->designation)."</span></div>
                <div style='border-bottom: 1px solid #F3F4F6; padding-bottom: 5px; margin-bottom: 5px;'>Committee Level: <span style='color: #111827; float: right;'>{$displayCadre}</span></div>
                <div>Jurisdiction Locality: <span style='color: #111827; float: right;'>{$member->locality}</span></div>
            </div>
            
            <p style='color: #9CA3AF; font-size: 9px; font-weight: 700; text-transform: uppercase; margin-top: 15px; letter-spacing: 1px;'>Global Administrative Live Secure Hierarchy Registry Node</p>
        </div>
        ";

        return response($htmlOutput)->header('Content-Type', 'text/html');
    }

}
