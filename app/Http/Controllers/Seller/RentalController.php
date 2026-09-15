<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\RentalItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        $rentals = $store->rentalItems()->with(['category'])->latest()->get();

        return view('seller.rentals.index', compact('rentals'));
    }

    public function create()
    {
        $store = auth()->user()->store;
        $categories = Category::where('type', 'rental')->orWhereDoesntHave('rentalItems')->get();

        return view('seller.rentals.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'rate' => 'required|numeric|min:0',
            'billing_unit' => 'required|in:hourly,daily,weekly,monthly',
            'deposit' => 'nullable|numeric|min:0',
            'return_conditions' => 'nullable|string',
            'duration_rules' => 'nullable|string',
            'condition_notes' => 'nullable|string',
            'serial_number' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'status' => 'nullable|in:published,draft,archived',
            'images' => 'nullable|array',
            'images.*' => 'image|max:5120',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('rentals', 'r2');
                $images[] = $path;
            }
        }

        $store = auth()->user()->store;

        $rental = RentalItem::create([
            'store_id' => $store->id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'description' => $request->description,
            'rate' => $request->rate,
            'billing_unit' => $request->billing_unit,
            'deposit' => $request->deposit,
            'images' => $images,
            'return_conditions' => $request->return_conditions,
            'duration_rules' => $request->duration_rules,
            'condition_notes' => $request->condition_notes,
            'serial_number' => $request->serial_number,
            'location' => $request->location,
            'status' => $request->status ?? 'published',
        ]);

        return redirect()->route('seller.rentals.index')
            ->with('success', 'Rental item created successfully.');
    }

    public function edit($id)
    {
        $store = auth()->user()->store;
        $rental = $store->rentalItems()
            ->with(['category', 'subcategory'])
            ->findOrFail($id);

        $categories = Category::where('type', 'rental')->orWhereDoesntHave('rentalItems')->get();

        return view('seller.rentals.edit', compact('rental', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $rental = auth()->user()->store->rentalItems()->findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
            'rate' => 'sometimes|numeric|min:0',
            'billing_unit' => 'nullable|in:hourly,daily,weekly,monthly',
            'deposit' => 'nullable|numeric|min:0',
            'return_conditions' => 'nullable|string',
            'duration_rules' => 'nullable|string',
            'condition_notes' => 'nullable|string',
            'serial_number' => 'nullable|string|max:255',
            'location' => 'sometimes|string|max:255',
            'status' => 'nullable|in:published,draft,archived',
            'images' => 'nullable|array',
            'images.*' => 'image|max:5120',
        ]);

        $store = auth()->user()->store;

        $data = $request->only([
            'name', 'description', 'category_id', 'subcategory_id',
            'rate', 'billing_unit', 'deposit',
            'return_conditions', 'duration_rules', 'condition_notes',
            'serial_number', 'location', 'status',
        ]);

        if ($request->hasFile('images')) {
            $data['images'] = [];
            foreach ($request->file('images') as $file) {
                $path = $file->store('rentals', 'r2');
                $data['images'][] = $path;
            }
        }

        $rental->update($data);

        return redirect()->route('seller.rentals.index')
            ->with('success', 'Rental item updated successfully.');
    }

    public function destroy($id)
    {
        $rental = auth()->user()->store->rentalItems()->findOrFail($id);

        if ($rental->images) {
            foreach ($rental->images as $path) {
                Storage::disk('r2')->delete($path);
            }
        }

        $rental->delete();

        return redirect()->route('seller.rentals.index')
            ->with('success', 'Rental item deleted successfully.');
    }
}
