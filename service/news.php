<?php
/**
 * User: Master King
 * Date: 2019/1/10
 */

return [

    'alias' => '快报服务',
    'model' => \App\Models\Article::class,
    'closure' => [
        '_after_find_all' =>function($pageList){
            return cache_instance(\App\Logic\NewsLogic::class)->_after_find_all($pageList);
        },
        '_after_find' => function($data){
            return cache_instance(\App\Logic\NewsLogic::class)->_after_find($data);
        },
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::NEWS_SERVICE_EXCEPTION,
];