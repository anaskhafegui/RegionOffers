<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function category(){

        return $this->belongsTo(Category::class);
    }

    public function offers(){

        return $this->hasMany(Offer::class);
    }

    public function regions(){

        return $this->belongsToMany(Region::class);
    }

}
