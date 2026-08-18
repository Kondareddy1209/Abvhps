<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GalleryController extends Controller
{
    /**
     * Display the Official Admin Media Gallery Desk Layout Panel
     */
    public function index()
    {
        // Fetch all physical photos and embedded video links from database vaults
        $galleryItems = Gallery::orderBy('id', 'desc')->get();

        return view('admin.gallery.index', compact('galleryItems'));
    }

    /**
     * Store and Upload New Media Package Assets (Photo Files or Video Links)
     */
    public function store(Request $request)
    {
        $request->validate([
            'media_type' => 'required|in:image,video',
            'image' => 'required_if:media_type,image|nullable|image|mimes:jpeg,jpg,png|max:2048', // Safe boundary 2MB size limit
            'video_url' => 'required_if:media_type,video|nullable|url|max:255' // Valid URL schema check
        ]);

        $uploadedPath = null;

        // Route routing to local secure public disk bounds if media payload is a photo asset
        if ($request->media_type === 'image' && $request->hasFile('image')) {
            $uploadedPath = $request->file('image')->store('gallery', 'public');
        }

        Gallery::create([
            'media_type' => $request->media_type,
            'image_path' => $uploadedPath,
            'video_url' => $request->media_type === 'video' ? $request->video_url : null
        ]);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', '🎉 New media asset safely deployed and published into central service gallery.');
    }

    /**
     * Permanent Purge Elimination Removal of a Gallery Asset and its attached physical file
     */
    public function destroy($id)
    {
        $media = Gallery::findOrFail($id);

        // Disconnect and wipe the profile photo file reference from public disk storage to claim bytes space
        if ($media->media_type === 'image' && !empty($media->image_path)) {
            Storage::disk('public')->delete($media->image_path);
        }

        $media->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', '🗑️ Gallery media record permanently erased from central repositories.');
    }
}
