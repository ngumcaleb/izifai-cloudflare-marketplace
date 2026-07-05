<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\RentalItem;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\ServicePackage;
use App\Models\Store;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Create users with stores ───
        $seller1 = User::create([
            'name' => 'Emmanuel Nkwi',
            'email' => 'seller1@izifai.com',
            'phone' => '+237670000001',
            'password' => bcrypt('password'),
            'role' => Role::User->value,
            'account_type' => 'seller',
            'status' => 'active',
            'email_verified' => true,
            'location' => 'Douala, Cameroon',
            'joined_at' => now()->subMonths(8),
            'trust_score' => 4.7,
            'verification_level' => 'verified_business',
        ]);

        $seller2 = User::create([
            'name' => 'Amina Diallo',
            'email' => 'seller2@izifai.com',
            'phone' => '+237670000002',
            'password' => bcrypt('password'),
            'role' => Role::User->value,
            'account_type' => 'seller',
            'status' => 'active',
            'email_verified' => true,
            'location' => 'Yaoundé, Cameroon',
            'joined_at' => now()->subMonths(12),
            'trust_score' => 4.9,
            'verification_level' => 'verified_business',
        ]);

        $buyer = User::create([
            'name' => 'Jean-Pierre Kamga',
            'email' => 'buyer@izifai.com',
            'phone' => '+237670000003',
            'password' => bcrypt('password'),
            'role' => Role::User->value,
            'account_type' => 'hybrid',
            'status' => 'active',
            'email_verified' => true,
            'location' => 'Douala, Cameroon',
            'joined_at' => now()->subMonths(3),
            'trust_score' => 4.2,
        ]);

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@izifai.com',
            'phone' => '+237670000000',
            'password' => bcrypt('password'),
            'role' => Role::Superadmin->value,
            'account_type' => 'buyer',
            'status' => 'active',
            'email_verified' => true,
        ]);

        // ─── Create wallets for all users ───
        foreach ([$seller1, $seller2, $buyer, $admin] as $user) {
            Wallet::create(['user_id' => $user->id, 'balance' => 0]);
        }

        // ─── Stores ───
        $store1 = Store::create([
            'user_id' => $seller1->id,
            'name' => 'Nkwi Electronics',
            'slug' => 'nkwi-electronics',
            'description' => 'Premier electronics store in Douala offering quality gadgets, laptops, phones and accessories at competitive prices. Authorized dealer of major brands.',
            'location' => 'Douala, Cameroon',
            'whatsapp_number' => '+237670000001',
            'business_email' => 'info@nkwi-electronics.cm',
            'is_verified' => true,
            'badge' => 'verified_business',
            'verification_level' => 'verified_business',
            'trust_score' => 4.5,
            'completion_rate' => 98.5,
            'follower_count' => 1240,
            'product_count' => 0,
            'service_count' => 0,
            'rating' => 4.3,
            'status' => 'active',
        ]);

        $store2 = Store::create([
            'user_id' => $seller2->id,
            'name' => 'Diallo Fashion House',
            'slug' => 'diallo-fashion',
            'description' => 'Trendy African and contemporary fashion. From Ankara prints to modern casual wear, we bring you the best of African fashion.',
            'location' => 'Yaoundé, Cameroon',
            'whatsapp_number' => '+237670000002',
            'business_email' => 'hello@diallofashion.cm',
            'is_verified' => true,
            'badge' => 'verified_business',
            'verification_level' => 'verified_business',
            'trust_score' => 4.8,
            'completion_rate' => 99.2,
            'follower_count' => 2560,
            'product_count' => 0,
            'service_count' => 0,
            'rating' => 4.6,
            'status' => 'active',
        ]);

        // ─── Products ───
        $electronicsCat = Category::where('slug', 'electronics')->first();
        $laptopsCat = Category::where('slug', 'laptops-computers')->first();
        $phonesCat = Category::where('slug', 'phones-accessories')->first();
        $fashionCat = Category::where('slug', 'fashion')->first();
        $menClothing = Category::where('slug', 'mens-clothing')->first();
        $beautyCat = Category::where('slug', 'beauty')->first();

        $product1 = Product::create([
            'store_id' => $store1->id,
            'category_id' => $laptopsCat?->id ?? $electronicsCat?->id,
            'name' => 'MacBook Pro 14" M3 Pro',
            'slug' => 'macbook-pro-14-m3-pro',
            'description' => 'Apple MacBook Pro with M3 Pro chip, 18GB RAM, 512GB SSD. Space Black. Perfect for professionals and creatives. Features Liquid Retina XDR display, up to 17 hours battery life.',
            'price' => 1850000,
            'old_price' => 2100000,
            'discount_price' => 1790000,
            'stock_status' => 'in_stock',
            'inventory' => 15,
            'brand' => 'Apple',
            'sku' => 'MBP-M3-14-SB',
            'is_featured' => true,
            'featured_until' => now()->addDays(14),
            'approval_status' => 'approved',
            'status' => 'published',
            'views' => 2340,
            'rating' => 4.5,
            'review_count' => 28,
        ]);

        ProductImage::create(['product_id' => $product1->id, 'path' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=600', 'is_main' => true]);
        ProductImage::create(['product_id' => $product1->id, 'path' => 'https://images.unsplash.com/photo-1611186871348-b1f696febbb3?q=80&w=600', 'is_main' => false]);

        $product2 = Product::create([
            'store_id' => $store1->id,
            'category_id' => $phonesCat?->id ?? $electronicsCat?->id,
            'name' => 'iPhone 15 Pro Max 256GB',
            'slug' => 'iphone-15-pro-max-256gb',
            'description' => 'Apple iPhone 15 Pro Max with A17 Pro chip, 256GB storage. Titanium design with 48MP camera system. Action button and USB-C.',
            'price' => 1450000,
            'old_price' => 1650000,
            'discount_price' => 1390000,
            'stock_status' => 'in_stock',
            'inventory' => 22,
            'brand' => 'Apple',
            'sku' => 'IP15PM-256-NT',
            'is_featured' => true,
            'featured_until' => now()->addDays(10),
            'approval_status' => 'approved',
            'status' => 'published',
            'views' => 4560,
            'rating' => 4.7,
            'review_count' => 42,
        ]);

        ProductImage::create(['product_id' => $product2->id, 'path' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?q=80&w=600', 'is_main' => true]);

        $product3 = Product::create([
            'store_id' => $store2->id,
            'category_id' => $menClothing?->id ?? $fashionCat?->id,
            'name' => 'Premium Ankara Shirt - Men',
            'slug' => 'premium-ankara-shirt-men',
            'description' => 'Handcrafted premium Ankara cotton shirt for men. Features traditional African prints with modern tailoring. Perfect for casual and semi-formal occasions.',
            'price' => 35000,
            'stock_status' => 'in_stock',
            'inventory' => 50,
            'brand' => 'Diallo Fashion',
            'sku' => 'DF-M-ANK-001',
            'is_featured' => true,
            'approval_status' => 'approved',
            'status' => 'published',
            'views' => 1890,
            'rating' => 4.3,
            'review_count' => 15,
            'colors' => ['Blue/Gold', 'Green/Orange', 'Red/Black'],
            'sizes' => ['S', 'M', 'L', 'XL', '2XL'],
        ]);

        ProductImage::create(['product_id' => $product3->id, 'path' => 'https://images.unsplash.com/photo-1598965402089-897ce52e8355?q=80&w=600', 'is_main' => true]);

        $product4 = Product::create([
            'store_id' => $store2->id,
            'category_id' => $beautyCat?->id,
            'name' => 'Shea Butter Moisturizer 500ml',
            'slug' => 'shea-butter-moisturizer-500ml',
            'description' => 'Organic African shea butter moisturizer. Rich in vitamins A and E. Deeply hydrating for all skin types. 100% natural and cruelty-free.',
            'price' => 8500,
            'old_price' => 10000,
            'stock_status' => 'in_stock',
            'inventory' => 200,
            'brand' => 'Natura Africa',
            'sku' => 'NA-SBM-500',
            'is_featured' => false,
            'approval_status' => 'approved',
            'status' => 'published',
            'views' => 3450,
            'rating' => 4.6,
            'review_count' => 87,
        ]);

        ProductImage::create(['product_id' => $product4->id, 'path' => 'https://images.unsplash.com/photo-1611930022073-b7a4ba5fcccd?q=80&w=600', 'is_main' => true]);

        // ─── Services ───
        $catHomeServices = Category::where('slug', 'home-services')->first();
        $catProfServices = Category::where('slug', 'professional-services')->first();
        $catCleaning = Category::where('slug', 'cleaning')->first();

        $service1 = Service::create([
            'store_id' => $store1->id,
            'category_id' => $catHomeServices?->id,
            'name' => 'Professional Cleaning Service',
            'slug' => 'professional-cleaning-service',
            'description' => 'Deep cleaning for homes and offices. Includes floor scrubbing, window cleaning, dusting, bathroom sanitation, and kitchen degreasing.',
            'starting_price' => 25000,
            'delivery_time' => '2-4 hours',
            'status' => 'active',
            'views' => 560,
            'rating' => 4.4,
            'review_count' => 12,
            'approval_status' => 'approved',
        ]);

        ServiceImage::create(['service_id' => $service1->id, 'path' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=600', 'is_main' => true]);

        ServicePackage::create([
            'service_id' => $service1->id, 'name' => 'Basic Clean',
            'description' => '2 rooms, 1 bathroom', 'price' => 25000,
            'delivery_days' => 1, 'features' => ['Vacuuming', 'Dusting', 'Mopping', 'Trash removal'],
        ]);
        ServicePackage::create([
            'service_id' => $service1->id, 'name' => 'Deep Clean',
            'description' => '4 rooms, 2 bathrooms', 'price' => 45000,
            'delivery_days' => 1, 'features' => ['Full vacuuming', 'Window cleaning', 'Deep kitchen', 'Bathroom scrub', 'Baseboards'],
        ]);
        ServicePackage::create([
            'service_id' => $service1->id, 'name' => 'Premium Clean',
            'description' => 'Entire house or office', 'price' => 75000,
            'delivery_days' => 2, 'features' => ['Everything in Deep', 'Carpet shampoo', 'Upholstery clean', 'Inside cabinets', 'Organizing'],
        ]);

        $service2 = Service::create([
            'store_id' => $store2->id,
            'category_id' => $catProfServices?->id,
            'name' => 'IT Support & Consulting',
            'slug' => 'it-support-consulting',
            'description' => 'Expert IT support for businesses and individuals. Network setup, troubleshooting, software installation, and cybersecurity consulting.',
            'starting_price' => 15000,
            'delivery_time' => '1-24 hours',
            'videos' => ['https://www.youtube.com/watch?v=example'],
            'status' => 'active',
            'views' => 320,
            'rating' => 4.8,
            'review_count' => 24,
            'approval_status' => 'approved',
        ]);

        ServicePackage::create([
            'service_id' => $service2->id, 'name' => 'Remote Support',
            'description' => 'Phone/chat support', 'price' => 15000,
            'delivery_days' => 1, 'features' => ['Remote desktop', 'Diagnostics', 'Basic troubleshooting', 'Software install'],
        ]);
        ServicePackage::create([
            'service_id' => $service2->id, 'name' => 'On-site Visit',
            'description' => 'Physical visit within Douala', 'price' => 35000,
            'delivery_days' => 1, 'features' => ['On-site diagnosis', 'Hardware fix', 'Network setup', 'Configuration'],
        ]);
        ServicePackage::create([
            'service_id' => $service2->id, 'name' => 'Monthly Retainer',
            'description' => 'Ongoing support contract', 'price' => 120000,
            'delivery_days' => 30, 'features' => ['Unlimited remote', '2 on-site visits', '24/7 support', 'Monthly report', 'Priority queue'],
        ]);

        // ─── Rental Items ───
        RentalItem::create([
            'store_id' => $store1->id,
            'name' => 'DJ Sound System',
            'slug' => 'dj-sound-system',
            'description' => 'Professional DJ sound system with 2 speakers, mixer, microphone, and lighting. Perfect for parties, weddings, and events.',
            'rate' => 50000,
            'billing_unit' => 'daily',
            'deposit' => 100000,
            'images' => ['https://images.unsplash.com/photo-1571266028243-e4733b0f0bb0?q=80&w=600'],
            'return_conditions' => 'Return in same condition. Damage fee applies.',
            'duration_rules' => 'Minimum 1 day rental. Late return charged at 1.5x daily rate.',
            'location' => 'Douala, Cameroon',
            'status' => 'published',
            'rating' => 4.2,
            'review_count' => 8,
            'views' => 420,
        ]);

        RentalItem::create([
            'store_id' => $store2->id,
            'name' => 'Canon EOS R5 Camera',
            'slug' => 'canon-eos-r5-camera',
            'description' => 'Canon EOS R5 mirrorless camera with 24-105mm lens kit. 45MP full-frame sensor, 8K video. Includes memory card and carrying case.',
            'rate' => 35000,
            'billing_unit' => 'daily',
            'deposit' => 250000,
            'images' => ['https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=600'],
            'return_conditions' => 'Camera and all accessories must be returned. Memory card can be kept.',
            'duration_rules' => 'Minimum 2 days. Weekly discount available.',
            'location' => 'Yaoundé, Cameroon',
            'status' => 'published',
            'rating' => 4.6,
            'review_count' => 14,
            'views' => 680,
        ]);

        // ─── Payment Methods ───
        PaymentMethod::create([
            'name' => 'MTN Mobile Money',
            'icon' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/MTN_Group_logo.svg/256px-MTN_Group_logo.svg.png',
            'number' => '+237670000000',
            'account_name' => 'IZIFAI Marketplace',
            'is_active' => true,
        ]);
        PaymentMethod::create([
            'name' => 'Orange Money',
            'icon' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Orange_Money_logo.svg/256px-Orange_Money_logo.svg.png',
            'number' => '+237690000000',
            'account_name' => 'IZIFAI Marketplace',
            'is_active' => true,
        ]);

        // ─── Notifications ───
        $notifications = [
            ['user_id' => $buyer->id, 'type' => 'order', 'title' => 'Order Confirmed', 'message' => 'Your order #IZF-001 has been confirmed and is being processed.'],
            ['user_id' => $buyer->id, 'type' => 'system', 'title' => 'Welcome to IZIFAI', 'message' => 'Welcome! Start exploring products and services from trusted sellers.'],
            ['user_id' => $seller1->id, 'type' => 'order', 'title' => 'New Order Received', 'message' => 'You have received a new order for MacBook Pro 14".'],
            ['user_id' => $seller2->id, 'type' => 'review', 'title' => 'New Review', 'message' => 'A customer left a 5-star review on your Ankara Shirt.'],
        ];

        foreach ($notifications as $n) {
            UserNotification::create($n);
        }

        // ─── Conversation & Messages ───
        $conv = Conversation::create([
            'buyer_id' => $buyer->id,
            'seller_id' => $seller1->id,
            'target_type' => 'App\\Models\\Product',
            'target_id' => $product1->id,
            'last_message' => 'Thank you! When can I pick it up?',
            'last_message_at' => now()->subHours(2),
            'buyer_unread' => 0,
            'seller_unread' => 1,
        ]);

        Message::create([
            'conversation_id' => $conv->id,
            'sender_id' => $buyer->id,
            'body' => 'Hi, is the MacBook Pro still available?',
            'read' => true,
            'read_at' => now()->subHours(5),
            'created_at' => now()->subHours(6),
        ]);
        Message::create([
            'conversation_id' => $conv->id,
            'sender_id' => $seller1->id,
            'body' => 'Yes, it is! We have 15 in stock.',
            'read' => true,
            'read_at' => now()->subHours(4),
            'created_at' => now()->subHours(5),
        ]);
        Message::create([
            'conversation_id' => $conv->id,
            'sender_id' => $buyer->id,
            'body' => 'Great! What\'s the final price with discount?',
            'read' => true,
            'read_at' => now()->subHours(3),
            'created_at' => now()->subHours(4),
        ]);
        Message::create([
            'conversation_id' => $conv->id,
            'sender_id' => $seller1->id,
            'body' => 'It\'s 1,790,000 FCFA with the current promotion.',
            'read' => true,
            'read_at' => now()->subHours(2),
            'created_at' => now()->subHours(3),
        ]);
        Message::create([
            'conversation_id' => $conv->id,
            'sender_id' => $buyer->id,
            'body' => 'Thank you! When can I pick it up?',
            'read' => false,
            'created_at' => now()->subHours(2),
        ]);

        // Update product/store counts
        foreach (Product::all() as $p) {
            $p->store->increment('product_count');
        }

        foreach (Service::all() as $s) {
            $s->store->increment('service_count');
        }
    }
}
