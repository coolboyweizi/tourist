<?php
/**
 * User: Master King
 * Date: 2018/11/14
 */

namespace App\Logic;

use App\User as Admin;
use App\Models\UserModel as User;
use Exception;

class ProfitLogic
{
    private static $orderInstance = [];

    /**
     * Discount
     * @var float
     */
    const SYSTEM = 0.01; // 系统
    const SHARED = 0.08; // 分享
    const TALENT = 0.02; // 达人

    /**
     * 获取单个的订单实例
     * @param $app
     * @return \Illuminate\Foundation\Application|mixed
     */
    private function getOrderInstance($app)
    {
        if (($instance = array_get(self::$orderInstance,$app,null)) == null ){
            $instance = app($app.'Order.abstract');
            self::$orderInstance = array_merge(
              self::$orderInstance,
              [$app => $instance]
            );
        }
        return $instance;
    }

    /**
     * 收益置前操作
     * @param array $data     AppOrder 数据库数据
     * @return array
     * @throws Exception
     */
    public function _before_create($data)
    {
        try {
            return [
                'system' => ($system = $this->system($data['sale'])),
                'shared' => ($shared = $this->shared($data['sale'], array_get($data,'shared_uid',0))),
                'talent' => ($talent = $this->talent($data['sale'], array_get($data,'talent_uid',0))),
                'merchant' => $data['sale'] - $shared - $system - $talent,
            ];
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * 收益记录后，分别给商户和用户添加资金日志
     * @param $data
     * @return mixed
     */
    public function _after_create($data)
    {
        // 订单详情
        $orderInstance = $this->getOrderInstance(array_get($data,'app'))->findById($data['order_id']);

        // 达人。
        if ( $data['talent_uid'] > 0 ) {
            app('moneyLog.abstract')->create(array_merge(
                $data,
                [
                    'uid'      => $data['talent_uid'],
                    'app_id'   => $orderInstance['appId'],
                    'affect'   => array_get($data,'talent'),
                    'amount'   => User::find(array_get($data,'talent_uid'))->amount,
                    'freeze'   => 0,
                    'remark'   => $orderInstance['appAlias'].':'.$orderInstance['appTitle']."达人收益入账"
                ]
            ));
        }

        // 分享
        if ( $data['shared_uid'] > 0 ) {
            app('moneyLog.abstract')->create(array_merge(
                $data,
                [
                    'uid'      => $data['shared_uid'],
                    'app_id'   => $orderInstance['appId'],
                    'affect'   => array_get($data,'shared'),
                    'amount'   => User::find(array_get($data,'shared_uid'))->amount,
                    'freeze'   => 0,
                    'remark'   => $orderInstance['appAlias'].':'.$orderInstance['appTitle']."分享收益入账"
                ]
            ));
        }

        // 商家收益
        if ( $data['merchant_id'] > 0 ) {
            app('merchantMoneyLog.abstract')->create(array_merge(
                $data,
                [
                    'app_id'   => $orderInstance['appId'],
                    'affect'   => array_get($data,'merchant'),
                    'amount'   => Admin::find(array_get($data,'merchant_id'))->amount,
                    'freeze'   => 0,
                    'remark'   => $orderInstance['appAlias'].':'.$orderInstance['appTitle']."商家收益入账"
                ]
            ));
        }else {

        }

        return $data;
    }

    /**
     * @param $data
     * @return array
     */
    public function _after_find_all($data){
        $items = $data['data'];
        foreach ($items as $key => $item){
            $data = app($item['app'].'Order.abstract')->findById($item['order_id']);
            foreach (['id','created','updated','deleted','talent','shared','order_id'] as $k) {
                unset($data[$k]);
            }

            $items[$key] = array_merge($item, $data);
        }
        return [
          'data' => $items
        ];
    }

    /**
     * 系统平台收益
     * @param $amount
     * @return float|int
     */
    private function system($amount){
        return bcmul($amount,  bcdiv(config('system'),100,2),2);
    }

    /**
     * 计算收益
     * @param $amount
     * @param $talent_uid
     * @return int|string
     */
    private function talent($amount, $talent_uid){
        $talent = app('talentUser.abstract')->findAll([
            ['uid',$talent_uid]
        ],1);
        if ($talent['total'] > 0) {
            return bcmul($amount , bcdiv($talent['data'][0]['groupScale'],100,2), 2);
        }
        return 0;

    }

    /**
     * 分享者收益
     * @param $amount
     * @return string
     */
    private function shared($amount, $shared_uid){
        $shared = app('user.abstract')->findAll([
            ['id',$shared_uid]
        ],1);
        if ($shared['total'] > 0){
            return bcmul($amount, bcdiv(config('shared'),100,2),2);
        }
        return 0;
    }

}