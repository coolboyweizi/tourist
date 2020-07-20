<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '评论服务',
    'model' => \App\Models\RecommendModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance(\App\Logic\RecommendLogic::class,'recommend')->_after_find_all($pageList);
        },
        '_before_create' => function($data){
            return cache_instance(\App\Logic\RecommendLogic::class,'recommend')->_before_create($data);
        },
        '_after_create' => function($data){
            return cache_instance(\App\Logic\RecommendLogic::class,'recommend')->_after_create($data);
        },
        '_before_destroy' => function($ids) {
            return cache_instance(\App\Logic\RecommendLogic::class,'recommend')->_before_destroy($ids);
        }

    ],
    'query'=>[
        ['app_id',\Illuminate\Http\Request::capture()->input('app_id')],
        ['app',\Illuminate\Http\Request::capture()->input('app')]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::RECOMMEND_SERVICE_EXCEPTION,
];