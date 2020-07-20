<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '提现申请',
    'model' => \App\Models\WithdrawModel::class,
    'closure' => [
        '_before_create' => function($data) {
            return cache_instance(\App\Logic\WithDrawLogic::class)->_before_create($data);
        },
        '_after_create' => function($data) {
            return cache_instance(\App\Logic\WithDrawLogic::class)->_after_create($data);
        },
        '_after_find_all' => function($data){
            return cache_instance(\App\Logic\WithDrawLogic::class)->_after_find_all($data);
        },
        '_before_update' => function($ids, $data) {
            return cache_instance(\App\Logic\WithDrawLogic::class)->_before_update($ids, $data);
        },
        '_after_update' => function($id, $data) {
            return cache_instance(\App\Logic\WithDrawLogic::class)->_after_update($id, $data);
        }
    ],
    'query'=>[
        ['uid',\Illuminate\Http\Request::capture()->input('uid')]
    ],
    'verify' => [
        'GET'=>[
            'uid',
        ],
        'POST' => [
            'uid','money'
        ]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::WITHDRAW_SERVICE_EXCEPTION,
];