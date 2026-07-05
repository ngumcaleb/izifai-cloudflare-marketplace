<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'type', 'amount', 'currency',
        'payment_method', 'reference', 'status', 'notes',
        'escrow_held_at', 'escrow_released_at',
    ];

    protected $casts = [
        'escrow_held_at' => 'datetime',
        'escrow_released_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
