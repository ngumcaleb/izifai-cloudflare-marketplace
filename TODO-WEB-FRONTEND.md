# Web Frontend — Remaining Work

## Missing Views (in priority order)

### 1. Search Results Page
- Route: `GET /products/search` → `ProductController@search`
- No view exists — likely falls back or errors.
- Create `resources/views/products/search.blade.php` or reuse `products/index.blade.php` with query param.

### 2. Post-Checkout Confirmation / Thank-You
- `CheckoutController@placeOrder` redirects to `orders.show` on success.
- Create a dedicated success page (order confirmation with payment instructions).
- Handle payment failure view.

### 3. Favorites / Saved Products Page
- No web route for listing saved products (API has `GET /favorites`).
- Add `GET /favorites` web route + `resources/views/products/favorites.blade.php`.

### 4. User Profile (Web)
- No web profile routes at all (API-only).
- Create routes + views for profile show/edit, password change.

### 5. Shipping Addresses (Web)
- No web address CRUD (API-only).
- Create routes + views for managing shipping addresses.

### 6. Buyer Wallet (Web)
- No buyer-facing wallet views (seller wallet exists under seller dashboard).
- Create buyer wallet page showing balance/transactions.

### 7. Buyer Notifications (Web)
- No user notification views (only admin notifications exist).
- Create notification list/dropdown for buyers.

### 8. Messaging / Inbox (Web)
- API-only (ConversationController, MessageController).
- Create web inbox/compose/conversation views.

### 9. Static Pages
- `resources/views/pages/` is empty.
- Footer links to `#` for: Help Center, Terms of Service, Privacy Policy.
- Create: `about.blade.php`, `terms.blade.php`, `privacy.blade.php`, `help.blade.php`.
- Add routes in `web.php`.

### 10. Empty States
- Cart empty, orders empty, no search results — some may already show inline messages but check consistency.

## Routes to Add
```php
// web.php
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/favorites', [SavedProductController::class, 'index'])->name('favorites.index');
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/addresses', [AddressController::class, 'index'])->name('addresses.index');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/terms', [PageController::class, 'terms'])->name('pages.terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');
Route::get('/help', [PageController::class, 'help'])->name('pages.help');
```

## Design Notes
- All buyer-facing views use `layouts.guest`
- Use consistent component patterns from existing views (product-card, store-badge, pagination)
- Flash messages use `@section('flash-messages')` pattern in guest layout
