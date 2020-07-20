<?php

namespace App\Http\Controllers\Api;

use App\Jobs\TravelOrder;
use App\Models\WxPayRecordModel;
use function EasyWeChat\Kernel\Support\generate_sign;
use Illuminate\Support\Facades\Auth;


class WxApiController extends Controller
{

    /**
     * 微信支付回调
     *
     *  array (
     *      'appid' => 'wxbbb34fceedb03bc0',
     *      'bank_type' => 'CFT', 'cash_fee' => '1',
     *       'fee_type' => 'CNY',
     *       'is_subscribe' => 'N',
     *       'mch_id' => '1518216951',
     *       'nonce_str' => '5c0f28366b7ff',
     *       'openid' => 'o11975Tqf1J8033af2o-4FxW08SU',
     *       'out_trade_no' => '53',
     *       'result_code' => 'SUCCESS',
     *       'return_code' => 'SUCCESS',
     *       'sign' => '232AD95EBEC04C2BA2DACDCEF08E0657',
     *       'time_end' => '20181211110130',
     *       'total_fee' => '1',
     *       'trade_type' => 'JSAPI',
     *       'transaction_id' => '4200000222201812115220106322',
     *   )
     * @return mixed
     */
    public function store( )
    {
        try {
            $app  = \EasyWeChat::payment();
            $orderService = app('order.abstract');
            return $app->handlePaidNotify(function ($message, $fail) use( $orderService ) {

                $wxRecordModel = null;
                try {
                    $user = app('user.abstract')->findAll([
                        ['opendid', $message['openid']]
                    ],1);
                    $user = $user['total'] == 1? $user['data'][0]['nickname'] : $message['openid'];
                    $wxRecordModel = WxPayRecordModel::create(array_merge(
                        $message,
                        [
                            'nickname' => $user,
                            'status' => 0
                        ]
                    ));
                }catch (\Exception $exception) {
                    smartLog('wxPay','wx_pay_record_log_fail',$exception->getMessage());
                }

                if ($message['return_code'] !== 'SUCCESS') {
                    return $fail('Order not exists.');
                }else {
                    $sign = $message['sign'];
                    unset($message['sign']);
                    if($sign == generate_sign( $message, config('wechat.payment.default.key')) ) {
                        list($app, $order_id,$time) = explode('_',$message['out_trade_no'] );
                        $realOrder = $orderService->findAll(
                            [
                                'app' => $app,
                                'order_id' => $order_id
                            ],1
                        );
                        if ($realOrder['total'] < 1 ) {
                            smartLog('wxPay','total', $realOrder);
                            return true;
                        }
                        if ($realOrder['data'][0]['status'] > 0) {
                            smartLog('wxPay','status', $realOrder);
                            return true;
                        }
                        $orderService->update(
                           [$realOrder['data'][0]['id']],
                            ['status' => 1]
                        );
                        try {
                            if ($wxRecordModel != null) {
                                $wxRecordModel->update(['status' => 1]);
                            }
                            if ($app == 'travel') {
                                TravelOrder::dispatch(
                                    app( 'travelOrder.abstract')->findById($order_id)
                                );
                            }

                        }catch (\Exception $exception) {
                            smartLog('wxPay','wx_pay_record_log_fail',$exception->getMessage());
                        }
                       return true;
                    }else {
                        return $fail('Order not exists.');
                    }
                }
            });
        }catch (\Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * 订单重新发起支付。
     * @param $id
     * @return array
     */
    public function wxRePay($id)
    {
        try {
            $sysOrder = app('order.abstract')->findById($id);

            if ($sysOrder['status'] > 0 ) {
                return [
                    'code' => 1,
                    'data' => "订单已支付"
                ];
            }
            // $sysOrder, $openid, $app, $order_id
            return [
                'code' => 0,
                'data' => app($sysOrder['app'].'Order.abstract')->wxPay($sysOrder,Auth::user()->opendid, $sysOrder['app'], $sysOrder['order_id'] )
            ];
        }catch (\Exception $exception){
            return [
                'code' => $exception->getCode(),
                'data' => $exception->getMessage()
            ];
        }
    }


}
