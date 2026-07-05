<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'addresses' => auth()->user()->shippingAddresses,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'is_default' => 'boolean',
        ]);

        if ($validated['is_default'] ?? false) {
            auth()->user()->shippingAddresses()->update(['is_default' => false]);
        }

        $address = ShippingAddress::create([
            'user_id' => auth()->id(),
            ...$validated,
        ]);

        return response()->json([
            'message' => 'Address saved.',
            'address' => $address,
        ], 201);
    }

    public function update(Request $request, ShippingAddress $address): JsonResponse
    {
        if ($address->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'is_default' => 'boolean',
        ]);

        if ($validated['is_default'] ?? false) {
            auth()->user()->shippingAddresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return response()->json([
            'message' => 'Address updated.',
            'address' => $address,
        ]);
    }

    public function setDefault(ShippingAddress $address): JsonResponse
    {
        if ($address->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        auth()->user()->shippingAddresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return response()->json(['message' => 'Default address set.']);
    }

    public function destroy(ShippingAddress $address): JsonResponse
    {
        if ($address->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $address->delete();

        return response()->json([
            'message' => 'Address deleted.',
        ]);
    }
}
