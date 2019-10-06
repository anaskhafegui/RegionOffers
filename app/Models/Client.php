<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Schedula\Laravel\PassportSocialite\User\UserSocialAccount;
use Illuminate\Foundation\Auth\Client as Authenticatable;


class Client extends Model implements UserSocialAccount
{
    use HasApiTokens, Notifiable;

    protected $fillable = [

        'name', 'email', 'phone' ,'password', 'api_token', 'provider', 'provider_id'

    ];

    public function socials(){

        return $this->hasMany(SocialAccount::class);
    }

    public static function findForPassportSocialite($provider,$id) {
        $account = SocialAccount::where('provider', $provider)->where('provider_user_id', $id)->first();
        if($account) {
            if($account->user){
                return $account->user;
            }
        }
        return;
    }
}
