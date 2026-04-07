<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionRequest extends Model
{
    //

    protected $fillable = [
        'type', 
        'model_type',
        'model_id',
        'requested_by',
        'payload',
        'status',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'payload' => 'array',
        'approved_at' => 'datetime',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }   


    //this relationship will morph or combine the model_type and model_id in just one variable "model" so meaning $request->model is find the model with the id
    public function model()
    {
        return $this->morphTo();
    }

    

}
