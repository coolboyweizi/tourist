<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'model' => \App\Models\TravelPriceModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            $data =  cache_instance(\App\Logic\AppPriceLogic::class,'travel')->_after_find_all($pageList);
            $items = $data['data'];
            foreach ($items as $key=>$item){
                $items[$key] = array_merge(
                  $item,
                  [
                      'occupiedseats' => bcsub($item['seats'] - $item['occupiedseats'],0),
                      'departure' => app('travel.abstract')->findById($item['app_id'])['departure'],
                      'destination' => app('travel.abstract')->findById($item['app_id'])['destination']
                  ]
                );
            }
            return [
                'data' => $items
            ];
        },
        '_after_find' => function($pageList){
            $data =  cache_instance(\App\Logic\AppPriceLogic::class,'travel')->_after_find($pageList);
            return array_merge($data,
                [
                    'occupiedseats' => bcsub($data['seats'] - $data['occupiedseats'],0),
                    'departure' => app('travel.abstract')->findById($data['app_id'])['departure'],
                    'destination' => app('travel.abstract')->findById($data['app_id'])['destination'],
                    'godate' => \Carbon\Carbon::createFromTimestamp($data['godate'])->format('Y-m-d'),
                    'goschdule' => \Carbon\Carbon::createFromTimestamp($data['godate'])->format('Y-m-d').' '.$data['schedule'],
                ]);
        },
        '_before_find_all' => function($condition){
            // 直通车价格自动删除
            \App\Models\TravelPriceModel::where('godate','<',time())
                ->where('schedule','<',\Carbon\Carbon::now()->format('H:i'))
                ->delete();
            return $condition;
        }
    ],
    'query' => [
        ['app_id',\Illuminate\Http\Request::capture()->input('app_id')],
        ['godate',\Carbon\Carbon::createFromTimeString(
            \Illuminate\Http\Request::capture()->input('godate').' 00:00:00',
            'Asia/Chongqing'
        )->timestamp],
        ['status',1]
    ],
    'verify' => [
        'GET' => ['app_id','status']
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::TRAVEL_PRICE_SERVICE_EXCEPTION,
];