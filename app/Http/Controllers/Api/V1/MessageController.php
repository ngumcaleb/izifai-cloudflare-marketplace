<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    public function index(Conversation $conversation): JsonResponse
    {
        $userId = auth()->id();
        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $messages = $conversation->messages()->with('sender')->latest()->paginate(50);

        return response()->json([
            'messages' => collect($messages->items())->map(fn($m) => [
                'id' => $m->id,
                'sender_id' => $m->sender_id,
                'body' => $m->body,
                'image_url' => $m->image_url,
                'created_at' => $m->created_at,
                'edited_at' => $m->edited_at,
                'read' => $m->read,
                'deleted_at' => $m->deleted_at,
            ])->reverse()->values(),
            'pagination' => [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'total' => $messages->total(),
            ],
        ]);
    }

    public function store(Request $request, Conversation $conversation): JsonResponse
    {
        $userId = auth()->id();
        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'body' => 'nullable|string|max:2000',
            'image' => 'nullable|file|mimes:jpeg,png,gif,webp,bmp|max:5120',
        ]);

        if (!$validated['body'] && !$request->hasFile('image')) {
            return response()->json(['message' => 'Message must have text or an image.'], 422);
        }

        $data = [
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'body' => $validated['body'] ?? null,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('message_images', 'r2');
        }

        $message = Message::create($data);

        $conversation->update([
            'last_message' => $validated['body'] ?? '[Image]',
            'last_message_at' => now(),
            'seller_unread' => $conversation->seller_unread + ($conversation->buyer_id === $userId ? 1 : 0),
            'buyer_unread' => $conversation->buyer_unread + ($conversation->seller_id === $userId ? 1 : 0),
        ]);

        return response()->json([
            'message' => 'Message sent.',
            'data' => [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'body' => $message->body,
                'image_url' => $message->image_url,
                'created_at' => $message->created_at,
                'edited_at' => $message->edited_at,
                'read' => $message->read,
            ],
        ], 201);
    }

    public function update(Request $request, Conversation $conversation, Message $message): JsonResponse
    {
        $userId = auth()->id();
        if ($message->sender_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        if ($message->conversation_id !== $conversation->id) {
            return response()->json(['message' => 'Message not found in this conversation.'], 404);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $message->update([
            'body' => $validated['body'],
            'edited_at' => now(),
        ]);

        return response()->json([
            'message' => 'Message updated.',
            'data' => [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'body' => $message->body,
                'image_url' => $message->image_url,
                'created_at' => $message->created_at,
                'edited_at' => $message->edited_at,
                'read' => $message->read,
            ],
        ]);
    }

    public function destroy(Conversation $conversation, Message $message): JsonResponse
    {
        $userId = auth()->id();
        if ($message->sender_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        if ($message->conversation_id !== $conversation->id) {
            return response()->json(['message' => 'Message not found in this conversation.'], 404);
        }

        if ($message->image) {
            Storage::disk('r2')->delete($message->image);
        }

        $message->delete();

        return response()->json(['message' => 'Message deleted.']);
    }

    public function markRead(Conversation $conversation): JsonResponse
    {
        $userId = auth()->id();
        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $conversation->messages()->where('sender_id', '!=', $userId)->where('read', false)->update([
            'read' => true,
            'read_at' => now(),
        ]);

        if ($conversation->buyer_id === $userId) {
            $conversation->update(['buyer_unread' => 0]);
        } else {
            $conversation->update(['seller_unread' => 0]);
        }

        return response()->json(['message' => 'Messages marked as read.']);
    }
}
