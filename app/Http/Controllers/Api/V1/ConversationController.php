<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(): JsonResponse
    {
        $userId = auth()->id();

        $conversations = Conversation::with(['buyer', 'seller', 'messages' => fn($q) => $q->latest()->limit(1)])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->latest('last_message_at')
            ->paginate(20);

        return response()->json([
            'conversations' => collect($conversations->items())->map(fn($c) => [
                'id' => $c->id,
                'buyer' => ['id' => $c->buyer_id, 'name' => $c->buyer->name, 'profile_photo_url' => $c->buyer->profile_photo_url],
                'seller' => ['id' => $c->seller_id, 'name' => $c->seller->name, 'profile_photo_url' => $c->seller->profile_photo_url],
                'last_message' => $c->messages->first() ? [
                    'id' => $c->messages->first()->id,
                    'sender_id' => $c->messages->first()->sender_id,
                    'body' => $c->messages->first()->body,
                    'created_at' => $c->messages->first()->created_at,
                    'read' => $c->messages->first()->read,
                ] : null,
                'unread_count' => $c->buyer_id === $userId ? $c->buyer_unread : $c->seller_unread,
                'target_id' => $c->target_id,
                'target_type' => class_basename($c->target_type),
                'target_name' => $c->target?->name ?? null,
                'updated_at' => $c->last_message_at ?? $c->updated_at,
            ]),
            'pagination' => [
                'current_page' => $conversations->currentPage(),
                'last_page' => $conversations->lastPage(),
                'total' => $conversations->total(),
            ],
        ]);
    }

    public function show(Conversation $conversation): JsonResponse
    {
        $userId = auth()->id();
        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $conversation->load(['buyer', 'seller', 'messages.sender']);

        // Mark messages as read
        if ($conversation->buyer_id === $userId) {
            $conversation->update(['buyer_unread' => 0]);
        } else {
            $conversation->update(['seller_unread' => 0]);
        }

        return response()->json([
            'conversation' => [
                'id' => $conversation->id,
                'buyer' => ['id' => $conversation->buyer_id, 'name' => $conversation->buyer->name, 'profile_photo_url' => $conversation->buyer->profile_photo_url],
                'seller' => ['id' => $conversation->seller_id, 'name' => $conversation->seller->name, 'profile_photo_url' => $conversation->seller->profile_photo_url],
                'messages' => $conversation->messages->map(fn($m) => [
                    'id' => $m->id,
                    'sender_id' => $m->sender_id,
                    'body' => $m->body,
                    'created_at' => $m->created_at,
                    'read' => $m->read,
                ]),
            ],
        ]);
    }

    public function destroy(Conversation $conversation): JsonResponse
    {
        $userId = auth()->id();
        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $conversation->messages()->delete();
        $conversation->delete();

        return response()->json(['message' => 'Conversation deleted.']);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'seller_id' => 'required|exists:users,id',
            'target_type' => 'required|string|in:product,service,rental,store',
            'target_id' => 'required|integer',
            'message' => 'required|string|max:2000',
        ]);

        $modelClass = match ($validated['target_type']) {
            'product' => 'App\\Models\\Product',
            'service' => 'App\\Models\\Service',
            'rental' => 'App\\Models\\RentalItem',
            'store' => 'App\\Models\\Store',
            default => 'App\\Models\\Product',
        };

        $conversation = Conversation::firstOrCreate(
            [
                'buyer_id' => auth()->id(),
                'seller_id' => $validated['seller_id'],
                'target_type' => $modelClass,
                'target_id' => $validated['target_id'],
            ],
            [
                'buyer_unread' => 0,
                'seller_unread' => 1,
            ]
        );

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'body' => $validated['message'],
        ]);

        $conversation->update([
            'last_message' => $validated['message'],
            'last_message_at' => now(),
            'seller_unread' => $conversation->seller_unread + ($conversation->buyer_id === auth()->id() ? 1 : 0),
            'buyer_unread' => $conversation->buyer_unread + ($conversation->seller_id === auth()->id() ? 1 : 0),
        ]);

        return response()->json([
            'message' => 'Message sent.',
            'conversation_id' => $conversation->id,
            'data' => $message,
        ], 201);
    }
}
