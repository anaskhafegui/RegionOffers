<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use Response;


class OfferController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $offers = Offer::with('shop')->paginate(20);
        return view('admin.offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.1
     *
     * @return Response
     */
    public function create()
    {
        $model = new Offer;
        return view('admin.offers.create', compact('model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
      /*  $this->validate($request, [
            'title' => 'required',
            'title_ar' => 'requried',
            'description' => 'required',
            'description_ar' => 'required',
            'shop_id' => 'required',
            'photo' => 'required',
            'price' => 'required',
            'starting_at' => 'required',
            'ending_at' => 'required',
        ]);*/
        $offer = Offer::create($request->all());
        if ($request->hasFile('photo')) {
            $path = public_path();
            $destinationPath = $path . '/uploads/offers/'; // upload path
            $photo = $request->file('photo');
            $extension = $photo->getClientOriginalExtension(); // getting image extension
            $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
            $photo->move($destinationPath, $name); // uploading file to given path
            $offer->photo = 'uploads/offers/' . $name;
            $offer->save();
        }

        flash()->success('تم إضافة العرض بنجاح');
        return redirect('admin/offer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $model = Offer::findOrFail($id);
        return view('admin.offers.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'title_ar' => 'requried',
            'description' => 'required',
            'description_ar' => 'required',
            'shop_id' => 'required',
            'photo' => 'required',
            'price' => 'required',
            'starting_at' => 'required',
            'ending_at' => 'required',
        ]);
        $offer = Offer::findOrFail($id);
        $offer->update($request->all());
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $destinationPath = public_path() . '/uploads/categories';
            $extension = $photo->getClientOriginalExtension(); // getting image extension
          $name = time() . '' . rand(11111, 99999) . '.' . $extension; // renameing image
          $photo->move($destinationPath, $name); // uploading file to given
          $offer->photo = 'uploads/categories/' . $name;
            $offer->save();
        }

        flash()->success('تم تعديل بيانات العرض بنجاح');
        return redirect('admin/offer/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $offer = Offer::findOrFail($id);
        $offer->delete();
        $data = [
            'status' => 1,
            'msg' => 'تم الحذف بنجاح',
            'id' => $id
        ];
        return Response::json($data, 200);
    }
}
