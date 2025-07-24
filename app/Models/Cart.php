<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // Helper methods
    public function getSubtotalAttribute()
    {
        $price = $this->product->price;
        if ($this->variant && $this->variant->additional_price) {
            $price += $this->variant->additional_price;
        }
        return $price * $this->quantity;
    }
}
