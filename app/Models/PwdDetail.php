<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PwdDetail extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];


    protected $fillable = [
        'pwd_id_number',
        'beneficiary_id',
        'disability_type',
        'guardian_name',
        'blood_type',
        'educational_attainment',
        'date_id_issued',
        'date_id_expiration',
        'qr_link',
        'is_middleclass',
    ];


    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

    //Requests related to this pwd
    public function requests()
    {
        return $this->morphMany(ActionRequest::class, 'model');
    }

    
}
