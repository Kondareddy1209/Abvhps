<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    /**
     * The official database table associated with the model.
     *
     * @var string
     */
    protected $table = 'blogs';

    /**
     * The attributes that are mass assignable inside core systems.
     * Defends against malicious request parameters injection attempts.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'image_path',
        'thumbnail_path',
        'content',
        'status',
    ];
}
