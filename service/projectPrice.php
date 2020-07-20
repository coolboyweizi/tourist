<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'model' => \App\Models\ProjectPriceModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance( \App\Logic\AppPriceLogic::class,'project')->_after_find_all($pageList);
        },
        '_after_find' => function($pageList){
            return cache_instance( \App\Logic\AppPriceLogic::class,'project')->_after_find($pageList);
        },
        '_before_create' => function($data){
            return cache_instance( \App\Logic\AppPriceLogic::class,'project')->_before_create($data);
        },
        'appInfo' => function($item){
            return cache_instance( \App\Logic\AppPriceLogic::class,'project')->appInfo($item);
        }
    ],
    'query' => [
        ['app_id',\Illuminate\Http\Request::capture()->input('app_id')],
        ['status', \Illuminate\Http\Request::capture()->input('status')]
    ],
    'verify' => [
        'GET' => [
            'app_id',
            'status'
        ]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::PROJECT_PRICE_SERVICE_EXCEPTION,
];