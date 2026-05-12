<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvertisementRequest extends Model
{
    protected $fillable = [
        'product_id',
        'store_id',
        'type',
        'duration_days',
        'status',
        'seller_notes',
        'admin_notes',
        'starts_at',
        'ends_at',
        'payment_sender_number',
        'total_amount',
        'payment_proof',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
