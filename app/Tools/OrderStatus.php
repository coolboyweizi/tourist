<?php
/**
 * 订单状态code，并且每个状态做辅助工作
 * User: Master King
 * Date: 2019/2/22
 */

namespace App\Tools;


use App\Exceptions\ExceptionCode;
use Couchbase\Cluster;

class OrderStatus
{
    private $verify = false ; // 判断购买时需要第三方验证?

    /**
     * @param bool $verify
     */
    public function setVerify(bool $verify): void
    {
        $this->verify = $verify;
    }


    public function wxPay(){

    }

}