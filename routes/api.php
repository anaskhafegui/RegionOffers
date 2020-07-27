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
    Route::get('filter','Api\MainController@index');
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
      

    });  }); 
    Route::group(['prefix' =>'shop'],function(){

        Route::post('register', 'Api\Shop\AuthController@register');
        Route::post('login', 'Api\Shop\AuthController@login');
//        Route::post('profile', 'Api\Shop\AuthController@profile');
        Route::post('reset-password', 'Api\Shop\AuthController@reset');
        Route::post('new-password', 'Api\Shop\AuthController@password');

        Route::group(['middleware'=>'auth:api'],function(){

            Route::post('profile', 'Api\Shop\AuthController@profile')->middleware('check-commissions');
            Route::post('register-token', 'Api\Shop\AuthController@registerToken');
            Route::post('remove-token', 'Api\Shop\AuthController@removeToken');

            Route::get('my-items','Api\Shop\MainController@myItems');
            Route::post('new-item','Api\Shop\MainController@newItem')->middleware('check-commissions');
            Route::post('update-item','Api\Shop\MainController@updateItem')->middleware('check-commissions');
            Route::post('delete-item','Api\Shop\MainController@deleteItem')->middleware('check-commissions');

            Route::get('my-offers','Api\Shop\MainController@myOffers');
            Route::post('new-offer','Api\Shop\MainController@newOffer')->middleware('check-commissions');
            Route::post('update-offer','Api\Shop\MainController@updateOffer')->middleware('check-commissions');
            Route::post('delete-offer','Api\Shop\MainController@deleteOffer')->middleware('check-commissions');

            Route::get('my-orders','Api\Shop\MainController@myOrders');
            Route::get('show-order','Api\Shop\MainController@showOrder');
            Route::post('confirm-order','Api\Shop\MainController@confirmOrder')->middleware('check-commissions');
            Route::post('accept-order','Api\Shop\MainController@acceptOrder');
            Route::post('reject-order','Api\Shop\MainController@rejectOrder');
            Route::get('notifications','Api\Shop\MainController@notifications');
            Route::post('change-state','Api\Shop\MainController@changeState');
            
            Route::get('commissions','Api\Shop\MainController@commissions');
        });
    }); 
}); 