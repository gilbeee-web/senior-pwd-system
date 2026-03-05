<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PwdDetail extends Model
{
    //
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
        'is_middleclass',
    ];


    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }
}
