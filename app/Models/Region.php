<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name','city_id'];
    
    public function city(){

        return $this->belongsTo(City::class);
    }

    public function shops(){

        return $this->belongsToMany(Shop::class);
    }
}
