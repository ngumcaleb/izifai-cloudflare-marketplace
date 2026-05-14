<?php

use Illuminate\Support\Facades\Route;

// === PUBLIC HOMEPAGE ===
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// === PUBLIC SHAREABLE PAGES ===
Route::get('/stores', [\App\Http\Controllers\StoreController::class, 'index'])->name('stores.index');
Route::get('/store/{slug}', [\App\Http\Controllers\StoreController::class, 'show'])->name('stores.show');
Route::get('/store/{slug}/search', [\App\Http\Controllers\StoreController::class, 'searchJson'])->name('stores.search-json');
Route::post('/store/{store}/review', [\App\Http\Controllers\StoreReviewController::class, 'store'])->name('stores.review');

Route::get('/products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [\App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('/products/autocomplete', [\App\Http\Controllers\ProductController::class, 'autocompleteJson'])->name('products.autocomplete');
Route::get('/search/autocomplete', [\App\Http\Controllers\SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::get('/products/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/log-contact', [\App\Http\Controllers\ProductController::class, 'logContact'])->name('products.log-contact');
Route::post('/products/{product}/favorite', [\App\Http\Controllers\SavedProductController::class, 'toggle'])->name('products.favorite');
Route::post('/products/{product}/report', [\App\Http\Controllers\ProductReportController::class, 'store'])->name('products.report');

// === SELLER ROUTES (middleware: auth, seller) ===
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

    Route::get('/ads', [\App\Http\Controllers\Seller\AdController::class, 'index'])->name('ads.index');
    Route::post('/ads', [\App\Http\Controllers\Seller\AdController::class, 'store'])->name('ads.store');

    Route::get('/reviews', [\App\Http\Controllers\Seller\SellerController::class, 'reviews'])->name('reviews');
});

// === ADMIN ROUTES ===
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::post('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
        
        Route::get('stores', [\App\Http\Controllers\Admin\StoreController::class, 'index'])->name('stores.index');
        Route::get('stores/{store}', [\App\Http\Controllers\Admin\StoreController::class, 'show'])->name('stores.show');
        Route::post('stores/{store}/verify', [\App\Http\Controllers\Admin\StoreController::class, 'verify'])->name('stores.verify');
        Route::post('stores/{store}/badge', [\App\Http\Controllers\Admin\StoreController::class, 'updateBadge'])->name('stores.badge');
        Route::post('stores/{store}/status', [\App\Http\Controllers\Admin\StoreController::class, 'toggleStatus'])->name('stores.status');
        Route::delete('stores/{store}', [\App\Http\Controllers\Admin\StoreController::class, 'destroy'])->name('stores.destroy');

        Route::get('products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::delete('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

        Route::get('ads', [\App\Http\Controllers\Admin\AdRequestController::class, 'index'])->name('ads.index');
        Route::get('ads/{ad}', [\App\Http\Controllers\Admin\AdRequestController::class, 'show'])->name('ads.show');
        Route::post('ads/{ad}/action', [\App\Http\Controllers\Admin\AdRequestController::class, 'handleAction'])->name('ads.action');

        Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::post('users/{user}/status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.status');
        Route::delete('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        Route::get('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('categories.update');
        Route::delete('categories/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/{type}/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'show'])->name('reports.show');
        Route::post('reports/{type}/{id}/action', [\App\Http\Controllers\Admin\ReportController::class, 'handleAction'])->name('reports.action');

        Route::get('analytics', [\App\Http\Controllers\Admin\AdminController::class, 'analytics'])->name('analytics');
        Route::get('settings', [\App\Http\Controllers\Admin\AdminController::class, 'settings'])->name('settings');
        Route::post('settings', [\App\Http\Controllers\Admin\AdminController::class, 'updateSettings'])->name('settings.update');

        Route::resource('payment-methods', \App\Http\Controllers\Admin\PaymentMethodController::class)->except(['create', 'edit', 'show']);
        Route::post('payment-methods/{paymentMethod}/toggle', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'toggle'])->name('payment-methods.toggle');
    });
});

require __DIR__ . '/auth.php';
