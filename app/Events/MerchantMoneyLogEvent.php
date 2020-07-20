<?php

namespace App\Events;

use App\Models\MerchantMoneyLogModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MerchantMoneyLogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var MerchantMoneyLogModel
     */
    public $model = null;

    /**
     * Create a new event instance.
     *
     * @param MerchantMoneyLogModel $model
     * @return void
     */
    public function __construct(MerchantMoneyLogModel $model)
    {
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
