<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '我的关注',
    'model' => \App\Models\FavoriteModel::class,
    'closure' => [
        '_after_find_all' => function($data){
            return  cache_instance(\App\Logic\FavoriteLogic::class)->_after_find_all($data);
        },
        '_before_create' => function($data){
            return  cache_instance(\App\Logic\FavoriteLogic::class)->_before_create($data);
        },
        'moreApp' => function($data){
            return  cache_instance(\App\Logic\FavoriteLogic::class)->moreApp($data);
        },
        'appInfo' => function($data){
            return  cache_instance(\App\Logic\FavoriteLogic::class)->appInfo($data);
        },
    ],
    'query' => [
        ['app_id',\Illuminate\Http\Request::capture()->input('app_id')],
        ['app',\Illuminate\Http\Request::capture()->input('app')],
        ['uid',\Illuminate\Http\Request::capture()->input('uid')]
    ],
    'verify' => [
        'GET' => [
            'app',
        ],
        'POST' => [
            'uid',
            'app',
            'app_id'
        ],
        'DELETE' => [
            'uid'
        ],
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::FAVORITE_SERVICE_EXCEPTION,
];