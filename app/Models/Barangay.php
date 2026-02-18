<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    //

    protected $fillable = ['name', 'created_at', 'updated_at'];

    public function streets()
    {
        return $this->hasMany(Street::class);
    }

}
