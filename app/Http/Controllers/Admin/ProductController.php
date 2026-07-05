<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['store', 'category', 'mainImage']);

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhereHas('store', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        if ($request->featured) {
            $query->where('is_featured', true);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->store_id) {
            $query->where('store_id', $request->store_id);
        }

        if ($request->stock_status) {
            $query->where('stock_status', $request->stock_status);
        }

        if ($request->approval_status) {
            $query->where('approval_status', $request->approval_status);
        }

        $perPage = $request->input('per_page', 20);
        $products = $query->latest()->paginate($perPage);

        $categories = Category::orderBy('name')->get();
        $stores = Store::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'stores'));
    }

    public function show(Product $product)
    {
        $product->load(['store', 'category', 'mainImage', 'images', 'reviews.user']);
        return view('admin.products.show', compact('product'));
    }

    public function approve(Product $product)
    {
        $product->update(['approval_status' => 'approved']);
        AuditLogger::log('product.approved', "Approved product #{$product->id}: {$product->name}", $product);
        return back()->with('success', 'Product approved successfully.');
    }

    public function toggleFeature(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);
        $status = $product->is_featured ? 'featured' : 'unfeatured';
        AuditLogger::log("product.{$status}", "Product #{$product->id}: {$product->name} {$status}", $product);
        return back()->with('success', "Product {$status} successfully.");
    }

    public function destroy(Product $product)
    {
        $product->delete();
        AuditLogger::log('product.deleted', "Deleted product #{$product->id}: {$product->name}");
        return back()->with('success', 'Product deleted successfully.');
    }
}
