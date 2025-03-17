<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\BroadcastEvent;
use Illuminate\Queue\SerializesModels;


class TaskAssigned implements BroadcastEvent
{
    use InteractsWithSockets, SerializesModels;

    public $task;
    public $user;

    public function __construct($task, $user)
    {
        if (auth()->check()) { // Check if the user is authenticated
            $this->task = $task;
            $this->user = $user;
        }
    }

    public function broadcastOn()
    {
        return new PrivateChannel('notifications.' . $this->user->id);
    }

    public function broadcastWith()
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'description' => $this->task->description,
        ];
    }
}