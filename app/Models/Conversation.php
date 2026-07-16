<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Conversation extends Model
{
    protected $fillable = [
        'buyer_id', 'seller_id', 'target_type', 'target_id',
        'last_message', 'last_message_at',
        'buyer_unread', 'seller_unread',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function target(): MorphTo
    {
        return $this->morphTo();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function getTargetMetadataAttribute(): ?array
    {
        $target = $this->target;
        if (!$target) return null;

        $type = match (class_basename($this->target_type)) {
            'Product' => 'product',
            'Service' => 'service',
            'RentalItem' => 'rental',
            'Store' => 'store',
            default => null,
        };
        if (!$type) return null;

        $image = match ($type) {
            'product' => $target->main_image_url ?? null,
            'service' => $target->main_image_url ?? null,
            'rental' => $target->main_image_url ?? ($target->images_url[0] ?? null),
            'store' => $target->logo_url ?? null,
            default => null,
        };
        $price = match ($type) {
            'product' => $target->price ?? null,
            'service' => $target->starting_price ?? null,
            'rental' => $target->rate ?? null,
            default => null,
        };

        return [
            'type' => $type,
            'label' => match ($type) {
                'product' => 'Product',
                'service' => 'Service',
                'rental' => 'Rental',
                'store' => 'Store',
                default => 'Item',
            },
            'id' => $target->id,
            'slug' => $target->slug ?? null,
            'name' => $target->name ?? null,
            'image' => $image,
            'price' => $price,
            'currency' => $price !== null ? 'KSh' : null,
        ];
    }
}
