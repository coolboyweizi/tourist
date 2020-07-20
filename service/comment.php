<?php
/**
 * 评论服务
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '评论服务',
    'model' => \App\Models\CommentModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance(\App\Logic\CommentLogic::class)->_after_find_all($pageList);
        },
        '_after_find' => function($pageList){
            return cache_instance(\App\Logic\CommentLogic::class)->_after_find($pageList);
        },
        '_before_create' => function($data) {
            return cache_instance(\App\Logic\CommentLogic::class)->_before_create($data);
        },
        '_after_create' => function($data){
            return cache_instance(\App\Logic\CommentLogic::class)->_after_create($data);
        }
    ],
    'query' => [
        ['uid', \Illuminate\Http\Request::capture()->input('uid')],
        ['app',\Illuminate\Http\Request::capture()->input('app')],
        ['app_id',\Illuminate\Http\Request::capture()->input('app_id')],
        ['status', \Illuminate\Http\Request::capture()->input('status')]
    ],
    // 微信端请求检查参数.
    'verify' => [
        'GET' => [
            'uid' => ['app_id','app'],
        ],
        'POST' => [
            'uid' ,
            'data' ,
            'app' ,
            'order_id'
        ],
        'DELETE' => [
            'uid'
        ]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::COMMENT_SERVICE_EXCEPTION,
];