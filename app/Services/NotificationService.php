<?php 
namespace App\Services;

use App\Models\Notify;
use App\Models\User;
use Str;

class NotificationService
{
    public static function createNotification($fromId, $toId, $type, $title, $message, $description = null, $postId = null)
    {
        // Create a new instance of Notify
        $notification = new Notify();

        // Set each attribute manually
        $notification->id = Str::uuid();
        $notification->from_id = $fromId;
        $notification->to_id = $toId;
        $notification->type = $type;
        $notification->title = $title;
        $notification->message = $message;
        $notification->description = $description;
        $notification->notifiable_type = User::class;
        $notification->notifiable_id = $toId;
        $notification->post_id = $postId;

        // Save the notification to the database
        $notification->save();

        // Return the saved notification instance
        return $notification;
    }
}
