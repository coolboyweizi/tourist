<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'model' =>  \App\Models\TravelOrderModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance(\App\Logic\AppOrderLogic::class,'travel')->_after_find_all($pageList);
        },
        '_after_find' => function($pageList){
            return cache_instance(\App\Logic\AppOrderLogic::class,'travel')->_after_find($pageList);
        },
        '_before_create' => function($data){
            $items = cache_instance(\App\Logic\AppOrderLogic::class,'travel')->_before_create($data);
            return array_merge(
              $items,
              [
                  //'tel' => $data['umobile'],
                  'apiShortUrl' => 'none',
                  'apiOrder'=> 'none',
                  'apiTag'=> 'none',
                  'apiNumber' => '',
                  'godate' => $items['godate'],
                  'productCode' => $items['pcode'],
                  'status' => 0,
              ]
            );
        },
        '_after_create' => function($data){
            /*\App\Jobs\TravelOrder::dispatch(
                $data
            );
            return $data;*/
            return cache_instance(\App\Logic\AppOrderLogic::class,'travel')->_after_create($data);
        }
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::TRAVEL_ORDER_SERVICE_EXCEPTION,
];