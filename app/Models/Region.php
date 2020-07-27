<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'name_ar', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }

    public function clients()
    {
        return $this->hasMany(Region::class);
    }
}
