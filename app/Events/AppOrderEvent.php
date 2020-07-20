<?php

namespace App\Events;

use App\Models\BaseModel as Model;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AppOrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order = null;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $appOrder)
    {
        $this->order = $appOrder;
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
