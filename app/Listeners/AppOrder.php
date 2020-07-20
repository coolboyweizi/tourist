<?php
/**
 * 监听AppOrder数据
 */
namespace App\Listeners;

use App\Events\AppOrderEvent;
use App\Models\OrderModel;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AppOrder
{
    /**
     * 处理事件记录，避免重复处理
     * @var array
     */
    private static $records = [];

    /**
     * Handle the event.
     *
     * @param  AppOrderEvent  $event
     * @return void
     */
    public function handle(AppOrderEvent $event)
    {
        $app = $event->order->app;
        $app_id = $event->order->app_id;

        if (in_array($app.$app_id, self::$records)) {
            return ;
        }

        // 订单自动同步
        OrderModel::updateOrCreate([
            'app' => $app,
            'order_id' => $event->order->id,
        ],$event->order->getAttributes());


        array_push(self::$records, $app.$app_id);
    }
}
