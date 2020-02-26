<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Setting;

class SettingsController extends Controller
{
    

    public function view()
    {
        
            $model = Setting::find(1);


        return view('admin.settings.view',compact('model'));
    }

    public function update(Request $request)
    {
        if (Setting::all()->count() > 0)
        {
            Setting::find(1)->update($request->all());
        }else{
            Setting::create($request->all());
        }

        flash()->success('تم الحفظ بنجاح');
        return back();
    }
}
