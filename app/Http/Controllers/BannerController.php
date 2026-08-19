<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use App\Services\AuditLogger;

class BannerController extends Controller
{
    /**
     * Display the Admin Banner Management Desk with Page Filtering and Search
     */
    public function index(Request $request)
    {
        $selectedPage = $request->query('page') ?: $request->query('page_key');
        $searchToken  = $request->query('search');
        $statusFilter = $request->query('status');

        $query = Banner::query();

        if (!empty($selectedPage) && $selectedPage !== 'all') {
            $query->where('page_key', $selectedPage);
        }

        if (!empty($statusFilter) && $statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        if (!empty($searchToken)) {
            $query->where(function ($q) use ($searchToken) {
                $q->where('page_key', 'LIKE', "%{$searchToken}%")
                  ->orWhere('page_name', 'LIKE', "%{$searchToken}%")
                  ->orWhere('title', 'LIKE', "%{$searchToken}%")
                  ->orWhere('subtitle', 'LIKE', "%{$searchToken}%")
                  ->orWhere('id', $searchToken);
            });
        }

        $banners = $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc')->paginate(15)->withQueryString();

        $pages = Banner::getSupportedPages();

        $stats = [
            'total_banners'  => Banner::count(),
            'active_banners' => Banner::show()->count(),
            'hidden_banners' => Banner::where('status', 'hide')->orWhere('status', 'Hide')->orWhere('status', 'inactive')->orWhere('status', '0')->count(),
            'pages_covered'  => Banner::distinct('page_key')->count('page_key'),
        ];

        return view('admin.banner.index', compact('banners', 'pages', 'selectedPage', 'searchToken', 'statusFilter', 'stats'));
    }

    /**
     * Show the form for creating a new Page-specific Banner
     */
    public function create()
    {
        $pages = Banner::getSupportedPages();
        return view('admin.banner.create', compact('pages'));
    }

    /**
     * Store a newly created Banner in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'page_key'       => 'required|string|max:100',
            'desktop_banner' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            'mobile_banner'  => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'status'         => 'required|in:show,hide,Show,Hide',
            'title'          => 'nullable|string|max:255',
            'subtitle'       => 'nullable|string|max:500',
            'sort_order'     => 'nullable|integer',
        ], [
            'page_key.required'       => 'Please select which website page this banner belongs to.',
            'desktop_banner.required' => 'Desktop banner image is required.',
            'desktop_banner.image'    => 'Desktop banner must be a valid image file (JPG, PNG, WEBP).',
            'mobile_banner.image'     => 'Mobile banner must be a valid image file (JPG, PNG, WEBP).',
        ]);

        $desktopPath = $request->file('desktop_banner')->store('banners', 'public');
        $mobilePath  = $request->hasFile('mobile_banner') 
            ? $request->file('mobile_banner')->store('banners', 'public') 
            : null;

        $pageKey  = strtolower(trim($request->page_key));
        $pageName = Banner::resolvePageName($pageKey);

        $banner = Banner::create([
            'page_key'       => $pageKey,
            'page_name'      => $pageName,
            'title'          => $request->title,
            'subtitle'       => $request->subtitle,
            'desktop_banner' => $desktopPath,
            'mobile_banner'  => $mobilePath,
            'status'         => strtolower($request->status) === 'show' ? 'show' : 'hide',
            'sort_order'     => $request->sort_order ?? 0,
        ]);

        if (class_exists(AuditLogger::class)) {
            AuditLogger::log('banner_created', 'Banner', (string) $banner->id, ['info' => "Created banner for page: {$pageName}"]);
        }

        return redirect()
            ->route('admin.banner.index')
            ->with('success', "🎉 Banner for '{$pageName}' page created and published successfully.");
    }

    /**
     * Show the form for editing an existing Banner
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        $pages  = Banner::getSupportedPages();

        return view('admin.banner.edit', compact('banner', 'pages'));
    }

    /**
     * Update the specified Banner in storage
     */
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'page_key'       => 'required|string|max:100',
            'desktop_banner' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'mobile_banner'  => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'status'         => 'required|in:show,hide,Show,Hide',
            'title'          => 'nullable|string|max:255',
            'subtitle'       => 'nullable|string|max:500',
            'sort_order'     => 'nullable|integer',
        ], [
            'page_key.required'    => 'Please select which website page this banner belongs to.',
            'desktop_banner.image' => 'Desktop banner must be a valid image file (JPG, PNG, WEBP).',
            'mobile_banner.image'  => 'Mobile banner must be a valid image file (JPG, PNG, WEBP).',
        ]);

        $desktopPath = $banner->desktop_banner;
        if ($request->hasFile('desktop_banner')) {
            // Delete old desktop image if exists
            if (!empty($banner->desktop_banner) && Storage::disk('public')->exists($banner->desktop_banner)) {
                Storage::disk('public')->delete($banner->desktop_banner);
            }
            $desktopPath = $request->file('desktop_banner')->store('banners', 'public');
        }

        $mobilePath = $banner->mobile_banner;
        if ($request->hasFile('mobile_banner')) {
            // Delete old mobile image if exists
            if (!empty($banner->mobile_banner) && Storage::disk('public')->exists($banner->mobile_banner)) {
                Storage::disk('public')->delete($banner->mobile_banner);
            }
            $mobilePath = $request->file('mobile_banner')->store('banners', 'public');
        }

        $pageKey  = strtolower(trim($request->page_key));
        $pageName = Banner::resolvePageName($pageKey);

        $banner->update([
            'page_key'       => $pageKey,
            'page_name'      => $pageName,
            'title'          => $request->title,
            'subtitle'       => $request->subtitle,
            'desktop_banner' => $desktopPath,
            'mobile_banner'  => $mobilePath,
            'status'         => strtolower($request->status) === 'show' ? 'show' : 'hide',
            'sort_order'     => $request->sort_order ?? $banner->sort_order,
        ]);

        if (class_exists(AuditLogger::class)) {
            AuditLogger::log('banner_updated', 'Banner', (string) $banner->id, ['info' => "Updated banner for page: {$pageName}"]);
        }

        return redirect()
            ->route('admin.banner.index')
            ->with('success', "✓ Banner for '{$pageName}' page updated successfully.");
    }

    /**
     * Toggle the status of a Banner between show and hide
     */
    public function toggleStatus($id)
    {
        $banner = Banner::findOrFail($id);
        $newStatus = $banner->status === 'show' ? 'hide' : 'show';
        $banner->update(['status' => $newStatus]);

        $statusLabel = $newStatus === 'show' ? 'Visible (Show)' : 'Hidden (Hide)';

        if (class_exists(AuditLogger::class)) {
            AuditLogger::log('banner_status_toggled', 'Banner', (string) $banner->id, ['status' => $newStatus]);
        }

        return redirect()
            ->route('admin.banner.index')
            ->with('success', "Status for '{$banner->page_name}' banner set to {$statusLabel}.");
    }

    /**
     * Remove the specified Banner from storage
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $pageName = $banner->page_name;

        // Clean up attached physical image files from storage
        if (!empty($banner->desktop_banner) && Storage::disk('public')->exists($banner->desktop_banner)) {
            Storage::disk('public')->delete($banner->desktop_banner);
        }
        if (!empty($banner->mobile_banner) && Storage::disk('public')->exists($banner->mobile_banner)) {
            Storage::disk('public')->delete($banner->mobile_banner);
        }

        $banner->delete();

        if (class_exists(AuditLogger::class)) {
            AuditLogger::log('banner_deleted', 'Banner', (string) $id, ['info' => "Deleted banner for page: {$pageName}"]);
        }

        return redirect()
            ->route('admin.banner.index')
            ->with('success', "🗑️ Banner for '{$pageName}' page permanently deleted.");
    }
}
