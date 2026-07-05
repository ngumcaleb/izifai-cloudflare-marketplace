<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Category;
use App\Models\Store;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with(['store', 'category', 'mainImage']);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('store', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->store_id) {
            $query->where('store_id', $request->store_id);
        }

        if ($request->is_featured !== null && $request->is_featured !== '') {
            $query->where('is_featured', $request->is_featured);
        }

        if ($request->status) {
            switch ($request->status) {
                case 'pending':
                    $query->where('approval_status', 'pending');
                    break;
                case 'approved':
                    $query->where('approval_status', 'approved');
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
            }
        }

        $perPage = $request->input('per_page', 20);
        $services = $query->latest()->paginate($perPage);

        $categories = Category::orderBy('name')->get();
        $stores = Store::orderBy('name')->get();

        return view('admin.services.index', compact('services', 'categories', 'stores'));
    }

    public function show(Service $service)
    {
        $service->load(['store', 'category', 'mainImage', 'images', 'packages', 'bookings.user']);
        return view('admin.services.show', compact('service'));
    }

    public function approve(Service $service)
    {
        $service->update(['approval_status' => 'approved']);
        AuditLogger::log('service.approved', "Approved service #{$service->id}: {$service->name}", $service);
        return back()->with('success', 'Service approved successfully.');
    }

    public function toggleFeature(Service $service)
    {
        $service->update(['is_featured' => !$service->is_featured]);
        $status = $service->is_featured ? 'featured' : 'unfeatured';
        AuditLogger::log("service.{$status}", "Service #{$service->id}: {$service->name} {$status}", $service);
        return back()->with('success', "Service {$status} successfully.");
    }

    public function destroy(Service $service)
    {
        $service->delete();
        AuditLogger::log('service.deleted', "Deleted service #{$service->id}: {$service->name}");
        return back()->with('success', 'Service deleted successfully.');
    }
}
