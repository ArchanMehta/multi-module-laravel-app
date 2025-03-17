<?php
namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message;
    public string $sender_name;
    public string $receiver_name;
    public int $receiver_id;
    public string $sent_time;

    public function __construct(Message $message)
    {
        $this->message = $message->message;
        $this->sender_name = $message->sender->name;
        $this->receiver_name = $message->receiver->name;
        $this->receiver_id = $message->receiver_id;
        $this->sent_time = $message->created_at->format('H:i:s'); // Format the time
    }

    public function broadcastOn(): array
    {
        return [new Channel('chat.' . $this->receiver_id)];
    }

    public function broadcastAs(): string
    {
        return 'message.sent';
    }
    
}
