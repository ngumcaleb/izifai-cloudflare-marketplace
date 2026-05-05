<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $mainCategories = [
            [
                'name' => 'Electronics',
                'icon' => 'M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z',
                'image_path' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=600',
            ],
            [
                'name' => 'Fashion',
                'icon' => 'M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.703 2.703 0 01-3 0 2.705 2.705 0 01-3 0 2.703 2.703 0 01-3 0 2.704 2.704 0 01-1.5-.454M3 8V4h18v4M3 8v10a2 2 0 002 2h14a2 2 0 002-2V8M3 8l9 6 9-6',
                'image_path' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=600',
            ],
            [
                'name' => 'Home & Living',
                'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                'image_path' => 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?q=80&w=600',
            ],
            [
                'name' => 'Beauty',
                'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'image_path' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54c28?q=80&w=600',
            ],
            [
                'name' => 'Auto Parts',
                'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                'image_path' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600',
            ],
            [
                'name' => 'Construction',
                'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
                'image_path' => 'https://images.unsplash.com/photo-1541888086225-f6404f456106?q=80&w=600',
            ],
            [
                'name' => 'Agriculture',
                'icon' => 'M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5a2 2 0 10-2 2h2zm0 0v4l-6 6',
                'image_path' => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?q=80&w=600',
            ],
            [
                'name' => 'Phones & Accessories',
                'icon' => 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z',
                'image_path' => 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbfb?q=80&w=600',
            ]
        ];

        // Seed 8 main categories
        foreach ($mainCategories as $cat) {
            Category::updateOrCreate(['name' => $cat['name']], [
                'slug' => Str::slug($cat['name']),
                'icon' => $cat['icon'],
                'image_path' => $cat['image_path'],
            ]);
        }

        // Additional categories to make it 50
        $additional = [
            'Laptops & Computers', 'Home Audio & Video', 'Cameras & Photo', 'Men\'s Clothing', 'Women\'s Clothing',
            'Shoes & Footwear', 'Bags & Accessories', 'Kitchen Appliances', 'Furniture', 'Home Decor', 'Bedding & Bath',
            'Building Materials', 'Flooring & Tiles', 'Roofing', 'Hardware & Tools', 'Skincare', 'Haircare', 'Makeup',
            'Fragrances', 'Engine Parts', 'Car Electronics', 'Exterior Accessories', 'Interior Accessories',
            'Farming Equipment', 'Fresh Produce', 'Grains & Seeds', 'Poultry & Livestock', 'Industrial Machinery',
            'Packaging & Printing', 'Office Supplies', 'Education & Stationery', 'Electrical Equipment', 'Medical Devices',
            'Protective Gear', 'Vitamins & Supplements', 'Sports & Entertainment', 'Toys & Hobbies', 'Gifts & Crafts',
            'Pet Supplies', 'Lighting & Lamps', 'Renewable Energy', 'Watches & Jewelry'
        ];

        foreach ($additional as $name) {
            Category::updateOrCreate(['name' => $name], [
                'slug' => Str::slug($name),
                'icon' => 'M9 5l7 7-7 7', // generic arrow right
                'image_path' => 'https://images.unsplash.com/photo-1550009158-9ebf6d250400?q=80&w=600',
            ]);
        }
    }
}
