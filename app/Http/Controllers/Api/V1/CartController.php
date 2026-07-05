<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getOrCreateCart()
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        return $cart->load('items.item');
    }

    public function show(): JsonResponse
    {
        $cart = $this->getOrCreateCart();

        return response()->json([
            'cart' => [
                'id' => $cart->id,
                'items' => $cart->items->map(fn($item) => [
                    'id' => $item->id,
                    'item_type' => $item->item_type,
                    'item_id' => $item->item_id,
                    'name' => $item->item->name,
                    'price' => (float) $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => (float) ($item->price * $item->quantity),
                    'store_name' => $item->item->store->name ?? null,
                    'store_slug' => $item->item->store->slug ?? null,
                    'main_image_url' => $item->item_type === 'App\\Models\\Product'
                        ? ($item->item->mainImage?->url ?? $item->item->images->first()?->url)
                        : ($item->item->main_image_url),
                ]),
                'total' => $cart->total,
                'items_count' => $cart->items_count,
            ],
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'item_type' => 'required|string|in:product,service',
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $modelClass = $validated['item_type'] === 'product' ? Product::class : Service::class;
        $item = $modelClass::active()->findOrFail($validated['item_id']);

        if ($item->store->user_id === auth()->id()) {
            return response()->json(['message' => 'You cannot add your own listing to the cart.'], 422);
        }

        $price = $validated['item_type'] === 'product'
            ? $item->price
            : $item->starting_price;

        $cart = $this->getOrCreateCart();

        $existingItem = $cart->items()
            ->where('item_type', $modelClass)
            ->where('item_id', $item->id)
            ->first();

        if ($existingItem) {
            $existingItem->update([
                'quantity' => $existingItem->quantity + $validated['quantity'],
                'price' => $price,
            ]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'item_type' => $modelClass,
                'item_id' => $item->id,
                'quantity' => $validated['quantity'],
                'price' => $price,
            ]);
        }

        AuditLogger::log('cart.added', "Added {$validated['quantity']}x {$item->name} to cart", $item);

        return response()->json([
            'message' => 'Item added to cart.',
            'cart' => $cart->fresh()->load('items.item'),
        ]);
    }

    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        AuditLogger::log('cart.updated', "Updated cart item #{$cartItem->id} to quantity {$validated['quantity']}", $cartItem);

        return response()->json([
            'message' => 'Cart updated.',
            'cart' => $cartItem->cart->fresh()->load('items.item'),
        ]);
    }

    public function remove(CartItem $cartItem): JsonResponse
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $cart = $cartItem->cart;
        $cartItem->delete();

        AuditLogger::log('cart.removed', "Removed item #{$cartItem->id} from cart", $cartItem);

        return response()->json([
            'message' => 'Item removed from cart.',
            'cart' => $cart->fresh()->load('items.item'),
        ]);
    }

    public function clear(): JsonResponse
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        if ($cart) {
            $cart->items()->delete();
        }

        AuditLogger::log('cart.cleared', 'Cart cleared', $cart ?? auth()->user());

        return response()->json([
            'message' => 'Cart cleared.',
        ]);
    }
}
