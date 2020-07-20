<?php
/**
 * User: Master King
 * Date: 2019/2/21
 */

return [
  'alias' => '价格活动',
  'model' => \App\Models\ActiveModel::class,
  'closure' => [
        'minPrice' => function($price_id){
            return cache_instance(\App\Logic\Active::class)->findMinPrice($price_id);
        },
        '_before_create' => function($data){
            return cache_instance(\App\Logic\Active::class)->_before_create($data);
        },
        '_after_find_all' => function($data){
            return cache_instance(\App\Logic\Active::class)->_after_find_all($data);
        },
        'priceDate' => function($price_id, $app, $days) {
            return cache_instance(\App\Logic\Active::class)->priceDate($price_id, $app, $days);
        }
    ],
    'query'=>[
        ['app', \Illuminate\Http\Request::capture()->input('app')],
        ['price_id', \Illuminate\Http\Request::capture()->input('price_id')]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::HOTEL_SERVICE_EXCEPTION,
];