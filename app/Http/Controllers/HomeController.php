<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // 1. Public Website Home Page Layout
    public function index()
    {
        // Fetch all active sliders from database
        $sliders = DB::table('home_sliders')->where('is_active', true)->orderBy('sort_order', 'asc')->get();

        // Fetch all active core projects from database
        $projects = DB::table('our_supports')->where('status', 'show')->orderBy('sort_order', 'asc')->get();

        // Fetch the latest active fundraising campaign from database
        $fundraising = DB::table('fundraisings')->where('is_active', true)->latest()->first();

        // Static counts representing live database connection in future updates
        $liveCounts = [
            'donors' => 960,
            'members' => 9000,
            'volunteers' => 852,
            'years' => 10
        ];

        // Pass all database items to the view folder
        return view('home', compact('sliders', 'projects', 'fundraising', 'liveCounts'));
    }

    // 2. Public Website Gallery Page Node
    public function gallery()
    {
        // Fetch all active photos and videos uploaded from admin panel
        $galleryItems = DB::table('galleries')->orderBy('id', 'desc')->get();

        return view('gallery', compact('galleryItems'));
    }

    // 3. Public Website Blogs / Articles Page Node
    public function blogs()
    {
        // Fetch all published blog articles from admin panel (Only active status)
        $blogs = DB::table('blogs')->where('status', 'active')->orderBy('id', 'desc')->paginate(9);

        return view('blogs', compact('blogs'));
    }

    // 4. Public Website Our Team Leadership Page Node
    public function team()
    {
        // Fetch all onboarded committee leaders from admin panel
        $teamMembers = DB::table('our_teams')->orderBy('id', 'asc')->get();

        return view('team', compact('teamMembers'));
    }
        // 5. Display Public Single Project Full Details Page
    public function showProject($id)
    {
        // Fetch the specific core service project from database using ID
        $project = DB::table('our_supports')->where('id', $id)->where('status', 'show')->first();

        // If project not found, redirect back to home page
        if (!$project) {
            return redirect()->route('public.home');
        }

        return view('project_details', compact('project'));
    }

}
