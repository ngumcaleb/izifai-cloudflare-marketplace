<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\RentalTransaction;
use Illuminate\Http\Request;

class RentalTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = RentalTransaction::with(['rentalItem', 'customer']);

        if ($request->search) {
            $query->whereHas('customer', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('rentalItem', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(20);
        return view('admin.rental-transactions.index', compact('transactions'));
    }

    public function show(RentalTransaction $rentalTransaction)
    {
        $rentalTransaction->load(['rentalItem.store', 'customer']);
        return view('admin.rental-transactions.show', compact('rentalTransaction'));
    }

    public function updateStatus(Request $request, RentalTransaction $rentalTransaction)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,active,completed,cancelled,returned'
        ]);

        $oldStatus = $rentalTransaction->status;
        $rentalTransaction->update(['status' => $request->status]);

        AuditLogger::log('rental.status_updated', "Rental #{$rentalTransaction->id}: status {$oldStatus} → {$request->status}", $rentalTransaction, ['status' => $oldStatus], ['status' => $request->status]);

        return back()->with('success', "Rental transaction status updated to {$request->status}.");
    }
}
