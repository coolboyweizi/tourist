<?php
/**
 * 商户资金事件对应的监听器
 */
namespace App\Listeners;

use App\Events\MerchantMoneyLogEvent;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MerchantMoneyLog
{
    private static $handleRecord = [];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * 检查是否已经触发过
     * @param MerchantMoneyLogEvent $event
     * @return bool
     */
    private function _before_handle(MerchantMoneyLogEvent $event){
        if (!in_array($event->model->getKey(),self::$handleRecord)) {
            array_push(self::$handleRecord,$event->model->getKey());
            return false;
        }
        return true;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MerchantMoneyLogEvent $event)
    {
        if ($this->_before_handle($event)) {
            return ;
        }

        $user = User::find($event->model->merchant_id);
        $user->increment('amount', $event->model->affect);      // 增加金额
        $user->increment('freeze', $event->model->freeze);      // 冻结金额
    }
}
