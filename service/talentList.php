<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '达人定制列表',
    'model' => \App\Models\TalentListModel::class,
    'closure' => [
        '_before_create' => function($data) {
            // 判断是否已经添加
            $map = [];
            foreach ($data as $field => $val){
                array_push($map,[$field, $val]);
            }

            $talentList = app('talentList.abstract')->findAll($map,1);
            if ($talentList['total'] > 0) {
                throw new Exception("已经订购");
            }
            $appInfo = app($data['app'].'Price.abstract')->findById($data['price_id']);

            // 判断状态
            if ($appInfo['status'] < 1) {
                throw new Exception("项目状态不可用");
            }
            return $data;
        },

        '_after_find_all' => function($data){
            $items = $data['data'];
            $appInstance = [];
            foreach ($items as $key=>$item) {
                // 关联相关的价格信息
                $instance = array_get($appInstance,$item['app'],null);
                if ( ! $instance instanceof \App\Services\BootService ) {
                    $instance = app($item['app'].'Price.abstract');
                    $appInstance = array_merge(
                        $appInstance,
                        [$item['app'] => $instance]
                    );
                }
                $appPrice = $instance->findById($item['price_id']);
                $items[$key] = array_merge(
                    $item,
                    [
                        'appTitle' => $appPrice['appTitle'],
                        'appPrice' => $appPrice['price'],
                        'appPriceTitle' => $appPrice['title'],
                        'appPriceType' => $appPrice['type'],
                        'appLogo' => $appPrice['appLogo'],
                    ]
                );
            }
            return [
                'data' => $items
            ];
        },
        '_after_create' => function($data){
            \App\Jobs\TalentPrice::dispatch($data['talent_id']);
            return $data;
        },
        '_before_destroy' => function($ids){
            // 查询talent_id
            $data = \App\Models\TalentListModel::whereIn('id',$ids)->get();
            foreach ($data as $item){
                \App\Jobs\TalentPrice::dispatch($item->talent_id);
            }
            return $ids;
        }
    ],
    'query'=>[
        ['talent_id',\Illuminate\Http\Request::capture()->input('talent_id')]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::TALENT_LIST_SERVICE_EXCEPTION,
];
