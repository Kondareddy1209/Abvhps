<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RudrasenaMember extends Model
{
    protected $table = 'rudrasena_members';

    protected $fillable = [
        'membership_id',
        'full_name',
        'email',
        'mobile',
        'volunteer_type',
        'dob',
        'age',
        'blood_group',
        'gotram',
        'nominee_name',
        'nominee_relation',
        'nominee_age',
        'nominee_contact',
        'bank_holder_name',
        'bank_account_number',
        'bank_ifsc_code',
        'bank_name_branch',
        'document_health_declaration',
        'document_family_declaration',
        'document_id_proof',
        'document_bank_proof',
        'rudrasena_id',
        'assigned_cadder',
        'assigned_locality',
        'status',
        'disclaimer_accepted',
        'terms_accepted_at'
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'membership_id');
    }

    public function familyDetails()
    {
        return $this->hasMany(RudrasenaFamilyDetail::class, 'rudrasena_member_id', 'id');
    }
}
