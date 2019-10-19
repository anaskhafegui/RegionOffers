<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function(){
    return redirect()->to('/admin');
});

Auth::routes();


Route::get('/run', 'MainController@index');
Route::get('/home', 'HomeController@index');

// admin routes
Route::group(['middleware'=>'auth' , 'prefix' => 'admin'],function(){
    Route::get('/','HomeController@index');
    Route::resource('city', 'CityController');
    Route::resource('region', 'RegionController');
    Route::resource('category', 'CategoryController');
    Route::resource('shop', 'ShopController');
  
//    Route::resource('user','UserController');
//    Route::resource('role','RoleController');
});
