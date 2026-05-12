<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'old_price',
        'stock_status',
        'is_featured',
        'featured_until',
        'colors',
        'sizes',
    ];

    public function scopeActive($query)
    {
        return $query->whereHas('store', function ($q) {
            $q->where('status', 'active');
        });
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    protected $casts = [
        'colors' => 'array',
        'sizes' => 'array',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reports()
    {
        return $this->hasMany(ProductReport::class);
    }

    public function advertisementRequests()
    {
        return $this->hasMany(AdvertisementRequest::class);
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function savedUsers()
    {
        return $this->hasMany(SavedProduct::class);
    }

    public function favorites()
    {
        return $this->hasMany(SavedProduct::class);
    }

    public function events()
    {
        return $this->hasMany(ProductEvent::class);
    }

    public function logEvent($type)
    {
        return $this->events()->create([
            'store_id' => $this->store_id,
            'type' => $type,
            'ip_address' => request()->ip(),
        ]);
    }

    public function getDailyViewsAttribute()
    {
        return $this->events()->where('type', 'view')->where('created_at', '>=', now()->startOfDay())->count();
    }

    public function getTotalContactsAttribute()
    {
        return $this->events()->whereIn('type', ['whatsapp_click', 'call_click'])->count();
    }

    public function getDailyContactsAttribute()
    {
        return $this->events()->whereIn('type', ['whatsapp_click', 'call_click'])->where('created_at', '>=', now()->startOfDay())->count();
    }
}
