<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CrateNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $room_name;
    protected $status;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($room_name, $status)
    {
        $this->room_name = $room_name;
        $this->status    = $status;
    }

    public function broadcastOn()
    {
        return ['my-channel'];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
