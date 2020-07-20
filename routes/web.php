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

Route::post('uploadImg', 'PublicController@uploadImg')->name('uploadImg');

Route::get('/demo','DemoController@index');

Auth::routes();

/**
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth:WxAuth');
Route::get('/upload','UploadController@demo');
Route::post('/upload','StorageController@store');

Route::post('/wxLogin','WxLoginController@login');

Route::resource('user','UserController',['only' => ['store','index']]);

Route::get('/member','WxLoginController@memberInfo')
    ->middleware('auth:WxAuth');

Route::resource('comment', 'CommentController',['only' => ['store','index','update','destroy','show']])
    ->middleware('auth:WxAuth');

Route::resource('project', 'ProjectController')
    ->middleware('auth:WxAuth');

Route::resource('projectPrice','ProjectPriceController',['only' => ['store','index','update','destroy','show']])
    ->middleware('auth:WxAuth');

Route::resource('projectOrder','ProjectOrderController',['only' => ['store','update']])
    ->middleware('auth:WxAuth');

Route::resource('moneyLog','MoneyLogController',['only'=>['index']])
    ->middleware('auth:WxAuth');

Route::resource('favorite','FavoriteController')
    ->middleware('auth:WxAuth');

Route::resource('banner','BannerController')
    ->middleware('auth:WxAuth');

Route::resource('news','NewsController')
    ->middleware('auth:WxAuth');

Route::resource('withdraw','WithdrawController')
    ->middleware('auth:WxAuth');

Route::resource('hotel','HotelController')
    ->middleware('auth:WxAuth');

Route::resource('hotelPrice','HotelPriceController')
    ->middleware('auth:WxAuth');

Route::resource('hotelOrder','HotelOrderController')
    ->middleware('auth:WxAuth');

Route::resource('notification','NotificationController')
    ->middleware('auth:WxAuth');

Route::post('/storage/upload','StorageController@store')
    ->middleware('auth:WxAuth');

Route::resource('order','OrderController', ['only' => ['index','show','update','destroy']])
    ->middleware('auth:WxAuth');

Route::resource("recommend",'RecommendController',['only' =>['index','store','destroy']])
    ->middleware('auth:WxAuth');


Route::resource('search','SearchController', ['only' => ['index']]);
Route::resource('wxPay','WxApiController',['only'=>['store']]);

Route::get('wxRePay/{id}','WxApiController@wxRePay')
    ->middleware('auth:WxAuth');

*/