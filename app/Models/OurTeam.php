<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurTeam extends Model
{
    /**
     * The official database table associated with the model.
     *
     * @var string
     */
    protected $table = 'our_teams';

    /**
     * The attributes that are mass assignable inside global cadre systems.
     * Defends against malicious request parameters injection attempts.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'membership_id',
        'name',
        'cadre_level',
        'designation',
        'locality',
        'image_path',
    ];
}
