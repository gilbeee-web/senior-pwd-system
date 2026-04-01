<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeniorFamilyMember extends Model
{
    //
    protected $fillable = ['senior_detail_id', 'full_name', 'relationship', 'birthdate', 'civil_status', 'occupation', 'income'];
    
    public function seniorDetail(){
        return $this->belongsTo(SeniorDetail::class);
    }

}
