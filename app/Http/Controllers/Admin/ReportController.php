<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReport;
use App\Models\StoreReport;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $productReports = ProductReport::with(['product', 'user'])->latest()->paginate(10, ['*'], 'product_page');
        $storeReports = StoreReport::with(['store', 'user'])->latest()->paginate(10, ['*'], 'store_page');

        return view('admin.reports.index', compact('productReports', 'storeReports'));
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
            // Logic for resolve/dismiss could be added here if there's a status column
            // For now we just delete the report itself if resolved
            $report->delete();
        } else {
             $report->delete();
        }

        return redirect()->route('admin.reports.index')->with('success', 'Action processed successfully.');
    }
}
