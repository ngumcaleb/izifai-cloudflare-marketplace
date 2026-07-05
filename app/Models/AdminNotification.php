<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminNotification extends Model
{
    protected $fillable = ['admin_id', 'type', 'title', 'message', 'read', 'data'];

    protected $casts = [
        'read' => 'boolean',
        'data' => 'array',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }
}
