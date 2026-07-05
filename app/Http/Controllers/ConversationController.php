<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ConversationController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $conversations = Conversation::with(['buyer', 'seller', 'messages' => fn($q) => $q->latest()->limit(1)])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->latest('last_message_at')
            ->paginate(20);

        return view('conversations.index', compact('conversations'));
    }

    public function show(Conversation $conversation): View
    {
        $userId = auth()->id();

        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            abort(403);
        }

        $conversation->load(['buyer', 'seller', 'messages.sender']);
        $conversation->messages->load('sender');

        if ($conversation->buyer_id === $userId) {
            $conversation->update(['buyer_unread' => 0]);
        } else {
            $conversation->update(['seller_unread' => 0]);
        }

        $otherUser = $conversation->buyer_id === $userId ? $conversation->seller : $conversation->buyer;
        $otherStore = $otherUser->store;

        $target = $conversation->target;

        return view('conversations.show', compact('conversation', 'otherUser', 'otherStore', 'target'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'seller_id' => 'required|exists:users,id',
            'target_type' => 'required|string|in:product,service,rental,store',
            'target_id' => 'required|integer',
            'message' => 'nullable|string|max:2000',
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
            ],
            [
                'buyer_unread' => 0,
                'seller_unread' => 0,
                'target_type' => $modelClass,
                'target_id' => $validated['target_id'],
            ]
        );

        $target = (new $modelClass)->find($validated['target_id']);

        $targetMetadata = $target ? $this->buildTargetMetadata($target, $validated['target_type']) : null;

        if (!empty($validated['message'])) {
            $metadata = $targetMetadata ? ['target' => $targetMetadata] : null;

            Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => auth()->id(),
                'body' => $validated['message'],
                'metadata' => $metadata,
            ]);

            $conversation->update([
                'last_message' => $validated['message'],
                'last_message_at' => now(),
                'seller_unread' => $conversation->seller_unread + ($conversation->buyer_id === auth()->id() ? 1 : 0),
                'buyer_unread' => $conversation->buyer_unread + ($conversation->seller_id === auth()->id() ? 1 : 0),
                'target_type' => $modelClass,
                'target_id' => $validated['target_id'],
            ]);
        }

        return redirect()->route('conversations.show', $conversation);
    }

    public function sendMessage(Request $request, Conversation $conversation): JsonResponse
    {
        $userId = auth()->id();

        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:2000',
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'body' => $validated['body'],
        ]);

        $conversation->update([
            'last_message' => $validated['body'],
            'last_message_at' => now(),
            'seller_unread' => $conversation->seller_unread + ($conversation->buyer_id === $userId ? 1 : 0),
            'buyer_unread' => $conversation->buyer_unread + ($conversation->seller_id === $userId ? 1 : 0),
        ]);

        $message->load('sender');

        return response()->json([
            'message' => [
                'id' => $message->id,
                'sender_id' => $message->sender_id,
                'body' => $message->body,
                'sender_name' => $message->sender->name,
                'created_at' => $message->created_at->toISOString(),
                'read' => $message->read,
                'metadata' => $message->metadata,
            ],
        ]);
    }

    public function fetchMessages(Request $request, Conversation $conversation): JsonResponse
    {
        $userId = auth()->id();

        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $query = $conversation->messages()->with('sender');

        if ($request->has('after')) {
            $query->where('id', '>', $request->integer('after'));
        }

        $messages = $query->oldest()->get();

        return response()->json([
            'messages' => $messages->map(fn($m) => [
                'id' => $m->id,
                'sender_id' => $m->sender_id,
                'body' => $m->body,
                'sender_name' => $m->sender->name,
                'created_at' => $m->created_at->toISOString(),
                'read' => $m->read,
                'metadata' => $m->metadata,
            ]),
        ]);
    }

    public function unreadCount(): JsonResponse
    {
        $userId = auth()->id();

        $count = Conversation::where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->get()
            ->sum(fn($c) => $c->buyer_id === $userId ? $c->buyer_unread : $c->seller_unread);

        return response()->json(['count' => $count]);
    }

    public function destroy(Conversation $conversation)
    {
        $userId = auth()->id();

        if ($conversation->buyer_id !== $userId && $conversation->seller_id !== $userId) {
            abort(403);
        }

        $conversation->messages()->delete();
        $conversation->delete();

        return redirect()->route('conversations.index')->with('success', 'Conversation deleted.');
    }

    private function buildTargetMetadata($target, string $type): array
    {
        $image = match ($type) {
            'product' => $target->mainImage?->url ?? $target->images->first()?->url,
            'service' => $target->mainImage?->url ?? $target->images->first()?->url,
            'rental' => $target->images_url[0] ?? null,
            default => null,
        };
        $price = match ($type) {
            'product' => $target->price ?? null,
            'service' => $target->starting_price ?? null,
            'rental' => $target->rate ?? null,
            default => null,
        };
        $url = match ($type) {
            'product' => route('products.show', $target->slug ?? $target->id),
            'service' => route('services.show', $target->slug ?? $target->id),
            'rental' => route('rentals.show', $target->slug ?? $target->id),
            'store' => route('stores.show', $target->slug ?? $target->id),
            default => null,
        };
        $label = match ($type) {
            'product' => 'Product',
            'service' => 'Service',
            'rental' => 'Rental',
            'store' => 'Store',
            default => 'Item',
        };
        $currency = $price !== null ? 'FCFA' : null;

        return [
            'type' => $type,
            'label' => $label,
            'id' => $target->id,
            'name' => $target->name ?? null,
            'image' => $image,
            'price' => $price,
            'currency' => $currency,
            'url' => $url,
        ];
    }
}
