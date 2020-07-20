<?php

namespace App\Listeners;

use App\Events\MoneyLogEvent;
use App\Models\UserModel as User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MoneyLogListener
{
    /**
     * 防止多次同步
     * @var array
     */
    private static $handleRecord = [];

    /**
     * 检查是否已经执行
     * @param MoneyLogEvent $event
     * @return bool
     */
    private function _before_handle(MoneyLogEvent $event){
        if (!in_array($event->model->getKey(), self::$handleRecord)) {
            array_push(self::$handleRecord,$event->model->getKey());
            return false;
        }
        return true;
    }

    /**
     * 同步数据
     * @param MoneyLogEvent $event
     */
    public function handle(MoneyLogEvent $event)
    {
            if ($this->_before_handle($event)) {
                return;
            }
            $user = User::find($event->model->uid);
            $user->increment('amount', $event->model->affect);      // 增加金额
            $user->increment('freeze', $event->model->freeze);      // 冻结金额
    }

}
