<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreTeamMember extends Model
{
    protected $fillable = ['store_id', 'name', 'role', 'photo', 'bio'];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? url('/r2/' . ltrim($this->photo, '/')) : null;
    }
}