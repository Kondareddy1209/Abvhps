<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    /**
     * The official database table associated with the model.
     *
     * @var string
     */
    protected $table = 'galleries';

    /**
     * The attributes that are mass assignable inside core systems.
     * Defends against malicious request parameters injection attempts.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image_path',
        'video_url',
        'media_type',
    ];
}
