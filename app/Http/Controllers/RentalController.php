<?php

namespace App\Http\Controllers;

use App\Models\RentalItem;
use App\Models\Category;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = RentalItem::with(['store', 'category', 'subcategory'])
            ->where('status', 'published');

        if ($request->filled('q')) {
            $q = $request->q;
            $keywords = array_filter(explode(' ', $q));
            $query->where(function ($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', fn($c) => $c->where('name', 'LIKE', "%{$word}%"))
                        ->orWhereHas('store', fn($s) => $s->where('name', 'LIKE', "%{$word}%"));
                }
            });
            $title = "Search: " . $q;
            $description = "Search results for \"" . $q . "\" — Browse rental items from verified sellers.";
        } else {
            $title = "Rental Marketplace";
            $description = "Browse rental items from verified sellers in Cameroon — equipment, vehicles, tools and more.";
        }

        if ($request->filled('store')) {
            $query->whereHas('store', fn($q) => $q->where('slug', $request->store));
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('min_price')) {
            $query->where('rate', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('rate', '<=', (int) $request->max_price);
        }

        if ($request->filled('billing_unit')) {
            $query->where('billing_unit', $request->billing_unit);
        }

        if ($request->filled('location')) {
            $query->where('location', 'LIKE', "%{$request->location}%");
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_low' => $query->orderBy('rate', 'asc'),
            'price_high' => $query->orderBy('rate', 'desc'),
            'popular' => $query->orderBy('views', 'desc'),
            default => $query->latest(),
        };

        $rentals = $query->paginate(24)->withQueryString();

        $categoryIds = RentalItem::where('status', 'published')
            ->whereNotNull('category_id')
            ->distinct()
            ->pluck('category_id');
        $categories = Category::whereIn('id', $categoryIds)->get();

        $featuredRentals = RentalItem::where('status', 'published')
            ->with(['store', 'category'])
            ->inRandomOrder()
            ->take(8)
            ->get();

        $topStores = \App\Models\Store::where('status', 'active')
            ->withCount(['rentalItems' => fn($q) => $q->where('status', 'published')])
            ->having('rental_items_count', '>', 0)
            ->orderBy('is_verified', 'desc')
            ->orderBy('rental_items_count', 'desc')
            ->take(4)
            ->get();

        return view('rentals.index', compact(
            'rentals', 'title', 'description',
            'categories', 'featuredRentals', 'topStores'
        ));
    }

    public function show($slug)
    {
        $rental = RentalItem::where('slug', $slug)
            ->where('status', 'published')
            ->with(['store', 'category', 'subcategory'])
            ->firstOrFail();

        $rental->increment('views');

        $store = $rental->store;
        $storeRentals = $store->rentalItems()
            ->where('id', '!=', $rental->id)
            ->where('status', 'published')
            ->with(['store', 'category'])
            ->latest()
            ->take(12)
            ->get();

        $totalRentals = $store->rentalItems()->where('status', 'published')->count();

        return view('rentals.show', compact(
            'rental', 'store', 'storeRentals', 'totalRentals'
        ));
    }
}
