<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded=[];

    // City to State Relationship 
    public function state(){
        return $this->belongsTo(State::class);
    }
}
