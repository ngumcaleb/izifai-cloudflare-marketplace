<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'store_id', 'category_id', 'store_category_id', 'name', 'slug', 'description',
        'price', 'old_price', 'stock_status', 'is_featured',
        'featured_until', 'colors', 'sizes', 'brand', 'sku',
        'inventory', 'video_url', 'approval_status', 'views',
        'status', 'rating', 'review_count', 'discount_price', 'subcategory_id',
    ];

    protected $casts = [
        'colors' => 'array',
        'sizes' => 'array',
        'is_featured' => 'boolean',
        'featured_until' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->whereHas('store', fn($q) => $q->where('status', 'active'))
            ->where('approval_status', 'approved');
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock');
    }

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

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function savedUsers(): HasMany
    {
        return $this->hasMany(SavedProduct::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(ProductReport::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function cartItems(): MorphMany
    {
        return $this->morphMany(CartItem::class, 'item');
    }

    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'item');
    }

    public function follows(): MorphMany
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function getMainImageUrlAttribute(): ?string
    {
        $image = $this->images->first();
        return $image?->url;
    }
}
