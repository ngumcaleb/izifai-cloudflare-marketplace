<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $fillable = [
        'name',
        'icon',
        'number',
        'account_name',
        'is_active',
    ];

    public function getIconUrlAttribute(): ?string
    {
        return $this->icon ? url('/r2/' . ltrim($this->icon, '/')) : null;
    }
}
