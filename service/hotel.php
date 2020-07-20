<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '酒店服务',
    'model' => \App\Models\HotelModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance(\App\Logic\AppLogic::class,'hotel')->_after_find_all($pageList);
        },
        '_after_find' => function($pageList){
            return cache_instance(\App\Logic\AppLogic::class,'hotel')->_after_find($pageList);
        },
        '_before_create' => function($data){
            return cache_instance(\App\Logic\AppLogic::class,'hotel')->_before_create($data);
        },
        'starsCoin' => function($stars){
            return cache_instance(\App\Logic\AppLogic::class,'hotel')->starsCoin($stars);
        },
        'moreData' => function($data){
            return cache_instance(\App\Logic\AppLogic::class,'hotel')->moreData($data);
        },
        '_before_update' => function($ids,$data){
            return cache_instance(\App\Logic\AppLogic::class,'hotel')->_before_update($ids,$data);
        },
    ],
    'query' => [
        ['status' ,1]
    ],
    'verify' => [
        'GET' => ['status']
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::HOTEL_SERVICE_EXCEPTION,
];