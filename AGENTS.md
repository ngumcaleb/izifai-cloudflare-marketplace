# IZIFAI Backend - MVP Scope

Laravel 12 backend for IZIFAI marketplace. REST API with Sanctum token auth.

## Tech Stack
- **Framework**: Laravel 12
- **Auth**: Laravel Sanctum (token-based)
- **Database**: MySQL (local port 3306) / SQLite fallback

## Controllers (26)

### Auth & Profile
- `Auth\AuthController` — register, login, logout
- `Auth\PasswordResetController` — forgot/reset password
- `ProfileController` — show, update, updatePassword, uploadPhoto, destroy, stores, stats

### Products & Stores
- `ProductController` — index, featured, autocomplete, show, store, update, destroy
- `StoreController` — index, featured, show, products, services, store, update, follow
- `SavedProductController` — index (favorites), toggle
- `CategoryController` — index, show

### Services & Bookings
- `ServiceController` — index, show, store, update, destroy
- `BookingController` — index, store, show, confirm, complete, cancel

### Rentals
- `RentalItemController` — index, show, store, update, destroy, myListings, availability
- `RentalTransactionController` — index, show, store, cancel, approve, reject, markReturned, incoming

### Commerce
- `CartController` — show, add, update, remove, clear
- `CheckoutController` — preview, placeOrder, confirmPayment
- `OrderController` — index, show, cancel, confirmReceived
- `AddressController` — index, store, update, setDefault, destroy

### Messaging
- `ConversationController` — index, store, show, destroy
- `MessageController` — index, store, markRead

### Wallet & Payments
- `WalletController` — show, transactions, deposit, withdraw, paymentMethods
- `PaymentController` — index (transaction history)

### Social & Trust
- `ReviewController` — store, storeProduct, storeService, index, show, markHelpful, destroy
- `FollowController` — index, toggle
- `ReportController` — reportProduct, reportStore

### Admin & Other
- `AdminController` — dashboard, users, updateUserStatus
- `HomeController` — index (discover feed)
- `SearchController` — search, autocomplete, trending
- `UserNotificationController` — index, unreadCount, markRead, markAllRead, destroy

## API Routes (MVP — ~100 routes)

### Public
- `POST /auth/register`, `/auth/login`, `/auth/forgot-password`, `/auth/reset-password`
- `GET /home`, `/categories`, `/categories/{slug}`
- `GET /products`, `/products/featured`, `/products/autocomplete`, `/products/{slug}`
- `GET /stores`, `/stores/featured`, `/stores/{slug}`, `/stores/{slug}/products`, `/stores/{slug}/services`
- `GET /services`, `/services/{slug}`
- `GET /rental-items`, `/rental-items/{rentalItem}`, `/rental-items/{rentalItem}/availability`
- `GET /search`, `/search/autocomplete`, `/search/trending`

### Protected
- **Profile**: GET/PUT /profile, PUT /profile/password, POST /profile/photo, DELETE /profile
- **User**: GET /user/stores, /user/stats
- **Auth**: POST /auth/logout
- **Favorites**: GET /favorites, POST /products/{product}/favorite
- **Products**: POST/PUT/DELETE /products
- **Stores**: POST/PUT /stores, POST /stores/{store}/follow
- **Cart**: GET /cart, POST /cart/add, PUT/DELETE /cart/{cartItem}, DELETE /cart
- **Checkout**: GET /checkout/preview, POST /checkout/place-order, /checkout/{order}/confirm-payment
- **Orders**: GET /orders, GET /orders/{order}, POST /orders/{order}/cancel, /confirm-received
- **Services**: POST/PUT/DELETE /services
- **Bookings**: GET/POST /bookings, GET /bookings/{booking}, POST /bookings/{booking}/{confirm|complete|cancel}
- **Rentals**: POST/PUT/DELETE /rental-items, GET /my-rentals, GET /rental-items/{id}/availability
- **Rental Transactions**: GET/POST, approve, reject, cancel, return, incoming
- **Conversations**: GET/POST, GET/DELETE /conversations/{id}, messages, read
- **Wallet**: GET /wallet, /wallet/transactions, POST /wallet/deposit, /wallet/withdraw, GET /wallet/payment-methods
- **Addresses**: GET/POST /addresses, PUT/DELETE /addresses/{id}, POST /addresses/{id}/default
- **Notifications**: GET /notifications, unread-count, markRead, markAllRead, destroy
- **Follows**: GET /follows, POST /follows/toggle
- **Reviews**: POST (product|service|store)/{id}/review, GET /reviews/{id}, GET /reviews/{type}/{id}, POST helpful, DELETE
- **Admin**: GET /admin/dashboard, GET /admin/users, PUT /admin/users/{user}/status
- **Payments**: GET /payments
- **Reports**: POST /products/{product}/report, /stores/{store}/report

## Out-of-Scope (Removed)
- Campaigns, Disputes, Refunds, Delivery, Providers, Verification, Seller Dashboard, Analytics

## Database Connection
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=izifai
DB_USERNAME=root
DB_PASSWORD=
```

## Demo Credentials
- `buyer@izifai.com`, `seller1@izifai.com`, `seller2@izifai.com`, `admin@izifai.com`
- All passwords: `password`

## Common Commands
```bash
php artisan migrate:fresh --seed   # reset and seed database
php artisan serve                  # start dev server on :8000
php artisan route:list             # list all routes
```
