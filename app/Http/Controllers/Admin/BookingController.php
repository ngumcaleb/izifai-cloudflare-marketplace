<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\Service;
use App\Models\Store;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceBooking::with(['service', 'user', 'package']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->whereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('service', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->service_id) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->store_id) {
            $query->whereHas('service', function($q) use ($request) {
                $q->where('store_id', $request->store_id);
            });
        }

        if ($request->date_from) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 20);
        $bookings = $query->latest()->paginate($perPage);

        $services = Service::orderBy('name')->get();
        $stores = Store::orderBy('name')->get();

        return view('admin.bookings.index', compact('bookings', 'services', 'stores'));
    }

    public function show(ServiceBooking $booking)
    {
        $booking->load(['service.store', 'user', 'package']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, ServiceBooking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);

        AuditLogger::log('booking.status_updated', "Booking #{$booking->id}: status {$oldStatus} → {$request->status}", $booking, ['status' => $oldStatus], ['status' => $request->status]);

        return back()->with('success', "Booking status updated to {$request->status}.");
    }
}
