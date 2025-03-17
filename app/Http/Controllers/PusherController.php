<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\PusherBroadcast;
use Illuminate\Support\Facades\Log;

class PusherController extends Controller
{
    public function index()
    {
        return view('Dashboard.pages.forms.chat');
    }

    public function users()
    {
        $users = User::where('id', '!=', auth()->id())->get(['id', 'name']);
        return response()->json($users);
    }

    public function getMessages($userId)
    {
        $messages = Message::where(function ($query) use ($userId) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', auth()->id());
        })->orderBy('created_at', 'asc')->get();

        // Append sender_name and formatted sent_time to each message
        $messages->transform(function ($message) {
            $message->sender_name = User::find($message->sender_id)->name;
            $message->sent_time = $message->created_at->format('H:i:s');
            return $message;
        });

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);

        // Append sender_name and formatted sent_time to the message
        $message->sender_name = auth()->user()->name;
        $message->sent_time = $message->created_at->format('H:i:s');

        // Pass the entire message object to the event
        broadcast(new PusherBroadcast($message))->toOthers();
        Log::info('Broadcasting message: ', $message->toArray()); // Add this for debugging

        return response()->json($message);
    }
}
