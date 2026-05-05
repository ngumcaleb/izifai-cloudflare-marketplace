<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SavedProduct;
use Illuminate\Http\Request;

class SavedProductController extends Controller
{
    public function index()
    {
        $products = Product::whereHas('savedUsers', function($q) {
            $q->where('user_id', auth()->id());
        })->with(['images', 'store', 'savedUsers'])->paginate(20);
        
        return view('favorites.index', compact('products'));
    }

    public function toggle(Product $product)
    {
        $user = auth()->user();
        $exists = SavedProduct::where('user_id', $user->id)
                             ->where('product_id', $product->id)
                             ->first();

        if ($exists) {
            $exists->delete();
            $favorited = false;
        } else {
            SavedProduct::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $favorited = true;
        }

        return response()->json([
            'favorited' => $favorited,
            'count' => $product->savedUsers()->count(),
        ]);
    }
}
