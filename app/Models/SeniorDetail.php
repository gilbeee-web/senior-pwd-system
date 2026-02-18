<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeniorDetail extends Model
{
    //
    
    protected $fillable = [
        'osca_id_number',
        'beneficiary_id',
        'ncsc_registration_number',
        'place_of_birth',
        'occupation',
        'other_skills',
        'receives_pension',
        'pension_amount',
        'staying_with_family',
        'living_reason',
    ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }



    // public function familyMembers()
    // {
    //     return $this->hasMany(SeniorFamilyMember::class);
    // }

}
