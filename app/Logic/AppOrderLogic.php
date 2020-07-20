<?php
/**
 * User: Master King
 * Date: 2019/1/10
 */

namespace App\Logic;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use function EasyWeChat\Kernel\Support\generate_sign;
use Exception;
use Illuminate\Support\Facades\Auth;

class AppOrderLogic
{
    /**
     * @var array 状态
     */
    private $processOn = [
        '-2' => '已退款',
        '-1' => '已取消' ,
        '0' => '待支付',
        '1' => '待使用',
        '2' => '待评价',
        '3' => '已完成',
    ];

    /**
     * 对应的价格服务
     * @var null
     */
    private $priceService = null;

    /**
     * 关联的项目类型
     * @var null
     */
    private $app = null;

    /**
     * AppOrderService constructor.
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->priceService = app($app.'Price.abstract');
    }

    /**
     * 添加置前操作
     * @param $data
     * @return array
     * @throws Exception
     */
    public function _before_create($data)
    {
        $price_info = $this->priceService->findById(array_get($data,'price_id'));

        if ($price_info['status'] == 0) throw new Exception("该价格销售状态不可用");

        // 判断用户id与分享id是否一致
        $shared = array_get($data, 'shared', 0)??0;

        if(Auth::id() == $shared)
        {
            return array_merge(
                $price_info, $data,[
                    'app_id' => array_get($price_info,'app_id'),
                    'talent' => array_get($data,'talent',0),
                    'shared' => 0,
                    'detail' => implode('-',[
                        $price_info['appTitle'],
                        $price_info['title']
                    ]),
                    'status' => 0,
                    'money'  => $price_info['price'] ,
                    'amount' => $price_info['price'] * array_get($data,'number',0),
                    'iscomment' => 0,
            ]);
        } else {
            return array_merge(
                $price_info, $data, [
                    'app_id' => array_get($price_info,'app_id'),
                    'talent' => array_get($data,'talent',0),
                    'shared' =>$shared,
                    'detail' => implode('-',[
                        $price_info['appTitle'],
                        $price_info['title']
                    ]),
                    'status' => 0,
                    'money'  => $price_info['price'] ,
                    'amount' => $price_info['price'] * array_get($data,'number',0),
                    'iscomment' => 0,
                ]);
        }
    }


    /**
     * 创建订单后，返回带微信支付接口的相关信息
     * @param $data
     * @return array
     */
    public function _after_create($data)
    {
        $appPrice = app($this->app.'Price.abstract')->findById($data['price_id']);
        // app:ordered字段自加1
        app($this->app.'.abstract')->increment($appPrice['appId'],'ordered',1);

        $sysOrder = DB::table('orders')
            ->where('app', $this->app)
            ->where('order_id', $data['id'])
            ->first();

        return $this->wxPay((array)$sysOrder, Auth::user()->opendid, $this->app, $data['id']);
    }


    /**
     * 订单更新后
     * @param $data
     * @return mixed
     */
    public function _after_update($data){
        switch ($data) {
            case -2: // 退款
                app('moneyLog.abstract')->create([
                    'affect' => $data['amount'],
                    'app' => $this->app.'Order',
                    'app_id' => $data['id'],
                    'remark' => trim($data['detail'].'退款'),
                    'uid' => $data['uid'],
                ]);
                break;
            default:break;
        }
        return $data;
    }


    /**
     * 调用微信支付接口
     * @param $sysOrder
     * @param $openid
     * @param $app
     * @param $order_id
     * @return array
     */
    public function wxPay($sysOrder, $openid, $app, $order_id)
    {
        $payment = \EasyWeChat::payment();
        $payData = [
            'body'         => substr($sysOrder['detail'],0,64),
            'out_trade_no' => $app.'_'.$order_id.'_'.rand(100,999).date('Y-m-d'),
            'trade_type'   => 'JSAPI',  // 必须为JSAPI
            'openid'       => $openid,
            'total_fee'    => 1,
        ];
        $result = $payment->order->unify($payData);

        if ($result['return_code'] === 'SUCCESS') {
            $params = [
                'appId'     => config('wechat.payment.default.app_id'),
                'timeStamp' => time(),
                'nonceStr'  => $result['nonce_str'],
                'package'   => 'prepay_id=' . $result['prepay_id'],
                'signType'  => 'MD5',
            ];
            $params['paySign'] = generate_sign($params, config('wechat.payment.default.key'));
            $params['timeStamp'] = strval($params['timeStamp']);
            $params['id'] = $sysOrder['id'];
            return $params;
        } else {
            return $result;
        }
    }

    /**
     * 单个查询操作
     * @param $data
     *
     * @return array
     */
    public function _after_find($data){
        return array_merge(
            $data,
            $this->priceInfo($data),
            $this->userInfo($data)
        );
    }

    /**
     * 分页信息填充
     * @param $pageList
     * @return array
     */
    public function _after_find_all($pageList)
    {
        $items = $pageList['data'];
        foreach ($items as $key=>$item) {
            $items[$key] = array_merge(
                $item,
                $this->priceInfo($item),
                $this->userInfo($item)
            );
        }
        return [
            'data' => $items
        ];
    }

    /**
     * 票务基本信息
     * @param $data
     * @return array
     */
    public function priceInfo($data)
    {
        $price_id = array_get($data, 'price_id');
        try {
            $priceInfo = $this->priceService->findById($price_id);
            return [
                'appTitle' => $priceInfo['appTitle'],
                'appLogo' => $priceInfo['appLogo'],
                'merchant_id' => $priceInfo['merchant_id'],
                'appAlias' => $priceInfo['appAlias'],
                'priceType' => $priceInfo['type'],
                //'priceThumbs' => $data['thumbs'],
                'appId' => $priceInfo['appId'],
                'statusCn' => $this->processOn[$data['status']],


            ];
        }catch (Exception $exception){

            return [
                'merchant_id' => 0,
                'appTitle' => "项目不可用",
                'appLogo' => "https://static.scxysd.com//16pic_4524591_b.jpg",
                'appAlias' => 'alias not exist',
                'priceType' => "项目不可用",
                //'priceThumbs' => $data['thumbs'],
                'appId' => 0,
                'statusCn' => "项目不可用",
                'error'  => $exception->getMessage(),
            ];
        }
    }

    /**
     * 用户信息
     * @param $data
     * @return array
     */
    public function userInfo($data){

        $uid = array_get($data,'uid');
        try {
            $user = app('user.abstract')->findById($uid);
            return [
                'nickname' => array_get($user,'nickname'),
                'gender' => array_get($user,'gender'),
                'avatar' => array_get($user,'avatar'),
                'talent' => array_get($user,'talent'),
            ];
        }catch (Exception $exception) {
            return [
                'nickname' => '查无用户',
                'gender' => 0,
                'avatar' => '',
                'talent' => 0,
                'error'  => 'AppOrderLogic'.$exception->getMessage(),
            ];
        }
    }
}