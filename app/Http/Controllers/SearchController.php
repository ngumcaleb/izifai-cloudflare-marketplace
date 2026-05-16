<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Store;
use App\Models\Product;
use App\Models\User;


class SearchController extends Controller
{
    public function trending()
    {
        $categories = Category::whereHas('products', fn($q) => $q->active())
            ->withCount(['products' => fn($q) => $q->active()])
            ->orderByDesc('products_count')
            ->take(8)
            ->get()
            ->map(fn($cat) => [
                'id'   => $cat->id,
                'name' => $cat->name,
                'url'  => route('products.index', ['category' => $cat->slug]),
            ]);

        return response()->json($categories);
    }

    public function autocomplete(Request $request)
    {
        $q = $request->query('q');
        if (!$q || strlen($q) < 2) {
            return response()->json(['products' => [], 'stores' => [], 'categories' => [], 'locations' => [], 'users' => []]);
        }

        $keywords = array_filter(explode(' ', $q));

        // 1. Categories with active products (max 3)
        $categories = Category::whereHas('products', fn($q) => $q->active());
        foreach ($keywords as $word) {
            $categories->where('name', 'LIKE', "%{$word}%");
        }
        $categoryResults = $categories->take(3)->get()->map(fn($cat) => [
            'id'   => $cat->id,
            'name' => $cat->name,
            'slug' => $cat->slug,
            'url'  => route('products.index', ['category' => $cat->slug]),
        ]);

        // 2. Stores (max 3)
        $stores = Store::query();
        foreach ($keywords as $word) {
            $stores->where(function($q) use ($word) {
                $q->where('name', 'LIKE', "%{$word}%")
                  ->orWhere('location', 'LIKE', "%{$word}%");
            });
        }
        $storeResults = $stores->take(3)->get()->map(fn($store) => [
            'id'         => $store->id,
            'name'       => $store->name,
            'slug'       => $store->slug,
            'logo'       => $store->logo,
            'logo_url'   => $store->logo_url,
            'is_verified' => $store->is_verified,
            'url'        => route('stores.show', $store->slug),
        ]);

        // 3. Products (max 6)
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

        // 4. Locations (max 4) — unique locations from matching stores
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

        // 5. Users (max 3) — merchants and customers by name
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
            'stores'     => $storeResults,
            'categories' => $categoryResults,
            'locations'  => $locationResults,
            'users'      => $userResults,
        ]);
    }
}
