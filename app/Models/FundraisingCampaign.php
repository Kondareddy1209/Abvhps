<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
