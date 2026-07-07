<?php

use Illuminate\Support\Facades\Route;

// === SITEMAP ===
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index']);

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
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'search'])->name('search');
Route::get('/search/autocomplete', [\App\Http\Controllers\SearchController::class, 'autocomplete'])->name('search.autocomplete');
Route::get('/search/trending', [\App\Http\Controllers\SearchController::class, 'trending'])->name('search.trending');
Route::get('/products/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');

// === SERVICES ===
Route::get('/services', [\App\Http\Controllers\ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [\App\Http\Controllers\ServiceController::class, 'show'])->name('services.show');
Route::post('/products/{product}/log-contact', [\App\Http\Controllers\ProductController::class, 'logContact'])->name('products.log-contact');
Route::post('/products/{product}/favorite', [\App\Http\Controllers\SavedProductController::class, 'toggle'])->name('products.favorite');
Route::post('/products/{product}/report', [\App\Http\Controllers\ProductReportController::class, 'store'])->name('products.report');

// === RENTALS ===
Route::get('/rentals', [\App\Http\Controllers\RentalController::class, 'index'])->name('rentals.index');
Route::get('/rentals/{slug}', [\App\Http\Controllers\RentalController::class, 'show'])->name('rentals.show');

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

    Route::get('/services', [\App\Http\Controllers\Seller\ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/create', [\App\Http\Controllers\Seller\ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [\App\Http\Controllers\Seller\ServiceController::class, 'store'])->name('services.store');
    Route::get('/services/{id}/edit', [\App\Http\Controllers\Seller\ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/services/{id}', [\App\Http\Controllers\Seller\ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{id}', [\App\Http\Controllers\Seller\ServiceController::class, 'destroy'])->name('services.destroy');

    Route::get('/rentals', [\App\Http\Controllers\Seller\RentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/create', [\App\Http\Controllers\Seller\RentalController::class, 'create'])->name('rentals.create');
    Route::post('/rentals', [\App\Http\Controllers\Seller\RentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{id}/edit', [\App\Http\Controllers\Seller\RentalController::class, 'edit'])->name('rentals.edit');
    Route::put('/rentals/{id}', [\App\Http\Controllers\Seller\RentalController::class, 'update'])->name('rentals.update');
    Route::delete('/rentals/{id}', [\App\Http\Controllers\Seller\RentalController::class, 'destroy'])->name('rentals.destroy');

    Route::get('/store-categories', [\App\Http\Controllers\Seller\StoreCategoryController::class, 'index'])->name('store-categories.index');
    Route::get('/store-categories/create', [\App\Http\Controllers\Seller\StoreCategoryController::class, 'create'])->name('store-categories.create');
    Route::post('/store-categories', [\App\Http\Controllers\Seller\StoreCategoryController::class, 'store'])->name('store-categories.store');
    Route::get('/store-categories/{id}/edit', [\App\Http\Controllers\Seller\StoreCategoryController::class, 'edit'])->name('store-categories.edit');
    Route::put('/store-categories/{id}', [\App\Http\Controllers\Seller\StoreCategoryController::class, 'update'])->name('store-categories.update');
    Route::delete('/store-categories/{id}', [\App\Http\Controllers\Seller\StoreCategoryController::class, 'destroy'])->name('store-categories.destroy');

    Route::get('/ads', [\App\Http\Controllers\Seller\AdController::class, 'index'])->name('ads.index');
    Route::post('/ads', [\App\Http\Controllers\Seller\AdController::class, 'store'])->name('ads.store');
    Route::get('/ads/{id}', [\App\Http\Controllers\Seller\AdController::class, 'show'])->name('ads.show');
    Route::get('/ads/{id}/check-payment', [\App\Http\Controllers\Seller\AdController::class, 'checkPayment'])->name('ads.check-payment');

    Route::get('/reviews', [\App\Http\Controllers\Seller\SellerController::class, 'reviews'])->name('reviews');

    Route::get('/wallet', [\App\Http\Controllers\Seller\WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/transactions', [\App\Http\Controllers\Seller\WalletController::class, 'transactions'])->name('wallet.transactions');
    Route::get('/wallet/deposit', [\App\Http\Controllers\Seller\WalletController::class, 'depositForm'])->name('wallet.deposit');
    Route::post('/wallet/deposit', [\App\Http\Controllers\Seller\WalletController::class, 'deposit'])->name('wallet.deposit.store');
    Route::get('/wallet/withdraw', [\App\Http\Controllers\Seller\WalletController::class, 'withdrawForm'])->name('wallet.withdraw');
    Route::post('/wallet/withdraw', [\App\Http\Controllers\Seller\WalletController::class, 'withdraw'])->name('wallet.withdraw.store');

    Route::get('/orders', [\App\Http\Controllers\Seller\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [\App\Http\Controllers\Seller\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/ship', [\App\Http\Controllers\Seller\OrderController::class, 'markShipped'])->name('orders.ship');

    Route::get('/store/create', [\App\Http\Controllers\Seller\SellerController::class, 'createStore'])->name('store.create');
    Route::post('/store', [\App\Http\Controllers\Seller\SellerController::class, 'storeStore'])->name('store.store');

});

// === FAPSHI WEBHOOK ===
Route::post('/webhooks/fapshi', function (\Illuminate\Http\Request $request) {
    $service = new \App\Services\FapshiService;
    $data = $service->handleWebhook($request->all());

    if ($data['status'] !== 'success') {
        return response('OK');
    }

    $transId = $data['transaction_id'];

    $transaction = \App\Models\Transaction::where('reference', $transId)->first();

    if ($transaction && $transaction->status !== 'completed') {
        $order = $transaction->order;

        if ($order && $order->status === 'pending') {
            $order->update([
                'status' => 'confirmed',
                'confirmed_at' => now(),
                'escrow_status' => 'held',
            ]);

            $transaction->update([
                'status' => 'completed',
                'escrow_held_at' => now(),
            ]);

            foreach ($order->items as $item) {
                $sellerWallet = $item->store?->user?->wallet;
                if (!$sellerWallet) continue;

                $itemTotal = $item->price * $item->quantity;

                $sellerWallet->increment('locked_balance', $itemTotal);

                \App\Models\WalletTransaction::create([
                    'wallet_id' => $sellerWallet->id,
                    'type' => 'escrow_hold',
                    'amount' => $itemTotal,
                    'balance_before' => $sellerWallet->balance,
                    'balance_after' => $sellerWallet->balance,
                    'description' => "Payment locked in escrow for Order #{$order->order_number}",
                    'reference' => "HOLD-{$order->id}-{$item->id}",
                    'status' => 'completed',
                    'order_id' => $order->id,
                    'buyer_name' => $order->user->name,
                ]);
            }

            \App\Helpers\AuditLogger::log('order.confirmed', "Payment confirmed for order #{$order->order_number} via Fapshi", $order);
        }

        return response('OK');
    }

    $ad = \App\Models\AdvertisementRequest::where('payment_reference', $transId)->first();
    if ($ad && $ad->payment_status !== 'paid') {
        $ad->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    return response('OK');
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
        Route::post('stores/{store}/images', [\App\Http\Controllers\Admin\StoreController::class, 'updateImages'])->name('stores.images');
        Route::post('stores/{store}/status', [\App\Http\Controllers\Admin\StoreController::class, 'toggleStatus'])->name('stores.status');
        Route::delete('stores/{store}', [\App\Http\Controllers\Admin\StoreController::class, 'destroy'])->name('stores.destroy');

        Route::get('products', [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
        Route::get('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'show'])->name('products.show');
        Route::post('products/{product}/approve', [\App\Http\Controllers\Admin\ProductController::class, 'approve'])->name('products.approve');
        Route::post('products/{product}/feature', [\App\Http\Controllers\Admin\ProductController::class, 'toggleFeature'])->name('products.feature');
        Route::delete('products/{product}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

        Route::get('services', [\App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('services.index');
        Route::get('services/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'show'])->name('services.show');
        Route::post('services/{service}/approve', [\App\Http\Controllers\Admin\ServiceController::class, 'approve'])->name('services.approve');
        Route::post('services/{service}/feature', [\App\Http\Controllers\Admin\ServiceController::class, 'toggleFeature'])->name('services.feature');
        Route::delete('services/{service}', [\App\Http\Controllers\Admin\ServiceController::class, 'destroy'])->name('services.destroy');

        Route::get('rentals', [\App\Http\Controllers\Admin\RentalController::class, 'index'])->name('rentals.index');
        Route::get('rentals/{rentalItem}', [\App\Http\Controllers\Admin\RentalController::class, 'show'])->name('rentals.show');
        Route::delete('rentals/{rentalItem}', [\App\Http\Controllers\Admin\RentalController::class, 'destroy'])->name('rentals.destroy');

        Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.status');

        Route::get('bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [\App\Http\Controllers\Admin\BookingController::class, 'show'])->name('bookings.show');
        Route::post('bookings/{booking}/status', [\App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.status');

        Route::get('rental-transactions', [\App\Http\Controllers\Admin\RentalTransactionController::class, 'index'])->name('rental-transactions.index');
        Route::get('rental-transactions/{rentalTransaction}', [\App\Http\Controllers\Admin\RentalTransactionController::class, 'show'])->name('rental-transactions.show');
        Route::post('rental-transactions/{rentalTransaction}/status', [\App\Http\Controllers\Admin\RentalTransactionController::class, 'updateStatus'])->name('rental-transactions.status');

        Route::get('withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::get('withdrawals/{withdrawal}', [\App\Http\Controllers\Admin\WithdrawalController::class, 'show'])->name('withdrawals.show');
        Route::post('withdrawals/{withdrawal}/approve', [\App\Http\Controllers\Admin\WithdrawalController::class, 'approve'])->name('withdrawals.approve');
        Route::post('withdrawals/{withdrawal}/reject', [\App\Http\Controllers\Admin\WithdrawalController::class, 'reject'])->name('withdrawals.reject');

        Route::get('reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
        Route::delete('reviews/product/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroyProductReview'])->name('reviews.product.destroy');
        Route::delete('reviews/service/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroyServiceReview'])->name('reviews.service.destroy');
        Route::delete('reviews/store/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroyStoreReview'])->name('reviews.store.destroy');

        Route::get('ads', [\App\Http\Controllers\Admin\AdRequestController::class, 'index'])->name('ads.index');
        Route::get('ads/{ad}', [\App\Http\Controllers\Admin\AdRequestController::class, 'show'])->name('ads.show');
        Route::post('ads/{ad}/action', [\App\Http\Controllers\Admin\AdRequestController::class, 'handleAction'])->name('ads.action');
        Route::delete('ads/{ad}', [\App\Http\Controllers\Admin\AdRequestController::class, 'destroy'])->name('ads.destroy');

        Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}/edit', [\App\Http\Controllers\Admin\UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('users.update');
        Route::post('users/{user}/status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.status');
        Route::delete('users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

        Route::get('admin-management', [\App\Http\Controllers\Admin\AdminManagementController::class, 'index'])->name('admin-management.index');
        Route::get('admin-management/create', [\App\Http\Controllers\Admin\AdminManagementController::class, 'create'])->name('admin-management.create');
        Route::post('admin-management', [\App\Http\Controllers\Admin\AdminManagementController::class, 'store'])->name('admin-management.store');
        Route::get('admin-management/{adminManagement}/edit', [\App\Http\Controllers\Admin\AdminManagementController::class, 'edit'])->name('admin-management.edit');
        Route::put('admin-management/{adminManagement}', [\App\Http\Controllers\Admin\AdminManagementController::class, 'update'])->name('admin-management.update');
        Route::delete('admin-management/{adminManagement}', [\App\Http\Controllers\Admin\AdminManagementController::class, 'destroy'])->name('admin-management.destroy');

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
        Route::get('financials', [\App\Http\Controllers\Admin\FinancialController::class, 'index'])->name('financials');
        Route::get('settings', [\App\Http\Controllers\Admin\AdminController::class, 'settings'])->name('settings');
        Route::post('settings', [\App\Http\Controllers\Admin\AdminController::class, 'updateSettings'])->name('settings.update');

        Route::get('profile', [\App\Http\Controllers\Admin\AdminController::class, 'profile'])->name('profile');
        Route::post('profile', [\App\Http\Controllers\Admin\AdminController::class, 'updateProfile'])->name('profile.update');
        Route::post('profile/password', [\App\Http\Controllers\Admin\AdminController::class, 'updatePassword'])->name('profile.password');

        Route::get('notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/{id}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markRead'])->name('notifications.read');
        Route::post('notifications/read-all', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
        Route::get('notifications/unread-count', [\App\Http\Controllers\Admin\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
        Route::get('notifications/dropdown', [\App\Http\Controllers\Admin\NotificationController::class, 'dropdown'])->name('notifications.dropdown');

        Route::get('audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('audit-logs/{auditLog}', [\App\Http\Controllers\Admin\AuditLogController::class, 'show'])->name('audit-logs.show');

        Route::resource('payment-methods', \App\Http\Controllers\Admin\PaymentMethodController::class)->except(['create', 'edit', 'show']);
        Route::post('payment-methods/{paymentMethod}/toggle', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'toggle'])->name('payment-methods.toggle');
    });
});

// === CONVERSATIONS (authenticated users) ===
Route::middleware(['auth'])->group(function () {
    Route::get('/conversations', [\App\Http\Controllers\ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{conversation}', [\App\Http\Controllers\ConversationController::class, 'show'])->name('conversations.show');
    Route::post('/conversations', [\App\Http\Controllers\ConversationController::class, 'store'])->name('conversations.store');
    Route::post('/conversations/{conversation}/messages', [\App\Http\Controllers\ConversationController::class, 'sendMessage'])->name('conversations.messages.store');
    Route::get('/conversations/{conversation}/fetch', [\App\Http\Controllers\ConversationController::class, 'fetchMessages'])->name('conversations.messages.fetch');
    Route::get('/conversations/unread/count', [\App\Http\Controllers\ConversationController::class, 'unreadCount'])->name('conversations.unread');
    Route::delete('/conversations/{conversation}', [\App\Http\Controllers\ConversationController::class, 'destroy'])->name('conversations.destroy');

    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');

    Route::post('/products/{product}/review', [\App\Http\Controllers\ProductController::class, 'review'])->name('products.review');
    Route::post('/services/{service}/review', [\App\Http\Controllers\ServiceController::class, 'review'])->name('services.review');
    Route::post('/rentals/{rental}/review', [\App\Http\Controllers\RentalController::class, 'review'])->name('rentals.review');
});

// === R2 IMAGE PROXY (serves images from Cloudflare R2 for environments without public access) ===
Route::get('/r2/{path}', function (string $path) {
    $disk = \Illuminate\Support\Facades\Storage::disk('r2');

    if (!$disk->exists($path)) {
        abort(404);
    }

    $mime = $disk->mimeType($path);
    $contents = $disk->get($path);

    return response($contents, 200, [
        'Content-Type' => $mime,
        'Cache-Control' => 'public, max-age=31536000, immutable',
        'X-Content-Type-Options' => 'nosniff',
    ]);
})->where('path', '.*')->name('r2.image');

require __DIR__ . '/auth.php';
