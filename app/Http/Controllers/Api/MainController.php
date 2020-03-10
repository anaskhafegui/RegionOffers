<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Shop;
use App\Models\Order;
use App\Models\Review;
use App\Models\Token;
use App\Models\Notification;
use App\Models\Contact;
use App\Setting;

use Illuminate\Support\Facades\DB;
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
    public function citiesNotPaginated(Request $request)
    {
        $cities = City::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->get();
        return responseJson(1,'تم التحميل',$cities);
    }

    public function regionsNotPaginated(Request $request)
    {
        $regions = Region::where(function($q) use($request){
            if ($request->has('name')){
                $q->where('name','LIKE','%'.$request->name.'%');
            }
        })->where('city_id',$request->city_id)->get();
        return responseJson(1,'تم التحميل',$regions);
    }

    public function ajax_region(Request $request)
    {
        $regions = Region::where('city_id',$request->city_id)->get();
        return responseJson(1,'تم التحميل',$regions);
    }

    public function categories()
    {
        $categories = Category::paginate(10);
        if (!$categories)
        {
            return responseJson(0,'no data');
        }
        return responseJson(1,'تم التحميل',$categories);
    }

    public function shops(Request $request)
    {
     $shops = Shop::Join(
                DB::raw('(SELECT shop_id, ROUND(AVG(rate)) AS rate FROM reviews GROUP BY shop_id) AS n'),
                'n.shop_id', '=', 'shops.id' ) 
            ->where(function($q) use($request) {
            if ($request->has('keyword'))
            {
                $q->where(function($q2) use($request){
                    $q2->where('name','LIKE','%'.$request->keyword.'%')->orwhere('name_ar','LIKE','%'.$request->keyword.'%');
                });
                
            }
            if ($request->has('region_id'))
            {
                $q->whereHas('regions',function($q2) use($request){
                    $q2->where('regions.id',$request->region_id);
        
                });
            }
            if ($request->has('category_id'))
            {
                $q->where(function($q2) use($request){
                $q2->where('category_id','=',$request->category_id);
                });
            }
            
             if ($request->has('Mapname'))
            {
                $q->whereHas('regions',function($q2) use($request){
                    $q2->where('regions.Mapname',$request->Mapname);
        
                });
            }
        })->activated()->orderBy('rate', 'desc')->paginate(10);
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
    public function review(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'rate'          => 'required',
            'comment'       => 'required',
            'shop_id' => 'required|exists:shops,id',

        ]);
        if ($validation->fails()) {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }

        $shop = Shop::find($request->shop_id);
        if (!$shop) {
            return responseJson(0, 'لا يمكن الحصول على البيانات');
        }
        $request->merge(['client_id' => $request->user()->id]);
        $clientOrdersCount = $request->user()->orders()
                                     ->where('shop_id', $shop->id)
                                     ->where('state', 'accepted')
                                     ->count();
        if ($clientOrdersCount == 0) {
            return responseJson(0, 'لا يمكن التقييم الا بعد تنفيذ طلب من المطعم');
        }
        $checkOrder = $request->user()->orders()
                              ->where('shop_id', $shop)
                              ->where('state', 'accepted')
                              ->count();
        if ($checkOrder > 0) {
            return responseJson(0, 'لا يمكن التقييم الا بعد بيان حالة استلام الطلب');
        }
        $review = $shop->reviews()->create($request->all());
        return responseJson(1, 'تم التقييم بنجاح',
           $review->load('client','shop')
        );

    }
    public function reviews(Request $request)
    {
        $shop = Shop::find($request->shop_id);
        if (!$shop)
        {
            return responseJson(0,'no data');
        }
        $reviews = $shop->reviews()->latest()->paginate(10);
        return responseJson(1,'',$reviews);
        
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
 
public function newOrder(Request $request)
{

    $validation = validator()->make($request->all(), [
        'shop_id'     => 'required|exists:shops,id',
        'offers'             => 'required|array',
        'offers.*'           => 'required|exists:offers,id',
        'quantities'        => 'required|array',
        'notes'             => 'required|array',
        'address'           => 'required',
        'payment_method_id' => 'required|exists:payment_methods,id',
        //            'need_delivery_at' => 'required|date_format:Y-m-d',// H:i:s
    ]);
    if ($validation->fails()) {
        $data = $validation->errors();
        return responseJson(0, $validation->errors()->first(), $data);
    }

   

    $shop = Shop::find($request->shop_id);
    // shop closed
    if ($shop->availability == 'closed') {
        return responseJson(0, 'عذرا المطعم غير متاح في الوقت الحالي');
    }
  
      $order = $request->user()->orders()->create([

        'payment_method_id' => $request->payment_method_id,
        'address' => $request->user()->address,
        'shop_id' => $request->shop_id
    ]);

    if($request->payment_method_id == 2){
        $order->update([
            'offercode'   => mt_rand(1000, 9999),
        ]);
     }

    $cost = 0;
    $delivery_cost = $shop->delivery_cost;
    
    if ($request->has('offers')) {
        $counter = 0;
        foreach ($request->offers as $itemId) {
//ask
            $item = Offer::find($itemId);
            $order->offers()->attach([
            $itemId => [
                'quantity' => $request->quantities[$counter],
                'price'    => $item->price,
                'note'     => $request->notes[$counter],
            ]
           ]);
            $cost += ($item->price * $request->quantities[$counter]);
            $counter++;
        }
        
    }
    // minimum charge
    if ($cost >= $shop->minimum_charger) {
        $total = $cost + $delivery_cost; // 200 SAR

  
        $commission = settings()->commission * $cost;

       
        $net = $total - settings()->commission;

        $update = $order->update([
                 'cost'          => $cost,
                 'delivery_cost' => $delivery_cost,
                 'total'         => $total,
                 'commission'    => $commission,
                 'net'           =>$net
             ]);
           
       $notification = Notification::create([
           
                'client_id' => $request->user()->id,
                'shop_id'  => $shop->id,
                'title' =>'لديك طلب جديد',
                'content' =>$request->user()->name   .  '  لديك طلب جديد من العميل ',
               // 'action' =>  'new-order',
                'order_id' => $order->id
                
        ]);

        $tokens = $shop->tokens()->where('token', '!=' ,'null')->pluck('token')->toArray();
        
      //  $tokens = Token::whereIn('client_id', $clientsIds)->where('token', '!=', null)->pluck('token')->toArray();


        if(count($tokens))
        {
            $title = $notification->title;
            $content = $notification->content;
            $data =[
                'order_id' => $order->id,
                'user_type' => 'shop',
            ];
            $send = notifyByFirebase($title , $content , $tokens,$data);
            info("firebase result: " . $send);
        }
        
        $data = [
            'order' => $order->fresh()->load('offers','shop.regions','shop.category','client') // $order->fresh()  ->load (lazy eager loading) ->with('items')
        ];
        return responseJson(1, 'تم الطلب بنجاح', $data);
    } else {
        $order->items()->delete();
        $order->delete();
        return responseJson(0, 'الطلب لابد أن لا يكون أقل من ' . $shop->minimum_charger . ' ريال');
    }
}



public function myorders(Request $request)
{

    $orders = $request->user()->orders()->where(function ($order) use ($request) {
      
      
       if ($request->has('state')) {
          
            $order->where('state', '!=', 'pending');
        } elseif ($request->has('state')) {
            
            $order->where('state', '=', 'pending');
        }
    })->with('shop')->latest()->paginate(20); 
    return responseJson(1, 'تم التحميل', $orders);
}

public function showOrder(Request $request)
{
    $order = Order::with('offers','shop','shop.category','client')->find($request->order_id);
    return responseJson(1, 'تم التحميل', $order);
}
public function latestOrder(Request $request)
{
    $order = $request->user()->orders()
                     ->with('shop', 'offers')
                     ->latest()
                     ->first();
    if ($order) {
        return responseJson(1, 'تم التحميل', $order);
    }
    return responseJson(0, 'لا يوجد');
}
 public function contact(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'type' => 'required|in:complaint,suggestion,inquiry',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'content' => 'required'
        ]);
        if ($validation->fails()) {
            $data = $validation->errors();
            return responseJson(0,$validation->errors()->first(),$data);
        }
        Contact::create($request->all());
        return responseJson(1,'تم الارسال بنجاح');
    }




}
