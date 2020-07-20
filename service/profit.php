<?php
/**
 * User: Master King
 * Date: 2019/1/11
 */

return [
    'alias' => '评论服务',
    'model' => \App\Models\ProfitModel::class,
    'closure' => [
        '_before_create' => function($pageList) {
            return cache_instance(\App\Logic\ProfitLogic::class)->_before_create($pageList);
            },
        '_after_create' => function($data) {
            return cache_instance(\App\Logic\ProfitLogic::class)->_after_create($data);
        },
        '_after_find_all' => function($data) {
            return cache_instance(\App\Logic\ProfitLogic::class)->_after_find_all($data);
        }
    ],
    'query'=>[
        ['shared_uid',\Illuminate\Http\Request::capture()->input('shared_uid')]
    ],
    'verify' => [
        'GET'=>[
                'shared_uid',

            ]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::PROFIT_SERVICE_EXCEPTION
];