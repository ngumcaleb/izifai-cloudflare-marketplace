<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = UserNotification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function unreadCount()
    {
        $count = UserNotification::where('user_id', auth()->id())
            ->unread()
            ->count();

        return response()->json(['unread_count' => $count]);
    }

    public function markRead($id)
    {
        $notification = UserNotification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->update(['read' => true]);

        return back();
    }

    public function markAllRead()
    {
        UserNotification::where('user_id', auth()->id())
            ->unread()
            ->update(['read' => true]);

        return back()->with('success', 'All notifications marked as read.');
    }

    public function destroy($id)
    {
        $notification = UserNotification::where('user_id', auth()->id())
            ->findOrFail($id);

        $notification->delete();

        return back()->with('success', 'Notification removed.');
    }
}
