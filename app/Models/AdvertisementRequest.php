<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AdvertisementRequest extends Model
{
    protected $fillable = [
        'store_id', 'promotable_type', 'promotable_id', 'title',
        'image', 'description',
        'days', 'daily_rate', 'total_amount',
        'status', 'payment_status', 'payer_phone',
        'payment_reference', 'paid_at',
        'starts_at', 'ends_at',
        'admin_notes', 'approved_at', 'rejected_at',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? \Illuminate\Support\Facades\Storage::disk('r2')->url($this->image) : null;
    }

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'paid_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'daily_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function promotable(): MorphTo
    {
        return $this->morphTo();
    }
}
