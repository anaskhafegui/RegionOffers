<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name','image'];

    public function shops(){

        return $this->hasMany(Shop::class);
    }

    public function  offers(){

        return $this->hasMany(Offer::class);
    }

    public function getPhotoUrlAttribute($value)
    {
        return url($this->photo);
    }
     
}
