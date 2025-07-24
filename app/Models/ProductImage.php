<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'is_primary',
        'sort_order'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    // Relationship dengan product
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    // Scope untuk gambar utama
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // Accessor untuk URL gambar
    public function getUrlAttribute()
    {
        return $this->image_path;
    }

    public function getImageUrlAttribute()
    {
        return $this->image_path;
    }
}
