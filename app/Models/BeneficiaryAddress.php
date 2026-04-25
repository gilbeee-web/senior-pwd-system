<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryAddress extends Model
{
    //
    use HasFactory;
    
    protected $fillable = [
        'house_num',
        'street_id',
        'municipality',
        'province',
        'zip_code'
    ];


    public function street()
    {
        return $this->belongsTo(Street::class,'street_id');
    }

    public function beneficiaries()
    {
        return $this->hasMany(Beneficiary::class);
    }
}
