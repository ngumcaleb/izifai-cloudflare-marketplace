<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceBooking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $bookings = ServiceBooking::with(['service', 'package'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return response()->json([
            'bookings' => collect($bookings->items())->map(fn($b) => [
                'id' => $b->id,
                'service_name' => $b->service->name,
                'service_slug' => $b->service->slug,
                'package_name' => $b->package?->name,
                'status' => $b->status,
                'booking_date' => $b->booking_date,
                'booking_time' => $b->booking_time,
                'notes' => $b->notes,
                'created_at' => $b->created_at,
            ]),
            'pagination' => [
                'current_page' => $bookings->currentPage(),
                'last_page' => $bookings->lastPage(),
                'total' => $bookings->total(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'package_id' => 'nullable|exists:service_packages,id',
            'booking_date' => 'nullable|date',
            'booking_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($validated['service_id']);

        $booking = ServiceBooking::create([
            'service_id' => $service->id,
            'user_id' => auth()->id(),
            'package_id' => $validated['package_id'] ?? null,
            'status' => 'pending',
            'booking_date' => $validated['booking_date'] ?? null,
            'booking_time' => $validated['booking_time'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'message' => 'Booking request submitted.',
            'booking' => $booking->load('service', 'package'),
        ], 201);
    }

    public function show(ServiceBooking $booking): JsonResponse
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $booking->load(['service.store', 'package', 'user']);

        return response()->json([
            'booking' => [
                'id' => $booking->id,
                'service_id' => $booking->service_id,
                'service_name' => $booking->service->name,
                'service_slug' => $booking->service->slug,
                'store_name' => $booking->service->store?->name,
                'store_slug' => $booking->service->store?->slug,
                'package_name' => $booking->package?->name,
                'package_price' => (float) ($booking->package?->price ?? 0),
                'status' => $booking->status,
                'booking_date' => $booking->booking_date,
                'booking_time' => $booking->booking_time,
                'price' => (float) ($booking->price ?? 0),
                'notes' => $booking->notes,
                'created_at' => $booking->created_at,
                'updated_at' => $booking->updated_at,
            ],
        ]);
    }

    public function confirm(ServiceBooking $booking): JsonResponse
    {
        if ($booking->service->store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($booking->status !== 'pending') {
            return response()->json(['message' => 'Booking cannot be confirmed.'], 400);
        }

        $booking->update(['status' => 'confirmed']);

        return response()->json(['message' => 'Booking confirmed.']);
    }

    public function complete(ServiceBooking $booking): JsonResponse
    {
        if ($booking->service->store->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($booking->status !== 'confirmed') {
            return response()->json(['message' => 'Booking must be confirmed first.'], 400);
        }

        $booking->update(['status' => 'completed']);

        return response()->json(['message' => 'Booking marked as completed.']);
    }

    public function cancel(ServiceBooking $booking): JsonResponse
    {
        if ($booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Booking cancelled.',
        ]);
    }
}
