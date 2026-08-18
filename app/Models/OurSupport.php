<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurSupport extends Model
{
    /**
     * The official database table associated with the model.
     *
     * @var string
     */
    protected $table = 'our_supports';

    /**
     * The attributes that are mass assignable inside core systems.
     * Defends against malicious request parameters injection attempts.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sort_order',
        'image_path',
        'short_info',
        'status',
    ];
}
