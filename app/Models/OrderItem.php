<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'item_type', 'item_id', 'store_id', 'quantity', 'price', 'name', 'image', 'package_id'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function item(): MorphTo
    {
        return $this->morphTo();
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
