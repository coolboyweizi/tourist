<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '达人定制订单',
    'model' => \App\Models\TalentOrderModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance(\App\Logic\AppOrderLogic::class,'talent')->_after_find_all($pageList);
        },
        '_after_find' => function($pageList){
            return cache_instance(\App\Logic\AppOrderLogic::class,'talent')->_after_find($pageList);
        },
        '_before_create' => function($data){
            $talent = app('talentPrice.abstract')->findById($data['price_id']);
            return cache_instance(\App\Logic\AppOrderLogic::class,'talent')->_before_create(array_merge(
                $data,
                ['talent'=> $talent['talent']]
            ));
        },
        '_after_create' => function($data){
            return cache_instance(\App\Logic\AppOrderLogic::class,'talent')->_after_create($data);
        },
        'wxPay' => function($sysOrder, $openid, $app, $order_id) {
            return cache_instance(\App\Logic\AppOrderLogic::class,'talent')->wxPay($sysOrder, $openid, $app, $order_id);
        }
    ],
    'query'=>[
        ['uid',\Illuminate\Http\Request::capture()->input('uid')]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::TALENT_ORDER_SERVICE_EXCEPTION,
];