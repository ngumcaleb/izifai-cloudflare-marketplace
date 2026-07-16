<?php

use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\AdminController;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CheckoutController;
use App\Http\Controllers\Api\V1\ConversationController;
use App\Http\Controllers\Api\V1\FollowController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\MessageController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\PaymentController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\RentalItemController;
use App\Http\Controllers\Api\V1\RentalTransactionController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\SavedProductController;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\StoreController;
use App\Http\Controllers\Api\V1\SupportController;
use App\Http\Controllers\Api\V1\UserNotificationController;
use App\Http\Controllers\Api\V1\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // ==================== PUBLIC ROUTES ====================

    // --- Auth ---
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/forgot-password', [PasswordResetController::class, 'sendResetLink']);
    Route::post('/auth/reset-password', [PasswordResetController::class, 'reset']);

    // --- Home / Discover ---
    Route::get('/home', [HomeController::class, 'index']);

    // --- Categories ---
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryController::class, 'show']);

    // --- Products ---
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/featured', [ProductController::class, 'featured']);
    Route::get('/products/autocomplete', [ProductController::class, 'autocomplete']);
    Route::get('/products/{slug}', [ProductController::class, 'show']);

    // --- Stores ---
    Route::get('/stores', [StoreController::class, 'index']);
    Route::get('/stores/featured', [StoreController::class, 'featured']);
    Route::get('/stores/{slug}', [StoreController::class, 'show']);
    Route::get('/stores/{slug}/products', [StoreController::class, 'products']);
    Route::get('/stores/{slug}/services', [StoreController::class, 'services']);

    // --- Services ---
    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{slug}', [ServiceController::class, 'show']);

    // --- Rentals ---
    Route::get('/rental-items', [RentalItemController::class, 'index']);
    Route::get('/rental-items/{rentalItem}', [RentalItemController::class, 'show']);
    Route::get('/rental-items/{rentalItem}/availability', [RentalItemController::class, 'availability']);

    // --- Search ---
    Route::get('/search', [SearchController::class, 'search']);
    Route::get('/search/autocomplete', [SearchController::class, 'autocomplete']);
    Route::get('/search/trending', [SearchController::class, 'trending']);

    // --- Support ---
    Route::post('/support/report', [SupportController::class, 'store']);

    // --- Reviews (public listing) ---
    Route::get('/reviews/{targetType}/{targetId}', [ReviewController::class, 'index']);

    // ==================== PROTECTED ROUTES ====================
    Route::middleware('auth:sanctum')->group(function () {

        // --- Profile ---
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::put('/profile/password', [ProfileController::class, 'updatePassword']);
        Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto']);
        Route::post('/profile/cover', [ProfileController::class, 'uploadCover']);
        Route::delete('/profile', [ProfileController::class, 'destroy']);

        // --- User ---
        Route::get('/user/stores', [ProfileController::class, 'stores']);
        Route::get('/user/stats', [ProfileController::class, 'stats']);

        // --- Auth ---
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        // --- Favorites ---
        Route::get('/favorites', [SavedProductController::class, 'index']);
        Route::post('/products/{product}/favorite', [SavedProductController::class, 'toggle']);

        // --- Products (CRUD) ---
        Route::get('/my-products', [ProductController::class, 'myListings']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
        Route::post('/products/{product}', [ProductController::class, 'update']); // POST + _method=PUT spoofing
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        // --- Stores (CRUD) ---
        Route::post('/stores', [StoreController::class, 'store']);
        Route::put('/stores/{store}', [StoreController::class, 'update']);
        Route::post('/stores/{store}/follow', [StoreController::class, 'follow']);

        // --- Cart ---
        Route::get('/cart', [CartController::class, 'show']);
        Route::post('/cart/add', [CartController::class, 'add']);
        Route::put('/cart/{cartItem}', [CartController::class, 'update']);
        Route::delete('/cart/{cartItem}', [CartController::class, 'remove']);
        Route::delete('/cart', [CartController::class, 'clear']);

        // --- Checkout ---
        Route::get('/checkout/preview', [CheckoutController::class, 'preview']);
        Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder']);
        Route::post('/checkout/{order}/confirm-payment', [CheckoutController::class, 'confirmPayment']);

        // --- Orders ---
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel']);
        Route::post('/orders/{order}/confirm-received', [OrderController::class, 'confirmReceived']);

        // --- Services (CRUD) ---
        Route::get('/my-services', [ServiceController::class, 'myListings']);
        Route::post('/services', [ServiceController::class, 'store']);
        Route::put('/services/{service}', [ServiceController::class, 'update']);
        Route::post('/services/{service}', [ServiceController::class, 'update']); // POST + _method=PUT spoofing
        Route::delete('/services/{service}', [ServiceController::class, 'destroy']);

        // --- Service Bookings ---
        Route::get('/bookings', [BookingController::class, 'index']);
        Route::post('/bookings', [BookingController::class, 'store']);
        Route::get('/bookings/{booking}', [BookingController::class, 'show']);
        Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm']);
        Route::post('/bookings/{booking}/complete', [BookingController::class, 'complete']);
        Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);

        // --- Rentals (CRUD) ---
        Route::post('/rental-items', [RentalItemController::class, 'store']);
        Route::put('/rental-items/{rentalItem}', [RentalItemController::class, 'update']);
        Route::post('/rental-items/{rentalItem}', [RentalItemController::class, 'update']); // POST + _method=PUT spoofing
        Route::delete('/rental-items/{rentalItem}', [RentalItemController::class, 'destroy']);
        Route::get('/my-rentals', [RentalItemController::class, 'myListings']);

        // --- Rental Transactions ---
        Route::get('/rental-transactions', [RentalTransactionController::class, 'index']);
        Route::get('/rental-transactions/{rentalTransaction}', [RentalTransactionController::class, 'show']);
        Route::post('/rental-transactions', [RentalTransactionController::class, 'store']);
        Route::post('/rental-transactions/{rentalTransaction}/cancel', [RentalTransactionController::class, 'cancel']);
        Route::post('/rental-transactions/{rentalTransaction}/approve', [RentalTransactionController::class, 'approve']);
        Route::post('/rental-transactions/{rentalTransaction}/reject', [RentalTransactionController::class, 'reject']);
        Route::post('/rental-transactions/{rentalTransaction}/return', [RentalTransactionController::class, 'markReturned']);
        Route::get('/incoming-rentals', [RentalTransactionController::class, 'incoming']);

        // --- Conversations / Messages ---
        Route::get('/conversations', [ConversationController::class, 'index']);
        Route::post('/conversations', [ConversationController::class, 'store']);
        Route::get('/conversations/{conversation}', [ConversationController::class, 'show']);
        Route::delete('/conversations/{conversation}', [ConversationController::class, 'destroy']);
        Route::get('/conversations/{conversation}/messages', [MessageController::class, 'index']);
        Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store']);
        Route::put('/conversations/{conversation}/messages/{message}', [MessageController::class, 'update']);
        Route::delete('/conversations/{conversation}/messages/{message}', [MessageController::class, 'destroy']);
        Route::post('/conversations/{conversation}/read', [MessageController::class, 'markRead']);

        // --- Wallet ---
        Route::get('/wallet', [WalletController::class, 'show']);
        Route::get('/wallet/transactions', [WalletController::class, 'transactions']);
        Route::post('/wallet/deposit', [WalletController::class, 'deposit']);
        Route::post('/wallet/withdraw', [WalletController::class, 'withdraw']);
        Route::get('/wallet/payment-methods', [WalletController::class, 'paymentMethods']);

        // --- Addresses ---
        Route::get('/addresses', [AddressController::class, 'index']);
        Route::post('/addresses', [AddressController::class, 'store']);
        Route::put('/addresses/{address}', [AddressController::class, 'update']);
        Route::post('/addresses/{address}/default', [AddressController::class, 'setDefault']);
        Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);

        // --- Notifications ---
        Route::get('/notifications', [UserNotificationController::class, 'index']);
        Route::get('/notifications/unread-count', [UserNotificationController::class, 'unreadCount']);
        Route::post('/notifications/{id}/read', [UserNotificationController::class, 'markRead']);
        Route::post('/notifications/read-all', [UserNotificationController::class, 'markAllRead']);
        Route::delete('/notifications/{id}', [UserNotificationController::class, 'destroy']);

        // --- Follows ---
        Route::get('/follows', [FollowController::class, 'index']);
        Route::post('/follows/toggle', [FollowController::class, 'toggle']);

        // --- Reviews ---
        Route::post('/stores/{store}/review', [ReviewController::class, 'store']);
        Route::post('/products/{product}/review', [ReviewController::class, 'storeProduct']);
        Route::post('/services/{service}/review', [ReviewController::class, 'storeService']);
        Route::post('/rental-items/{rentalItem}/review', [ReviewController::class, 'storeRental']);
        Route::get('/reviews/{id}', [ReviewController::class, 'show']);
        Route::post('/reviews/{id}/helpful', [ReviewController::class, 'markHelpful']);
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

        // --- Admin ---
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/admin/financial-overview', [AdminController::class, 'financialOverview']);
        Route::get('/admin/withdrawals', [AdminController::class, 'withdrawalRequests']);
        Route::post('/admin/withdrawals/{withdrawal}/approve', [AdminController::class, 'approveWithdrawal']);
        Route::post('/admin/withdrawals/{withdrawal}/reject', [AdminController::class, 'rejectWithdrawal']);
        Route::get('/admin/platform-settings', [AdminController::class, 'platformSettings']);
        Route::put('/admin/platform-settings', [AdminController::class, 'platformSettings']);
        Route::put('/admin/platform-fee', [AdminController::class, 'updatePlatformFee']);
        Route::get('/admin/users', [AdminController::class, 'users']);
        Route::put('/admin/users/{user}/status', [AdminController::class, 'updateUserStatus']);

        // --- Payments (History) ---
        Route::get('/payments', [PaymentController::class, 'index']);

        // --- Reports ---
        Route::post('/products/{product}/report', [ReportController::class, 'reportProduct']);
        Route::post('/stores/{store}/report', [ReportController::class, 'reportStore']);

    });
});
