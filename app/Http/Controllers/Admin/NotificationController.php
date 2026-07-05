<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminNotification::where('admin_id', auth()->guard('admin')->id());

        if ($request->filter === 'unread') {
            $query->where('read', false);
        }

        $notifications = $query->latest()->paginate(20);
        $unreadCount = AdminNotification::where('admin_id', auth()->guard('admin')->id())
            ->where('read', false)->count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markRead($id)
    {
        $notification = AdminNotification::where('admin_id', auth()->guard('admin')->id())
            ->findOrFail($id);
        $notification->update(['read' => true]);

        if (request()->wantsJson()) {
            return response()->json(['unread_count' => AdminNotification::where('admin_id', auth()->guard('admin')->id())->where('read', false)->count()]);
        }
        return back();
    }

    public function markAllRead()
    {
        AdminNotification::where('admin_id', auth()->guard('admin')->id())
            ->where('read', false)
            ->update(['read' => true]);

        if (request()->wantsJson()) {
            return response()->json(['unread_count' => 0]);
        }
        return back();
    }

    public function unreadCount()
    {
        $count = AdminNotification::where('admin_id', auth()->guard('admin')->id())
            ->where('read', false)->count();
        return response()->json(['unread_count' => $count]);
    }

    public function dropdown()
    {
        $notifications = AdminNotification::where('admin_id', auth()->guard('admin')->id())
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'title' => $n->title,
                    'message' => $n->message,
                    'type' => $n->type,
                    'read' => $n->read,
                    'time' => $n->created_at->diffForHumans(),
                    'url' => route('admin.notifications.read', $n->id),
                ];
            });

        return response()->json(['notifications' => $notifications]);
    }
}
