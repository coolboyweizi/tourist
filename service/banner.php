<?php
/**
 * User: Master King
 * Date: 2019/1/10
 */

return [

    'alias' => '广告服务',
    'model' =>  \App\Models\Advert::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance(\App\Logic\BannerLogic::class)->_after_find_all($pageList);
        }
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::BANNER_SERVICE_EXCEPTION
];