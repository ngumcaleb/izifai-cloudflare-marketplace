<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceImage extends Model
{
    protected $fillable = ['service_id', 'path', 'is_main', 'position'];

    protected $appends = ['url'];

    protected $casts = ['is_main' => 'boolean'];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function getUrlAttribute(): ?string
    {
        if (!$this->path) return null;
        if (str_starts_with($this->path, 'http://') || str_starts_with($this->path, 'https://')) {
            return $this->path;
        }
        return url('/r2/' . ltrim($this->path, '/'));
    }
}
