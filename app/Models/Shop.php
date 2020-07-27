<?php

namespace App\Models;
use App\Scoping\Scoper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = 'shops';
    public $timestamps = true;
    protected $fillable = array(
        'region_id','category_id', 'name', 'email', 'password','delivery_cost', 'minimum_charger',
        'phone','whatsapp', 'photo', 'availability', 'api_token','code','activated','about','delivery','takeaway','address'
    );
    protected $appends = ['photo_url'];
    

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function offers(){
        return $this->hasMany(Offer::class);
    }
    public function regions(){
        return $this->belongsToMany(Region::class,'region_shop');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    public function tokens()
    {
        return $this->hasMany('App\Models\Token');
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }
    public function getShopDetailsAttribute()
    {
        $cityName = count($this->regions) ? $this->regions[0]->name.':' : '';
        return $cityName.$this->name.' : '.$this->phone;
    }
     
   public function getRateAttribute($value)
    {
        $sumRating = $this->reviews()->sum('rate');
        $countRating = $this->reviews()->count();
        $avgRating = 0;
        if ($countRating > 0)
        {
            $avgRating = round($sumRating/$countRating,1);
        }
        return number_format($this->reviews()->avg('rate'), 0, '.', '');
    }

    public function scopeActivated($query)
    {
        return $query->where('activated',1);
    }

    public function getTotalOrdersAmountAttribute($value)
    {
        $commissions = $this->orders()->where('state','delivered')->sum('total');

        return $commissions;
    }

    public function getTotalCommissionsAttribute($value)
    {
        $commissions = $this->orders()->where('state','delivered')->sum('commission');

        return $commissions;
    }

    public function getTotalPaymentsAttribute($value)
    {
        $payments = $this->transactions()->sum('amount');

        return $payments;
    }

    public function getPhotoUrlAttribute($value)
    {
        return url($this->photo);
    }

    public function scopeWithScopes(Builder $builder, $scopes=[] ){
       
        return (new Scoper(request()))->apply($builder,$scopes);

    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'api_token', 'code'
    ];


}
