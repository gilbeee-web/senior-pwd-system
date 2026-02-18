<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    //
    protected $fillable = ['name','barangay_id', 'created_at', 'updated_at'];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    public function addresses()
    {
        return $this->hasMany(BeneficiaryAddress::class);
    }
}
