<?php
/**
 * 监听系统订单save事件
 */
namespace App\Events;

use App\Models\OrderModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SysOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var OrderModel
     */
    public $order = null;

    /**
     * Create a new event instance.
     *
     * @param OrderModel $orderModel
     * @return void
     */
    public function __construct(OrderModel $orderModel)
    {
        $this->order = $orderModel;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
