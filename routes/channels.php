<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
    // Allow the user to listen to the channel if they are the intended recipient or sender
    return (int) $user->id === (int) $receiverId;
});