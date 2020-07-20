<?php
/**
 * User: Master King
 * Date: 2019/2/27
 */
return [
    'alias' => '搜索记录',
    'model' => \App\Models\SearchRecordModel::class,
    'closure' => [
        '_after_find_all' => function($pageList) {
            $items = $pageList['data'];

            foreach ($items as $key=>$value){
               $appAlias = config('common.'.$value['app'].'.alias');
               $items[$key] = array_merge(
                   $value,
                   ['appAlias' => $appAlias]
               );
            }
            return [
                'data' => $items
            ];
        }
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::SEARCH_SERVICE_EXCEPTION
];