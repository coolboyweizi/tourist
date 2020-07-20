<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '微信返回记录',
    'model' => \App\Models\WxPayRecordModel::class,
    'errorCode' => \App\Exceptions\ExceptionCode::WITHDRAW_SERVICE_EXCEPTION,
    'closure' => [
        '_after_find_all'  => function($pageList){
            $data = $pageList['data'];
            foreach ($data as $key=>$item) {
                list($app, $order_id) = explode('_', $item['out_trade_no']);
                try {
                    $priceInfo = app($app.'Order.abstract')->findById($order_id);
                }catch (Exception $exception){
                    $priceInfo = [];
                }

                $data[$key] = array_merge(
                    $item,[
                        'orderDetail' => $priceInfo['detail']??'已删除',
                        'appTitle'    => $priceInfo['appTitle']??'已删除',
                        'total_fee'   => bcdiv($item['total_fee'],100,2)
                ]);
            }
            return ['data' => $data];
        }
    ]
];