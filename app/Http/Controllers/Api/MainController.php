<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\City;
use App\Models\Region;
use App\Models\Category;


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
        })->where('cities_id',$request->cities_id)->paginate(10);

        return responseJson(1,'تم التحميل',$regions);
    }


    public function categories()
    {
        $categories = Category::all();
        return responseJson(1,'تم التحميل',$categories);
    }
    public function restaurants(Request $request)
    {
        
        $restaurants = Restaurant::where(function($q) use($request) {
            if ($request->has('keyword'))
            {
                $q->where(function($q2) use($request){
                    $q2->where('name','LIKE','%'.$request->keyword.'%');
                });
            }
            if ($request->has('city_id'))
            {
                $q->where('city_id',$request->city_id);
            }
            
        })->has('items')->with('city', 'categories')->activated()->paginate(10);
        return responseJson(1,'تم التحميل',$restaurants);

 }
}
