<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\ProductReport;
use App\Models\StoreReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $productQuery = ProductReport::with(['product', 'user']);
        $storeQuery = StoreReport::with(['store', 'user']);

        if ($request->search) {
            $productQuery->where(function($q) use ($request) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                  ->orWhereHas('product', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                  ->orWhere('reason', 'like', '%' . $request->search . '%')
                  ->orWhere('details', 'like', '%' . $request->search . '%');
            });
            $storeQuery->where(function($q) use ($request) {
                $q->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                  ->orWhereHas('store', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                  ->orWhere('reason', 'like', '%' . $request->search . '%')
                  ->orWhere('details', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->reason) {
            $productQuery->where('reason', $request->reason);
            $storeQuery->where('reason', $request->reason);
        }

        if ($request->date_from) {
            $productQuery->whereDate('created_at', '>=', $request->date_from);
            $storeQuery->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $productQuery->whereDate('created_at', '<=', $request->date_to);
            $storeQuery->whereDate('created_at', '<=', $request->date_to);
        }

        $productReports = $productQuery->latest()->paginate($perPage, ['*'], 'product_page');
        $storeReports = $storeQuery->latest()->paginate($perPage, ['*'], 'store_page');

        $reasons = ProductReport::distinct()->pluck('reason')->merge(
            StoreReport::distinct()->pluck('reason')
        )->unique()->sort()->values();

        return view('admin.reports.index', compact('productReports', 'storeReports', 'reasons'));
    }

    public function show($type, $id)
    {
        if ($type === 'product') {
            $report = ProductReport::with(['product.store', 'user'])->findOrFail($id);
            return view('admin.reports.show', compact('report', 'type'));
        } else {
            $report = StoreReport::with(['store.user', 'user'])->findOrFail($id);
            return view('admin.reports.show', compact('report', 'type'));
        }
    }

    public function handleAction(Request $request, $type, $id)
    {
        $request->validate([
            'action' => 'required|in:resolve,dismiss,delete'
        ]);

        if ($type === 'product') {
            $report = ProductReport::findOrFail($id);
            if ($request->action === 'delete') {
                $report->product->delete();
            }
        } else {
            $report = StoreReport::findOrFail($id);
            if ($request->action === 'delete') {
                $report->store->delete();
            }
        }

        if ($request->action !== 'delete') {
            $report->delete();
        } else {
             $report->delete();
        }

        AuditLogger::log("report.{$request->action}", "Report #{$report->id} ({$type}) {$request->action}d");

        return redirect()->route('admin.reports.index')->with('success', 'Action processed successfully.');
    }
}
