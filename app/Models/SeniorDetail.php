<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeniorDetail extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'osca_id_number',
        'beneficiary_id',
        'ncsc_registration_number',
        'place_of_birth',
        'occupation',
        'receives_pension',
        'pension_amount',
        'date_id_issued'
    ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }



    public function familyMembers()
    {
        return $this->hasMany(SeniorFamilyMember::class);
    }

    // Requests related to this senior
    public function requests()
    {
        return $this->morphMany(ActionRequest::class, 'model');
    }

}
