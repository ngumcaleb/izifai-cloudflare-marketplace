<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user()->load('store');

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'status' => $user->status,
                'account_type' => $user->account_type,
                'location' => $user->location,
                'profile_photo_url' => $user->profile_photo_url,
                'cover_photo_url' => $user->cover_photo_url,
                'default_page' => $user->default_page,
                'email_verified' => $user->email_verified,
                'phone_verified' => $user->phone_verified,
                'verification_level' => $user->verification_level,
                'store' => $user->store ? [
                    'id' => $user->store->id,
                    'name' => $user->store->name,
                    'slug' => $user->store->slug,
                    'description' => $user->store->description,
                    'logo_url' => $user->store->logo_url,
                    'banner_url' => $user->store->banner_url,
                    'location' => $user->store->location,
                    'whatsapp_number' => $user->store->whatsapp_number,
                    'business_email' => $user->store->business_email,
                    'open_hours' => $user->store->open_hours,
                    'social_links' => $user->store->social_links,
                    'is_verified' => $user->store->is_verified,
                    'badge' => $user->store->badge,
                    'rating' => (float) ($user->store->rating ?? 0),
                ] : null,
                'created_at' => $user->created_at,
                'joined_at' => $user->joined_at,
            ],
        ]);
    }

    public function stores(): JsonResponse
    {
        $stores = Store::where('user_id', auth()->id())->get()->map(fn($s) => [
            'id' => $s->id,
            'name' => $s->name,
            'slug' => $s->slug,
            'description' => $s->description,
            'logo_url' => $s->logo_url,
            'location' => $s->location,
            'is_verified' => $s->is_verified,
            'badge' => $s->badge,
            'rating' => (float) ($s->rating ?? 0),
            'product_count' => $s->product_count ?? $s->products()->count(),
            'service_count' => $s->service_count ?? $s->services()->count(),
            'status' => $s->status,
            'created_at' => $s->created_at,
        ]);

        return response()->json(['stores' => $stores]);
    }

    public function stats(): JsonResponse
    {
        $user = auth()->user();
        $store = $user->store;

        $stats = [
            'products' => 0,
            'services' => 0,
            'orders' => 0,
            'revenue' => 0,
        ];

        if ($store) {
            $stats['products'] = Product::where('store_id', $store->id)->count();
            $stats['services'] = Service::where('store_id', $store->id)->count();
        }

        $stats['orders'] = \App\Models\Order::where('user_id', $user->id)->count();
        $stats['revenue'] = (float) \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->sum('total_amount');

        return response()->json(['stats' => $stats]);
    }

    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user->fresh()->load('store'),
        ]);
    }

    public function updatePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'message' => 'Password updated successfully.',
        ]);
    }

    public function uploadPhoto(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'photo' => ['required', 'image', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->profile_photo_path) {
            Storage::disk('r2')->delete($user->profile_photo_path);
        }

        $path = $request->file('photo')->store('profile_photos', 'r2');
        $user->update(['profile_photo_path' => $path]);

        return response()->json([
            'message' => 'Profile photo updated.',
            'profile_photo_url' => $user->profile_photo_url,
        ]);
    }

    public function uploadCover(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'cover' => ['required', 'image', 'max:5120'],
        ]);

        $user = $request->user();

        if ($user->cover_photo_path) {
            Storage::disk('r2')->delete($user->cover_photo_path);
        }

        $path = $request->file('cover')->store('cover_photos', 'r2');
        $user->update(['cover_photo_path' => $path]);

        return response()->json([
            'message' => 'Cover photo updated.',
            'cover_photo_url' => $user->cover_photo_url,
        ]);
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->store) {
            $user->store->delete();
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'message' => 'Account deleted successfully.',
        ]);
    }
}
