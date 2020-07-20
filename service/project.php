<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '景区项目',
    'model' => \App\Models\ProjectModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance(\App\Logic\AppLogic::class,'project')->_after_find_all($pageList);
        },
        '_after_find' => function($pageList){
            return cache_instance(\App\Logic\AppLogic::class,'project')->_after_find($pageList);
        },
        '_before_create' => function($data){
            return cache_instance(\App\Logic\AppLogic::class,'project')->_before_create($data);
        },
        '_before_update' => function($ids,$data){
            return cache_instance(\App\Logic\AppLogic::class,'project')->_before_update($ids,$data);
        },
    ],
    'query'=>[
        [
            'status', \Illuminate\Http\Request::capture()->input('status'),
        ]
    ],
    'verify' => [
        'GET' => [
            'status'
        ]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::PROJECT_SERVICE_EXCEPTION,
];