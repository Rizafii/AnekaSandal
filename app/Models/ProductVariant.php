<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'size',
        'color',
        'additional_price',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'additional_price' => 'decimal:2'
    ];

    // Relationship dengan product
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    // Scope untuk varian aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk varian yang tersedia (stock > 0)
    public function scopeAvailable($query)
    {
        return $query->where('stock', '>', 0);
    }
}
