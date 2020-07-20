<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'model' => \App\Models\ProjectOrderModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance( \App\Logic\AppOrderLogic::class,'project')->_after_find_all($pageList);
        },
        '_after_find' => function($pageList){
            return cache_instance( \App\Logic\AppOrderLogic::class,'project')->_after_find($pageList);
        },
        '_before_create' => function($data){
            return cache_instance( \App\Logic\AppOrderLogic::class,'project')->_before_create($data);
        },
        '_after_create' => function($data){
            return cache_instance( \App\Logic\AppOrderLogic::class,'project')->_after_create($data);
        },
        'wxPay' => function($sysOrder, $openid, $app, $order_id) {
            return cache_instance( \App\Logic\AppOrderLogic::class,'project')->wxPay($sysOrder, $openid, $app, $order_id);
        }
    ],
    'verify' => [
        'POST'=>[
            ['uid'],
            ['number'],
            ['price_id'],
            ['usetime'],
            ['umobile']
        ]
    ],
    
    'errorCode' => \App\Exceptions\ExceptionCode::PROJECT_ORDER_SERVICE_EXCEPTION,
];