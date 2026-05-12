<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductEvent extends Model
{
    protected $fillable = ['product_id', 'store_id', 'type', 'ip_address'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
