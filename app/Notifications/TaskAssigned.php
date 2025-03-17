<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;

class TaskAssigned extends Notification
{
    protected $data;

    // Constructor accepts data and type
    public function __construct($data)
    {
        $this->data = $data; // Flexible data payload
    }

    // Define the notification delivery method
    public function via($notifiable)
    {
        return ['database']; // Using database to store the notification
    }

    // Prepare data for database notification
    public function toDatabase($notifiable)
    {
        return [
            'type' => $this->data['type'], // E.g., task, leave, FAQ
            'id' => $this->data['id'],     // Generic ID field
            'title' => $this->data['title'] ?? null, // Title or name of the entity
            'description' => $this->data['description'] ?? null, // Optional description
            'additional_data' => $this->data['additional_data'] ?? [], // Any extra data
        ];
    }
}
