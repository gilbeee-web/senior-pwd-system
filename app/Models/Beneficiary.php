<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiary extends Model
{
    //

    use SoftDeletes;

    protected $fillable = [
        'beneficiary_address_id',
        'type',
        'last_name',
        'first_name',
        'middle_name',
        'extension',
        'birthdate',
        'contact_number',
        'civil_status',
        'gender',
    ];

    public function address()
    {
        return $this->belongsTo(BeneficiaryAddress::class);
    }

    public function pwdDetail()
    {
        return $this->hasOne(PwdDetail::class);
    }

    public function seniorDetail()
    {
        return $this->hasOne(SeniorDetail::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }



  

}
