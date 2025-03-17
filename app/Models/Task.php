<?php

namespace App\Models;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = "tasks_tables";
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user_tables', 'task_id', 'user_id')
            ->withPivot('status', 'assigned_at')
            ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


     // Broadcasting task assigned to users
     public function broadcastOn()
     {
         return new Channel('task.' . $this->id); // Broadcasts on a channel named task.{task_id}
     }
 
     public function broadcastAs()
     {
         return 'task-assigned'; // Event name
     }
}
