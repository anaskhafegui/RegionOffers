<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Shop;
use App\Models\City;
use DB;
use Illuminate\Http\Request;
use Response;
use Validator;
use Response;

class ShopController extends Controller
{

    public function index(Request $request)
    {

        $shops = Shop::where(function ($q) use ($request) {

            if ($request->has('name')) {
                $q->where(function ($q2) use ($request) {
                    $q2->where('name', 'LIKE', '%' . $request->name . '%');
                });
            }
            /* if ($request->has('regions')) {
                $q->whereHas('city',function ($q2) use($request){
                    // search in restaurant region "Region" Model
                    $q2->whereCityId($request->city_id);
                });
            }*/
            if ($request->has('region_id')) {
                $q->whereHas('regions',function ($q2) use($request){
                    $q2->where('regions.id',$request->region_id);
                });
            }

           if ($request->has('availability')) {
                $q->where('availability',$request->availability);
            }

        })->with('regions.city')->latest()->paginate(20);
        return view('admin.shops.index', compact('shops'));
    }

    public function create(Shop $model)
    {
        return view('admin.shops.create', compact('model'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'minimum_charger' => 'required',
            'delivery_cost' => 'required',
            'availability' => 'required',
            'address' => 'required',
            'delivery' => 'required|string',
            'takeaway'  => 'required',
        ]);



        $shop = Shop::create([
            'name' =>$request->name,
            'category_id' =>$request->category_id,
            'email' =>$request->email,
            'phone' =>$request->phone,
            'minimum_charger' =>$request->minimum_charger,
            'delivery_cost' =>$request->delivery_cost,
            'availability' =>$request->availability,
            'address' =>$request->address,
            'delivery' => (int)$request->delivery,
            'takeaway'  =>(int) $request->takeaway,
            'password' =>bcrypt('123456'),
            'api_token' =>'123456'

        ]);
        $shop->regions()->attach((int)$request->region_id);

        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/shops/'; // upload path
            $logo = $request->file('photo');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $shop->photo = 'uploads/shops/' . $name;
            $shop->save();
        }
        if ($request->has('regions_list')) {
            $restaurant->delivery_regions()->attach($request->regions_list);
        }



        flash()->success('تم إضافة المطعم بنجاح');
        return redirect('admin/shop');
    }

    public function edit($id)
    {
        $model = Shop::findOrFail($id);
        return view('admin.shops.edit',compact('model'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'minimum_charger' => 'required',
            'delivery_cost' => 'required',
            'availability' => 'required',
            'address' => 'required',
            'delivery' => 'required|string',
            'takeaway'  => 'required',
        ]);
        $shop = Shop::findOrFail($id);
        $shop->update([
            'name'=>$request->name,
            'category_id'=>$request->category_id,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'minimum_charger'=>$request->minimum_charger,
            'delivery_cost'=>$request->delivery_cost,
            'availability'=>$request->availability,
            'address' =>$request->address,
            'delivery'=> (int)$request->delivery,
            'takeaway'=>(int)$request->takeaway,
        ]);
        $shop->regions()->attach((int)$request->region_id);
        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/shops/'; // upload path
            $logo = $request->file('photo');
            $extension = $logo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $logo->move($destinationPath, $name); // uploading file to given path
            $shop->photo = 'uploads/shops/' . $name;
            $shop->save();
        }
        flash()->success('تم تعديل بيانات المطعم بنجاح.');
        return redirect('admin/shop/' . $shop->id . '/edit');
    }

    public function destroy($id)
    {
        $shop = Shop::findOrFail($id);
        if (count($shop->offers) > 0) {
            $data = [
                'status' => 0,
                'msg' => 'لا يمكن حذف المطعم ، لان به طلبات مسجلة',
                'id' => $shop->id
            ];
            return Response::json($data, 200);
        }
        $shop->delete();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $shop->id
        ];
        return Response::json($data, 200);
    }

    public function activate($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->activated = 1;
        $shop->save();
        flash()->success('تم التفعيل');
        return back();
    }

    public function deActivate($id)
    {
        $shop = Shop::findOrFail($id);
        $shop->activated = 0;
        $shop->save();
        flash()->success('تم الإيقاف');
        return back();
    }

}
