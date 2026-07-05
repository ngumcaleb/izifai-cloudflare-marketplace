<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends Model
{
    protected $fillable = [
        'store_id', 'category_id', 'store_category_id', 'name', 'slug', 'description',
        'starting_price', 'delivery_time', 'is_featured', 'featured_until',
        'status', 'views', 'approval_status',
        'rating', 'review_count', 'videos', 'portfolio',
        'availability_schedule', 'subcategory_id',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'featured_until' => 'datetime',
        'videos' => 'array',
        'portfolio' => 'array',
        'availability_schedule' => 'array',
        'rating' => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('approval_status', 'approved');
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
        return $this->hasMany(ServiceImage::class);
    }

    public function mainImage(): HasOne
    {
        return $this->hasOne(ServiceImage::class)->where('is_main', true);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(ServicePackage::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(ServiceBooking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ServiceReview::class);
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
        return $this->mainImage?->url ?? $this->images->first()?->url;
    }
}
