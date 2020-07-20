<?php

namespace App\Listeners;

use App\Events\SysOrderEvent;
use App\Jobs\AppActive;
use App\Jobs\Profit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SysOrder
{
    /**
     * 处理事件记录，避免重复处理
     * @var array
     */
    private static $records = [];

    /**
     * 处理事件。
     * @param SysOrderEvent $event
     */
    public function handle(SysOrderEvent $event)
    {
        $id = $event->order->getKey();
        if (in_array($id, self::$records)) {
            return ;
        }
        array_push(self::$records, $id);

        // 同步订单状态
        app($event->order->app.'Order.abstract')->update([
            $event->order->order_id
        ],[
            'status' => $event->order->status
        ]);

        // 队列计算收益
        if ($event->order->status == 2) {
            Profit::dispatch($event->order);
        }

        // 队列处理已经支付的活动
        if ($event->order->active_id > 0 && $event->order->status == 1){
            AppActive::dispatch($event->order->getAttributes());
        }
    }
}
