<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Notification extends Model
{
    
    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title','content','order_id','client_id','shop_id');
    


    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
    public function shop()
    {
        return $this->belongsTo('App\Models\Shop');
    }
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

}