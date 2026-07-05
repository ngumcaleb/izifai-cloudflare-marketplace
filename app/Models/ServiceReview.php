<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceReview extends Model
{
    protected $fillable = ['service_id', 'user_id', 'booking_id', 'rating', 'comment', 'images', 'helpful'];

    protected $casts = [
        'images' => 'array',
        'helpful' => 'array',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(ServiceBooking::class, 'booking_id');
    }
}
