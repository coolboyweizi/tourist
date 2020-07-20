<?php
/**
 * User: Master King
 * Date: 2019/1/17
 */

namespace App\Logic;


class MoneyLogLogic
{
    public function _before_create($data){
        return [
            'amount' => app('user.abstract')->findById($data['uid'])['amount'],
            'freeze' => array_get($data,'freeze',0.00),
            'affect' => array_get($data,'affect',0.00),
        ];
    }
}