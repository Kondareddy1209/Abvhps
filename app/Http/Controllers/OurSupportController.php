<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OurSupport;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OurSupportController extends Controller
{
    /**
     * Display the Official Admin Our Support Missions Ledger with Search Filter Channels
     */
    public function index(Request $request)
    {
        $searchToken = $request->input('search');

        // Dynamic Query Builder Matrix with Search Filter Vector Pipeline
        $query = OurSupport::query();

        if (!empty($searchToken)) {
            $query->where(function ($q) use ($searchToken) {
                $q->where('name', 'LIKE', '%' . $searchToken . '%')
                  ->orWhere('short_info', 'LIKE', '%' . $searchToken . '%');
            });
        }

        // Enforce strict priority sort order hierarchy layout mapping
        $supports = $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        return view('admin.our_support.index', compact('supports', 'searchToken'));
    }

    /**
     * Display the Official View Screen to Onboard a New Mission Project
     */
    public function create()
    {
        return view('admin.our_support.create');
    }

    /**
     * Store and Upload New Core Mission Project Packet into Central Repositories
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'required|integer|min:1',
            'short_info' => 'required|string',
            'status' => 'required|in:show,hide',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048' // Safe boundary 2MB size limit
        ]);

        // Secure file system storage upload packet routing
        $uploadedPath = null;
        if ($request->hasFile('image')) {
            $uploadedPath = $request->file('image')->store('supports', 'public');
        }

        OurSupport::create([
            'name' => strtoupper($request->name), // Enforce strict uppercase uniformity bounds
            'sort_order' => $request->sort_order,
            'short_info' => $request->short_info,
            'status' => $request->status,
            'image_path' => $uploadedPath
        ]);

        return redirect()
            ->route('admin.our_support.index')
            ->with('success', '🎉 New core mission project successfully added into central systems.');
    }

    /**
     * Display the Edit/Modification Interface for an Existing Mission Profile
     */
    public function edit($id)
    {
        $support = OurSupport::findOrFail($id);
        return view('admin.our_support.edit', compact('support'));
    }

    /**
     * Update and Modify Existing Support Mission Parameters safely
     */
    public function update(Request $request, $id)
    {
        $support = OurSupport::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sort_order' => 'required|integer|min:1',
            'short_info' => 'required|string',
            'status' => 'required|in:show,hide',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $support->name = strtoupper($request->name);
        $support->sort_order = $request->sort_order;
        $support->short_info = $request->short_info;
        $support->status = $request->status;

        // If a new project image is provided, clear the obsolete asset reference to clean disk space
        if ($request->hasFile('image')) {
            if (!empty($support->image_path)) {
                Storage::disk('public')->delete($support->image_path);
            }
            $support->image_path = $request->file('image')->store('supports', 'public');
        }

        $support->save();

        return redirect()
            ->route('admin.our_support.index')
            ->with('success', '🎉 Mission project metrics modified and locked successfully.');
    }

    /**
     * Permanent Purge Elimination Removal of a Support Record from Central Core Database Vaults
     */
    public function destroy($id)
    {
        $support = OurSupport::findOrFail($id);

        // Disconnect and erase image file from public disk before database erasure trigger
        if (!empty($support->image_path)) {
            Storage::disk('public')->delete($support->image_path);
        }

        $support->delete();

        return redirect()
            ->route('admin.our_support.index')
            ->with('success', '🗑️ Mission project record permanently erased from central database repositories.');
    }
}
