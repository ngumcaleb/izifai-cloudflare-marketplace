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
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    private array $stores = [];
    private array $categories = [];
    private array $users = [];

    public function run(): void
    {
        $this->categories = [
            'electronics'    => Category::where('slug', 'electronics')->first(),
            'laptops'        => Category::where('slug', 'laptops-computers')->first(),
            'phones'         => Category::where('slug', 'phones-accessories')->first(),
            'fashion'        => Category::where('slug', 'fashion')->first(),
            'men_clothing'   => Category::where('slug', 'mens-clothing')->first(),
            'women_clothing' => Category::where('slug', 'womens-clothing')->first(),
            'shoes'          => Category::where('slug', 'shoes-footwear')->first(),
            'home_living'    => Category::where('slug', 'home-living')->first(),
            'furniture'      => Category::where('slug', 'furniture')->first(),
            'kitchen'        => Category::where('slug', 'kitchen-appliances')->first(),
            'beauty'         => Category::where('slug', 'beauty')->first(),
            'skincare'       => Category::where('slug', 'skincare')->first(),
            'auto'           => Category::where('slug', 'auto-parts')->first(),
            'construction'   => Category::where('slug', 'construction')->first(),
            'agriculture'    => Category::where('slug', 'agriculture')->first(),
            'home_services'  => Category::where('slug', 'home-services')->first(),
            'cleaning'       => Category::where('slug', 'cleaning')->first(),
            'plumbing'       => Category::where('slug', 'plumbing')->first(),
            'electrical'     => Category::where('slug', 'electrical')->first(),
            'prof_services'  => Category::where('slug', 'professional-services')->first(),
            'health'         => Category::where('slug', 'health-wellness')->first(),
            'events'         => Category::where('slug', 'events-photography')->first(),
            'sports'         => Category::firstOrCreate(['name' => 'Sports & Entertainment'], [
                'slug' => 'sports-entertainment', 'icon' => 'basketball', 'type' => 'product',
            ]),
            'watches'        => Category::firstOrCreate(['name' => 'Watches & Jewelry'], [
                'slug' => 'watches-jewelry', 'icon' => 'watch', 'type' => 'product',
            ]),
            'toys'           => Category::firstOrCreate(['name' => 'Toys & Hobbies'], [
                'slug' => 'toys-hobbies', 'icon' => 'toy-brick-outline', 'type' => 'product',
            ]),
            'office'         => Category::firstOrCreate(['name' => 'Office Supplies'], [
                'slug' => 'office-supplies', 'icon' => 'printer', 'type' => 'product',
            ]),
        ];

        $this->createUsers();
        $this->createStores();
        $this->createProducts();
        $this->createServices();
        $this->createRentals();
        $this->createMiscData();
        $this->updateCounts();
    }

    private function createUsers(): void
    {
        $sellers = [
            ['name' => 'Emmanuel Nkwi',     'email' => 'seller1@izifai.com', 'phone' => '+237670000001', 'location' => 'Douala, Cameroon',   'trust' => 4.7, 'joined' => 8],
            ['name' => 'Amina Diallo',      'email' => 'seller2@izifai.com', 'phone' => '+237670000002', 'location' => 'Yaoundé, Cameroon',  'trust' => 4.9, 'joined' => 12],
            ['name' => 'Kamga Fru',         'email' => 'seller3@izifai.com', 'phone' => '+237670000004', 'location' => 'Bamenda, Cameroon',  'trust' => 4.5, 'joined' => 6],
            ['name' => 'Mama Njoku',        'email' => 'seller4@izifai.com', 'phone' => '+237670000005', 'location' => 'Douala, Cameroon',   'trust' => 4.8, 'joined' => 10],
            ['name' => 'Boum Christian',    'email' => 'seller5@izifai.com', 'phone' => '+237670000006', 'location' => 'Kribi, Cameroon',    'trust' => 4.3, 'joined' => 5],
            ['name' => 'LeGrand Mbarga',    'email' => 'seller6@izifai.com', 'phone' => '+237670000007', 'location' => 'Douala, Cameroon',   'trust' => 4.6, 'joined' => 9],
            ['name' => 'Sophie Nde',        'email' => 'seller7@izifai.com', 'phone' => '+237670000008', 'location' => 'Yaoundé, Cameroon',  'trust' => 4.4, 'joined' => 7],
            ['name' => 'Paul Atangana',     'email' => 'seller8@izifai.com', 'phone' => '+237670000009', 'location' => 'Limbe, Cameroon',    'trust' => 4.7, 'joined' => 11],
        ];

        foreach ($sellers as $s) {
            $user = User::create([
                'name' => $s['name'], 'email' => $s['email'], 'phone' => $s['phone'],
                'password' => bcrypt('password'), 'role' => Role::User->value,
                'account_type' => 'seller', 'status' => 'active', 'email_verified' => true,
                'location' => $s['location'], 'joined_at' => now()->subMonths($s['joined']),
                'trust_score' => $s['trust'], 'verification_level' => 'verified_business',
            ]);
            Wallet::create(['user_id' => $user->id, 'balance' => 0]);
            $this->users[] = $user;
        }

        // Buyer
        $buyer = User::create([
            'name' => 'Jean-Pierre Kamga', 'email' => 'buyer@izifai.com', 'phone' => '+237670000003',
            'password' => bcrypt('password'), 'role' => Role::User->value,
            'account_type' => 'hybrid', 'status' => 'active', 'email_verified' => true,
            'location' => 'Douala, Cameroon', 'joined_at' => now()->subMonths(3), 'trust_score' => 4.2,
        ]);
        Wallet::create(['user_id' => $buyer->id, 'balance' => 0]);
        $this->users[] = $buyer;

        // Admin
        $admin = User::create([
            'name' => 'Admin User', 'email' => 'admin@izifai.com', 'phone' => '+237670000000',
            'password' => bcrypt('password'), 'role' => Role::Superadmin->value,
            'account_type' => 'buyer', 'status' => 'active', 'email_verified' => true,
        ]);
        Wallet::create(['user_id' => $admin->id, 'balance' => 0]);
    }

    private function createStores(): void
    {
        $storeData = [
            ['user' => 0, 'name' => 'Nkwi Electronics',      'slug' => 'nkwi-electronics',      'desc' => 'Premier electronics store in Douala offering quality gadgets, laptops, phones and accessories.', 'loc' => 'Douala',  'verified' => true,  'followers' => 1240, 'rating' => 4.5, 'badge' => 'verified_business'],
            ['user' => 1, 'name' => 'Diallo Fashion House',   'slug' => 'diallo-fashion',         'desc' => 'Trendy African and contemporary fashion. Ankara prints to modern casual wear.',                        'loc' => 'Yaoundé', 'verified' => true,  'followers' => 2560, 'rating' => 4.8, 'badge' => 'verified_business'],
            ['user' => 2, 'name' => 'Kamga Tech Hub',         'slug' => 'kamga-tech-hub',         'desc' => 'Your one-stop shop for computer hardware, software and IT accessories.',                             'loc' => 'Bamenda', 'verified' => true,  'followers' => 890,  'rating' => 4.3, 'badge' => 'verified_business'],
            ['user' => 3, 'name' => 'Mama Njoku Organic Farm','slug' => 'mama-njoku-organic',     'desc' => 'Certified organic produce. Fresh from the farm to your table. Free-range poultry and farm eggs.',    'loc' => 'Douala',  'verified' => true,  'followers' => 3200, 'rating' => 4.9, 'badge' => 'top_seller'],
            ['user' => 4, 'name' => 'Boum Construction',      'slug' => 'boum-construction',      'desc' => 'Building materials, tools and construction supplies. Delivery across Cameroon.',                      'loc' => 'Kribi',   'verified' => true,  'followers' => 670,  'rating' => 4.2, 'badge' => 'verified_business'],
            ['user' => 5, 'name' => 'LeGrand Auto Parts',     'slug' => 'legrand-auto-parts',     'desc' => 'Genuine and aftermarket auto parts for all vehicle makes. Fast delivery.',                             'loc' => 'Douala',  'verified' => true,  'followers' => 1580, 'rating' => 4.6, 'badge' => 'verified_business'],
            ['user' => 6, 'name' => 'Sophie Events & Media',  'slug' => 'sophie-events-media',    'desc' => 'Professional event planning, photography, videography and DJ services.',                             'loc' => 'Yaoundé', 'verified' => true,  'followers' => 2100, 'rating' => 4.7, 'badge' => 'top_seller'],
            ['user' => 7, 'name' => 'FitLife Wellness Center','slug' => 'fitlife-wellness',       'desc' => 'Personal training, massage therapy, nutrition coaching and wellness retreats.',                       'loc' => 'Limbe',   'verified' => true,  'followers' => 1850, 'rating' => 4.4, 'badge' => 'verified_business'],
        ];

        foreach ($storeData as $sd) {
            $store = Store::create([
                'user_id' => $this->users[$sd['user']]->id, 'name' => $sd['name'], 'slug' => $sd['slug'],
                'description' => $sd['desc'], 'location' => $sd['loc'] . ', Cameroon',
                'whatsapp_number' => $this->users[$sd['user']]->phone,
                'business_email' => 'info@' . $sd['slug'] . '.com',
                'is_verified' => $sd['verified'], 'badge' => $sd['badge'],
                'verification_level' => 'verified_business', 'trust_score' => $sd['rating'],
                'completion_rate' => rand(92, 99), 'follower_count' => $sd['followers'],
                'product_count' => 0, 'service_count' => 0, 'rating' => $sd['rating'],
                'status' => 'active',
            ]);
            $this->stores[] = $store;
        }
    }

    private function cat(string $key): ?int
    {
        return $this->categories[$key]?->id ?? null;
    }

    private function store(int $idx): int
    {
        return $this->stores[$idx]->id;
    }

    private function createProducts(): void
    {
        $products = [
            // ── Electronics (store 0) ──
            ['s' => 0, 'cat' => 'laptops', 'name' => 'MacBook Pro 14" M3 Pro', 'slug' => 'macbook-pro-14-m3-pro', 'desc' => 'Apple MacBook Pro with M3 Pro chip, 18GB RAM, 512GB SSD. Space Black.', 'price' => 1850000, 'old' => 2100000, 'brand' => 'Apple', 'views' => 2340, 'rating' => 4.5, 'reviews' => 28, 'img' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=600'],
            ['s' => 0, 'cat' => 'phones', 'name' => 'iPhone 15 Pro Max 256GB', 'slug' => 'iphone-15-pro-max-256gb', 'desc' => 'A17 Pro chip, titanium design, 48MP camera system. Natural Titanium.', 'price' => 1450000, 'old' => 1650000, 'brand' => 'Apple', 'views' => 4560, 'rating' => 4.7, 'reviews' => 42, 'img' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?q=80&w=600'],
            ['s' => 0, 'cat' => 'phones', 'name' => 'Samsung Galaxy S24 Ultra 512GB', 'slug' => 'samsung-galaxy-s24-ultra', 'desc' => 'Titanium frame, S Pen, 200MP camera, AI features. 512GB storage.', 'price' => 980000, 'old' => 1100000, 'brand' => 'Samsung', 'views' => 3200, 'rating' => 4.6, 'reviews' => 35, 'img' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?q=80&w=600'],
            ['s' => 0, 'cat' => 'electronics', 'name' => 'Sony WH-1000XM5 Headphones', 'slug' => 'sony-wh1000xm5', 'desc' => 'Industry-leading noise cancellation. 30-hour battery life. Multipoint connection.', 'price' => 185000, 'old' => 220000, 'brand' => 'Sony', 'views' => 1890, 'rating' => 4.8, 'reviews' => 56, 'img' => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?q=80&w=600'],
            ['s' => 0, 'cat' => 'electronics', 'name' => 'Samsung 65" QLED 4K Smart TV', 'slug' => 'samsung-65-qled-4k', 'desc' => 'Quantum Dot technology, 4K UHD, Smart TV with Tizen OS.', 'price' => 850000, 'old' => 950000, 'brand' => 'Samsung', 'views' => 1200, 'rating' => 4.4, 'reviews' => 18, 'img' => 'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?q=80&w=600'],
            ['s' => 0, 'cat' => 'phones', 'name' => 'Xiaomi 14 Ultra 256GB', 'slug' => 'xiaomi-14-ultra', 'desc' => 'Leica optics, Snapdragon 8 Gen 3, 5000mAh battery.', 'price' => 620000, 'brand' => 'Xiaomi', 'views' => 980, 'rating' => 4.3, 'reviews' => 12, 'img' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?q=80&w=600'],
            ['s' => 0, 'cat' => 'electronics', 'name' => 'JBL Charge 5 Bluetooth Speaker', 'slug' => 'jbl-charge-5', 'desc' => 'Portable waterproof speaker, 20 hours playtime, powerbank function.', 'price' => 65000, 'old' => 80000, 'brand' => 'JBL', 'views' => 2100, 'rating' => 4.5, 'reviews' => 33, 'img' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?q=80&w=600'],
            ['s' => 0, 'cat' => 'phones', 'name' => 'AirPods Pro 2nd Gen USB-C', 'slug' => 'airpods-pro-2-usb-c', 'desc' => 'Active noise cancellation, adaptive transparency, personalized spatial audio.', 'price' => 125000, 'brand' => 'Apple', 'views' => 3400, 'rating' => 4.7, 'reviews' => 67, 'img' => 'https://images.unsplash.com/photo-1606220588913-b3aacb4d2f46?q=80&w=600'],
            ['s' => 0, 'cat' => 'electronics', 'name' => 'DJI Mini 4 Pro Drone', 'slug' => 'dji-mini-4-pro', 'desc' => 'Under 249g, 4K/60fps HDR, omnidirectional obstacle sensing, 34-min flight time.', 'price' => 720000, 'brand' => 'DJI', 'views' => 890, 'rating' => 4.6, 'reviews' => 15, 'img' => 'https://images.unsplash.com/photo-1527977966376-1c8408f9f108?q=80&w=600'],

            // ── Fashion (store 1) ──
            ['s' => 1, 'cat' => 'men_clothing', 'name' => 'Premium Ankara Shirt - Men', 'slug' => 'premium-ankara-shirt-men', 'desc' => 'Handcrafted premium Ankara cotton shirt. Available in multiple prints.', 'price' => 35000, 'brand' => 'Diallo Fashion', 'views' => 1890, 'rating' => 4.3, 'reviews' => 15, 'img' => 'https://images.unsplash.com/photo-1598965402089-897ce52e8355?q=80&w=600', 'colors' => ['Blue/Gold', 'Green/Orange', 'Red/Black'], 'sizes' => ['S', 'M', 'L', 'XL', '2XL']],
            ['s' => 1, 'cat' => 'women_clothing', 'name' => 'Ankara Maxi Dress', 'slug' => 'ankara-maxi-dress', 'desc' => 'Elegant floor-length Ankara print dress with waist tie. Perfect for events.', 'price' => 55000, 'old' => 65000, 'brand' => 'Diallo Fashion', 'views' => 2340, 'rating' => 4.6, 'reviews' => 22, 'img' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?q=80&w=600', 'colors' => ['Yellow/Blue', 'Pink/Purple', 'White/Red']],
            ['s' => 1, 'cat' => 'men_clothing', 'name' => 'Men\'s Linen Suit Set', 'slug' => 'mens-linen-suit', 'desc' => 'Breathable linen blazer and trousers. Perfect for tropical weather weddings.', 'price' => 120000, 'brand' => 'Diallo Fashion', 'views' => 1560, 'rating' => 4.4, 'reviews' => 10, 'img' => 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?q=80&w=600', 'sizes' => ['S', 'M', 'L', 'XL']],
            ['s' => 1, 'cat' => 'women_clothing', 'name' => 'African Print Jumpsuit', 'slug' => 'african-print-jumpsuit', 'desc' => 'Modern jumpsuit with African wax print. Wide-leg style with belt.', 'price' => 48000, 'brand' => 'Diallo Fashion', 'views' => 1780, 'rating' => 4.5, 'reviews' => 18, 'img' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=600'],
            ['s' => 1, 'cat' => 'shoes', 'name' => 'Handcrafted Leather Sandals', 'slug' => 'handcrafted-leather-sandals', 'desc' => 'Genuine leather sandals, handmade by Cameroonian artisans.', 'price' => 28000, 'brand' => 'Artisan Cameroon', 'views' => 1340, 'rating' => 4.7, 'reviews' => 25, 'img' => 'https://images.unsplash.com/photo-1603487742131-4160ec999306?q=80&w=600', 'sizes' => ['38', '39', '40', '41', '42', '43']],
            ['s' => 1, 'cat' => 'fashion', 'name' => 'Kente Cloth Scarf', 'slug' => 'kente-cloth-scarf', 'desc' => 'Authentic handwoven Kente cloth scarf. Unisex. Made in Ghana.', 'price' => 18000, 'brand' => 'Pan African Textiles', 'views' => 890, 'rating' => 4.2, 'reviews' => 9, 'img' => 'https://images.unsplash.com/photo-1601924921557-45e8e0e68c31?q=80&w=600'],
            ['s' => 1, 'cat' => 'women_clothing', 'name' => 'Dashiki Blouse - Women', 'slug' => 'dashiki-blouse-women', 'desc' => 'Vibrant dashiki-inspired blouse with embroidery detail. Relaxed fit.', 'price' => 22000, 'brand' => 'Diallo Fashion', 'views' => 1120, 'rating' => 4.3, 'reviews' => 14, 'img' => 'https://images.unsplash.com/photo-1485968579580-b6d095142e6e?q=80&w=600'],
            ['s' => 1, 'cat' => 'men_clothing', 'name' => 'Men\'s Casual Polo Shirt', 'slug' => 'mens-casual-polo', 'desc' => 'Premium cotton polo shirt. Slim fit. Multiple color options.', 'price' => 15000, 'brand' => 'Diallo Fashion', 'views' => 2560, 'rating' => 4.1, 'reviews' => 30, 'img' => 'https://images.unsplash.com/photo-1625910513413-5fc421e4f4a3?q=80&w=600'],
            ['s' => 1, 'cat' => 'shoes', 'name' => 'Women\'s Wedge Heels', 'slug' => 'womens-wedge-heels', 'desc' => 'Comfortable wedge heels with African print accent. Canvas upper.', 'price' => 32000, 'brand' => 'Diallo Fashion', 'views' => 780, 'rating' => 4.0, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?q=80&w=600', 'sizes' => ['36', '37', '38', '39', '40']],

            // ── Tech (store 2) ──
            ['s' => 2, 'cat' => 'laptops', 'name' => 'Dell XPS 15 Laptop', 'slug' => 'dell-xps-15', 'desc' => 'Intel Core i7, 16GB RAM, 512GB SSD, OLED display. InfinityEdge.', 'price' => 950000, 'brand' => 'Dell', 'views' => 1800, 'rating' => 4.5, 'reviews' => 20, 'img' => 'https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?q=80&w=600'],
            ['s' => 2, 'cat' => 'laptops', 'name' => 'HP Pavilion Gaming Laptop 15"', 'slug' => 'hp-pavilion-gaming', 'desc' => 'RTX 4060, Ryzen 7, 16GB RAM, 1TB SSD, 144Hz display.', 'price' => 780000, 'old' => 850000, 'brand' => 'HP', 'views' => 1450, 'rating' => 4.3, 'reviews' => 16, 'img' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?q=80&w=600'],
            ['s' => 2, 'cat' => 'laptops', 'name' => 'Lenovo ThinkPad X1 Carbon', 'slug' => 'lenovo-thinkpad-x1', 'desc' => 'Business ultrabook, Intel i5, 16GB RAM, 256GB SSD, MIL-STD tested.', 'price' => 820000, 'brand' => 'Lenovo', 'views' => 920, 'rating' => 4.6, 'reviews' => 22, 'img' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?q=80&w=600'],
            ['s' => 2, 'cat' => 'laptops', 'name' => 'ASUS ROG Strix Gaming Desktop', 'slug' => 'asus-rog-strix-desktop', 'desc' => 'RTX 4070, Intel i7-14700F, 32GB DDR5, 1TB NVMe SSD.', 'price' => 1250000, 'brand' => 'ASUS', 'views' => 780, 'rating' => 4.7, 'reviews' => 11, 'img' => 'https://images.unsplash.com/photo-1587202372775-e229f172b9d7?q=80&w=600'],
            ['s' => 2, 'cat' => 'electronics', 'name' => 'Logitech MX Master 3S Mouse', 'slug' => 'logitech-mx-master-3s', 'desc' => 'Ergonomic wireless mouse, 8K DPI, quiet clicks, USB-C charging.', 'price' => 52000, 'brand' => 'Logitech', 'views' => 1340, 'rating' => 4.8, 'reviews' => 45, 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?q=80&w=600'],
            ['s' => 2, 'cat' => 'electronics', 'name' => 'Mechanical Keyboard RGB', 'slug' => 'mechanical-keyboard-rgb', 'desc' => 'Full-size mechanical keyboard, Cherry MX Blue switches, RGB backlight.', 'price' => 45000, 'old' => 55000, 'brand' => 'Keychron', 'views' => 1120, 'rating' => 4.4, 'reviews' => 28, 'img' => 'https://images.unsplash.com/photo-1541140532154-b024d705b90a?q=80&w=600'],
            ['s' => 2, 'cat' => 'electronics', 'name' => 'BenQ 27" 4K Monitor', 'slug' => 'benq-27-4k-monitor', 'desc' => '27-inch 4K UHD, HDR400, 99% sRGB, USB-C connectivity.', 'price' => 320000, 'brand' => 'BenQ', 'views' => 670, 'rating' => 4.5, 'reviews' => 12, 'img' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?q=80&w=600'],
            ['s' => 2, 'cat' => 'phones', 'name' => 'Google Pixel 8 Pro 128GB', 'slug' => 'google-pixel-8-pro', 'desc' => 'Tensor G3 chip, 50MP triple camera, 7 years of updates.', 'price' => 580000, 'brand' => 'Google', 'views' => 1560, 'rating' => 4.6, 'reviews' => 19, 'img' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?q=80&w=600'],
            ['s' => 2, 'cat' => 'laptops', 'name' => 'MacBook Air 15" M3', 'slug' => 'macbook-air-15-m3', 'desc' => 'M3 chip, 8GB RAM, 256GB SSD, 15.3" Liquid Retina display.', 'price' => 890000, 'brand' => 'Apple', 'views' => 2100, 'rating' => 4.8, 'reviews' => 31, 'img' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=600'],

            // ── Organic Farm (store 3) ──
            ['s' => 3, 'cat' => 'agriculture', 'name' => 'Organic Fresh Tomatoes (5kg)', 'slug' => 'organic-fresh-tomatoes-5kg', 'desc' => 'Farm-fresh organic Roma tomatoes. Pesticide-free, locally grown.', 'price' => 8000, 'brand' => 'Mama Njoku', 'views' => 4200, 'rating' => 4.9, 'reviews' => 120, 'img' => 'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?q=80&w=600'],
            ['s' => 3, 'cat' => 'agriculture', 'name' => 'Free-Range Eggs (Tray of 30)', 'slug' => 'free-range-eggs-tray-30', 'desc' => 'Fresh free-range eggs from happy hens. Rich golden yolk.', 'price' => 6500, 'brand' => 'Mama Njoku', 'views' => 5600, 'rating' => 4.8, 'reviews' => 95, 'img' => 'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?q=80&w=600'],
            ['s' => 3, 'cat' => 'agriculture', 'name' => 'Organic Cassava Flour (10kg)', 'slug' => 'organic-cassava-flour', 'desc' => 'Stone-ground cassava flour. Gluten-free, perfect for fufu and baking.', 'price' => 12000, 'brand' => 'Mama Njoku', 'views' => 3100, 'rating' => 4.7, 'reviews' => 68, 'img' => 'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?q=80&w=600'],
            ['s' => 3, 'cat' => 'agriculture', 'name' => 'Fresh Plantains (Bunch)', 'slug' => 'fresh-plantains-bunch', 'desc' => 'Locally grown ripe plantains. Great for alloco and dodo.', 'price' => 3500, 'brand' => 'Mama Njoku', 'views' => 2800, 'rating' => 4.6, 'reviews' => 45, 'img' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?q=80&w=600'],
            ['s' => 3, 'cat' => 'agriculture', 'name' => 'Organic Palm Oil (5L)', 'slug' => 'organic-palm-oil-5l', 'desc' => 'Traditional cold-pressed red palm oil. Rich flavor, no additives.', 'price' => 15000, 'brand' => 'Mama Njoku', 'views' => 3800, 'rating' => 4.9, 'reviews' => 88, 'img' => 'https://images.unsplash.com/photo-1474979266404-7f28eb320ede?q=80&w=600'],
            ['s' => 3, 'cat' => 'agriculture', 'name' => 'Farm Fresh Chicken (Whole)', 'slug' => 'farm-fresh-chicken', 'desc' => 'Free-range whole chicken, antibiotic-free. 2-3kg each.', 'price' => 9500, 'brand' => 'Mama Njoku', 'views' => 4500, 'rating' => 4.7, 'reviews' => 76, 'img' => 'https://images.unsplash.com/photo-1587593810167-a84920ea0781?q=80&w=600'],
            ['s' => 3, 'cat' => 'agriculture', 'name' => 'Organic Honey (1L)', 'slug' => 'organic-honey-1l', 'desc' => 'Raw unfiltered honey from local beekeepers. Pure and natural.', 'price' => 18000, 'brand' => 'Mama Njoku', 'views' => 2900, 'rating' => 4.8, 'reviews' => 52, 'img' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?q=80&w=600'],
            ['s' => 3, 'cat' => 'agriculture', 'name' => 'Basmati Rice (25kg)', 'slug' => 'basmati-rice-25kg', 'desc' => 'Premium long-grain basmati rice. Aged for extra fragrance.', 'price' => 35000, 'brand' => 'Import', 'views' => 3200, 'rating' => 4.5, 'reviews' => 40, 'img' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?q=80&w=600'],

            // ── Construction (store 4) ──
            ['s' => 4, 'cat' => 'construction', 'name' => 'Portland Cement 50kg', 'slug' => 'portland-cement-50kg', 'desc' => 'High-quality Portland cement. CEM II 42.5R. For all construction work.', 'price' => 7500, 'brand' => 'CIMENCAM', 'views' => 3400, 'rating' => 4.3, 'reviews' => 55, 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600'],
            ['s' => 4, 'cat' => 'construction', 'name' => 'Iron Rods 12mm (Bundle of 10)', 'slug' => 'iron-rods-12mm', 'desc' => 'Standard 12mm reinforcement bars, 12m length each.', 'price' => 85000, 'brand' => 'ALUCAM', 'views' => 2100, 'rating' => 4.4, 'reviews' => 30, 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600'],
            ['s' => 4, 'cat' => 'construction', 'name' => 'Roofing Sheets (3.6m)', 'slug' => 'roofing-sheets-360cm', 'desc' => 'Aluminium roofing sheets. 0.55mm thickness. Multiple colors available.', 'price' => 12000, 'brand' => 'ALUMIN', 'views' => 1800, 'rating' => 4.2, 'reviews' => 22, 'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?q=80&w=600'],
            ['s' => 4, 'cat' => 'construction', 'name' => 'Hollow Blocks (Per Piece)', 'slug' => 'hollow-blocks', 'desc' => 'Standard concrete hollow blocks 40x20x20cm. Durable and uniform.', 'price' => 850, 'brand' => 'Local', 'views' => 4500, 'rating' => 4.1, 'reviews' => 80, 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600'],
            ['s' => 4, 'cat' => 'construction', 'name' => 'Ceramic Floor Tiles (Per m²)', 'slug' => 'ceramic-floor-tiles', 'desc' => 'Premium 60x60cm ceramic floor tiles. Multiple patterns. Anti-slip.', 'price' => 6500, 'brand' => 'Ceramica', 'views' => 2300, 'rating' => 4.3, 'reviews' => 35, 'img' => 'https://images.unsplash.com/photo-1615876234886-fd9a39fda97f?q=80&w=600'],
            ['s' => 4, 'cat' => 'construction', 'name' => 'Bosch GBH 2-28 Drilling Machine', 'slug' => 'bosch-gbh-2-28', 'desc' => 'Professional rotary hammer drill. SDS-plus, 800W, 3 modes.', 'price' => 135000, 'brand' => 'Bosch', 'views' => 1560, 'rating' => 4.6, 'reviews' => 18, 'img' => 'https://images.unsplash.com/photo-1572981779307-38b8cabb2407?q=80&w=600'],
            ['s' => 4, 'cat' => 'construction', 'name' => 'Paint - Interior White (20L)', 'slug' => 'paint-interior-white-20l', 'desc' => 'Premium interior emulsion paint. Washable, low VOC. Covers 80-100m².', 'price' => 45000, 'brand' => 'Azar', 'views' => 1890, 'rating' => 4.4, 'reviews' => 27, 'img' => 'https://images.unsplash.com/photo-1562259949-e8e7689d7828?q=80&w=600'],

            // ── Auto Parts (store 5) ──
            ['s' => 5, 'cat' => 'auto', 'name' => 'Michelin Pilot Sport 4 (225/45R17)', 'slug' => 'michelin-pilot-sport-4', 'desc' => 'Premium summer tire. Excellent grip and handling.', 'price' => 95000, 'brand' => 'Michelin', 'views' => 2100, 'rating' => 4.7, 'reviews' => 35, 'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?q=80&w=600'],
            ['s' => 5, 'cat' => 'auto', 'name' => 'Bosch Spark Plugs (Set of 4)', 'slug' => 'bosch-spark-plugs-4', 'desc' => 'Iridium spark plugs for smoother engine performance.', 'price' => 18000, 'brand' => 'Bosch', 'views' => 1800, 'rating' => 4.5, 'reviews' => 42, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 5, 'cat' => 'auto', 'name' => 'Car Battery 12V 74Ah', 'slug' => 'car-battery-12v-74ah', 'desc' => 'Maintenance-free car battery. 2-year warranty.', 'price' => 65000, 'old' => 75000, 'brand' => 'Exide', 'views' => 3200, 'rating' => 4.3, 'reviews' => 55, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 5, 'cat' => 'auto', 'name' => 'Synthetic Engine Oil 5W-30 (4L)', 'slug' => 'synthetic-engine-oil-5w30', 'desc' => 'Full synthetic motor oil. Excellent engine protection.', 'price' => 28000, 'brand' => 'Mobil 1', 'views' => 2500, 'rating' => 4.6, 'reviews' => 38, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 5, 'cat' => 'auto', 'name' => 'LED Headlights (Pair)', 'slug' => 'led-headlights-pair', 'desc' => 'Ultra-bright LED headlight bulbs. 12000 lumens, 6000K white.', 'price' => 35000, 'brand' => 'Philips', 'views' => 1600, 'rating' => 4.4, 'reviews' => 22, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 5, 'cat' => 'auto', 'name' => 'Car Floor Mats (Set of 4)', 'slug' => 'car-floor-mats-set', 'desc' => 'Heavy-duty rubber floor mats. Universal fit. Waterproof.', 'price' => 22000, 'brand' => 'WeatherTech', 'views' => 1200, 'rating' => 4.2, 'reviews' => 18, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 5, 'cat' => 'auto', 'name' => 'Brake Pads Front (Set)', 'slug' => 'brake-pads-front', 'desc' => 'Ceramic brake pads. Low dust, quiet operation.', 'price' => 32000, 'brand' => 'Brembo', 'views' => 1900, 'rating' => 4.5, 'reviews' => 30, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],

            // ── Beauty (store 1 continued) ──
            ['s' => 1, 'cat' => 'beauty', 'name' => 'Shea Butter Moisturizer 500ml', 'slug' => 'shea-butter-moisturizer-500ml', 'desc' => 'Organic African shea butter moisturizer. Deep hydration.', 'price' => 8500, 'old' => 10000, 'brand' => 'Natura Africa', 'views' => 3450, 'rating' => 4.6, 'reviews' => 87, 'img' => 'https://images.unsplash.com/photo-1611930022073-b7a4ba5fcccd?q=80&w=600'],
            ['s' => 1, 'cat' => 'skincare', 'name' => 'Charcoal Face Mask (Pack of 5)', 'slug' => 'charcoal-face-mask-5', 'desc' => 'Deep cleansing peel-off mask. Detoxifies pores.', 'price' => 5500, 'brand' => 'Natura Africa', 'views' => 2100, 'rating' => 4.3, 'reviews' => 34, 'img' => 'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?q=80&w=600'],
            ['s' => 1, 'cat' => 'beauty', 'name' => 'Black Soap (Traditional 200g)', 'slug' => 'traditional-black-soap', 'desc' => 'Authentic African black soap. Natural ingredients, no chemicals.', 'price' => 3500, 'brand' => 'Herbal Cameroon', 'views' => 4800, 'rating' => 4.7, 'reviews' => 110, 'img' => 'https://images.unsplash.com/photo-1608248543803-ba4f8c70ae0b?q=80&w=600'],
            ['s' => 1, 'cat' => 'skincare', 'name' => 'Coconut Hair Oil (250ml)', 'slug' => 'coconut-hair-oil', 'desc' => 'Pure virgin coconut oil for hair growth and scalp health.', 'price' => 4200, 'brand' => 'Natura Africa', 'views' => 3200, 'rating' => 4.5, 'reviews' => 62, 'img' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?q=80&w=600'],

            // ── Sports (store 7) ──
            ['s' => 7, 'cat' => 'sports', 'name' => 'Football - Adidas Telstar', 'slug' => 'adidas-telstar-football', 'desc' => 'Official match ball. Thermal-bonded panels. FIFA Quality Pro.', 'price' => 45000, 'brand' => 'Adidas', 'views' => 2300, 'rating' => 4.6, 'reviews' => 28, 'img' => 'https://images.unsplash.com/photo-1553778263-73a83bab9b0c?q=80&w=600'],
            ['s' => 7, 'cat' => 'sports', 'name' => 'Dumbbell Set (5kg Pair)', 'slug' => 'dumbbell-set-5kg', 'desc' => 'Rubber-coated cast iron dumbbells. Ergonomic grip.', 'price' => 38000, 'brand' => 'FitLife', 'views' => 1800, 'rating' => 4.4, 'reviews' => 15, 'img' => 'https://images.unsplash.com/photo-1638536532686-d610adfc8e5c?q=80&w=600'],
            ['s' => 7, 'cat' => 'sports', 'name' => 'Yoga Mat Premium (6mm)', 'slug' => 'yoga-mat-premium', 'desc' => 'Non-slip TPE yoga mat. Eco-friendly, lightweight.', 'price' => 22000, 'brand' => 'FitLife', 'views' => 1500, 'rating' => 4.5, 'reviews' => 20, 'img' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?q=80&w=600'],
            ['s' => 7, 'cat' => 'sports', 'name' => 'Treadmill - Electric Folding', 'slug' => 'electric-folding-treadmill', 'desc' => '2.5HP motor, 12km/h max speed, LED display, foldable design.', 'price' => 320000, 'old' => 380000, 'brand' => 'FitLife', 'views' => 980, 'rating' => 4.3, 'reviews' => 12, 'img' => 'https://images.unsplash.com/photo-1576678927484-cc907957088c?q=80&w=600'],
            ['s' => 7, 'cat' => 'sports', 'name' => 'Boxing Gloves (12oz)', 'slug' => 'boxing-gloves-12oz', 'desc' => 'PU leather boxing gloves. Wrist support, breathable lining.', 'price' => 18000, 'brand' => 'FitLife', 'views' => 1200, 'rating' => 4.4, 'reviews' => 16, 'img' => 'https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?q=80&w=600'],

            // ── Watches (store 0 continued) ──
            ['s' => 0, 'cat' => 'watches', 'name' => 'Casio G-Shock GA-2100', 'slug' => 'casio-g-shock-ga2100', 'desc' => 'Carbon Core Guard structure. 200m water resistance. Octagonal bezel.', 'price' => 85000, 'brand' => 'Casio', 'views' => 1800, 'rating' => 4.6, 'reviews' => 30, 'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600'],
            ['s' => 0, 'cat' => 'watches', 'name' => 'Rolex Submariner Homage', 'slug' => 'rolex-submariner-homage', 'desc' => 'Stainless steel automatic dive watch. Sapphire crystal. Ceramic bezel.', 'price' => 120000, 'brand' => 'Generic', 'views' => 950, 'rating' => 4.1, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1524592094714-0f0654e20314?q=80&w=600'],

            // ── More electronics (store 2) ──
            ['s' => 2, 'cat' => 'electronics', 'name' => 'Canon EOS R6 Mark II', 'slug' => 'canon-eos-r6-ii', 'desc' => '24.2MP full-frame mirrorless. 40fps burst, 4K 60p video.', 'price' => 1850000, 'brand' => 'Canon', 'views' => 780, 'rating' => 4.8, 'reviews' => 14, 'img' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=600'],
            ['s' => 2, 'cat' => 'phones', 'name' => 'OnePlus 12 256GB', 'slug' => 'oneplus-12', 'desc' => 'Snapdragon 8 Gen 3, 5400mAh, 100W SUPERVOOC charging.', 'price' => 520000, 'brand' => 'OnePlus', 'views' => 1200, 'rating' => 4.5, 'reviews' => 18, 'img' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?q=80&w=600'],

            // ── More fashion (store 1) ──
            ['s' => 1, 'cat' => 'fashion', 'name' => 'Handmade Beaded Necklace', 'slug' => 'handmade-beaded-necklace', 'desc' => 'Colorful African bead necklace. Handcrafted by local artisans.', 'price' => 12000, 'brand' => 'Artisan Cameroon', 'views' => 1600, 'rating' => 4.5, 'reviews' => 22, 'img' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?q=80&w=600'],

            // ── More home (store 4) ──
            ['s' => 4, 'cat' => 'home_living', 'name' => 'Standing Fan 16"', 'slug' => 'standing-fan-16', 'desc' => 'Oscillating pedestal fan. 3 speed settings. Timer function.', 'price' => 28000, 'brand' => 'Polystar', 'views' => 2800, 'rating' => 4.2, 'reviews' => 35, 'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?q=80&w=600'],
            ['s' => 4, 'cat' => 'kitchen', 'name' => 'Blender 1.5L High Speed', 'slug' => 'blender-15l-high-speed', 'desc' => '600W blender with stainless steel blades. 5 speed settings.', 'price' => 25000, 'brand' => 'Polystar', 'views' => 1900, 'rating' => 4.3, 'reviews' => 28, 'img' => 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?q=80&w=600'],
        ];

        foreach ($products as $p) {
            $old = $p['old'] ?? null;
            $prod = Product::create([
                'store_id'       => $this->store($p['s']),
                'category_id'    => $this->cat($p['cat']),
                'name'           => $p['name'],
                'slug'           => $p['slug'],
                'description'    => $p['desc'],
                'price'          => $p['price'],
                'old_price'      => $old,
                'discount_price' => $old ? (int)($p['price'] * 0.92) : null,
                'stock_status'   => 'in_stock',
                'inventory'      => rand(10, 200),
                'brand'          => $p['brand'] ?? '',
                'sku'            => strtoupper(Str::slug($p['name'], '-')) . '-' . rand(100, 999),
                'is_featured'    => rand(1, 10) <= 3,
                'featured_until' => now()->addDays(rand(7, 30)),
                'approval_status'=> 'approved',
                'status'         => 'published',
                'views'          => $p['views'],
                'rating'         => $p['rating'],
                'review_count'   => $p['reviews'],
                'colors'         => $p['colors'] ?? null,
                'sizes'          => $p['sizes'] ?? null,
            ]);

            ProductImage::create([
                'product_id' => $prod->id,
                'path'       => $p['img'],
                'is_main'    => true,
            ]);
        }
    }

    private function createServices(): void
    {
        $services = [
            // ── Home Services (store 0) ──
            ['s' => 0, 'cat' => 'cleaning', 'name' => 'Professional Cleaning Service', 'slug' => 'professional-cleaning-service', 'desc' => 'Deep cleaning for homes and offices. Eco-friendly products.', 'price' => 25000, 'time' => '2-4 hours', 'views' => 560, 'rating' => 4.4, 'reviews' => 12, 'img' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=600'],
            ['s' => 0, 'cat' => 'plumbing', 'name' => 'Plumbing Repair Service', 'slug' => 'plumbing-repair', 'desc' => 'Expert plumbing repairs, installations and maintenance.', 'price' => 15000, 'time' => '1-3 hours', 'views' => 340, 'rating' => 4.3, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1585704032915-c142f75c4e1d?q=80&w=600'],
            ['s' => 0, 'cat' => 'electrical', 'name' => 'Electrical Installation & Repair', 'slug' => 'electrical-installation', 'desc' => 'Licensed electrician for all residential and commercial needs.', 'price' => 20000, 'time' => '2-6 hours', 'views' => 420, 'rating' => 4.5, 'reviews' => 15, 'img' => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?q=80&w=600'],

            // ── Professional Services (store 2) ──
            ['s' => 2, 'cat' => 'prof_services', 'name' => 'IT Support & Consulting', 'slug' => 'it-support-consulting', 'desc' => 'Expert IT support for businesses. Network setup, security, cloud.', 'price' => 15000, 'time' => '1-24 hours', 'views' => 320, 'rating' => 4.8, 'reviews' => 24, 'img' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=600'],
            ['s' => 2, 'cat' => 'prof_services', 'name' => 'Web Design & Development', 'slug' => 'web-design-development', 'desc' => 'Custom websites, e-commerce, CMS. Responsive and SEO-friendly.', 'price' => 150000, 'time' => '7-21 days', 'views' => 560, 'rating' => 4.6, 'reviews' => 18, 'img' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=600'],
            ['s' => 2, 'cat' => 'prof_services', 'name' => 'Digital Marketing Agency', 'slug' => 'digital-marketing', 'desc' => 'Social media management, Google ads, content creation.', 'price' => 80000, 'time' => '30 days', 'views' => 450, 'rating' => 4.4, 'reviews' => 14, 'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?q=80&w=600'],
            ['s' => 2, 'cat' => 'prof_services', 'name' => 'Graphic Design Service', 'slug' => 'graphic-design', 'desc' => 'Logos, branding, flyers, business cards. Adobe Creative Suite.', 'price' => 25000, 'time' => '2-5 days', 'views' => 780, 'rating' => 4.7, 'reviews' => 32, 'img' => 'https://images.unsplash.com/photo-1626785774625-ddcddc3445e9?q=80&w=600'],

            // ── Events (store 6) ──
            ['s' => 6, 'cat' => 'events', 'name' => 'Wedding Photography Package', 'slug' => 'wedding-photography', 'desc' => 'Full-day wedding coverage. 500+ edited photos. Albums included.', 'price' => 250000, 'time' => '1 day', 'views' => 1200, 'rating' => 4.8, 'reviews' => 28, 'img' => 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=600'],
            ['s' => 6, 'cat' => 'events', 'name' => 'DJ & Sound System Rental', 'slug' => 'dj-sound-system-rental', 'desc' => 'Professional DJ with full sound system. LED lights included.', 'price' => 150000, 'time' => '1 night', 'views' => 980, 'rating' => 4.6, 'reviews' => 22, 'img' => 'https://images.unsplash.com/photo-1571266028243-e4733b0f0bb0?q=80&w=600'],
            ['s' => 6, 'cat' => 'events', 'name' => 'Event Catering Service', 'slug' => 'event-catering', 'desc' => 'Buffet and plated meals for events. African and continental cuisine.', 'price' => 8000, 'time' => 'Per head', 'views' => 1500, 'rating' => 4.7, 'reviews' => 35, 'img' => 'https://images.unsplash.com/photo-1555244162-803834f70033?q=80&w=600'],
            ['s' => 6, 'cat' => 'events', 'name' => 'Birthday Party Planning', 'slug' => 'birthday-party-planning', 'desc' => 'Complete birthday party organization. Decorations, cake, entertainment.', 'price' => 100000, 'time' => '1 day', 'views' => 890, 'rating' => 4.5, 'reviews' => 18, 'img' => 'https://images.unsplash.com/photo-1530103862676-de8c9debad1d?q=80&w=600'],
            ['s' => 6, 'cat' => 'events', 'name' => 'Corporate Event Photography', 'slug' => 'corporate-event-photo', 'desc' => 'Professional photography for conferences, launches, galas.', 'price' => 120000, 'time' => '1 day', 'views' => 670, 'rating' => 4.6, 'reviews' => 15, 'img' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=600'],
            ['s' => 6, 'cat' => 'events', 'name' => 'Videography & Film Production', 'slug' => 'videography-film', 'desc' => 'Short films, music videos, documentaries. 4K production.', 'price' => 200000, 'time' => '2-14 days', 'views' => 560, 'rating' => 4.7, 'reviews' => 12, 'img' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=600'],

            // ── Wellness (store 7) ──
            ['s' => 7, 'cat' => 'health', 'name' => 'Personal Training Sessions', 'slug' => 'personal-training', 'desc' => 'One-on-one fitness coaching. Customized workout plans.', 'price' => 15000, 'time' => '1 hour', 'views' => 1300, 'rating' => 4.5, 'reviews' => 25, 'img' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?q=80&w=600'],
            ['s' => 7, 'cat' => 'health', 'name' => 'Swedish Massage Therapy', 'slug' => 'swedish-massage', 'desc' => 'Full body relaxation massage. Aromatherapy included.', 'price' => 25000, 'time' => '1.5 hours', 'views' => 1100, 'rating' => 4.8, 'reviews' => 30, 'img' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=600'],
            ['s' => 7, 'cat' => 'health', 'name' => 'Nutrition Consultation', 'slug' => 'nutrition-consultation', 'desc' => 'Personalized diet plans. Weight management, meal prep guidance.', 'price' => 20000, 'time' => '45 min', 'views' => 780, 'rating' => 4.4, 'reviews' => 18, 'img' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=600'],
            ['s' => 7, 'cat' => 'health', 'name' => 'Yoga Classes (Group)', 'slug' => 'yoga-classes-group', 'desc' => 'Morning and evening yoga sessions. All levels welcome.', 'price' => 5000, 'time' => '1 hour', 'views' => 920, 'rating' => 4.6, 'reviews' => 22, 'img' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=600'],
            ['s' => 7, 'cat' => 'health', 'name' => 'Deep Tissue Massage', 'slug' => 'deep-tissue-massage', 'desc' => 'Therapeutic massage for chronic pain and muscle recovery.', 'price' => 30000, 'time' => '1 hour', 'views' => 650, 'rating' => 4.7, 'reviews' => 16, 'img' => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?q=80&w=600'],
            ['s' => 7, 'cat' => 'health', 'name' => 'Prenatal Fitness Program', 'slug' => 'prenatal-fitness', 'desc' => 'Safe exercise programs for expecting mothers. Certified trainers.', 'price' => 25000, 'time' => 'Per month', 'views' => 430, 'rating' => 4.9, 'reviews' => 10, 'img' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=600'],

            // ── More home services (store 4) ──
            ['s' => 4, 'cat' => 'home_services', 'name' => 'House Painting Service', 'slug' => 'house-painting', 'desc' => 'Interior and exterior painting. Free consultation and quote.', 'price' => 50000, 'time' => '1-3 days', 'views' => 890, 'rating' => 4.3, 'reviews' => 14, 'img' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?q=80&w=600'],
            ['s' => 4, 'cat' => 'home_services', 'name' => 'Carpentry & Furniture Repair', 'slug' => 'carpentry-repair', 'desc' => 'Custom furniture, repairs, installations. 15+ years experience.', 'price' => 20000, 'time' => '1-5 days', 'views' => 560, 'rating' => 4.4, 'reviews' => 11, 'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?q=80&w=600'],

            // ── More professional services (store 2) ──
            ['s' => 2, 'cat' => 'prof_services', 'name' => 'Accounting & Tax Filing', 'slug' => 'accounting-tax', 'desc' => 'Bookkeeping, financial statements, tax returns. SME specialist.', 'price' => 50000, 'time' => 'Monthly', 'views' => 680, 'rating' => 4.5, 'reviews' => 20, 'img' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?q=80&w=600'],
            ['s' => 2, 'cat' => 'prof_services', 'name' => 'Legal Consultation Service', 'slug' => 'legal-consultation', 'desc' => 'Business law, contracts, intellectual property. Licensed attorney.', 'price' => 30000, 'time' => '1 hour', 'views' => 450, 'rating' => 4.6, 'reviews' => 12, 'img' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?q=80&w=600'],

            // ── More events (store 6) ──
            ['s' => 6, 'cat' => 'events', 'name' => 'Conference Room Rental', 'slug' => 'conference-room-rental', 'desc' => 'Fully equipped meeting room. Projector, WiFi, catering available.', 'price' => 50000, 'time' => 'Per day', 'views' => 380, 'rating' => 4.3, 'reviews' => 10, 'img' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600'],

            // ── More cleaning (store 0) ──
            ['s' => 0, 'cat' => 'cleaning', 'name' => 'Carpet & Upholstery Cleaning', 'slug' => 'carpet-cleaning', 'desc' => 'Steam cleaning for carpets, sofas and curtains. Deep stain removal.', 'price' => 30000, 'time' => '2-4 hours', 'views' => 420, 'rating' => 4.5, 'reviews' => 16, 'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?q=80&w=600'],
            ['s' => 0, 'cat' => 'cleaning', 'name' => 'Window & Glass Cleaning', 'slug' => 'window-glass-cleaning', 'desc' => 'High-rise and ground-level window cleaning. Streak-free finish.', 'price' => 15000, 'time' => '1-2 hours', 'views' => 280, 'rating' => 4.2, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=600'],

            // ── More fitness (store 7) ──
            ['s' => 7, 'cat' => 'health', 'name' => 'Boxing Training Program', 'slug' => 'boxing-training', 'desc' => 'Learn boxing fundamentals. Cardio and strength combined.', 'price' => 20000, 'time' => 'Per month', 'views' => 750, 'rating' => 4.6, 'reviews' => 19, 'img' => 'https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?q=80&w=600'],
            ['s' => 7, 'cat' => 'health', 'name' => 'Detox & Wellness Retreat', 'slug' => 'detox-wellness-retreat', 'desc' => '3-day wellness retreat. Juice cleanses, meditation, yoga.', 'price' => 150000, 'time' => '3 days', 'views' => 520, 'rating' => 4.8, 'reviews' => 14, 'img' => 'https://images.unsplash.com/photo-1545389336-cf090694435e?q=80&w=600'],

            // ── More construction (store 4) ──
            ['s' => 4, 'cat' => 'construction', 'name' => 'Tiling & Waterproofing', 'slug' => 'tiling-waterproofing', 'desc' => 'Professional tiling for bathrooms, kitchens. Waterproofing included.', 'price' => 35000, 'time' => '1-5 days', 'views' => 670, 'rating' => 4.4, 'reviews' => 13, 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600'],

            // ── More auto (store 5) ──
            ['s' => 5, 'cat' => 'auto', 'name' => 'Car Detailing Service', 'slug' => 'car-detailing', 'desc' => 'Full interior and exterior detailing. Paint correction and ceramic coating.', 'price' => 45000, 'time' => '4-6 hours', 'views' => 1100, 'rating' => 4.7, 'reviews' => 28, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 5, 'cat' => 'auto', 'name' => 'AC Repair & Gas Refill', 'slug' => 'car-ac-repair', 'desc' => 'Automotive AC diagnosis, repair and refrigerant recharge.', 'price' => 25000, 'time' => '1-3 hours', 'views' => 890, 'rating' => 4.3, 'reviews' => 16, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 5, 'cat' => 'auto', 'name' => 'Wheel Alignment & Balancing', 'slug' => 'wheel-alignment', 'desc' => 'Computerized wheel alignment and tire balancing.', 'price' => 10000, 'time' => '30-60 min', 'views' => 1200, 'rating' => 4.4, 'reviews' => 32, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],

            // ── More beauty (store 1) ──
            ['s' => 1, 'cat' => 'beauty', 'name' => 'Bridal Makeup & Styling', 'slug' => 'bridal-makeup-styling', 'desc' => 'Professional bridal makeup, hair styling and accessories.', 'price' => 80000, 'time' => '3-4 hours', 'views' => 1400, 'rating' => 4.8, 'reviews' => 26, 'img' => 'https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?q=80&w=600'],
            ['s' => 1, 'cat' => 'beauty', 'name' => 'Hair Braiding & Styling', 'slug' => 'hair-braiding-styling', 'desc' => 'Box braids, cornrows, twists, locs. All styles and lengths.', 'price' => 15000, 'time' => '2-6 hours', 'views' => 2800, 'rating' => 4.6, 'reviews' => 65, 'img' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?q=80&w=600'],
            ['s' => 1, 'cat' => 'beauty', 'name' => 'Manicure & Pedicure Spa', 'slug' => 'manicure-pedicure-spa', 'desc' => 'Gel nails, nail art, luxury pedicure. Long-lasting results.', 'price' => 12000, 'time' => '1-2 hours', 'views' => 1900, 'rating' => 4.5, 'reviews' => 42, 'img' => 'https://images.unsplash.com/photo-1604654894610-df63bc536371?q=80&w=600'],

            // ── Additional services ──
            ['s' => 3, 'cat' => 'home_services', 'name' => 'Catering for Small Events', 'slug' => 'catering-small-events', 'desc' => 'Buffet setup for 20-100 guests. Traditional Cameroonian dishes.', 'price' => 10000, 'time' => 'Per head', 'views' => 1800, 'rating' => 4.9, 'reviews' => 45, 'img' => 'https://images.unsplash.com/photo-1555244162-803834f70033?q=80&w=600'],
            ['s' => 6, 'cat' => 'events', 'name' => 'Photo Booth Rental', 'slug' => 'photo-booth-rental', 'desc' => 'Fun photo booth with props. Instant prints. Custom backdrop.', 'price' => 80000, 'time' => '4 hours', 'views' => 720, 'rating' => 4.5, 'reviews' => 16, 'img' => 'https://images.unsplash.com/photo-1496024840928-4c417adf211d?q=80&w=600'],
            ['s' => 0, 'cat' => 'home_services', 'name' => 'Home Security Installation', 'slug' => 'home-security', 'desc' => 'CCTV cameras, alarm systems, smart locks. Free consultation.', 'price' => 100000, 'time' => '1-2 days', 'views' => 560, 'rating' => 4.6, 'reviews' => 14, 'img' => 'https://images.unsplash.com/photo-1558002038-1055907df827?q=80&w=600'],
            ['s' => 2, 'cat' => 'prof_services', 'name' => 'Data Entry & Virtual Assistant', 'slug' => 'data-entry-va', 'desc' => 'Fast and accurate data entry. Email management, scheduling.', 'price' => 8000, 'time' => 'Per hour', 'views' => 340, 'rating' => 4.3, 'reviews' => 12, 'img' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=600'],
            ['s' => 7, 'cat' => 'health', 'name' => 'Zumba Fitness Classes', 'slug' => 'zumba-classes', 'desc' => 'Fun dance-based workouts. All fitness levels. Group sessions.', 'price' => 3000, 'time' => '1 hour', 'views' => 680, 'rating' => 4.4, 'reviews' => 20, 'img' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?q=80&w=600'],
            ['s' => 5, 'cat' => 'auto', 'name' => 'Windshield Replacement', 'slug' => 'windshield-replacement', 'desc' => 'OEM and aftermarket windshields. All car models. Mobile service.', 'price' => 80000, 'time' => '1-2 hours', 'views' => 450, 'rating' => 4.5, 'reviews' => 10, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 4, 'cat' => 'home_services', 'name' => 'Fence & Gate Installation', 'slug' => 'fence-gate-install', 'desc' => 'Metal and wood fencing. Automatic gate systems.', 'price' => 80000, 'time' => '2-5 days', 'views' => 340, 'rating' => 4.3, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600'],
            ['s' => 1, 'cat' => 'beauty', 'name' => 'Men\'s Grooming & Barber', 'slug' => 'mens-grooming-barber', 'desc' => 'Precision haircuts, beard shaping, hot towel shave.', 'price' => 5000, 'time' => '30-60 min', 'views' => 3200, 'rating' => 4.7, 'reviews' => 78, 'img' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?q=80&w=600'],
            ['s' => 6, 'cat' => 'events', 'name' => 'Live Band Booking', 'slug' => 'live-band-booking', 'desc' => 'Professional live bands for events. Jazz, Afrobeat, R&B.', 'price' => 200000, 'time' => '3 hours', 'views' => 480, 'rating' => 4.6, 'reviews' => 10, 'img' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?q=80&w=600'],
            ['s' => 0, 'cat' => 'home_services', 'name' => 'Appliance Repair Service', 'slug' => 'appliance-repair', 'desc' => 'Refrigerator, washing machine, microwave repairs. All brands.', 'price' => 15000, 'time' => '1-3 hours', 'views' => 780, 'rating' => 4.4, 'reviews' => 20, 'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?q=80&w=600'],
        ];

        foreach ($services as $svc) {
            $service = Service::create([
                'store_id'        => $this->store($svc['s']),
                'category_id'     => $this->cat($svc['cat']),
                'name'            => $svc['name'],
                'slug'            => $svc['slug'],
                'description'     => $svc['desc'],
                'starting_price'  => $svc['price'],
                'delivery_time'   => $svc['time'],
                'status'          => 'active',
                'views'           => $svc['views'],
                'rating'          => $svc['rating'],
                'review_count'    => $svc['reviews'],
                'approval_status' => 'approved',
            ]);

            ServiceImage::create([
                'service_id' => $service->id,
                'path'       => $svc['img'],
                'is_main'    => true,
            ]);

            // Create 3 packages for each service
            $base = $svc['price'];
            ServicePackage::create([
                'service_id'     => $service->id,
                'name'           => 'Basic',
                'description'    => 'Standard package',
                'price'          => $base,
                'delivery_days'  => 1,
                'features'       => ['Core service delivery', 'Standard support', '1 revision'],
            ]);
            ServicePackage::create([
                'service_id'     => $service->id,
                'name'           => 'Standard',
                'description'    => 'Enhanced package',
                'price'          => (int)($base * 1.8),
                'delivery_days'  => 2,
                'features'       => ['Everything in Basic', 'Priority support', '3 revisions', 'Follow-up'],
            ]);
            ServicePackage::create([
                'service_id'     => $service->id,
                'name'           => 'Premium',
                'description'    => 'Complete package',
                'price'          => (int)($base * 3),
                'delivery_days'  => 3,
                'features'       => ['Everything in Standard', '24/7 support', 'Unlimited revisions', 'Free follow-up', 'Guarantee'],
            ]);
        }
    }

    private function createRentals(): void
    {
        $rentals = [
            // ── Events & Media (store 6) ──
            ['s' => 6, 'name' => 'Canon EOS R5 Camera Kit', 'slug' => 'canon-eos-r5-kit', 'desc' => 'Mirrorless camera with 24-105mm lens. 45MP, 8K video.', 'rate' => 35000, 'unit' => 'daily', 'deposit' => 250000, 'loc' => 'Yaoundé', 'views' => 680, 'rating' => 4.6, 'reviews' => 14, 'img' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=600'],
            ['s' => 6, 'name' => 'DJ Sound System Full Setup', 'slug' => 'dj-sound-system-full', 'desc' => '2 speakers, mixer, 2 microphones, LED lighting. Professional grade.', 'rate' => 50000, 'unit' => 'daily', 'deposit' => 100000, 'loc' => 'Yaoundé', 'views' => 420, 'rating' => 4.2, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1571266028243-e4733b0f0bb0?q=80&w=600'],
            ['s' => 6, 'name' => 'Professional Tripod + Gimbal', 'slug' => 'tripod-gimbal-set', 'desc' => 'Manfrotto tripod + DJI Ronin gimbal. For video production.', 'rate' => 15000, 'unit' => 'daily', 'deposit' => 80000, 'loc' => 'Yaoundé', 'views' => 320, 'rating' => 4.5, 'reviews' => 10, 'img' => 'https://images.unsplash.com/photo-1617005082133-548c4dd27f35?q=80&w=600'],
            ['s' => 6, 'name' => 'LED Video Light Kit (3-Point)', 'slug' => 'led-video-light-kit', 'desc' => '3 LED panels with stands. Bi-color, dimmable. For studio shoots.', 'rate' => 20000, 'unit' => 'daily', 'deposit' => 60000, 'loc' => 'Yaoundé', 'views' => 280, 'rating' => 4.4, 'reviews' => 7, 'img' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=600'],
            ['s' => 6, 'name' => 'Portable PA System', 'slug' => 'portable-pa-system', 'desc' => 'Wireless microphone, speaker, stand. Perfect for small events.', 'rate' => 25000, 'unit' => 'daily', 'deposit' => 50000, 'loc' => 'Yaoundé', 'views' => 450, 'rating' => 4.3, 'reviews' => 9, 'img' => 'https://images.unsplash.com/photo-1571266028243-e4733b0f0bb0?q=80&w=600'],
            ['s' => 6, 'name' => 'Projector & Screen Bundle', 'slug' => 'projector-screen-bundle', 'desc' => '5000 lumens projector + 120" tripod screen. HDMI, USB.', 'rate' => 30000, 'unit' => 'daily', 'deposit' => 80000, 'loc' => 'Yaoundé', 'views' => 380, 'rating' => 4.5, 'reviews' => 11, 'img' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?q=80&w=600'],
            ['s' => 6, 'name' => 'Fog Machine + Laser Set', 'slug' => 'fog-machine-laser', 'desc' => 'Stage fog machine with RGB laser effects. Remote controlled.', 'rate' => 20000, 'unit' => 'daily', 'deposit' => 40000, 'loc' => 'Yaoundé', 'views' => 210, 'rating' => 4.1, 'reviews' => 5, 'img' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=600'],

            // ── Electronics (store 0) ──
            ['s' => 0, 'name' => 'MacBook Pro 14" (Rental)', 'slug' => 'macbook-pro-rental', 'desc' => 'M3 Pro, 18GB RAM. For short-term professional use.', 'rate' => 25000, 'unit' => 'daily', 'deposit' => 300000, 'loc' => 'Douala', 'views' => 560, 'rating' => 4.7, 'reviews' => 12, 'img' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?q=80&w=600'],
            ['s' => 0, 'name' => 'DJI Mavic 3 Drone', 'slug' => 'dji-mavic-3-rental', 'desc' => '4/3 CMOS Hasselblad camera. 46-min flight. With extra batteries.', 'rate' => 40000, 'unit' => 'daily', 'deposit' => 500000, 'loc' => 'Douala', 'views' => 340, 'rating' => 4.8, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1527977966376-1c8408f9f108?q=80&w=600'],
            ['s' => 0, 'name' => 'Sony A7IV Camera Kit', 'slug' => 'sony-a7iv-kit', 'desc' => 'Full-frame mirrorless with 24-70mm f/2.8 lens.', 'rate' => 30000, 'unit' => 'daily', 'deposit' => 200000, 'loc' => 'Douala', 'views' => 420, 'rating' => 4.6, 'reviews' => 10, 'img' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=600'],
            ['s' => 0, 'name' => 'GoPro Hero 12 Black', 'slug' => 'gopro-hero-12', 'desc' => 'Action camera. 5.3K waterproof. With accessories kit.', 'rate' => 15000, 'unit' => 'daily', 'deposit' => 80000, 'loc' => 'Douala', 'views' => 670, 'rating' => 4.5, 'reviews' => 15, 'img' => 'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?q=80&w=600'],
            ['s' => 0, 'name' => 'Portable Bluetooth Speaker JBL', 'slug' => 'jbl-speaker-rental', 'desc' => 'JBL PartyBox 310. 240W output. Lights, microphone included.', 'rate' => 12000, 'unit' => 'daily', 'deposit' => 40000, 'loc' => 'Douala', 'views' => 380, 'rating' => 4.3, 'reviews' => 12, 'img' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?q=80&w=600'],

            // ── Tech (store 2) ──
            ['s' => 2, 'name' => 'Gaming Laptop (RTX 4070)', 'slug' => 'gaming-laptop-rental', 'desc' => 'ASUS ROG Strix. i7, 32GB RAM, RTX 4070. For events and testing.', 'rate' => 20000, 'unit' => 'daily', 'deposit' => 150000, 'loc' => 'Bamenda', 'views' => 280, 'rating' => 4.4, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1603302576837-37561b2e2302?q=80&w=600'],
            ['s' => 2, 'name' => 'Printer & Scanner Combo', 'slug' => 'printer-scanner-rental', 'desc' => 'HP LaserJet Pro MFP. Print, scan, copy. Toner included.', 'rate' => 8000, 'unit' => 'daily', 'deposit' => 30000, 'loc' => 'Bamenda', 'views' => 190, 'rating' => 4.2, 'reviews' => 6, 'img' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?q=80&w=600'],
            ['s' => 2, 'name' => 'Presentation Clicker + Pointer', 'slug' => 'presentation-clicker', 'desc' => 'Logitech Spotlight presenter. Laser pointer, slide control.', 'rate' => 3000, 'unit' => 'daily', 'deposit' => 10000, 'loc' => 'Bamenda', 'views' => 150, 'rating' => 4.3, 'reviews' => 5, 'img' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=600'],

            // ── Fitness (store 7) ──
            ['s' => 7, 'name' => 'Adjustable Dumbbell Set', 'slug' => 'adjustable-dumbbells', 'desc' => '2-20kg adjustable per dumbbell. Space-saving design.', 'rate' => 5000, 'unit' => 'daily', 'deposit' => 20000, 'loc' => 'Limbe', 'views' => 320, 'rating' => 4.4, 'reviews' => 9, 'img' => 'https://images.unsplash.com/photo-1638536532686-d610adfc8e5c?q=80&w=600'],
            ['s' => 7, 'name' => 'Spin Bike (Exercise)', 'slug' => 'spin-bike-rental', 'desc' => 'Professional spin bike. Adjustable seat, digital display.', 'rate' => 8000, 'unit' => 'daily', 'deposit' => 30000, 'loc' => 'Limbe', 'views' => 210, 'rating' => 4.3, 'reviews' => 7, 'img' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=600'],
            ['s' => 7, 'name' => 'Yoga Equipment Set', 'slug' => 'yoga-equipment-set', 'desc' => 'Mat, blocks, strap, bolster. Complete yoga kit.', 'rate' => 3000, 'unit' => 'daily', 'deposit' => 10000, 'loc' => 'Limbe', 'views' => 180, 'rating' => 4.5, 'reviews' => 6, 'img' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?q=80&w=600'],
            ['s' => 7, 'name' => 'Folding Treadmill', 'slug' => 'folding-treadmill-rental', 'desc' => 'Compact folding treadmill. 10 speed, incline settings.', 'rate' => 10000, 'unit' => 'daily', 'deposit' => 40000, 'loc' => 'Limbe', 'views' => 260, 'rating' => 4.2, 'reviews' => 5, 'img' => 'https://images.unsplash.com/photo-1576678927484-cc907957088c?q=80&w=600'],

            // ── Auto (store 5) ──
            ['s' => 5, 'name' => 'Car Diagnostic Scanner', 'slug' => 'car-diagnostic-scanner', 'desc' => 'Professional OBD2 diagnostic tool. All car brands.', 'rate' => 8000, 'unit' => 'daily', 'deposit' => 20000, 'loc' => 'Douala', 'views' => 180, 'rating' => 4.4, 'reviews' => 6, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 5, 'name' => 'Hydraulic Jack Set', 'slug' => 'hydraulic-jack-set', 'desc' => '3-ton hydraulic jack + stands. For tire changes and maintenance.', 'rate' => 5000, 'unit' => 'daily', 'deposit' => 15000, 'loc' => 'Douala', 'views' => 150, 'rating' => 4.3, 'reviews' => 4, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 5, 'name' => 'Impact Wrench Set', 'slug' => 'impact-wrench-set', 'desc' => 'Cordless impact wrench + sockets. For wheel removal.', 'rate' => 6000, 'unit' => 'daily', 'deposit' => 20000, 'loc' => 'Douala', 'views' => 120, 'rating' => 4.2, 'reviews' => 3, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],

            // ── Construction (store 4) ──
            ['s' => 4, 'name' => 'Concrete Mixer (Electric)', 'slug' => 'concrete-mixer-rental', 'desc' => '200L electric cement mixer. For construction sites.', 'rate' => 15000, 'unit' => 'daily', 'deposit' => 50000, 'loc' => 'Kribi', 'views' => 280, 'rating' => 4.3, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600'],
            ['s' => 4, 'name' => 'Scaffolding Set', 'slug' => 'scaffolding-set', 'desc' => 'Modular scaffolding. 6m height. Steel construction.', 'rate' => 25000, 'unit' => 'daily', 'deposit' => 100000, 'loc' => 'Kribi', 'views' => 190, 'rating' => 4.2, 'reviews' => 5, 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600'],
            ['s' => 4, 'name' => 'Tile Cutter (Electric)', 'slug' => 'tile-cutter-rental', 'desc' => 'Professional wet tile cutter. Cuts up to 1200mm.', 'rate' => 8000, 'unit' => 'daily', 'deposit' => 25000, 'loc' => 'Kribi', 'views' => 140, 'rating' => 4.4, 'reviews' => 4, 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600'],
            ['s' => 4, 'name' => 'Welding Machine (Arc)', 'slug' => 'welding-machine-rental', 'desc' => '300A arc welding machine. Electrodes included.', 'rate' => 10000, 'unit' => 'daily', 'deposit' => 30000, 'loc' => 'Kribi', 'views' => 160, 'rating' => 4.1, 'reviews' => 3, 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600'],

            // ── Organic Farm (store 3) ──
            ['s' => 3, 'name' => 'Garden Tool Set', 'slug' => 'garden-tool-set', 'desc' => 'Shovel, rake, hoe, pruners. Complete garden maintenance kit.', 'rate' => 5000, 'unit' => 'daily', 'deposit' => 10000, 'loc' => 'Douala', 'views' => 220, 'rating' => 4.5, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?q=80&w=600'],
            ['s' => 3, 'name' => 'Wheelbarrow (Heavy Duty)', 'slug' => 'wheelbarrow-rental', 'desc' => '100L steel wheelbarrow. For farm and garden work.', 'rate' => 3000, 'unit' => 'daily', 'deposit' => 8000, 'loc' => 'Douala', 'views' => 180, 'rating' => 4.2, 'reviews' => 5, 'img' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?q=80&w=600'],

            // ── Additional rentals ──
            ['s' => 6, 'name' => 'Wedding Arch & Decor Set', 'slug' => 'wedding-arch-decor', 'desc' => 'Floral arch, fairy lights, table centerpieces. Full setup.', 'rate' => 80000, 'unit' => 'daily', 'deposit' => 100000, 'loc' => 'Yaoundé', 'views' => 560, 'rating' => 4.7, 'reviews' => 12, 'img' => 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=600'],
            ['s' => 0, 'name' => '4K Camcorder + Accessories', 'slug' => '4k-camcorder-kit', 'desc' => 'Sony FX30 cinema camera. With tripod, mic, lights.', 'rate' => 45000, 'unit' => 'daily', 'deposit' => 300000, 'loc' => 'Douala', 'views' => 290, 'rating' => 4.6, 'reviews' => 7, 'img' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=600'],
            ['s' => 7, 'name' => 'Punching Bag + Gloves Set', 'slug' => 'punching-bag-set', 'desc' => 'Heavy bag (60lb) + boxing gloves + wraps. Complete boxing kit.', 'rate' => 5000, 'unit' => 'daily', 'deposit' => 15000, 'loc' => 'Limbe', 'views' => 150, 'rating' => 4.3, 'reviews' => 4, 'img' => 'https://images.unsplash.com/photo-1549719386-74dfcbf7dbed?q=80&w=600'],
            ['s' => 2, 'name' => 'VR Headset - Meta Quest 3', 'slug' => 'meta-quest-3-rental', 'desc' => 'Latest VR headset. Great for events and demos.', 'rate' => 15000, 'unit' => 'daily', 'deposit' => 80000, 'loc' => 'Bamenda', 'views' => 380, 'rating' => 4.5, 'reviews' => 9, 'img' => 'https://images.unsplash.com/photo-1622979135225-d2ba269cf1ac?q=80&w=600'],
            ['s' => 5, 'name' => 'Car Battery Charger', 'slug' => 'car-battery-charger', 'desc' => 'Automatic battery charger/maintainer. 12V/24V dual mode.', 'rate' => 3000, 'unit' => 'daily', 'deposit' => 10000, 'loc' => 'Douala', 'views' => 130, 'rating' => 4.2, 'reviews' => 3, 'img' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600'],
            ['s' => 4, 'name' => 'Generator 5KVA (Silent)', 'slug' => 'generator-5kva-silent', 'desc' => 'Quiet inverter generator. 8 hours runtime. Fuel efficient.', 'rate' => 12000, 'unit' => 'daily', 'deposit' => 40000, 'loc' => 'Kribi', 'views' => 340, 'rating' => 4.4, 'reviews' => 10, 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600'],
            ['s' => 1, 'name' => 'Photography Backdrop Set', 'slug' => 'photo-backdrop-set', 'desc' => '3m x 6m backdrop stand + 5 colored muslin backgrounds.', 'rate' => 10000, 'unit' => 'daily', 'deposit' => 20000, 'loc' => 'Yaoundé', 'views' => 260, 'rating' => 4.3, 'reviews' => 6, 'img' => 'https://images.unsplash.com/photo-1496024840928-4c417adf211d?q=80&w=600'],
            ['s' => 6, 'name' => 'Catering Chafing Dish Set (10)', 'slug' => 'chafing-dish-set', 'desc' => 'Stainless steel chafing dishes with fuel. Full buffet setup.', 'rate' => 20000, 'unit' => 'daily', 'deposit' => 30000, 'loc' => 'Yaoundé', 'views' => 310, 'rating' => 4.4, 'reviews' => 8, 'img' => 'https://images.unsplash.com/photo-1555244162-803834f70033?q=80&w=600'],
            ['s' => 0, 'name' => 'iPad Pro 12.9" + Pencil', 'slug' => 'ipad-pro-rental', 'desc' => 'M2 chip, 256GB, Wi-Fi. With Apple Pencil 2nd gen.', 'rate' => 18000, 'unit' => 'daily', 'deposit' => 150000, 'loc' => 'Douala', 'views' => 420, 'rating' => 4.7, 'reviews' => 11, 'img' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?q=80&w=600'],
            ['s' => 2, 'name' => 'Laser Printer (Color)', 'slug' => 'laser-printer-rental', 'desc' => 'HP Color LaserJet Pro. Fast printing for events and offices.', 'rate' => 6000, 'unit' => 'daily', 'deposit' => 20000, 'loc' => 'Bamenda', 'views' => 170, 'rating' => 4.3, 'reviews' => 5, 'img' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?q=80&w=600'],
            ['s' => 7, 'name' => 'Massage Chair (Portable)', 'slug' => 'massage-chair-rental', 'desc' => 'Professional portable massage chair. Adjustable, padded.', 'rate' => 12000, 'unit' => 'daily', 'deposit' => 25000, 'loc' => 'Limbe', 'views' => 140, 'rating' => 4.5, 'reviews' => 4, 'img' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=600'],
        ];

        foreach ($rentals as $r) {
            RentalItem::create([
                'store_id'          => $this->store($r['s']),
                'name'              => $r['name'],
                'slug'              => $r['slug'],
                'description'       => $r['desc'],
                'rate'              => $r['rate'],
                'billing_unit'      => $r['unit'],
                'deposit'           => $r['deposit'],
                'images'            => [$r['img']],
                'return_conditions' => 'Return in same condition. Damage fee applies if item is damaged.',
                'duration_rules'    => 'Minimum 1 day rental. Late returns charged at 1.5x daily rate.',
                'location'          => $r['loc'] . ', Cameroon',
                'status'            => 'published',
                'rating'            => $r['rating'],
                'review_count'      => $r['reviews'],
                'views'             => $r['views'],
            ]);
        }
    }

    private function createMiscData(): void
    {
        $buyer = User::where('email', 'buyer@izifai.com')->first();

        // Payment Methods
        PaymentMethod::create([
            'name' => 'MTN Mobile Money', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2c/MTN_Group_logo.svg/256px-MTN_Group_logo.svg.png',
            'number' => '+237670000000', 'account_name' => 'IZIFAI Marketplace', 'is_active' => true,
        ]);
        PaymentMethod::create([
            'name' => 'Orange Money', 'icon' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Orange_Money_logo.svg/256px-Orange_Money_logo.svg.png',
            'number' => '+237690000000', 'account_name' => 'IZIFAI Marketplace', 'is_active' => true,
        ]);

        // Notifications
        $notifications = [
            ['user_id' => $buyer->id, 'type' => 'system', 'title' => 'Welcome to IZIFAI', 'message' => 'Welcome! Start exploring products and services from trusted sellers.'],
            ['user_id' => $buyer->id, 'type' => 'order', 'title' => 'Order Confirmed', 'message' => 'Your order #IZF-001 has been confirmed and is being processed.'],
        ];
        foreach ($notifications as $n) {
            UserNotification::create($n);
        }
    }

    private function updateCounts(): void
    {
        foreach (Product::all() as $p) {
            $p->store->increment('product_count');
        }
        foreach (Service::all() as $s) {
            $s->store->increment('service_count');
        }
    }
}
