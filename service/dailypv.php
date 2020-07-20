<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '网站流量',
    'model' => \App\Models\DailyPvModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            $data = array_get($pageList, 'data');
            // 保存返回的时刻表数据，
            $result = [];
            // 遍历0-23点的数组
            $timestamp = range(00,23);
            $items = array_pluck($data,'count','times');
            array_walk($timestamp,function($num) use(&$result, $items) {
                if ($num < 10) $num = '0'.$num;
                $time = $num.':00';

                $result[$time] = array_get($items, $num,0);

                /*if ($items[0]['times'] == $num) {
                    $result = array_merge($result, [$time => $items[0]['count']]);
                    array_shift($items);

                }else {
                    $result = array_merge($result, [$time => 0]);
                }*/

               /* $item = array_get($items, count($result));
                $result = array_merge($result, [
                        $time => array_get($item,'times',false)?'0':array_get($item,'count',0)
                ]);*/
            });
            return [
                'data' => $result
            ];
        }
    ]
];