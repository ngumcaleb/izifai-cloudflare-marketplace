# IZIFAI — Complete Codebase Documentation & Mobile API

## Overview

**Izifai** is a Laravel 12 marketplace platform connecting buyers and sellers in Central/West Africa (primarily Cameroon +237 and Nigeria +234). It operates as a **WhatsApp/call-to-order** marketplace — no online cart/checkout. Users browse products and contact sellers via WhatsApp or phone.

- **Domain:** https://izifai.com
- **Framework:** Laravel 12.x, PHP ^8.2
- **Database:** MySQL
- **Storage:** Cloudflare R2 (S3-compatible)
- **Frontend:** Tailwind CSS v4, Alpine.js, Vite
- **Auth:** Dual-guard (web for users, admin for admins)
- **Roles:** `buyer`, `seller`

---

## DATABASE SCHEMA (17 Tables)

### 1. `users` — User accounts
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| name | varchar(255) | |
| email | varchar(255) | unique |
| email_verified_at | timestamp | nullable |
| password | varchar(255) | hashed |
| remember_token | varchar(100) | nullable |
| role | varchar(255) | `buyer`, `seller`, or `admin` (default: `buyer`) |
| phone | varchar(255) | nullable |
| profile_photo_path | varchar(2048) | nullable — stored in R2 under `profile_photos/` |
| status | varchar(255) | `active` or `suspended` (default: `active`) |
| default_page | varchar(255) | default: `dashboard` — seller's default landing page |
| created_at / updated_at | timestamp | |

**Relations:** HasOne `Store`, HasMany `StoreReview`, HasMany `SavedProduct`, HasMany `ProductReport`

### 2. `stores` — Seller stores
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| user_id | bigint FK -> users | cascade delete |
| name | varchar(255) | |
| slug | varchar(255) | unique |
| description | text | nullable |
| logo | varchar(255) | nullable — R2 path `stores/logos/` |
| banner | varchar(255) | nullable — R2 path `stores/banners/` |
| location | varchar(255) | nullable — city/area |
| whatsapp_number | varchar(255) | nullable |
| business_email | varchar(255) | nullable |
| open_hours | text | nullable |
| social_links | json | nullable — `[{platform, url}]` |
| is_verified | tinyint(1) | default: false |
| badge | varchar(255) | nullable — `Verified Seller`, `Trusted Store`, `Premium Seller` |
| status | varchar(255) | `active` or `suspended` (default: `active`) |
| created_at / updated_at | timestamp | |

**Relations:** BelongsTo `User`, HasMany `Product`, HasMany `StoreReview`, HasMany `AdvertisementRequest`, HasManyThrough `ProductReport`

### 3. `products` — Marketplace products
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| store_id | bigint FK -> stores | cascade delete |
| category_id | bigint FK -> categories | cascade delete |
| name | varchar(255) | |
| slug | varchar(255) | unique |
| description | text | |
| price | decimal(15,2) | |
| old_price | decimal(15,2) | nullable — comparison/original price |
| views | bigint | default: 0 — view counter |
| stock_status | varchar(255) | `in_stock`, `out_of_stock`, `on_request` (default: `in_stock`) |
| is_featured | tinyint(1) | default: false |
| featured_until | timestamp | nullable — when featured expires |
| colors | json | nullable — product color variations |
| sizes | json | nullable — product size variations |
| created_at / updated_at | timestamp | |

**Scopes:** `active()` (store.status = active), `featured()`
**Relations:** BelongsTo `Store`, BelongsTo `Category`, HasMany `ProductImage`, HasMany `ProductSpecification`, HasMany `ProductAttribute`, HasMany `SavedProduct`, HasMany `ProductEvent`, HasMany `ProductReport`, HasMany `AdvertisementRequest`
**Accessors:** `mainImageUrl`, `dailyViews`, `totalContacts`, `dailyContacts`

### 4. `product_images` — Product gallery images
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| product_id | bigint FK -> products | cascade delete |
| path | varchar(255) | R2 path under `products/` |
| is_main | tinyint(1) | default: false |
| created_at / updated_at | timestamp | |

### 5. `product_specifications` — Product specs (e.g. Brand, Material)
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| product_id | bigint FK -> products | cascade delete |
| key | varchar(255) | e.g. "Brand", "Material" |
| value | varchar(255) | e.g. "Samsung", "Cotton" |

### 6. `product_attributes` — Product variant attributes (e.g. Size, Color)
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| product_id | bigint FK -> products | cascade delete |
| name | varchar(255) | e.g. "Size", "Color" |

### 7. `product_attribute_values` — Attribute values (e.g. XL, Red)
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| product_attribute_id | bigint FK -> product_attributes | cascade delete |
| value | varchar(255) | e.g. "XL", "Red" |

### 8. `categories` — Product categories (hierarchical)
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| name | varchar(255) | |
| slug | varchar(255) | unique |
| icon | varchar(255) | nullable — SVG path |
| image_path | varchar(255) | nullable — R2 path |
| parent_id | bigint FK -> categories | nullable, self-referencing for subcategories |
| created_at / updated_at | timestamp | |

### 9. `store_reviews` — Store reviews from users
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| user_id | bigint FK -> users | cascade delete |
| store_id | bigint FK -> stores | cascade delete |
| rating | int | 1-5 (default: 5) |
| comment | text | nullable |

### 10. `saved_products` — User favorites/bookmarks
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| user_id | bigint FK -> users | cascade delete |
| product_id | bigint FK -> products | cascade delete |

### 11. `product_reports` — Product violation reports
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| user_id | bigint FK -> users | set null on delete |
| product_id | bigint FK -> products | cascade delete |
| reason | varchar(255) | |
| details | text | nullable |
| status | varchar(255) | `pending`, `reviewed`, `dismissed` (default: `pending`) |

### 12. `store_reports` — Store violation reports
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| user_id | bigint FK -> users | set null on delete |
| store_id | bigint FK -> stores | cascade delete |
| reason | varchar(255) | |
| details | text | nullable |
| status | varchar(255) | `pending`, `reviewed`, `dismissed` (default: `pending`) |

### 13. `advertisement_requests` — Featured/promotion requests from sellers
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| product_id | bigint FK -> products | cascade delete |
| store_id | bigint FK -> stores | cascade delete |
| type | varchar(255) | `featured`, `banner`, `sidebar` (default: `featured`) |
| duration_days | int | |
| status | varchar(255) | `pending`, `approved`, `rejected`, `expired` (default: `pending`) |
| seller_notes | text | nullable |
| admin_notes | text | nullable |
| starts_at | timestamp | nullable |
| ends_at | timestamp | nullable |
| payment_sender_number | varchar(255) | nullable |
| total_amount | decimal(10,2) | nullable |
| payment_proof | varchar(255) | nullable — R2 path `payment_proofs/` |

### 14. `product_events` — Analytics events (views, contact clicks)
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| product_id | bigint FK -> products | cascade delete |
| store_id | bigint FK -> stores | cascade delete |
| type | varchar(255) | `view`, `whatsapp_click`, `call_click` |
| ip_address | varchar(255) | nullable |

### 15. `payment_methods` — Admin-managed payment methods
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| name | varchar(255) | e.g. "MTN MoMo", "Orange Money" |
| icon | varchar(255) | nullable — R2 path |
| number | varchar(255) | account number |
| account_name | varchar(255) | |
| is_active | tinyint(1) | default: true |

### 16. `settings` — Key-value site settings
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| key | varchar(255) | unique — e.g. `ad_price_per_day` |
| value | text | nullable |

### 17. `admins` — Admin panel accounts (separate from users)
| Column | Type | Notes |
|---|---|---|
| id | bigint AI PK | |
| name | varchar(255) | |
| email | varchar(255) | unique |
| password | varchar(255) | hashed |
| remember_token | varchar(100) | nullable |

### Additional Laravel Tables
- `password_reset_tokens` — Password reset tokens
- `sessions` — Session storage
- `cache` / `cache_locks` — Cache
- `jobs` / `job_batches` / `failed_jobs` — Queue
- `personal_access_tokens` — Sanctum API tokens

---

## SEED DATA

### Admin Seeder
- **Email:** admin@izifai.com
- **Password:** password123

### Category Seeder — 50 categories (8 parent + 42 subcategories)
1. Electronics & Gadgets (6 subs)
2. Fashion & Accessories (6 subs)
3. Home & Living (5 subs)
4. Beauty & Health (5 subs)
5. Sports & Outdoors (5 subs)
6. Books & Stationery (5 subs)
7. Automobiles & Accessories (5 subs)
8. Food & Beverages (5 subs)

---

## USER-FACING FEATURES (Web)

### Authentication
- Register with name, email, phone, country_code (237/234), role (buyer/seller), password
- Seller registration auto-creates a Store
- Login with email OR phone
- Password reset via email
- Session-based auth for web, token-based for mobile API

### Homepage (`/`)
- Hero stats (total stores, products, verified stores)
- Featured products section (is_featured = true)
- Trending products (by views desc)
- Latest products (random order)
- Category grid with product counts
- Store showcase (random active stores with products)
- Top stores (by product count)
- Featured store with latest 4 products

### Products Page (`/products`)
- Paginated grid (24 per page)
- Search (keyword across name/description/category/store/location)
- Category filter
- Price range filter (min/max)
- Sort: random, price_low, price_high
- Trending sidebar, most contacted sidebar, top stores sidebar

### Product Detail (`/products/{slug}`)
- Images gallery, price, stock status
- Specifications table
- Colors/sizes display
- Store info card with WhatsApp number
- Store reviews with star distribution (5-1 stars)
- Other store products
- Most favorited products from same store
- View counter (incremented on page load)
- Logs `view` event
- WhatsApp click / Call click logs `whatsapp_click` / `call_click` events

### Stores Page (`/stores`)
- Paginated grid (16 per page)
- Search by name/location/description
- Category filter (products within stores)
- Sort: newest, rating, products count
- Store shows: logo, name, verified badge, rating, products count, sample products

### Store Detail (`/store/{slug}`)
- Store info with banner, logo, location, WhatsApp, email, hours, social links
- Products grid with search/sort/filters
- Reviews with star distribution chart
- Top products by favorites (bento grid)
- Store tenure

### Search (`/search`)
- Search across products or stores
- Autocomplete: returns categories, stores, products, locations, users
- Trending categories on search page

### Favorites
- Toggle favorite on products (heart button)
- Saved products page `/favorites`

### Profile
- Edit profile info (name, email, photo)
- Change password
- Delete account

### Seller Dashboard (`/seller/*`)
- Store stats: total/daily views, contacts, saves
- Product management (CRUD with images, specs, categories)
- Advertisement requests (create with payment proof)
- Store settings (logo, banner, hours, social links)
- Reviews management

### Admin Panel (`/admin/*`)
- Dashboard with analytics
- User management (list, suspend, activate, delete)
- Store management (verify, badge, suspend, images)
- Product management (list, delete)
- Category management (CRUD hierarchical)
- Advertisement requests (approve, reject)
- Reports management (review, dismiss)
- Settings (key-value)
- Payment methods (CRUD, toggle)

---

## HELPER FUNCTIONS

```php
// Generate R2 image proxy URL
r2_url($path) // returns url('/r2/' . ltrim($path, '/'))

// Format WhatsApp number with country code
wa_url($number) // returns cleaned number with 237/234 prefix
```

---

## IMAGE PROXY

All images are stored on **Cloudflare R2** (private bucket) and served via `/r2/{path}` proxy route. The route reads from R2 and streams the response with proper Content-Type and long Cache-Control.

---

## SCHEDULED TASKS

- **Hourly:** Un-feature products where `featured_until < now()` and `is_featured = true`

---

# MOBILE APP API (NEW)

## Base URL
```
https://izifai.com/api/v1
```
For local development: `http://127.0.0.1:8000/api/v1`

## Authentication
- **Token-based** using Laravel Sanctum (Bearer tokens)
- Register/Login returns a `token` — include in all protected requests as:
  ```
  Authorization: Bearer {token}
  ```
- Logout revokes the current token

## Complete API Endpoint Reference

### AUTH — Public

#### POST /auth/register
Create a new user account.
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123",
  "role": "buyer|seller",
  "country_code": "237",
  "phone": "691234567",
  "store_name": "My Store" // required if role=seller
}
```
**Response 201:**
```json
{
  "message": "Registration successful.",
  "user": { "...user object..." },
  "token": "1|abc123..."
}
```

#### POST /auth/login
Login with email or phone.
```json
{
  "email": "john@example.com",  // or phone number
  "password": "password123"
}
```
**Response 200:**
```json
{
  "message": "Login successful.",
  "user": { "...user object..." },
  "token": "1|abc123..."
}
```

#### POST /auth/forgot-password
Send password reset link.
```json
{ "email": "john@example.com" }
```

#### POST /auth/reset-password
Reset password with token.
```json
{
  "token": "reset-token-from-email",
  "email": "john@example.com",
  "password": "newpassword",
  "password_confirmation": "newpassword"
}
```

### AUTH — Protected

#### POST /auth/logout
Revoke current API token.
**Headers:** `Authorization: Bearer {token}`

### HOME — Public

#### GET /home
Returns homepage data: stats, categories, featured/trending/latest products, stores.
```json
{
  "stats": { "total_stores": 10, "total_products": 100, "verified_stores": 5 },
  "categories": [ { "id": 1, "name": "Electronics", "slug": "electronics", "icon": "...", "image_url": null, "products_count": 20, "children": [...] } ],
  "featured_products": [ { "...product fields..." } ],
  "trending_products": [ { "...product fields..." } ],
  "latest_products": [ { "...product fields..." } ],
  "stores": [ { "id": 1, "name": "Store Name", "slug": "...", "logo_url": "...", "banner_url": "...", "location": "Yaounde", "is_verified": true, "badge": null, "products_count": 5 } ]
}
```

### CATEGORIES — Public

#### GET /categories
Returns hierarchical categories (parents with children).
```json
{
  "categories": [
    {
      "id": 1, "name": "Electronics", "slug": "electronics",
      "icon": "<svg>...</svg>", "image_url": null,
      "products_count": 20,
      "children": [
        { "id": 2, "name": "Phones", "slug": "phones", "icon": null, "image_url": null, "products_count": 8 }
      ]
    }
  ]
}
```

#### GET /categories/{slug}
Returns single category with its children.
```json
{
  "category": { "id": 1, "name": "Electronics", "slug": "electronics", "icon": "...", "image_url": null, "parent": null },
  "children": [ { "id": 2, "name": "Phones", "slug": "phones", "products_count": 8 } ]
}
```

### PRODUCTS — Public

#### GET /products
Paginated product listing with filters.
**Query Parameters:**
| Param | Type | Description |
|---|---|---|
| q | string | Search keyword |
| category | string | Category slug |
| store | string | Store slug |
| min_price | number | Minimum price |
| max_price | number | Maximum price |
| sort | string | `latest`, `price_low`, `price_high`, `popular` |
| per_page | number | Items per page (max 50, default 20) |
| page | number | Page number |

**Response:**
```json
{
  "products": [
    {
      "id": 1, "name": "Product Name", "slug": "product-name",
      "price": 5000, "old_price": null, "stock_status": "in_stock",
      "is_featured": false, "views": 100,
      "main_image_url": "https://...",
      "store_name": "Store Name", "store_slug": "store-slug",
      "category_name": "Category", "category_slug": "category"
    }
  ],
  "pagination": { "current_page": 1, "last_page": 5, "per_page": 20, "total": 100, "has_more": true }
}
```

#### GET /products/{slug}
Full product detail.
**Response:**
```json
{
  "product": {
    "id": 1, "name": "...", "slug": "...", "description": "...",
    "price": 5000, "old_price": 6000,
    "stock_status": "in_stock", "is_featured": false, "views": 100,
    "colors": ["Black", "White"], "sizes": ["M", "L", "XL"],
    "images": [ { "id": 1, "url": "https://...", "is_main": true } ],
    "specifications": [ { "key": "Brand", "value": "Nike" } ],
    "attributes": [ { "name": "Size", "values": ["M", "L"] } ],
    "category": { "id": 1, "name": "Fashion", "slug": "fashion" },
    "created_at": "2026-05-03T..."
  },
  "store": {
    "id": 1, "name": "Store", "slug": "store", "description": "...",
    "logo_url": "...", "banner_url": "...",
    "location": "Douala", "whatsapp_number": "237691234567",
    "business_email": "store@email.com", "open_hours": "Mon-Fri 9am-6pm",
    "social_links": [{"platform": "facebook", "url": "..."}],
    "is_verified": true, "badge": "Verified Seller",
    "avg_rating": 4.5, "total_reviews": 12, "total_products": 5
  },
  "reviews": [ { "id": 1, "rating": 5, "comment": "Great!", "user_name": "John", "created_at": "..." } ],
  "store_products": [ { "...product fields..." } ],
  "is_favorited": false
}
```

#### GET /products/autocomplete?q=search
Quick product search for autocomplete. Returns max 6 products.

### STORES — Public

#### GET /stores
Paginated store listing.
**Query Parameters:**
| Param | Type | Description |
|---|---|---|
| search | string | Search by name/location/description |
| location | string | Filter by location |
| verified | boolean | Filter verified only |
| sort | string | `newest`, `rating`, `products` |
| per_page | number | Items per page (default 20) |
| page | number | Page number |

#### GET /stores/{slug}
Full store detail with reviews and star distribution.

#### GET /stores/{slug}/products
Products within a store (paginated).
**Query Parameters:** q, category, min_price, max_price, sort, per_page, page

### SEARCH — Public

#### GET /search
Search across products or stores.
**Query Parameters:** q, type (`products`|`stores`), city, min_price, max_price

#### GET /search/autocomplete?q=search
Returns products, stores, and categories matching the query.

#### GET /search/trending
Returns trending categories (top 8 by product count).

### FAVORITES — Protected

#### GET /favorites
Paginated list of user's favorited products.

#### POST /products/{product}/favorite
Toggle favorite on a product.
**Response:**
```json
{ "favorited": true, "count": 5 }
```

### REVIEWS — Protected

#### POST /stores/{store}/review
Submit a store review.
```json
{ "rating": 5, "comment": "Great store!" }
```

### REPORTS — Protected

#### POST /products/{product}/report
Report a product listing.
```json
{ "reason": "Fake product", "details": "This item is counterfeit" }
```

#### POST /stores/{store}/report
Report a store.
```json
{ "reason": "Scam", "details": "They took payment and didn't deliver" }
```

### ANALYTICS — Protected

#### POST /products/{product}/log-event
Log a user action on a product.
```json
{ "type": "whatsapp_click" }
```
**Types:** `view`, `whatsapp_click`, `call_click`

### PROFILE — Protected

#### GET /profile
Get authenticated user's full profile including store info.

#### PUT /profile
Update profile.
```json
{ "name": "New Name", "email": "new@email.com", "phone": "237691234567" }
```

#### PUT /profile/password
Update password.
```json
{ "current_password": "oldpass", "password": "newpass", "password_confirmation": "newpass" }
```

#### POST /profile/photo
Upload profile photo (multipart/form-data).
- Field: `photo` (image, max 2MB)
- Stored in R2 under `profile_photos/`

#### DELETE /profile
Delete account (requires password confirmation).
```json
{ "password": "current_password" }
```

---

## User Object Shape (returned by auth/profile endpoints)
```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "237691234567",
  "role": "buyer|seller",
  "status": "active",
  "profile_photo_url": "https://izifai.com/r2/profile_photos/abc.jpg",
  "default_page": "dashboard",
  "store": { // only if role=seller
    "id": 1,
    "name": "My Store",
    "slug": "my-store-abc123",
    "logo_url": null,
    "is_verified": false,
    "badge": null
  },
  "created_at": "2026-05-03T..."
}
```

---

## Error Responses

**Validation Error (422):**
```json
{
  "message": "The email field is required.",
  "errors": { "email": ["The email field is required."] }
}
```

**Authentication Error (401):**
```json
{
  "message": "Unauthenticated."
}
```

**Suspended Account (403):**
```json
{
  "message": "Your account has been suspended. Please contact support."
}
```

**Not Found (404):**
```json
{
  "message": "No query results for model [App\\Models\\...]"
}
```

---

## Files Created for Mobile API

| File | Purpose |
|---|---|
| `routes/api.php` | All API v1 routes (28 endpoints) |
| `app/Http/Controllers/Api/V1/Auth/AuthController.php` | Register, login, logout |
| `app/Http/Controllers/Api/V1/Auth/PasswordResetController.php` | Forgot/reset password |
| `app/Http/Controllers/Api/V1/ProfileController.php` | Profile CRUD + photo + password |
| `app/Http/Controllers/Api/V1/HomeController.php` | Homepage feed |
| `app/Http/Controllers/Api/V1/ProductController.php` | Products list, detail, autocomplete |
| `app/Http/Controllers/Api/V1/StoreController.php` | Stores list, detail, store products |
| `app/Http/Controllers/Api/V1/CategoryController.php` | Categories (hierarchical) |
| `app/Http/Controllers/Api/V1/SearchController.php` | Search, autocomplete, trending |
| `app/Http/Controllers/Api/V1/SavedProductController.php` | Favorites list + toggle |
| `app/Http/Controllers/Api/V1/ReviewController.php` | Store reviews |
| `app/Http/Controllers/Api/V1/ReportController.php` | Product/store reports |
| `app/Http/Controllers/Api/V1/AnalyticsController.php` | Event logging |

## Files Modified

| File | Change |
|---|---|
| `app/Models/User.php` | Added `HasApiTokens` trait for Sanctum |
| `config/auth.php` | Added `api` guard with `sanctum` driver |
| `bootstrap/app.php` | Added `api` route loading |
| `composer.json` | Added `laravel/sanctum` package |

---

## Setup Steps (for the API to work)

1. **Database:** Ensure MySQL is running and `.env` has correct DB credentials
2. **Run migrations:** `php artisan migrate` (creates `personal_access_tokens` table)
3. **CORS:** For mobile apps, no CORS needed (Bearer tokens). If web SPA will use the API, configure CORS in `bootstrap/app.php`
4. **Sanctum config:** Published to `config/sanctum.php` — add `SANCTUM_STATEFUL_DOMAINS` in `.env` if SPA support needed
5. **API prefix:** All routes at `/api/v1/*`

---

## Admin Web Panel (Unchanged for Admin Use)

The admin continues to manage everything from the web at `/admin/*`:
- Users (suspend/activate)
- Stores (verify, badge, suspend)
- Products (delete)
- Categories (CRUD)
- Advertisements (approve/reject)
- Reports (review/dismiss)
- Payment methods (CRUD)
- Settings (key-value)
- Analytics

Users can access both the web app and the mobile app with the same account.






# IZIFAI MASTER PRODUCT VISION & BUSINESS SPECIFICATION

## What is IZIFAI?

IZIFAI is a trusted commerce ecosystem that enables individuals, businesses, brands, and service providers to create digital stores, sell products, offer services, receive secure payments, advertise, build reputation, and grow their businesses online.

IZIFAI bridges the gap between social selling and full e-commerce.

Businesses that currently sell through WhatsApp, Facebook, Instagram, TikTok, Telegram, and other social channels can use IZIFAI to manage their entire business professionally.

---

# Core Mission

To become Africa's most trusted platform for buying, selling, hiring services, making payments, and building online businesses.

---

# Core Problem

Businesses currently face:

* Repetitive WhatsApp product posting
* Poor product organization
* Lack of trust
* Customer frustration
* No order management
* No secure payment system
* No customer tracking
* No business analytics
* No professional storefront

Customers face:

* Fraudulent sellers
* Fake products
* No buyer protection
* Difficult product discovery
* No order tracking
* No seller reputation system

IZIFAI solves these problems.

---

# User Types

## Customers

People buying products and services.

## Sellers

Businesses selling physical products.

## Service Providers

Professionals offering services.

## Hybrid Businesses

Businesses selling both products and services.

## Delivery Partners

Companies responsible for logistics.

## Administrators

Platform management.

---

# Account System

Every user creates a standard IZIFAI account.

The same account can:

* Buy products
* Purchase services
* Create a store
* Become a seller
* Become a service provider

One account serves all purposes.

---

# Customer Features

Customers can:

* Browse marketplace
* Search products
* Search services
* Follow stores
* Follow providers
* Save favorites
* Place orders
* Book services
* Track orders
* Manage payments
* Leave reviews
* Open disputes
* Receive refunds

---

# Seller Features

## Store Creation

Seller creates:

* Store Name
* Logo
* Cover Banner
* Description
* Location
* Contact Information
* Social Media Links

Store receives unique URL.

Example:

izifai.com/store/varl-electronics

---

# Listing System

IZIFAI does not only support products.

Everything is a Listing.

Listing Types:

## Product

Physical goods.

Examples:

* Phones
* Clothing
* Furniture

## Service

Professional services.

Examples:

* Graphic Design
* Plumbing
* Photography

## Rental (Future)

Examples:

* Cars
* Equipment
* Properties

## Digital Product (Future)

Examples:

* Courses
* E-books
* Templates

---

# Category System

Seller creates custom categories.

Examples:

Electronics

Fashion

Beauty

Automobile

Services

Education

Real Estate

Home & Garden

Health

Technology

---

# Subcategory System

Unlimited subcategories.

Example:

Electronics

* Phones
* Laptops
* Tablets
* Chargers

Services

* Web Development
* Graphic Design
* Photography
* Consulting

---

# Product Listings

Each product contains:

* Name
* Description
* Price
* Discount Price
* Inventory
* Images
* Videos
* Specifications
* Brand
* SKU

---

# Service Listings

Each service contains:

* Service Name
* Description
* Starting Price
* Delivery Time
* Portfolio
* Images
* Service Packages
* Availability Schedule

Example:

Logo Design

Basic Package

15,000 FCFA

2 Days Delivery

---

# Booking System

For service providers.

Customer can:

* Book appointment
* Select date
* Select time
* Request consultation

---

# Marketplace

Marketplace contains:

* Products
* Services
* Verified Stores
* Featured Stores
* Featured Services
* Trending Listings
* New Listings

---

# Search Engine

Search by:

* Product Name
* Service Name
* Seller
* Provider
* Category
* Location
* Price Range

---

# Shopping Cart

Supports:

* Products
* Services

Customer checks out in one process.

---

# Secure Payments

Supported Methods:

* MTN Mobile Money
* Orange Money
* Visa
* Mastercard
* Bank Transfer

Future:

* IZIFAI Wallet

---

# Escrow Payment Protection

Customer pays.

↓

IZIFAI receives funds.

↓

Funds held securely.

↓

Seller delivers product.

or

↓

Service provider completes service.

↓

Customer confirms.

↓

Funds released.

---

# Buyer Protection

Customer protected against:

* Fraud
* Wrong item
* Non-delivery
* Service not rendered

---

# Seller Protection

Seller protected against:

* False disputes
* Fraudulent buyers
* Payment risks

---

# Review System

## Product Reviews

Review individual products.

Example:

⭐⭐⭐⭐⭐

Great quality.

---

## Service Reviews

Review completed services.

Example:

⭐⭐⭐⭐⭐

Delivered exactly as promised.

---

## Store Reviews

Review entire businesses.

Example:

⭐⭐⭐⭐⭐

Excellent communication and delivery.

---

## Provider Reviews

Review professionals.

Example:

⭐⭐⭐⭐⭐

Professional and punctual.

---

# Reputation System

Every store receives:

* Overall Rating
* Trust Score
* Verification Score
* Completion Rate

Displayed publicly.

---

# Verification System

## Basic Verification

Phone

Email

---

## Verified Seller

Government ID

Address

---

## Verified Business

Business Registration

Company Verification

---

## Verified Professional

Professional credentials verified.

---

# Advertising Platform

Businesses can promote:

* Products
* Services
* Stores

Advertising options:

## Featured Product

## Featured Service

## Featured Store

## Homepage Banner

## Search Ads

## Category Ads

---

# Analytics Dashboard

Seller sees:

* Revenue
* Views
* Conversion Rate
* Orders
* Followers
* Ad Performance

---

# Customer Dashboard

* Orders
* Service Bookings
* Wishlist
* Followed Stores
* Followed Providers
* Notifications
* Refund Requests

---

# Seller Dashboard

* Listings
* Orders
* Customers
* Payments
* Analytics
* Advertisements

---

# Admin Dashboard

Manage:

* Users
* Stores
* Services
* Products
* Payments
* Escrow
* Disputes
* Reviews
* Verifications
* Ads

---

# AI Features

## AI Product Generator

Generate descriptions.

## AI Service Generator

Generate service descriptions.

## AI Marketing Assistant

Create promotional content.

## AI Shopping Assistant

Help customers find products and services.

---

# Revenue Model

1. Featured Listings

2. Featured Stores

3. Service Promotions

4. Banner Advertising

5. Search Advertising

6. Transaction Fees

7. Premium Stores

8. Premium Service Accounts

9. Verification Fees

10. Logistics Commission

11. Financial Services (Future)

---

# Long-Term Vision

IZIFAI becomes the operating system for commerce in Africa.

A place where:

* Businesses create stores
* Professionals offer services
* Customers discover products
* Payments happen securely
* Trust is verified
* Deliveries are tracked
* Businesses advertise
* Commerce happens end-to-end

From a simple WhatsApp catalog link to a complete digital economy.

# Tagline

Create. Discover. Trust. Grow.

IZIFAI — The Future of African Commerce.
