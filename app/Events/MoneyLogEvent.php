<?php

namespace App\Events;

use App\Models\MoneyLogModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * 资金日志: 事件监听
 *
 * Class MoneyLogEvent
 * @package App\Events
 */
class  MoneyLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var MoneyLogModel
     */
    public $model = null;
    /**
     * MoneyLogEvent constructor.
     * @param MoneyLogModel $model
     */
    public function __construct(MoneyLogModel $model)
    {
        // 添加数据日志
        $this->model = $model;
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
