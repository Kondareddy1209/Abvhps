<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'page_key',
        'page_name',
        'title',
        'subtitle',
        'desktop_banner',
        'mobile_banner',
        'status',
        'sort_order',
    ];

    /**
     * Controlled list of all existing public website pages in ABVHPS
     */
    public static function getSupportedPages(): array
    {
        return [
            'home'            => 'Home',
            'about'           => 'About',
            'team'            => 'Our Team',
            'gallery'         => 'Gallery',
            'membership'      => 'Membership',
            'volunteer'       => 'Volunteer',
            'exam'            => 'Exam',
            'fundraise'       => 'Fundraise',
            'blogs'           => 'Blogs',
            'contact'         => 'Contact',
            'rudrasena'       => 'Rudra Sena',
            'kalabrundam'     => 'Kala Brundham',
            'gramasevadal'    => 'Grama Seva Dal',
            'organicfarmers'  => 'Organic Farmers',
            'certificates'    => 'Compliance Certificates',
            'donation'        => 'Donation',
        ];
    }

    /**
     * Resolve human-readable name for a given page key
     */
    public static function resolvePageName(?string $pageKey): string
    {
        $pages = static::getSupportedPages();
        return $pages[$pageKey] ?? ucfirst(str_replace(['-', '_'], ' ', $pageKey ?? 'General'));
    }

    /**
     * Scope query to only show/active banners
     */
    public function scopeShow($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'show')
              ->orWhere('status', 'Show')
              ->orWhere('status', 'active')
              ->orWhere('status', '1');
        });
    }

    /**
     * Static helper to fetch the primary active banner for a specific page
     */
    public static function getBannerForPage(string $pageKey): ?Banner
    {
        return static::where('page_key', $pageKey)
            ->show()
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Accessor for full Desktop Banner public URL
     */
    public function getDesktopUrlAttribute(): ?string
    {
        if (empty($this->desktop_banner)) {
            return null;
        }

        if (filter_var($this->desktop_banner, FILTER_VALIDATE_URL)) {
            return $this->desktop_banner;
        }

        return asset('storage/' . $this->desktop_banner);
    }

    /**
     * Accessor for full Mobile Banner public URL (falls back to Desktop Banner if missing)
     */
    public function getMobileUrlAttribute(): ?string
    {
        $path = !empty($this->mobile_banner) ? $this->mobile_banner : $this->desktop_banner;

        if (empty($path)) {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . $path);
    }

    /**
     * Check if banner is visible / active
     */
    public function getIsVisibleAttribute(): bool
    {
        return in_array(strtolower((string) $this->status), ['show', 'active', '1', 'true'], true);
    }
}
