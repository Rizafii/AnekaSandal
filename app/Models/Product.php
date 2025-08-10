<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'compare_price',
        'weight',
        'is_active',
        'featured',
        'category_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'featured' => 'boolean',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedComparePriceAttribute()
    {
        return $this->compare_price ? 'Rp ' . number_format($this->compare_price, 0, ',', '.') : null;
    }

    public function getTotalStockAttribute()
    {
        return $this->variants->where('is_active', true)->sum('stock');
    }

    public function getStockStatusAttribute()
    {
        $totalStock = $this->total_stock;

        if ($totalStock <= 0) {
            return 'out_of_stock';
        } elseif ($totalStock <= 5) {
            return 'low_stock';
        }
        return 'in_stock';
    }

    public function getStockStatusTextAttribute()
    {
        switch ($this->stock_status) {
            case 'out_of_stock':
                return 'Habis';
            case 'low_stock':
                return 'Stok Rendah';
            default:
                return 'Tersedia';
        }
    }
}