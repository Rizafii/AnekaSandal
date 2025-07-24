<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'weight',
        'is_active',
        'featured'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'featured' => 'boolean',
        'price' => 'decimal:2'
    ];

    // Relationship dengan category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship dengan product images
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // Relationship dengan product variants
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    // Scope untuk produk aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk produk featured
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Add method to get total stock from variants
    public function getTotalStockAttribute()
    {
        return $this->variants()->where('is_active', true)->sum('stock');
    }

    // Add method to check if product is available
    public function getIsAvailableAttribute()
    {
        return $this->total_stock > 0;
    }

    // Scope for products that have stock in variants
    public function scopeInStock($query)
    {
        return $query->whereHas('variants', function ($q) {
            $q->where('is_active', true)->where('stock', '>', 0);
        });
    }
}
