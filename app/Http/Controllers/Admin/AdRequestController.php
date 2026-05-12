<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdvertisementRequest;
use Carbon\Carbon;

class AdRequestController extends Controller
{
    public function index()
    {
        $requests = AdvertisementRequest::with(['product', 'store'])->latest()->paginate(15);
        return view('admin.ads.index', compact('requests'));
    }

    public function show(AdvertisementRequest $ad)
    {
        $ad->load(['product', 'store', 'product.images']);
        return view('admin.ads.show', compact('ad'));
    }

    public function handleAction(Request $request, AdvertisementRequest $ad)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        if ($request->action === 'approve') {
            $ad->update([
                'status' => 'approved',
                'admin_notes' => $request->admin_notes,
                'starts_at' => now(),
                'ends_at' => now()->addDays($ad->duration_days)
            ]);

            // Update the product status
            $ad->product->update([
                'is_featured' => true,
                'featured_until' => now()->addDays($ad->duration_days)
            ]);

            $message = 'Advertisement request approved.';
        } else {
            $ad->update([
                'status' => 'rejected',
                'admin_notes' => $request->admin_notes
            ]);
            $message = 'Advertisement request rejected.';
        }

        return back()->with('success', $message);
    }
}
