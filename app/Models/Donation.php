<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    /**
     * The official database table associated with the model.
     *
     * @var string
     */
    protected $table = 'donations';

    /**
     * The attributes that are mass assignable inside core systems.
     * Defends against malicious request parameters injection attempts.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'guardian',
        'amount',
        'pan_number',
        'contact',
        'about',
    ];
}
