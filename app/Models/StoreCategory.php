<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoreCategory extends Model
{
    protected $fillable = ['store_id', 'parent_id', 'name', 'slug', 'type'];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'store_category_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'store_category_id');
    }

    public function rentalItems(): HasMany
    {
        return $this->hasMany(RentalItem::class, 'store_category_id');
    }
}
