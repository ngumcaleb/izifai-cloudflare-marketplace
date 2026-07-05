<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentalItem;
use App\Models\Category;
use App\Models\Store;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = RentalItem::with(['store', 'category']);

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

        if ($request->billing_unit) {
            $query->where('billing_unit', $request->billing_unit);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 20);
        $rentals = $query->latest()->paginate($perPage);

        $categories = Category::orderBy('name')->get();
        $stores = Store::orderBy('name')->get();

        return view('admin.rentals.index', compact('rentals', 'categories', 'stores'));
    }

    public function show(RentalItem $rentalItem)
    {
        $rentalItem->load(['store', 'category', 'transactions.user' => function($q) {
            $q->with('customer');
        }]);
        return view('admin.rentals.show', compact('rentalItem'));
    }

    public function destroy(RentalItem $rentalItem)
    {
        $rentalItem->delete();
        return back()->with('success', 'Rental item deleted successfully.');
    }
}
