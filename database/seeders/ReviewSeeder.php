<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Service;
use App\Models\ServiceReview;
use App\Models\Store;
use App\Models\StoreReview;
use App\Models\RentalItem;
use App\Models\RentalReview;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    private array $comments = [
        5 => [
            'Excellent product! Exceeded my expectations in every way.',
            'Absolutely love this. Best purchase I have made this year.',
            'Perfect quality and fast delivery. Highly recommended!',
            'Outstanding value for money. Will definitely buy again.',
            'This is exactly what I needed. Five stars all the way!',
            'Amazing quality. The seller was very responsive too.',
            'Super impressed with the build quality. Truly premium.',
            'Works flawlessly. Couldn\'t be happier with my purchase.',
        ],
        4 => [
            'Very good product. Minor issues but overall satisfied.',
            'Great quality for the price. Would recommend to friends.',
            'Almost perfect. Shipping was a bit slow but product is great.',
            'Really nice. Does what it says. Would buy again.',
            'Solid product. Good packaging and fast delivery.',
            'Happy with my purchase. Good value for the price.',
            'Very satisfied. Just a small detail that could be better.',
            'Great product overall. Delivery could be slightly faster.',
        ],
        3 => [
            'Decent product. Not bad but nothing special either.',
            'Average quality. Expected a bit more for the price.',
            'It works but I have seen better. Acceptable overall.',
            'Mixed feelings. Some aspects are good, others not so much.',
            'Okay product. Met basic expectations but didn\'t impress.',
            'Fair for the price. Could use some improvements.',
        ],
        2 => [
            'Below expectations. Quality could be much better.',
            'Not very happy with this purchase. Expected more.',
            'Has some issues. Had to contact support for help.',
        ],
        1 => [
            'Very disappointed. Would not recommend.',
        ],
    ];

    public function run(): void
    {
        $this->seedProductReviews();
        $this->seedServiceReviews();
        $this->seedRentalReviews();
        $this->seedStoreReviews();
        $this->recalculateStats();
    }

    private function seedProductReviews(): void
    {
        $products = Product::all();
        $reviewers = [1, 2, 3];

        foreach ($products as $product) {
            $ownerId = $product->store->user_id;
            $possibleReviewers = array_values(array_filter($reviewers, fn($id) => $id !== $ownerId));

            $count = rand(5, 10);
            $reviews = [];

            for ($i = 0; $i < $count; $i++) {
                $rating = $this->weightedRating();
                $reviews[] = [
                    'product_id' => $product->id,
                    'user_id' => $possibleReviewers[array_rand($possibleReviewers)],
                    'rating' => $rating,
                    'comment' => $this->comments[$rating][array_rand($this->comments[$rating])],
                    'images' => [],
                    'helpful' => 0,
                    'created_at' => Carbon::now()->subDays(rand(1, 90))->subHours(rand(0, 23)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 90))->subHours(rand(0, 23)),
                ];
            }

            ProductReview::insert(array_map(fn($r) => array_merge($r, [
                'images' => json_encode($r['images']),
            ]), $reviews));
            $this->command->info("  Seeded {$count} reviews for product: {$product->name}");
        }
    }

    private function seedServiceReviews(): void
    {
        $services = Service::all();
        $reviewers = [1, 2, 3];

        foreach ($services as $service) {
            $ownerId = $service->store->user_id;
            $possibleReviewers = array_values(array_filter($reviewers, fn($id) => $id !== $ownerId));

            $count = rand(4, 8);
            $reviews = [];

            for ($i = 0; $i < $count; $i++) {
                $rating = $this->weightedRating();
                $reviews[] = [
                    'service_id' => $service->id,
                    'user_id' => $possibleReviewers[array_rand($possibleReviewers)],
                    'rating' => $rating,
                    'comment' => $this->comments[$rating][array_rand($this->comments[$rating])],
                    'images' => [],
                    'helpful' => 0,
                    'created_at' => Carbon::now()->subDays(rand(1, 90))->subHours(rand(0, 23)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 90))->subHours(rand(0, 23)),
                ];
            }

            ServiceReview::insert(array_map(fn($r) => array_merge($r, [
                'images' => json_encode($r['images']),
            ]), $reviews));
            $this->command->info("  Seeded {$count} reviews for service: {$service->name}");
        }
    }

    private function seedRentalReviews(): void
    {
        $rentals = RentalItem::all();
        $reviewers = [1, 2, 3];

        foreach ($rentals as $rental) {
            $ownerId = $rental->store->user_id;
            $possibleReviewers = array_values(array_filter($reviewers, fn($id) => $id !== $ownerId));
            shuffle($possibleReviewers);
            $reviews = [];

            foreach ($possibleReviewers as $reviewerId) {
                $rating = $this->weightedRating();
                $reviews[] = [
                    'rental_item_id' => $rental->id,
                    'user_id' => $reviewerId,
                    'rating' => $rating,
                    'comment' => $this->comments[$rating][array_rand($this->comments[$rating])],
                    'images' => [],
                    'helpful' => 0,
                    'created_at' => Carbon::now()->subDays(rand(1, 90))->subHours(rand(0, 23)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 90))->subHours(rand(0, 23)),
                ];
            }

            RentalReview::insert(array_map(fn($r) => array_merge($r, [
                'images' => json_encode($r['images']),
            ]), $reviews));

            $count = count($reviews);
            $this->command->info("  Seeded {$count} reviews for rental: {$rental->name}");
        }
    }

    private function seedStoreReviews(): void
    {
        $stores = Store::all();
        $reviewers = [1, 2, 3];

        foreach ($stores as $store) {
            $possibleReviewers = array_values(array_filter($reviewers, fn($id) => $id !== $store->user_id));

            $count = rand(3, 6);
            $reviews = [];

            for ($i = 0; $i < $count; $i++) {
                $rating = $this->weightedRating();
                $reviews[] = [
                    'store_id' => $store->id,
                    'user_id' => $possibleReviewers[array_rand($possibleReviewers)],
                    'rating' => $rating,
                    'comment' => $this->comments[$rating][array_rand($this->comments[$rating])],
                    'helpful' => 0,
                    'created_at' => Carbon::now()->subDays(rand(1, 90))->subHours(rand(0, 23)),
                    'updated_at' => Carbon::now()->subDays(rand(1, 90))->subHours(rand(0, 23)),
                ];
            }

            StoreReview::insert($reviews);
            $this->command->info("  Seeded {$count} reviews for store: {$store->name}");
        }
    }

    private function recalculateStats(): void
    {
        foreach (Product::all() as $product) {
            $product->update([
                'rating' => round($product->reviews()->avg('rating'), 1),
                'review_count' => $product->reviews()->count(),
            ]);
        }

        foreach (Service::all() as $service) {
            $service->update([
                'rating' => round($service->reviews()->avg('rating'), 1),
                'review_count' => $service->reviews()->count(),
            ]);
        }

        foreach (RentalItem::all() as $rental) {
            $rental->update([
                'rating' => round($rental->reviews()->avg('rating'), 1),
                'review_count' => $rental->reviews()->count(),
            ]);
        }

        foreach (Store::all() as $store) {
            $store->update([
                'rating' => round($store->reviews()->avg('rating'), 1),
            ]);
        }

        $this->command->info("\nRecalculated all ratings and review counts from actual review data.");
    }

    private function weightedRating(): int
    {
        $rand = mt_rand(1, 100);
        if ($rand <= 50) return 5;
        if ($rand <= 80) return 4;
        if ($rand <= 92) return 3;
        if ($rand <= 97) return 2;
        return 1;
    }
}
