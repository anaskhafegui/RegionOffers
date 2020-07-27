<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Offer extends Model
{
    protected $table = 'offers';
    public $timestamps = true;
    protected $fillable = ['title', 'title_ar', 'description','description_ar', 'price', 'starting_at', 'ending_at', 'photo', 'shop_id', 'created_at', 'updated_at'];

    protected $dates = ['starting_at', 'ending_at'];
    protected $appends = ['available', 'photo_url'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order')->withPivot('price', 'quantity', 'note');
    }

    public function getPhotoUrlAttribute($value)
    {
        return url($this->photo);
    }

    public function getAvailableAttribute()
    {
        $today = Carbon::now();
        if ($this->starting_at <= $today && $this->ending_at >= $today) {
            return true;
        }
        return false;
    }
}
