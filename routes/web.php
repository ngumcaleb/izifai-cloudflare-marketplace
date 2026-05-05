<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'seller') {
        return redirect()->route('seller.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/products/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/new-arrivals', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.new-arrivals');
Route::get('/local-sourcing', [\App\Http\Controllers\ProductController::class, 'localSourcing'])->name('products.local-sourcing');
Route::get('/search', [\App\Http\Controllers\ProductController::class, 'search'])->name('search');
Route::get('/search/autocomplete', [\App\Http\Controllers\ProductController::class, 'autocomplete'])->name('search.autocomplete');

Route::get('/stores', [\App\Http\Controllers\StoreController::class, 'index'])->name('stores.index');
Route::get('/store/{slug}', [\App\Http\Controllers\StoreController::class, 'show'])->name('stores.show');
Route::post('/store/{store}/review', [\App\Http\Controllers\StoreReviewController::class, 'store'])->name('stores.review')->middleware('auth');

Route::get('/help', function () {
    return view('help');
})->name('help');

Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');

Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Seller\SellerController::class, 'dashboard'])->name('dashboard');
    Route::get('/store', [\App\Http\Controllers\Seller\SellerController::class, 'storeSettings'])->name('store.settings');
    Route::put('/store', [\App\Http\Controllers\Seller\SellerController::class, 'updateStoreSettings'])->name('store.update');

    Route::get('/products', [\App\Http\Controllers\Seller\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [\App\Http\Controllers\Seller\ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [\App\Http\Controllers\Seller\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [\App\Http\Controllers\Seller\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [\App\Http\Controllers\Seller\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [\App\Http\Controllers\Seller\ProductController::class, 'destroy'])->name('products.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/favorites', [\App\Http\Controllers\SavedProductController::class, 'index'])->name('favorites.index');
    Route::post('/products/{product}/favorite', [\App\Http\Controllers\SavedProductController::class, 'toggle'])->name('products.toggle-favorite');
});

require __DIR__ . '/auth.php';
