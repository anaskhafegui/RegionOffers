<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $table = 'reviews';
    public $timestamps = true;
    protected $fillable = array('comment', 'rate', 'shop_id', 'client_id');
    protected $with = ['client', 'shop'];

    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

}