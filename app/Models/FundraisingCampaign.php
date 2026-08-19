<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FundraisingCampaign extends Model
{
    protected $table = 'fundraising_campaigns';

    protected $fillable = [
        'title',
        'description',
        'target_amount',
        'raised_amount',
        'end_date',
        'cover_image',
        'image_1',
        'image_2',
        'image_3',
        'image_4',
        'video_path',
        'status',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'raised_amount' => 'decimal:2',
        'end_date' => 'date',
    ];

    public function getProgressPercentAttribute()
    {
        if ($this->target_amount > 0) {
            return min(round(($this->raised_amount / $this->target_amount) * 100, 2), 100);
        }
        return 0;
    }

    public function getPublicUrlAttribute(): string
    {
        return route('donations.grid') . '#campaign_' . $this->id;
    }

    /**
     * Generate universal WhatsApp sharing URL with dynamic campaign details and canonical URL
     */
    public function getWhatsappShareUrlAttribute(): string
    {
        $campaignUrl = $this->public_url;
        $cleanDesc = \Illuminate\Support\Str::limit(strip_tags($this->description ?? ''), 120);

        $message = "🔱 Support ABVHPS Cause:\n\n"
            . "*" . trim($this->title) . "*\n\n"
            . ($cleanDesc ? $cleanDesc . "\n\n" : "")
            . "🎯 Target: ₹" . number_format($this->target_amount) . " | Raised: ₹" . number_format($this->raised_amount) . " (" . $this->progress_percent . "%)\n\n"
            . "👉 Click here to contribute:\n" . $campaignUrl . "\n\n"
            . "Help us preserve Sanatana Dharma and empower communities across India.";

        return "https://wa.me/?text=" . rawurlencode($message);
    }

    /**
     * Generate Facebook share URL
     */
    public function getFacebookShareUrlAttribute(): string
    {
        return "https://www.facebook.com/sharer/sharer.php?u=" . rawurlencode($this->public_url);
    }

    /**
     * Scope query for publicly visible active campaigns
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('end_date', '>=', Carbon::today()->toDateString());
    }
}
