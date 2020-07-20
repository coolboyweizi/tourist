<?php
/**
 * 微信接口，访问WxApi相关的中间件
 *
 * User: Master King
 * Date: 2018/12/23
 */

Route::group(['namespace'=>'Api', 'prefix' => '','middleware' => ['dailypv']],function (){

    //Banner图
    Route::group([],function (){
        Route::resource('banner','BannerController',['only' => ['index','show']]);
    });

    //快报
    Route::group([],function(){
        Route::resource('news','NewsController',['only' => ['index','show']]);
    });

    //推荐
    Route::group([],function(){
        Route::resource('recommend','RecommendController',['only' => ['index','show']]);
    });
});

// 需要登录验证
Route::group(['namespace'=>'Api', 'prefix' => '', 'middleware' => ['auth:WxAuth','dailypv']], function (){

    Route::group([],function (){
        Route::get('project', 'ProjectController@index')->middleware('verifyData:project');
        Route::get('project/{id}','ProjectController@show')->middleware('hotApp:project');
    });

    //景区价格
    Route::group([],function(){
        Route::get('projectPrice','ProjectPriceController@index')->middleware('verifyData:projectPrice');
        Route::get('projectPrice/{id}','ProjectPriceController@show');
    });

    // 直通车列表
    Route::group([],function (){
        Route::get('travel', 'TravelController@index')->middleware('verifyData:travel');
        Route::get('travel/{id}','TravelController@show')->middleware('hotApp:travel');
    });

    //直通车价格
    Route::group([],function(){
        Route::get('travelPrice','TravelPriceController@index')->middleware('verifyData:travelPrice');
        Route::get('travelPrice/{id}','TravelPriceController@show');
    });

    // 酒店项目列表
    Route::group([],function (){
        Route::get('hotel', 'HotelController@index')->middleware('verifyData:hotel');
        Route::get('hotel/{id}','HotelController@show')->middleware('hotApp:hotel');
    });

    //酒店价格
    Route::group([],function(){
        Route::get('hotelPrice','HotelPriceController@index')->middleware('verifyData:hotelPrice');
        Route::get('hotelPrice/{id}','HotelPriceController@show');
    });

    // 景区订单
    Route::group(['middleware' => ['verifyData:projectOrder']],function (){
        Route::post('projectOrder','ProjectOrderController@store')->middleware('verifyData:projectOrder');
    });

    //直通车订单
    Route::group([],function(){
        Route::resource('travelOrder','TravelOrderController',['only' => ['index','show','store','update','destroy']]);
    });

    // 达人项目
    Route::group([],function (){
        Route::get('talent', 'TalentController@index');
        Route::get('talent/{id}','TalentController@show')->middleware('hotApp:talent');
        Route::post('talent','TalentController@store');
        Route::put('talent/{id}','TalentController@update');
        Route::delete('talent/{id}','TalentController@destroy');
    });

    // 达人项目列表
    Route::group([],function (){
        Route::get('talentList', 'TalentListController@index');
        Route::get('talentList/{id}','TalentListController@show');
        Route::post('talentList','TalentListController@store');
        Route::put('talentList/{id}','TalentListController@update');
        Route::delete('talentList/{id}','TalentListController@destroy');
    });

    // 达人项目价格查询
    Route::group([],function (){
        Route::get('talentPrice/{id}','TalentPriceController@show');
    });

    // 达人项目订单
    Route::group([],function (){
        Route::post('talentOrder','TalentOrderController@store');
    });

    //酒店订单
    Route::group(['middleware' => ['verifyData:hotelOrder']],function(){
        Route::resource('hotelOrder','HotelOrderController',['only' => ['index','show','store','update','destroy']]);
    });

    // 系统订单
    Route::group([],function (){
        Route::get('order','OrderController@index')->middleware('verifyData:order');
        Route::get('order/{id}','OrderController@show');
        Route::put('order/{id}','OrderController@update')->middleware('verifyData:order');
        Route::delete('order/{id}','OrderController@destroy');
        //Route::resource('order','OrderController',['only' => ['index','show','update','destroy']]);
    });

    // 收益订单
    Route::group(['middleware' => ['verifyData:profit']],function (){
        Route::get('profit','ProfitController@index');
    });


    //收藏
    Route::group(['middleware' => ['verifyData:favorite']],function(){
        Route::resource('favorite','FavoriteController',['only' => ['index','show','store','destroy']]);
    });

    //消息通知
    Route::group(['middleware' => ['verifyData:notification']],function(){
        Route::get('notification','NotificationController@index');
        Route::get('notification/overview','NotificationController@overView');
        Route::get('notification/{id}','NotificationController@show');
        Route::delete('notification/{id}','NotificationController@destroy');
        //Route::resource('notification','NotificationController',['only' => ['index','show']]);
    });

    //评论
    Route::group(['middleware' => ['verifyData:comment']],function(){
        Route::resource('comment', 'CommentController',['only' => ['store','index','update','destroy','show']]);
    });

    //账户明细
    Route::group(['middleware' => ['verifyData:moneyLog']],function(){
        Route::get('moneyLog','MoneyLogController@index');
    });

    //提现
    Route::group(['middleware' => ['verifyData:withdraw']],function(){
        Route::resource('withdraw','WithdrawController',['only' => ['store','index','update','destroy','show']]);
    });

    // 微信支付记录
    Route::get('/member','WxLoginController@memberInfo');
    Route::get('wxRePay/{id}','WxApiController@wxRePay');
});

// 非登录
Route::group(['namespace'=>'Api'],function(){
    Route::post('/wxLogin','WxLoginController@login');
    Route::resource('wxPay','WxApiController',['only'=>['store']]);

});


Route::post('/upload','StorageController@store')->name('upload')->middleware('dailypv');
Route::resource('search','SearchController', ['only' => ['index']])->middleware(['dailypv','searchRecord']);

