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

        'name', 'email', 'phone' ,'password', 'api_token', 'city_id', 'address','profile_image'

    ];

  
}
