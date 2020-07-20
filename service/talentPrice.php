<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '达人价格',
    'model' => \App\Models\TalentPriceModel::class,
    'query'=>[
        ['app_id',\Illuminate\Http\Request::capture()->input('app_id')]
    ],
    'closure' => [
        '_after_find_all' => function($pageList){
            return cache_instance(\App\Logic\AppPriceLogic::class,'talent')->_after_find_all($pageList);
        },
        '_after_find' => function($pageList){

            return cache_instance(\App\Logic\AppPriceLogic::class,'talent')->_after_find($pageList);
        },
        '_before_create' => function($data){
            return cache_instance(\App\Logic\AppPriceLogic::class,'talent')->_before_create($data);
        },
        'appInfo' => function($item){
            return cache_instance(\App\Logic\AppPriceLogic::class,'talent')->appInfo($item);
        }
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::TALENT_PRICE_SERVICE_EXCEPTION,
];