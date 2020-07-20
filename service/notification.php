<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '评论服务',
    'model' => \App\Models\NotificationModel::class,
    'closure' => [
       '_after_find_all' => function($data) {
            return cache_instance(\App\Logic\NotificationLogic::class)->_after_find_all($data);
       },
       '_after_find' => function($data) {
            return cache_instance(\App\Logic\NotificationLogic::class)->_after_find($data);
        },
        'overview' => function($uid){
            return cache_instance(\App\Logic\NotificationLogic::class)->overview($uid);
        }
    ],
    'query'=>[
        ['uid',\Illuminate\Http\Request::capture()->input('uid')],
        ['type',\Illuminate\Http\Request::capture()->input('type','None')?
            :\Illuminate\Http\Request::capture()->input('type')]

    ],
    'verify' => [
        'GET' => [
            ['uid']
        ]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::NOTIFICATION_SERVICE_EXCEPTION
];