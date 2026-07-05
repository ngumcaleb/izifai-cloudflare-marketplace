<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::active()->with(['images', 'store', 'category', 'packages']);

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
            $description = "Search results for \"" . $q . "\" — Browse services from verified sellers.";
        } else {
            $title = "Professional Services";
            $description = "Browse professional services from verified sellers in Cameroon.";
        }

        if ($request->filled('store')) {
            $query->whereHas('store', fn($q) => $q->where('slug', $request->store));
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('min_price')) {
            $query->where('starting_price', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('starting_price', '<=', (int) $request->max_price);
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_low' => $query->orderBy('starting_price', 'asc'),
            'price_high' => $query->orderBy('starting_price', 'desc'),
            'popular' => $query->orderBy('views', 'desc'),
            default => $query->latest(),
        };

        $services = $query->paginate(24)->withQueryString();

        $categories = Category::whereHas('services', function ($q) {
            $q->whereHas('store', fn($s) => $s->where('status', 'active'));
        })->get();

        $featuredServices = Service::active()
            ->with(['images', 'store'])
            ->inRandomOrder()
            ->take(8)
            ->get();

        $topStores = \App\Models\Store::where('status', 'active')
            ->withCount(['services' => fn($q) => $q->active()])
            ->having('services_count', '>', 0)
            ->orderBy('is_verified', 'desc')
            ->orderBy('services_count', 'desc')
            ->take(4)
            ->get();

        return view('services.index', compact(
            'services', 'title', 'description',
            'categories', 'featuredServices', 'topStores'
        ));
    }

    public function show($slug)
    {
        $service = Service::active()
            ->where('slug', $slug)
            ->with(['images', 'store', 'category', 'packages'])
            ->firstOrFail();

        $service->increment('views');

        $reviews = $service->reviews()->with('user')->latest()->get();
        $avgRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;
        $totalReviews = $reviews->count();

        $store = $service->store;
        $totalServices = $store->services()->count();

        $storeServices = $store->services()
            ->where('id', '!=', $service->id)
            ->with(['images', 'packages'])
            ->latest()
            ->take(12)
            ->get();

        $starDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviews->where('rating', $i)->count();
            $starDistribution[$i] = [
                'count' => $count,
                'percentage' => $reviews->count() > 0 ? ($count / $reviews->count()) * 100 : 0,
            ];
        }

        return view('services.show', compact(
            'service', 'store', 'reviews', 'avgRating', 'totalReviews',
            'totalServices', 'storeServices', 'starDistribution'
        ));
    }
}
