<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BlogController extends Controller
{
    /**
     * Display the Official Admin Blogs Matrix Registry with Filter Channels
     */
    public function index(Request $request)
    {
        $searchToken = $request->input('search');

        // Dynamic Query Builder Matrix with Search Filter Vector Pipeline
        $query = Blog::query();

        if (!empty($searchToken)) {
            $query->where(function ($q) use ($searchToken) {
                $q->where('title', 'LIKE', '%' . $searchToken . '%')
                  ->orWhere('content', 'LIKE', '%' . $searchToken . '%');
            });
        }

        $blogs = $query->orderBy('id', 'desc')->get();

        return view('admin.blog.index', compact('blogs', 'searchToken'));
    }

    /**
     * Display the Official View Screen to Onboard a New Blog Post
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store and Upload New Blog Post Content and Image Files into Repositories
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,draft',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048', // Max 2MB Main Image
            'thumbnail' => 'required|image|mimes:jpeg,jpg,png|max:1048' // Max 1MB Thumbnail Image
        ]);

        // Secure file system storage upload paths processing
        $mainImagePath = null;
        $thumbnailPath = null;

        if ($request->hasFile('image')) {
            $mainImagePath = $request->file('image')->store('blogs/main', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('blogs/thumb', 'public');
        }

        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'image_path' => $mainImagePath,
            'thumbnail_path' => $thumbnailPath
        ]);

        return redirect()
            ->route('admin.blog.index')
            ->with('success', '🎉 Religious blog article successfully published into central database.');
    }

    /**
     * Display the Edit/Modification Interface for an Existing Blog Post
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog'));
    }

    /**
     * Update and Modify Existing Blog Post Parameters Safely
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:active,draft',
            'image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,jpg,png|max:1048'
        ]);

        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->status = $request->status;

        // If a new main image is provided, clear the obsolete asset file to free disk space
        if ($request->hasFile('image')) {
            if (!empty($blog->image_path)) {
                Storage::disk('public')->delete($blog->image_path);
            }
            $blog->image_path = $request->file('image')->store('blogs/main', 'public');
        }

        // Handle separate thumbnail image asset update
        if ($request->hasFile('thumbnail')) {
            if (!empty($blog->thumbnail_path)) {
                Storage::disk('public')->delete($blog->thumbnail_path);
            }
            $blog->thumbnail_path = $request->file('thumbnail')->store('blogs/thumb', 'public');
        }

        $blog->save();

        return redirect()
            ->route('admin.blog.index')
            ->with('success', '🎉 Blog post configurations modified and re-locked successfully.');
    }

    /**
     * Permanent Purge Elimination Removal of a Blog Post and its Attached Assets
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Disconnect and purge physical image assets before data layer erasure
        if (!empty($blog->image_path)) {
            Storage::disk('public')->delete($blog->image_path);
        }

        if (!empty($blog->thumbnail_path)) {
            Storage::disk('public')->delete($blog->thumbnail_path);
        }

        $blog->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('success', '🗑️ Blog post and related asset packages permanently purged from central systems.');
    }
}
