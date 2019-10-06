<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});





Route::group(['prefix' =>'v1'],function(){

    Route::get('categories','Api\MainController@categories');
    Route::get('cities','Api\MainController@cities');
    Route::get('regions','Api\MainController@regions');


    Route::group(['prefix' =>'client'],function(){
      
        Route::post('register', 'Api\AuthController@register');
        Route::post('login', 'Api\AuthController@login');
        Route::post('profile', 'Api\AuthController@profile');
        Route::post('reset-password', 'Api\AuthController@reset');
        Route::post('new-password', 'Api\AuthController@password');
    });
}); 