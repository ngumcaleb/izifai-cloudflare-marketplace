<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalTransaction extends Model
{
    protected $fillable = [
        'rental_item_id', 'customer_id', 'conversation_id',
        'start_date', 'end_date',
        'total_amount', 'deposit_amount',
        'status', 'payment_status', 'notes',
    ];

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['confirmed', 'active']);
    }

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
    ];

    public function rentalItem(): BelongsTo
    {
        return $this->belongsTo(RentalItem::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}
