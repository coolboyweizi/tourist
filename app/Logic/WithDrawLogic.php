<?php
/**
 * User: Master King
 * Date: 2019/1/10
 */

namespace App\Logic;

use App\Exceptions\AppException;
use App\Models\UserModel as User;

class WithDrawLogic
{
    /**
     * 最低提现金额
     */
    const MIN_WITHDRAW_MONEY = 100;

    /**
     * @var array
     */
    private static $userInfo = [];

    /**
     * 申请提现之前的用户与金额的判断
     *
     * @param $data
     * @return array
     * @throws AppException
     */
    public function _before_create($data){
        $uid = array_get($data, 'uid', 0);
        try{
            $userInfo = app('user.abstract')->findById($uid);
            if (empty($userInfo)) {
                throw new AppException("没查到提现用户Id:${uid}");
            }
            // 提现金额
            $amount = array_get($data, 'money',0);
            $userAmount = array_get($userInfo,'amount',0);
            if ($amount > $userAmount) {
                throw new AppException("提现金额已经超过用户金额");
            }
            if ($amount < self::MIN_WITHDRAW_MONEY) {
                throw new AppException("提现额度不低于:".self::MIN_WITHDRAW_MONEY);
            }
            return [
                'status' => 0
            ];
        }catch (\Exception $exception){
            throw new AppException(
                $exception->getMessage(),$exception->getCode(),$exception
            );
        }
    }

    /**
     * 提现后的数据
     * @param $data
     * @return array
     */
    public function _after_create($data){
        $moneyLog = app('moneyLog.abstract')->create([
            'affect' => (0-(array_get($data,'money'))),
            'freeze' => array_get($data,'money'),
            'app'    => 'withdraw',
            'app_id' => array_get($data,'id'),
            'remark' => '申请提现',
            'uid'    => array_get($data,'uid')
        ]);
        return [
            'amount' => $moneyLog['amount'],
        ];
    }

    /**
     * @param $ids
     * @param $data
     * @throws AppException
     * @return array
     */
    public function _before_update($ids, $data){
        foreach ($ids as $id) {
            $item = app('withdraw.abstract')->findById($id);
            if ( array_get($item,'status', false) !== 0 ){
                throw new AppException(
                    "该次提现已经受理，不再可重复受理"
                );
            }
        }
        return $ids;
    }

    /**
     * @param $pageList
     * @return array
     */
    public function _after_find_all($pageList){
        $items = $pageList['data'];
        foreach ($items as $key => $item) {
            $uid = $item['uid'];

            $userInfo = array_get(self::$userInfo, $uid, false);
            if ($userInfo === false){
                $info = app('user.abstract')->findById($uid);
                self::$userInfo[$uid] = [
                    'userNickname' => $info['nickname'],
                    'userAvatar' => $info['avatar'],
                    'userMoney' => $info['amount'],
                    'userFreeze' => $info['freeze']
                ];
                $userInfo = self::$userInfo[$uid];
            }
            $items[$key] = array_merge(
                $item,
                $userInfo
            );
        }
        return [
            'data' => $items
        ];
    }

    public function _after_update($id, $data){
        // 判断提现资金是否正常
        if ($data['status'] == 1) {
            // 受理提现. 把冻结资金减少
            $withDraw = app('withdraw.abstract')->findById($id);
            $freeze = User::find($withDraw['uid'])->freeze;

            if ($freeze < $withDraw['money']) {
                throw new AppException("提现异常:金额超出");
            }

            app('moneyLog.abstract')->create(
                [
                    'uid'      => $withDraw['uid'],
                    'app_id'   => $id,
                    'app'   => 'withdraw',
                    'affect'   => 0,
                    'amount'   => User::find($withDraw['uid'])->amount,
                    'freeze'   => bcsub(0, $withDraw['money'],2),
                    'remark'   => "成功提现"
                ]
            );
        }else if ($data['status'] == -1){
            // 受理提现. 把冻结资金减少
            $withDraw = app('withdraw.abstract')->findById($id);
            $freeze = User::find($withDraw['uid'])->freeze;


            if ($freeze < $withDraw['money']) {
                 throw new AppException("提现异常:金额超出");
            }

            app('moneyLog.abstract')->create(
                [
                    'uid'      => $withDraw['uid'],
                    'app_id'   => $id,
                    'app'   => 'withdraw',
                    'affect'   => $withDraw['money'],
                    'amount'   => User::find($withDraw['uid'])->amount,
                    'freeze'   => bcsub(0, $withDraw['money'],2),
                    'remark'   => "提现未通过审核，返回金额"
                ]
            );
        }
        return $data;
    }
}