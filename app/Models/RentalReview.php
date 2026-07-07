<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalReview extends Model
{
    protected $fillable = ['rental_item_id', 'user_id', 'rating', 'comment', 'images', 'helpful'];

    protected $casts = [
        'images' => 'array',
        'helpful' => 'array',
    ];

    public function rentalItem(): BelongsTo
    {
        return $this->belongsTo(RentalItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
