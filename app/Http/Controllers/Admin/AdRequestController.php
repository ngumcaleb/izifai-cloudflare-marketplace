<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdvertisementRequest;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AdRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = AdvertisementRequest::with(['promotable', 'store']);

        if ($request->status === 'pending') {
            $query->where('status', 'pending');
        } elseif ($request->status === 'approved') {
            $query->where('status', 'approved');
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhereHas('store', fn($q) => $q->where('name', 'like', '%' . $search . '%'));
            });
        }

        if ($request->store_id) {
            $query->where('store_id', $request->store_id);
        }

        if ($request->promotable_type) {
            $query->where('promotable_type', $request->promotable_type);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $perPage = $request->input('per_page', 15);
        $requests = $query->latest()->paginate($perPage);

        $stores = Store::orderBy('name')->get();

        return view('admin.ads.index', compact('requests', 'stores'));
    }

    public function show(AdvertisementRequest $ad)
    {
        $ad->load(['promotable', 'store']);
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
                'approved_at' => now(),
                'starts_at' => now(),
                'ends_at' => now()->addDays($ad->days),
            ]);

            // Mark the promotable item as featured
            if ($ad->promotable && method_exists($ad->promotable, 'update')) {
                $ad->promotable->update([
                    'is_featured' => true,
                    'featured_until' => now()->addDays($ad->days),
                ]);
            }

            AuditLogger::log('ad.approved', "Approved ad request #{$ad->id}: {$ad->title}", $ad);
            $message = 'Advertisement request approved.';
        } else {
            $ad->update([
                'status' => 'rejected',
                'admin_notes' => $request->admin_notes,
                'rejected_at' => now(),
            ]);
            AuditLogger::log('ad.rejected', "Rejected ad request #{$ad->id}: {$ad->title}", $ad);
            $message = 'Advertisement request rejected.';
        }

        return back()->with('success', $message);
    }

    public function destroy(AdvertisementRequest $ad)
    {
        if ($ad->image) {
            Storage::disk('r2')->delete($ad->image);
        }

        if ($ad->status === 'approved' && $ad->promotable && method_exists($ad->promotable, 'update')) {
            $ad->promotable->update([
                'is_featured' => false,
                'featured_until' => null,
            ]);
        }

        $ad->delete();
        AuditLogger::log('ad.deleted', "Deleted ad request #{$ad->id}: {$ad->title}");
        return redirect()->route('admin.ads.index')->with('success', 'Ad request deleted successfully.');
    }
}
