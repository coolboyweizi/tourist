<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'model' => \App\Models\OrderModel::class,
    'closure' => [
        '_after_find_all' => function($data){
            return cache_instance(\App\Logic\SysOrderLogic::class)->_after_find_all($data);
        },
        '_after_find' => function($pageList){
            return cache_instance(\App\Logic\SysOrderLogic::class)->_after_find($pageList);
        },
        '_before_update' => function($ids,$data){
            return cache_instance(\App\Logic\SysOrderLogic::class)->_before_update($ids,$data);
        },
        'getDataFromModel' => function($data) {
            return cache_instance(\App\Logic\SysOrderLogic::class)->getDataFromModel($data);
        },
        'SyncDataFromModel' => function($data, $id) {
            return cache_instance(\App\Logic\SysOrderLogic::class)->SyncDataFromModel($data, $id);
        }
    ],
    'query' => [
        [   'status',
            \Illuminate\Http\Request::capture()->input('status')<0 ? '<=' : '=',
            \Illuminate\Http\Request::capture()->input('status')
        ],
        [ 'uid', \Illuminate\Http\Request::capture()->input('uid')]
    ],
    'verify' => [
        'GET' => [
            'uid' => ['app_id','app'],
        ],
        'POST' => [
            'uid' ,
            'data',
            'app',
            'order_id'
        ],
        'PUT' => [
            'uid',
            'status',
        ],
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::ORDER_SERVICE_EXCEPTION
];