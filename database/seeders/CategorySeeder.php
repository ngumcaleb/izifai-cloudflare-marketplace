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
            ['name' => 'Electronics', 'type' => 'product', 'icon' => 'laptop', 'image_path' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=600',
                'children' => ['Laptops & Computers', 'Home Audio & Video', 'Cameras & Photo']],
            ['name' => 'Fashion', 'type' => 'product', 'icon' => 'tshirt-crew', 'image_path' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=600',
                'children' => ["Men's Clothing", "Women's Clothing", 'Shoes & Footwear', 'Bags & Accessories']],
            ['name' => 'Home & Living', 'type' => 'product', 'icon' => 'home', 'image_path' => 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?q=80&w=600',
                'children' => ['Kitchen Appliances', 'Furniture', 'Home Decor', 'Bedding & Bath']],
            ['name' => 'Beauty', 'type' => 'product', 'icon' => 'sparkles', 'image_path' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54c28?q=80&w=600',
                'children' => ['Skincare', 'Haircare', 'Makeup', 'Fragrances']],
            ['name' => 'Auto Parts', 'type' => 'product', 'icon' => 'car', 'image_path' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=600',
                'children' => ['Engine Parts', 'Car Electronics', 'Exterior Accessories', 'Interior Accessories']],
            ['name' => 'Construction', 'type' => 'product', 'icon' => 'hammer-wrench', 'image_path' => 'https://images.unsplash.com/photo-1541888086225-f6404f456106?q=80&w=600',
                'children' => ['Building Materials', 'Flooring & Tiles', 'Roofing', 'Hardware & Tools']],
            ['name' => 'Agriculture', 'type' => 'product', 'icon' => 'sprout', 'image_path' => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?q=80&w=600',
                'children' => ['Farming Equipment', 'Fresh Produce', 'Grains & Seeds', 'Poultry & Livestock']],
            ['name' => 'Phones & Accessories', 'type' => 'product', 'icon' => 'cellphone', 'image_path' => 'https://images.unsplash.com/photo-1601784551446-20c9e07cdbfb?q=80&w=600',
                'children' => []],
        ];

        $serviceCategories = [
            ['name' => 'Home Services', 'type' => 'service', 'icon' => 'tools', 'image_path' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?q=80&w=600',
                'children' => ['Plumbing', 'Electrical', 'Cleaning', 'Painting']],
            ['name' => 'Professional Services', 'type' => 'service', 'icon' => 'briefcase', 'image_path' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=600',
                'children' => ['Legal', 'Accounting', 'Consulting', 'IT Support']],
            ['name' => 'Health & Wellness', 'type' => 'service', 'icon' => 'heart-pulse', 'image_path' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=600',
                'children' => ['Fitness Training', 'Massage Therapy', 'Nutrition', 'Mental Health']],
            ['name' => 'Events & Photography', 'type' => 'service', 'icon' => 'camera', 'image_path' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?q=80&w=600',
                'children' => ['Event Planning', 'Photography', 'Videography', 'Catering']],
        ];

        $allCategories = array_merge($mainCategories, $serviceCategories);

        foreach ($allCategories as $cat) {
            $parent = Category::updateOrCreate(['name' => $cat['name']], [
                'slug' => Str::slug($cat['name']),
                'icon' => $cat['icon'],
                'image_path' => $cat['image_path'],
                'type' => $cat['type'],
                'parent_id' => null,
            ]);

            foreach ($cat['children'] as $childName) {
                Category::updateOrCreate(['name' => $childName], [
                    'slug' => Str::slug($childName),
                    'icon' => 'chevron-right',
                    'image_path' => 'https://images.unsplash.com/photo-1550009158-9ebf6d250400?q=80&w=600',
                    'type' => $cat['type'],
                    'parent_id' => $parent->id,
                ]);
            }
        }

        // Additional standalone categories
        $additional = [
            'Industrial Machinery', 'Packaging & Printing', 'Office Supplies',
            'Education & Stationery', 'Electrical Equipment', 'Medical Devices',
            'Protective Gear', 'Vitamins & Supplements', 'Sports & Entertainment',
            'Toys & Hobbies', 'Gifts & Crafts', 'Pet Supplies', 'Lighting & Lamps',
            'Renewable Energy', 'Watches & Jewelry',
        ];

        foreach ($additional as $name) {
            Category::firstOrCreate(['name' => $name], [
                'slug' => Str::slug($name),
                'icon' => 'tag',
                'image_path' => 'https://images.unsplash.com/photo-1550009158-9ebf6d250400?q=80&w=600',
                'type' => 'product',
            ]);
        }
    }
}
