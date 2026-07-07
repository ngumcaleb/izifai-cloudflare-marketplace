<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone',
        'profile_photo_path', 'cover_photo_path', 'status', 'default_page',
        'email_verified', 'phone_verified', 'verification_level',
        'trust_score', 'fcm_token',
        'location', 'joined_at',
    ];

    protected $appends = ['profile_photo_url', 'cover_photo_url'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'email_verified' => 'boolean',
            'phone_verified' => 'boolean',
            'joined_at' => 'datetime',
            'role' => Role::class,
        ];
    }

    public function store(): HasOne
    {
        return $this->hasOne(Store::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(StoreReview::class);
    }

    public function savedProducts(): HasMany
    {
        return $this->hasMany(SavedProduct::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function productReviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function serviceReviews(): HasMany
    {
        return $this->hasMany(ServiceReview::class);
    }

    public function serviceBookings(): HasMany
    {
        return $this->hasMany(ServiceBooking::class);
    }

    public function follows(): HasMany
    {
        return $this->hasMany(Follow::class);
    }

    public function shippingAddresses(): HasMany
    {
        return $this->hasMany(ShippingAddress::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === Role::Superadmin;
    }

    public function isSeller(): bool
    {
        return $this->store !== null;
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        if ($this->profile_photo_path) {
            return url('/r2/'.ltrim($this->profile_photo_path, '/'));
        }
        $name = urlencode($this->name ?? 'User');

        return "https://ui-avatars.com/api/?name={$name}&background=339933&color=fff&size=128&bold=true";
    }

    public function getCoverPhotoUrlAttribute(): ?string
    {
        if ($this->cover_photo_path) {
            return url('/r2/'.ltrim($this->cover_photo_path, '/'));
        }

        return null;
    }
}
