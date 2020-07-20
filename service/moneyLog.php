<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '资金日志服务',
    'model' =>\App\Models\MoneyLogModel::class,
    'closure' => [
        '_before_create' => function($model) {
            return cache_instance(\App\Logic\MoneyLogLogic::class)->_before_create($model);
        }
    ],
    'query'=>[
        ['uid',\Illuminate\Http\Request::capture()->input('uid')]
    ],
    'verify' => [
        'GET' => [
            ['uid']
        ]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::MONEY_LOG_SERVICE_EXCEPTION,
];