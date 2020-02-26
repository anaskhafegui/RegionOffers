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



Route::group(['prefix' =>'v1'],function(){

    Route::get('categories','Api\MainController@categories');
    Route::get('cities','Api\MainController@cities');
    Route::get('regions','Api\MainController@regions');
    Route::get('offers','Api\MainController@offers');
    Route::get('shops','Api\MainController@shops');
    Route::get('reviews','Api\MainController@reviews');

    Route::get('cities-not-paginated','Api\MainController@citiesNotPaginated');
    Route::get('regions-not-paginated','Api\MainController@regionsNotPaginated');
    Route::get('/admin/shop/regions_ajax','Api\MainController@ajax_region');

    Route::post('contact-us','Api\MainController@contact');
    

    
    Route::group(['prefix' =>'client'],function(){
        
        
        Route::post('facebooklogin', 'Api\AuthController@facebooklogin');
        Route::post('register', 'Api\AuthController@register');
        Route::post('login', 'Api\AuthController@login');
        Route::post('reset-password', 'Api\AuthController@reset');
        Route::post('new-password', 'Api\AuthController@password');
   
    Route::group(['middleware'=>'auth:api'],function(){

        Route::post('profile', 'Api\AuthController@profile');
        Route::post('register-token', 'Api\AuthController@registerToken');
        Route::post('remove-token', 'Api\AuthController@removeToken');
        Route::post('review','Api\MainController@review');
        Route::post('new-order','Api\MainController@newOrder');
        Route::get('show-order','Api\MainController@showOrder');
        Route::get('my-orders','Api\MainController@myorders');
      
        
        


    }); 
    }); 
}); 