<?php
/**
 * Web接口，访问Web的中间件
 *
 * User: Master King
 * Date: 2018/12/23
 */

Route::group(['namespace'=>'Api', 'prefix' => 'webApi', 'middleware' => []], function (){

    // 景区项目
    Route::group([],function (){
        Route::get('project','ProjectController@index');
        Route::get('project/{id}','ProjectController@show');
        Route::post('project','ProjectController@store');
        Route::put('project/{id}','ProjectController@update');
        Route::delete('project/{id}','ProjectController@destroy');
    });

    // 景区订单
    Route::group([],function (){
        //Route::post('projectOrder','ProjectOrderController@store');
        Route::get('projectOrder','ProjectOrderController@index');
        Route::put('projectOrder/{id}','ProjectOrderController@update');
        Route::get('projectOrder/{id}','ProjectOrderController@show');
        Route::delete('projectOrder/{id}','ProjectOrderController@destroy');
    });

    //景区价格
    Route::group([],function(){
        Route::get('projectPrice','ProjectPriceController@index');
        Route::post('projectPrice','ProjectPriceController@store');
        Route::put('projectPrice/{id}','ProjectPriceController@update');
        Route::get('projectPrice/{id}','ProjectPriceController@show');
        Route::delete('projectPrice/{id}','ProjectPriceController@destroy');
    });

    // 直通车
    Route::group([],function (){
        Route::get('travel','TravelController@index');
        Route::get('travel/{id}','TravelController@show');
        Route::post('travel','TravelController@store');
        Route::put('travel/{id}','TravelController@update');
        Route::delete('travel/{id}','TravelController@destroy');
    });

    // 直通车订单
    Route::group([],function (){
        //Route::post('projectOrder','ProjectOrderController@store');
        Route::get('travelOrder','TravelOrderController@index');
        Route::put('travelOrder/{id}','TravelOrderController@update');
        Route::get('travelOrder/{id}','TravelOrderController@show');
        Route::delete('travelOrder/{id}','TravelOrderController@destroy');
    });

    // 直通车价格
    Route::group([],function(){
        Route::get('travelPrice','TravelPriceController@index');
        Route::post('travelPrice','TravelPriceController@store');
        Route::put('travelPrice/{id}','TravelPriceController@update');
        Route::get('travelPrice/{id}','TravelPriceController@show');
        Route::delete('travelPrice/{id}','TravelPriceController@destroy');
    });

    // 达人组管理
    Route::group([], function (){
        Route::get('talentGroup','TalentGroupController@index');
        Route::get('talentGroup/{id}','TalentGroupController@show');
        Route::post('talentGroup','TalentGroupController@store');
        Route::put('talentGroup/{id}','TalentGroupController@update');
        Route::delete('talentGroup/{id}','TalentGroupController@destroy');
    });

    // 达人用户管理
    Route::group([], function (){
        Route::get('talentUser','TalentUserController@index');
        Route::get('talentUser/{id}','TalentUserController@show');
        Route::post('talentUser','TalentUserController@store');
        Route::put('talentUser/{id}','TalentUserController@update');
        Route::delete('talentUser/{id}','TalentUserController@destroy');
    });

    // 达人系统列表
    Route::group([],function (){
        Route::get('talent','TalentController@index');
        Route::get('talent/{id}','TalentController@show');
        Route::post('talent','TalentController@store');
        Route::put('talent/{id}','TalentController@update');
        Route::delete('talent/{id}','TalentController@destroy');
    });

    // 达人系统价格
    Route::group([],function(){
        Route::get('talentPrice','TalentPriceController@index');
        /*Route::post('talentPrice','TalentPriceController@store');
        Route::put('talentPrice/{id}','TalentPriceController@update');
        Route::get('talentPrice/{id}','TalentPriceController@show');
        Route::delete('talentPrice/{id}','TalentPriceController@destroy');*/
    });

    // 活动价格管理
    Route::group([], function (){
        Route::get('active','ActiveController@index');
        Route::post('active','ActiveController@store');
        Route::get('active/{id}','ActiveController@show');
        Route::put('active/{id}','ActiveController@update');
        Route::delete('active/{id}','ActiveController@destroy');
    });

    // 系统订单
    Route::group([],function (){
        Route::get('order','OrderController@index');
        Route::post('order','OrderController@store');
        Route::put('order/{id}','OrderController@update');
        Route::get('order/{id}','OrderController@show');
        Route::delete('order/{id}','OrderController@destroy');
    });

    // 酒店项目
    Route::group([],function (){
        Route::get('hotel','HotelController@index');
        Route::post('hotel','HotelController@store');
        Route::put('hotel/{id}','HotelController@update');
        Route::get('hotel/{id}','HotelController@show');
        Route::delete('hotel/{id}','HotelController@destroy');
    });

    //酒店订单
    Route::group([],function(){
        Route::get('hotelOrder','HotelOrderController@index');
        Route::put('hotelOrder/{id}','HotelOrderController@update');
        Route::get('hotelOrder/{id}','HotelOrderController@show');
        Route::delete('hotelOrder/{id}','HotelOrderController@destroy');
    });

    //酒店价格
    Route::group([],function(){
        Route::get('hotelPrice','HotelPriceController@index');
        Route::post('hotelPrice','HotelPriceController@store');
        Route::put('hotelPrice/{id}','HotelPriceController@update');
        Route::get('hotelPrice/{id}','HotelPriceController@show');
        Route::delete('hotelPrice/{id}','HotelPriceController@destroy');
    });

    //Banner图
    Route::group([],function (){
        Route::get('banner','BannerController@index');
        Route::post('banner','BannerController@store');
        Route::put('banner/{id}','BannerController@update');
        Route::get('banner/{id}','BannerController@show');
        Route::delete('banner/{id}','BannerController@destroy');
    });

    //快报
    Route::group([],function(){
        Route::get('news','NewsController@index');
        Route::post('news','NewsController@store');
        Route::put('news/{id}','NewsController@update');
        Route::get('news/{id}','NewsController@show');
        Route::delete('news/{id}','NewsController@destroy');
    });

    //推荐
    Route::group([],function(){
        Route::get('recommend','RecommendController@index');
        Route::post('recommend','RecommendController@store');
        Route::put('recommend/{id}','RecommendController@update');
        Route::get('recommend/{id}','RecommendController@show');
        Route::delete('recommend/{id}','RecommendController@destroy');
    });

    //收藏
    Route::group([],function(){
        Route::get('favorite','FavoriteController@index');
        Route::post('favorite','FavoriteController@stroe');
        Route::delete('favorite','FavoriteController@destroy');
    });

    //消息通知
    Route::group([],function(){
        Route::get('notification','NotificationController@index');
        Route::post('notification','NotificationController@store');
        Route::put('notification/{id}','NotificationController@update');
        Route::get('notification/{id}','NotificationController@show');
        Route::delete('notification/{id}','NotificationController@destroy');
    });

    //评论
    Route::group([],function(){
        Route::get('comment','CommentController@index')->name('api.comment.view');
        Route::post('comment','CommentController@store');
        Route::put('comment/{id}','CommentController@update');
        Route::get('comment/{id}','CommentController@show');
        Route::delete('comment/{id}','CommentController@destroy');
    });

    //消息通知
    Route::group([],function(){
        Route::get('wxPayRecord','WxPayRecordController@index');
        Route::post('wxPayRecord','WxPayRecordController@store');
        Route::put('wxPayRecord/{id}','WxPayRecordController@update');
        Route::get('wxPayRecord/{id}','WxPayRecordController@show');
        Route::delete('wxPayRecord/{id}','WxPayRecordController@destroy');
    });

    //流量
    Route::group([],function(){
        Route::get('dailyPv','DailyPvController@index');
    });

    // 热门商品
    Route::group([],function (){
        Route::get('hotApp','HotAppController@index');
    });

    // 搜索记录
    Route::group([],function (){
        Route::get('searchRecord','SearchRecordController@index');
    });

    // 提现
    Route::group([],function(){
        Route::resource('withdraw','WithdrawController',['only' => ['store','index','update','destroy','show']]);
    });

});

