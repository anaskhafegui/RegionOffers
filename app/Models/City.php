<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name'];

    public function regions(){

        return $this->hasMany(Region::class);
    }
     public function getNameAttribute($value)
    {
        return unserialize($value);
    } 
}
