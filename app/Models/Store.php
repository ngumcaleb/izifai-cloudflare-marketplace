<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo',
        'banner',
        'location',
        'whatsapp_number',
        'business_email',
        'open_hours',
        'social_links',
        'is_verified',
        'badge',
        'status',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    /**
     * Get the user that owns the store.
     */
    public function user()
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

    public function advertisementRequests()
    {
        return $this->hasMany(AdvertisementRequest::class);
    }

    public function productReports()
    {
        return $this->hasManyThrough(ProductReport::class, Product::class);
    }
}
