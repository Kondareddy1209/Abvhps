<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    /**
     * The official database table associated with the model.
     *
     * @var string
     */
    protected $table = 'memberships';

    /**
     * The attributes that are mass assignable inside core systems.
     * Maps perfectly with payment tokens, Aadhaar, and address configurations.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'membership_id',
        'phone',
        'payment_status',
        'payment_id',
        'aadhaar_number',
        'full_name',
        'gender',
        'dob',
        'father_or_husband_name',
        'photo_path',
        'gotram',
        'occupation',
        'blood_group',
        'email',
        'permanent_address',
        'present_address',
        'pincode',
        'grama_panchayat',
        'mandal',
        'assembly_segment',
        'district',
        'state',
        'country',
        'is_completed',
    ];
}
