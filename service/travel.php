<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '直通车',
    'model' =>  \App\Models\TravelModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance(\App\Logic\AppLogic::class,'travel')->_after_find_all($pageList);
        },
        '_after_find' => function($pageList){
            return cache_instance(\App\Logic\AppLogic::class,'travel')->_after_find($pageList);
        }
    ],
    'query'=>[
        ['status',1]
    ],
    'verify' => [
        'GET' => ['status']
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::TRAVEL_SERVICE_EXCEPTION,
];