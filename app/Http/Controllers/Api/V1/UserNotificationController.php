<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\JsonResponse;

class UserNotificationController extends Controller
{
    public function index(): JsonResponse
    {
        $notifications = UserNotification::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return response()->json([
            'notifications' => collect($notifications->items())->map(fn($n) => [
                'id' => $n->id,
                'type' => $n->type,
                'title' => $n->title,
                'message' => $n->message,
                'read' => $n->read,
                'data' => $n->data ?? [],
                'created_at' => $n->created_at,
            ]),
            'unread_count' => UserNotification::where('user_id', auth()->id())->where('read', false)->count(),
            'pagination' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'total' => $notifications->total(),
            ],
        ]);
    }

    public function markRead(string $id): JsonResponse
    {
        $notification = UserNotification::where('user_id', auth()->id())->findOrFail($id);
        $notification->update(['read' => true]);

        return response()->json(['message' => 'Notification marked as read.']);
    }

    public function markAllRead(): JsonResponse
    {
        UserNotification::where('user_id', auth()->id())->where('read', false)->update(['read' => true]);

        return response()->json(['message' => 'All notifications marked as read.']);
    }

    public function destroy(string $id): JsonResponse
    {
        $notification = UserNotification::where('user_id', auth()->id())->findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Notification deleted.']);
    }

    public function unreadCount(): JsonResponse
    {
        $count = UserNotification::where('user_id', auth()->id())->where('read', false)->count();

        return response()->json(['count' => $count]);
    }
}
