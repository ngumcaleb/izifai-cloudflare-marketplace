<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceBooking extends Model
{
    protected $fillable = [
        'service_id', 'user_id', 'package_id', 'status',
        'booking_date', 'booking_time', 'notes',
        'price',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(ServicePackage::class, 'package_id');
    }
}
