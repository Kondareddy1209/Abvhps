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

    /**
     * Format numbers into Indian numbering style (e.g. ₹50,00,000 / ₹1,00,000 / ₹5,000)
     */
    public static function formatIndianCurrency(float|int|string|null $number): string
    {
        $num = (int) round((float) ($number ?? 0));
        if ($num === 0) {
            return '₹0';
        }
        $isNegative = $num < 0;
        $num = abs($num);
        $numStr = (string) $num;
        if (strlen($numStr) <= 3) {
            $formatted = $numStr;
        } else {
            $last3 = substr($numStr, -3);
            $rest = substr($numStr, 0, -3);
            $restFormatted = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
            $formatted = $restFormatted . ',' . $last3;
        }
        return ($isNegative ? '-₹' : '₹') . $formatted;
    }

    /**
     * Get publicly accessible HTTPS image URL for Open Graph / Social previews
     */
    public function getPublicImageUrlAttribute(): string
    {
        if (!empty($this->cover_image)) {
            if (\Illuminate\Support\Str::startsWith($this->cover_image, ['http://', 'https://'])) {
                return $this->cover_image;
            }
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/ABVHPS_LOGO.jpg');
    }

    /**
     * Canonical crawler-friendly public campaign URL
     */
    public function getPublicUrlAttribute(): string
    {
        return route('donations.campaign', $this->id);
    }

    /**
     * Generate professional WhatsApp sharing URL with dynamic campaign details and Indian currency formatting
     */
    public function getWhatsappShareUrlAttribute(): string
    {
        $campaignUrl = $this->public_url;
        $cleanTitle = trim($this->title);
        $cleanDesc = trim(strip_tags($this->description ?? ''));
        if ($cleanDesc) {
            $cleanDesc = \Illuminate\Support\Str::limit($cleanDesc, 140);
        }

        $targetFormatted = self::formatIndianCurrency($this->target_amount);
        $raisedFormatted = self::formatIndianCurrency($this->raised_amount);
        $percent = $this->progress_percent;
        $percentFormatted = (floor($percent) == $percent) ? number_format($percent, 0) : number_format($percent, 1);

        $message = "🙏 SUPPORT ABVHPS\n\n"
            . "🌺 *" . $cleanTitle . "*\n\n"
            . ($cleanDesc ? $cleanDesc . "\n\n" : "")
            . "🎯 Target: " . $targetFormatted . "\n"
            . "💰 Raised: " . $raisedFormatted . "\n"
            . "📊 Progress: " . $percentFormatted . "%\n\n"
            . "🔗 Support this campaign:\n"
            . $campaignUrl . "\n\n"
            . "Every contribution helps us continue our service activities.\n\n"
            . "🙏 Join us in supporting this cause.";

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
