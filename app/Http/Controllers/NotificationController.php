<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class NotificationController extends Controller
{




    public function index(Request $request)
    {
        // Fetch all notifications related to the logged-in user (both sent and received notifications)
        $notifications = auth()->user()
            ->notifications() // Get all notifications related to the user
            // ->orWhere('from_id', auth()->id()) // Include notifications where the user is the sender
            ->orWhere('to_id', auth()->id())   // Include notifications where the user is the recipient
            ->latest() // Latest first
            ->paginate(10); // Paginate notifications (10 per page)

        return view('Dashboard.pages.forms.viewallnotification', compact('notifications'));
    }





    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();  // Mark notification as read
        $notification->delete();


        return redirect()->route('notifications.index');  // Redirect back to notifications
    }

    public function getUnreadCount()
    {
        return auth()->user()->unreadNotifications->count();  // Return unread notifications count
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json([
            'status' => 'success',
            'message' => 'All notifications have been marked as read.',
        ]);
    }
}
