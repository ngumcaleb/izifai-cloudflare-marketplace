<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalItem extends Model
{
    protected $fillable = [
        'store_id', 'category_id', 'store_category_id', 'subcategory_id',
        'name', 'slug', 'description',
        'rate', 'billing_unit', 'deposit',
        'images', 'availability_calendar',
        'return_conditions', 'duration_rules', 'condition_notes',
        'serial_number', 'location', 'status',
        'rating', 'review_count', 'views',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    protected $casts = [
        'images' => 'array',
        'availability_calendar' => 'array',
        'rate' => 'decimal:2',
        'deposit' => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function storeCategory(): BelongsTo
    {
        return $this->belongsTo(StoreCategory::class, 'store_category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(RentalTransaction::class, 'rental_item_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(RentalReview::class, 'rental_item_id');
    }

    public function getImagesUrlAttribute(): array
    {
        $images = $this->images;
        if (is_string($images)) {
            $decoded = json_decode($images, true);
            $images = is_array($decoded) ? $decoded : [$images];
        }
        return array_map(fn($path) => $this->resolveImageUrl($path), $images ?? []);
    }

    public function getMainImageUrlAttribute(): ?string
    {
        $images = $this->images;
        if (is_string($images)) {
            $decoded = json_decode($images, true);
            $images = is_array($decoded) ? $decoded : [$images];
        }
        $images = $images ?? [];
        return !empty($images) ? $this->resolveImageUrl($images[0]) : null;
    }

    private function resolveImageUrl(string $path): string
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }
        return url('/r2/' . ltrim($path, '/'));
    }
}
