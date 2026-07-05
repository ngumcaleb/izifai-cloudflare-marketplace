<?php

namespace App\Http\Controllers;

use App\Helpers\AuditLogger;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart()
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        return $cart->load('items.item.store');
    }

    public function index()
    {
        $cart = $this->getCart();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'item_type' => 'required|string|in:product,service',
            'item_id' => 'required|integer',
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $modelClass = $validated['item_type'] === 'product' ? Product::class : Service::class;
        $item = $modelClass::active()->findOrFail($validated['item_id']);

        if ($item->store->user_id === auth()->id()) {
            return back()->with('error', 'You cannot add your own listing to the cart.');
        }

        $price = $validated['item_type'] === 'product' ? $item->price : $item->starting_price;

        $cart = $this->getCart();

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

        AuditLogger::log('cart.item_added', "Added {$validated['quantity']}x {$item->name} to cart", $item, null, ['quantity' => $validated['quantity'], 'item_type' => $validated['item_type']]);

        return redirect()->route('cart.index')->with('success', 'Item added to cart.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $oldQty = $cartItem->quantity;
        $cartItem->update(['quantity' => $validated['quantity']]);

        AuditLogger::log('cart.item_updated', "Updated {$cartItem->item->name} quantity: {$oldQty} → {$validated['quantity']}", $cartItem->item, ['quantity' => $oldQty], ['quantity' => $validated['quantity']]);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $itemName = $cartItem->item->name;
        $cartItem->delete();

        AuditLogger::log('cart.item_removed', "Removed {$itemName} from cart");

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        if ($cart) {
            $count = $cart->items->count();
            $cart->items()->delete();

            AuditLogger::log('cart.cleared', "Cleared cart ({$count} items)");
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
