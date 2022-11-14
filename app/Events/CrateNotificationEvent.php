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
use Illuminate\Support\Facades\Log;

class CrateNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $room_name;
    public $status_new;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($room_name, $status)
    {
        Log::info('evento:');
        Log::info($room_name);
        Log::info($status);

        $this->room_name = $room_name;
        $this->status_new    = $status;
    }

    public function broadcastOn()
    {
        return ['notification'];
    }

    public function broadcastAs()
    {
        return 'notification';
    }
}
