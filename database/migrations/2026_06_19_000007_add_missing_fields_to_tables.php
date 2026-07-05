<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ─── USERS ───
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'account_type')) {
                $table->string('account_type')->default('buyer')->after('role');
                // buyer, seller, provider, hybrid
            }
            if (!Schema::hasColumn('users', 'location')) {
                $table->string('location')->nullable()->after('profile_photo_path');
            }
            if (!Schema::hasColumn('users', 'joined_at')) {
                $table->timestamp('joined_at')->nullable()->after('location');
            }
        });

        // ─── STORES ───
        Schema::table('stores', function (Blueprint $table) {
            if (!Schema::hasColumn('stores', 'contact_info')) {
                $table->json('contact_info')->nullable()->after('whatsapp_number');
            }
            if (!Schema::hasColumn('stores', 'rating')) {
                $table->decimal('rating', 3, 2)->default(0)->after('is_verified');
            }
            if (!Schema::hasColumn('stores', 'product_count')) {
                $table->integer('product_count')->default(0)->after('follower_count');
            }
            if (!Schema::hasColumn('stores', 'service_count')) {
                $table->integer('service_count')->default(0)->after('product_count');
            }
        });

        // ─── PRODUCTS ───
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'status')) {
                $table->string('status')->default('published')->after('approval_status');
                // draft, published, archived
            }
            if (!Schema::hasColumn('products', 'rating')) {
                $table->decimal('rating', 3, 2)->default(0)->after('status');
            }
            if (!Schema::hasColumn('products', 'review_count')) {
                $table->integer('review_count')->default(0)->after('rating');
            }
            if (!Schema::hasColumn('products', 'discount_price')) {
                $table->decimal('discount_price', 15, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'subcategory_id')) {
                $table->foreignId('subcategory_id')->nullable()->constrained('categories')->onDelete('set null')->after('category_id');
            }
        });

        // ─── SERVICES ───
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'rating')) {
                $table->decimal('rating', 3, 2)->default(0)->after('views');
            }
            if (!Schema::hasColumn('services', 'review_count')) {
                $table->integer('review_count')->default(0)->after('rating');
            }
            if (!Schema::hasColumn('services', 'videos')) {
                $table->json('videos')->nullable()->after('delivery_time');
            }
            if (!Schema::hasColumn('services', 'portfolio')) {
                $table->json('portfolio')->nullable()->after('videos');
            }
            if (!Schema::hasColumn('services', 'availability_schedule')) {
                $table->json('availability_schedule')->nullable()->after('portfolio');
            }
            if (!Schema::hasColumn('services', 'subcategory_id')) {
                $table->foreignId('subcategory_id')->nullable()->constrained('categories')->onDelete('set null')->after('category_id');
            }
        });

        // ─── SERVICE PACKAGES ───
        Schema::table('service_packages', function (Blueprint $table) {
            if (!Schema::hasColumn('service_packages', 'features')) {
                $table->json('features')->nullable()->after('delivery_time');
            }
            if (!Schema::hasColumn('service_packages', 'delivery_days')) {
                $table->integer('delivery_days')->nullable()->after('delivery_time');
            }
        });

        // ─── SERVICE BOOKINGS ───
        Schema::table('service_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('service_bookings', 'price')) {
                $table->decimal('price', 15, 2)->default(0)->after('package_id');
            }
            if (!Schema::hasColumn('service_bookings', 'time_slot')) {
                $table->string('time_slot')->nullable()->after('booking_time');
            }
        });

        // ─── ORDERS ───
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'seller_id')) {
                $table->foreignId('seller_id')->nullable()->constrained('users')->onDelete('set null')->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('total_amount');
                // mtn_momo, orange_money, visa, mastercard, bank_transfer
            }
            if (!Schema::hasColumn('orders', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('payment_method');
                // pending, paid, failed
            }
            if (!Schema::hasColumn('orders', 'escrow_status')) {
                $table->string('escrow_status')->default('pending')->after('payment_status');
                // pending, held, released, refunded
            }
        });

        // ─── ORDER ITEMS ───
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'name')) {
                $table->string('name')->nullable()->after('store_id');
            }
            if (!Schema::hasColumn('order_items', 'image')) {
                $table->string('image')->nullable()->after('name');
            }
            if (!Schema::hasColumn('order_items', 'package_id')) {
                $table->foreignId('package_id')->nullable()->constrained('service_packages')->onDelete('set null')->after('image');
            }
        });

        // ─── DISPUTES ───
        if (Schema::hasTable('disputes')) {
            Schema::table('disputes', function (Blueprint $table) {
                if (!Schema::hasColumn('disputes', 'respondent_id')) {
                    $table->foreignId('respondent_id')->nullable()->constrained('users')->onDelete('set null')->after('user_id');
                }
                if (!Schema::hasColumn('disputes', 'evidence')) {
                    $table->json('evidence')->nullable()->after('description');
                }
                if (!Schema::hasColumn('disputes', 'admin_notes')) {
                    $table->text('admin_notes')->nullable()->after('resolution');
                }
                if (!Schema::hasColumn('disputes', 'amount')) {
                    $table->decimal('amount', 15, 2)->default(0)->after('resolution');
                }
                if (!Schema::hasColumn('disputes', 'order_number')) {
                    $table->string('order_number')->nullable()->after('order_id');
                }
            });
        }

        // ─── WALLETS ───
        Schema::table('wallets', function (Blueprint $table) {
            if (!Schema::hasColumn('wallets', 'locked_balance')) {
                $table->decimal('locked_balance', 15, 2)->default(0)->after('balance');
            }
            if (!Schema::hasColumn('wallets', 'total_earned')) {
                $table->decimal('total_earned', 15, 2)->default(0)->after('locked_balance');
            }
        });

        // ─── WALLET TRANSACTIONS ───
        Schema::table('wallet_transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('wallet_transactions', 'status')) {
                $table->string('status')->default('available')->after('amount');
                // locked, available, withdrawn
            }
            if (!Schema::hasColumn('wallet_transactions', 'order_id')) {
                $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null')->after('wallet_id');
            }
            if (!Schema::hasColumn('wallet_transactions', 'buyer_name')) {
                $table->string('buyer_name')->nullable()->after('reference');
            }
        });

        // ─── VERIFICATIONS ───
        // ─── VERIFICATIONS ───
        if (Schema::hasTable('verifications')) {
            Schema::table('verifications', function (Blueprint $table) {
                if (!Schema::hasColumn('verifications', 'target_level')) {
                    $table->string('target_level')->nullable()->after('type');
                    // basic, verified_seller, verified_business, verified_professional
                }
                if (!Schema::hasColumn('verifications', 'documents')) {
                    $table->json('documents')->nullable()->after('document_path');
                }
                if (!Schema::hasColumn('verifications', 'admin_notes')) {
                    $table->text('admin_notes')->nullable()->after('notes');
                }
            });
        }

        // ─── ADVERTISEMENT REQUESTS (Campaigns) ───
        if (Schema::hasTable('advertisement_requests')) {
            Schema::table('advertisement_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('advertisement_requests', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
            if (!Schema::hasColumn('advertisement_requests', 'headline')) {
                $table->string('headline')->nullable()->after('name');
            }
            if (!Schema::hasColumn('advertisement_requests', 'description')) {
                $table->text('description')->nullable()->after('headline');
            }
            if (!Schema::hasColumn('advertisement_requests', 'cta')) {
                $table->string('cta')->nullable()->after('description');
            }
            if (!Schema::hasColumn('advertisement_requests', 'target_url')) {
                $table->string('target_url')->nullable()->after('cta');
            }
            if (!Schema::hasColumn('advertisement_requests', 'image')) {
                $table->string('image')->nullable()->after('target_url');
            }
            if (!Schema::hasColumn('advertisement_requests', 'budget')) {
                $table->decimal('budget', 15, 2)->nullable()->after('total_amount');
            }
            if (!Schema::hasColumn('advertisement_requests', 'daily_budget')) {
                $table->decimal('daily_budget', 15, 2)->nullable()->after('budget');
            }
            if (!Schema::hasColumn('advertisement_requests', 'spent')) {
                $table->decimal('spent', 15, 2)->default(0)->after('daily_budget');
            }
            if (!Schema::hasColumn('advertisement_requests', 'impressions')) {
                $table->integer('impressions')->default(0)->after('spent');
            }
            if (!Schema::hasColumn('advertisement_requests', 'clicks')) {
                $table->integer('clicks')->default(0)->after('impressions');
            }
            if (!Schema::hasColumn('advertisement_requests', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('ends_at');
            }
        });
        }

        // ─── PRODUCT REVIEWS ───
        Schema::table('product_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('product_reviews', 'images')) {
                $table->json('images')->nullable()->after('comment');
            }
            if (!Schema::hasColumn('product_reviews', 'helpful')) {
                $table->integer('helpful')->default(0)->after('images');
            }
        });

        // ─── SERVICE REVIEWS ───
        Schema::table('service_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('service_reviews', 'images')) {
                $table->json('images')->nullable()->after('comment');
            }
            if (!Schema::hasColumn('service_reviews', 'helpful')) {
                $table->integer('helpful')->default(0)->after('images');
            }
        });

        // ─── STORE REVIEWS ───
        Schema::table('store_reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('store_reviews', 'images')) {
                $table->json('images')->nullable()->after('comment');
            }
            if (!Schema::hasColumn('store_reviews', 'helpful')) {
                $table->integer('helpful')->default(0)->after('images');
            }
        });

        // ─── DELIVERIES ───
        if (Schema::hasTable('deliveries')) {
            Schema::table('deliveries', function (Blueprint $table) {
                if (!Schema::hasColumn('deliveries', 'pickup_address')) {
                    $table->text('pickup_address')->nullable()->after('tracking_number');
                }
                if (!Schema::hasColumn('deliveries', 'delivery_address')) {
                    $table->text('delivery_address')->nullable()->after('pickup_address');
                }
                if (!Schema::hasColumn('deliveries', 'rental_item_id')) {
                    $table->foreignId('rental_item_id')->nullable()->constrained('rental_items')->onDelete('set null')->after('order_id');
                }
            });
        }

        // ─── NOTIFICATIONS (app-level) ───
        // Create a user_notifications table for app-level notifications
        // (separate from Laravel's internal notifications table)
        if (!Schema::hasTable('user_notifications')) {
            Schema::create('user_notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('type'); // order, payment, review, promotion, system, booking, dispute, verification
                $table->string('title');
                $table->text('message');
                $table->boolean('read')->default(false);
                $table->json('data')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'read']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_notifications');

        $tables = [
            'deliveries' => ['pickup_address', 'delivery_address', 'rental_item_id'],
            'store_reviews' => ['images', 'helpful'],
            'service_reviews' => ['images', 'helpful'],
            'product_reviews' => ['images', 'helpful'],
            'advertisement_requests' => ['name', 'headline', 'description', 'cta', 'target_url', 'image', 'budget', 'daily_budget', 'spent', 'impressions', 'clicks', 'paid_at'],
            'verifications' => ['target_level', 'documents', 'admin_notes'],
            'wallet_transactions' => ['status', 'order_id', 'buyer_name'],
            'wallets' => ['locked_balance', 'total_earned'],
            'disputes' => ['respondent_id', 'evidence', 'admin_notes', 'amount', 'order_number'],
            'order_items' => ['name', 'image', 'package_id'],
            'orders' => ['seller_id', 'payment_method', 'payment_status', 'escrow_status'],
            'service_bookings' => ['price', 'time_slot'],
            'service_packages' => ['features', 'delivery_days'],
            'services' => ['rating', 'review_count', 'videos', 'portfolio', 'availability_schedule', 'subcategory_id'],
            'products' => ['status', 'rating', 'review_count', 'discount_price', 'subcategory_id'],
            'stores' => ['contact_info', 'rating', 'product_count', 'service_count'],
            'users' => ['account_type', 'location', 'joined_at'],
        ];

        foreach ($tables as $table => $columns) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            Schema::table($table, function (Blueprint $blueprint) use ($columns) {
                if (in_array('package_id', $columns)) {
                    $blueprint->dropForeign(['package_id']);
                }
                if (in_array('seller_id', $columns)) {
                    $blueprint->dropForeign(['seller_id']);
                }
                if (in_array('respondent_id', $columns)) {
                    $blueprint->dropForeign(['respondent_id']);
                }
                if (in_array('order_id', $columns) && $table === 'wallet_transactions') {
                    $blueprint->dropForeign(['order_id']);
                }
                if (in_array('subcategory_id', $columns)) {
                    $blueprint->dropForeign(['subcategory_id']);
                }
                if (in_array('rental_item_id', $columns)) {
                    $blueprint->dropForeign(['rental_item_id']);
                }
                $blueprint->dropColumn($columns);
            });
        }
    }
};
