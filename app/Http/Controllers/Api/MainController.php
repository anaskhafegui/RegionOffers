<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\City;
use App\Models\Region;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Shop;


class MainController extends Controller
{
   
    public function cities(Request $request)
    {  
       
        $cities = City::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->paginate(10);
        return responseJson(1,'تم التحميل',$cities);
    }

    public function regions(Request $request)
    {
        $regions = Region::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->where('city_id',$request->city_id)->paginate(10);

        return responseJson(1,'تم التحميل',$regions);
    }

    public function categories()
    {
        $categories = Category::has('shops')->paginate(10);
        if (!$categories)
        {
            return responseJson(0,'no data');
        }
        return responseJson(1,'تم التحميل',$categories);
    }

    public function shops(Request $request)
    {
        //مش لازم يخرج ويخش كاتيجوري تاني هيا دينامك
      
        $shops = Shop::where(function($q) use($request) {
            if ($request->has('keyword'))
            {
                $q->where(function($q2) use($request){
                    $q2->where('name','LIKE','%'.$request->keyword.'%');
                });
            }

            if ($request->has('category_id'))
            {
                $q->where('category_id',$request->category_id);
            }

            if ($request->has('region_id'))
            {
                $q->whereHas('regions',function($q2) use($request){
                    $q2->where('regions.id',$request->region_id);
                });

            }

        })->has('offers')->with('regions.city', 'category')->paginate(10);

        if (!$shops)
        {
            return responseJson(0,'no data');
        }
        
        return responseJson(1,'تم التحميل',$shops);
        /*
         *->orderByRating()
         * ->sortByDesc(function ($restaurant) {
            return $restaurant->reviews->sum('rate');
        })
         * */
    }
    public function offers(Request $request)
    {

      $offers = Offer::where('shop_id','=',$request->shop_id)->with('shop.regions')->paginate(10);

      if (!$offers)
      {
          return responseJson(0,' لايوجد عروض حالية لهذا المحل');
      }


      return responseJson(1,'تم التحميل',$offers);
   
}











}
