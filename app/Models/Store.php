<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Store extends Model
{
    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'logo', 'banner',
        'location', 'whatsapp_number', 'business_email', 'open_hours',
        'social_links', 'is_verified', 'badge', 'status',
        'verification_level', 'trust_score', 'completion_rate', 'follower_count',
        'contact_info', 'rating', 'product_count', 'service_count',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_verified' => 'boolean',
    ];

    protected $appends = ['logo_url', 'banner_url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(StoreReview::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function rentalItems(): HasMany
    {
        return $this->hasMany(RentalItem::class);
    }

    public function storeCategories(): HasMany
    {
        return $this->hasMany(StoreCategory::class);
    }


    public function advertisementRequests(): HasMany
    {
        return $this->hasMany(AdvertisementRequest::class);
    }

    public function productReports(): HasManyThrough
    {
        return $this->hasManyThrough(ProductReport::class, Product::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function follows(): MorphMany
    {
        return $this->morphMany(Follow::class, 'followable');
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? url('/r2/' . ltrim($this->logo, '/')) : null;
    }

    public function getBannerUrlAttribute()
    {
        return $this->banner ? url('/r2/' . ltrim($this->banner, '/')) : null;
    }
}
