<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Client as Authenticatable;


class Client extends Model 
{
    use HasApiTokens, Notifiable;

    protected $fillable = [

        'name', 'email', 'phone' ,'password', 'api_token', 'region_id', 'address','profile_image','gender','birthday'

    ];
    
    public function region(){

        return $this->belongsTo(Region::class);
    }
    public function orders(){

        return $this->hasMany(Order::class);
    }
    public function reviews(){

        return $this->hasMany(Order::class);
    }

  
}
