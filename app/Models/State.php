<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $guarded=[];

    // State To Country Relationship 
    public function country(){
        return $this->belongsTo(Country::class);
    }

    // State to CIty Relationship 
    public function Cities(){
        return $this->hasMany(City::class);
    }
}
