<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Store;
use App\Models\Product;
use App\Models\Service;
use App\Models\RentalItem;
use App\Models\User;


class SearchController extends Controller
{
    public function trending(Request $request)
    {
        $scope = $request->query('scope', 'products');

        $route = match ($scope) {
            'services' => 'services.index',
            'rentals'  => 'rentals.index',
            default    => 'products.index',
        };

        $categories = Category::whereHas($scope === 'services' ? 'services' : ($scope === 'rentals' ? 'rentalItems' : 'products'),
            fn($q) => $scope === 'rentals' ? $q : $q->active()
        )
            ->withCount([$scope === 'services' ? 'services' : ($scope === 'rentals' ? 'rentalItems' : 'products')
                => fn($q) => $scope === 'rentals' ? $q : $q->active()
            ])
            ->orderByDesc($scope === 'services' ? 'services_count' : ($scope === 'rentals' ? 'rental_items_count' : 'products_count'))
            ->take(8)
            ->get()
            ->map(fn($cat) => [
                'id'   => $cat->id,
                'name' => $cat->name,
                'url'  => route($route, ['category' => $cat->slug]),
            ]);

        return response()->json($categories);
    }

    public function autocomplete(Request $request)
    {
        $q = $request->query('q');
        $scope = $request->query('scope', 'products');

        if (!$q || strlen($q) < 2) {
            return response()->json(array_merge(
                ['products' => [], 'services' => [], 'rentals' => []],
                ['stores' => [], 'categories' => [], 'locations' => [], 'users' => []]
            ));
        }

        $keywords = array_filter(explode(' ', $q));

        $route = match ($scope) {
            'services' => 'services.index',
            'rentals'  => 'rentals.index',
            default    => 'products.index',
        };

        $scopeRelation = match ($scope) {
            'services' => 'services',
            'rentals'  => 'rentalItems',
            default    => 'products',
        };

        $scopeActive = $scope === 'rentals'
            ? fn($q) => $q->where('status', 'published')
            : fn($q) => $q->active();

        // 1. Categories scoped to current tab
        $categories = Category::whereHas($scopeRelation, $scopeActive);
        foreach ($keywords as $word) {
            $categories->where('name', 'LIKE', "%{$word}%");
        }
        $categoryResults = $categories->take(3)->get()->map(fn($cat) => [
            'id'   => $cat->id,
            'name' => $cat->name,
            'slug' => $cat->slug,
            'url'  => route($route, ['category' => $cat->slug]),
        ]);

        // 2. Stores (max 3) — shared across all scopes
        $stores = Store::query();
        foreach ($keywords as $word) {
            $stores->where(function($q) use ($word) {
                $q->where('name', 'LIKE', "%{$word}%")
                  ->orWhere('location', 'LIKE', "%{$word}%");
            });
        }
        $storeResults = $stores->take(3)->get()->map(fn($store) => [
            'id'          => $store->id,
            'name'        => $store->name,
            'slug'        => $store->slug,
            'logo'        => $store->logo,
            'logo_url'    => $store->logo_url,
            'is_verified' => $store->is_verified,
            'url'         => route('stores.show', $store->slug),
        ]);

        // 3. Primary results based on scope
        $productResults = [];
        $serviceResults = [];
        $rentalResults = [];

        if ($scope === 'services') {
            $services = Service::active()->with(['images', 'store', 'category']);
            $services->where(function($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', fn($cat) => $cat->where('name', 'LIKE', "%{$word}%"))
                        ->orWhereHas('store', fn($s) => $s->where('name', 'LIKE', "%{$word}%"));
                }
            });
            $serviceResults = $services->orderByDesc('views')->take(6)->get()->map(fn($s) => [
                'id'             => $s->id,
                'name'           => $s->name,
                'slug'           => $s->slug,
                'price'          => $s->starting_price,
                'image'          => $s->main_image_url,
                'category'       => $s->category?->name,
                'store'          => $s->store?->name,
                'delivery_time'  => $s->delivery_time,
                'url'            => route('services.show', $s->slug),
            ]);
        } elseif ($scope === 'rentals') {
            $rentals = RentalItem::with(['store', 'category'])
                ->where('status', 'published');
            $rentals->where(function($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', fn($cat) => $cat->where('name', 'LIKE', "%{$word}%"))
                        ->orWhereHas('store', fn($s) => $s->where('name', 'LIKE', "%{$word}%"));
                }
            });
            $rentalResults = $rentals->orderByDesc('views')->take(6)->get()->map(fn($r) => [
                'id'           => $r->id,
                'name'         => $r->name,
                'slug'         => $r->slug,
                'rate'         => $r->rate,
                'billing_unit' => $r->billing_unit,
                'image'        => $r->main_image_url,
                'category'     => $r->category?->name,
                'store'        => $r->store?->name,
                'location'     => $r->location,
                'url'          => route('rentals.show', $r->slug),
            ]);
        } else {
            // Products (default scope)
            $products = Product::active()->with(['category', 'images', 'store']);
            $products->where(function($sub) use ($keywords) {
                foreach ($keywords as $word) {
                    $sub->orWhere('name', 'LIKE', "%{$word}%")
                        ->orWhere('description', 'LIKE', "%{$word}%")
                        ->orWhereHas('category', fn($cat) => $cat->where('name', 'LIKE', "%{$word}%"))
                        ->orWhereHas('store', fn($store) => $store->where('name', 'LIKE', "%{$word}%"));
                }
            });
            $productResults = $products->orderByDesc('views')->take(6)->get()->map(fn($p) => [
                'id'        => $p->id,
                'name'      => $p->name,
                'slug'      => $p->slug,
                'price'     => $p->price,
                'old_price' => $p->old_price,
                'image'     => $p->images->first()?->path,
                'category'  => $p->category?->name,
                'store'     => $p->store?->name,
                'url'       => route('products.show', $p->slug),
            ]);
        }

        // 4. Locations (max 4)
        $locationResults = collect();
        if ($keywords) {
            $locQuery = Store::whereNotNull('location')
                ->where('location', '!=', '');
            foreach ($keywords as $word) {
                $locQuery->where('location', 'LIKE', "%{$word}%");
            }
            $locationResults = $locQuery->distinct()->limit(4)->pluck('location')
                ->map(fn($loc) => ['name' => $loc, 'type' => 'location']);
        }

        // 5. Users (max 3)
        $users = User::query();
        foreach ($keywords as $word) {
            $users->where(function($q) use ($word) {
                $q->where('name', 'LIKE', "%{$word}%");
            });
        }
        $userResults = $users->take(3)->get()->map(fn($user) => [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'store' => $user->store?->name,
            'url'   => $user->store ? route('stores.show', $user->store->slug) : null,
        ]);

        return response()->json([
            'products'   => $productResults,
            'services'   => $serviceResults,
            'rentals'    => $rentalResults,
            'stores'     => $storeResults,
            'categories' => $categoryResults,
            'locations'  => $locationResults,
            'users'      => $userResults,
        ]);
    }
}
