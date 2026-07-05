<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'image_path', 'parent_id', 'type'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function rentalItems(): HasMany
    {
        return $this->hasMany(RentalItem::class, 'category_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? url('/r2/' . ltrim($this->image_path, '/')) : null;
    }
}
