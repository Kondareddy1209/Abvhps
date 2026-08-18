<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $table = 'volunteers';

    protected $fillable = [
        'membership_id',
        'phone',
        'qualification',
        'voter_id_number',
        'email',
        'password',
        'bank_name',
        'account_holder_name',
        'account_number',
        'ifsc_code',
        'branch_name',
        'nominee_name',
        'nominee_relation',
        'nominee_phone',
        'document_declaration_path',
        'document_voter_path',
        'document_bank_path',
        'status',
        'cadre',
        'role',
        'designation',
        'locality',
        'volunteer_id',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'membership_id');
    }
}
