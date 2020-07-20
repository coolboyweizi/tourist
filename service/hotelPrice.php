<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'model' => \App\Models\HotelPriceModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance(\App\Logic\AppPriceLogic::class,'hotel')->_after_find_all($pageList);
        },
        '_after_find' => function($pageList){
            return cache_instance(\App\Logic\AppPriceLogic::class,'hotel')->_after_find($pageList);
        },
        '_before_create' => function($data){
            return cache_instance(\App\Logic\AppPriceLogic::class,'hotel')->_before_create($data);
        },
        'appInfo' => function($item){
            return cache_instance(\App\Logic\AppPriceLogic::class,'hotel')->appInfo($item);
        }
    ],
    'query' => [
        ['app_id',\Illuminate\Http\Request::capture()->input('app_id')],
        ['status', 1]
    ],
    'verify' => [
        'GET' => [
            'status','app_id'
        ]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::HOTEL_PRICE_SERVICE_EXCEPTION,
];