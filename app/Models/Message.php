<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'conversation_id', 'sender_id', 'body', 'image',
        'read', 'read_at', 'edited_at', 'metadata',
    ];

    protected $casts = [
        'read' => 'boolean',
        'read_at' => 'datetime',
        'edited_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? url('/r2/' . ltrim($this->image, '/')) : null;
    }
}
