<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship dengan products
    public function products()
    {
        return $this->hasMany(Products::class, 'category_id');
    }

    // Scope untuk kategori aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);

                // Ensure slug is unique
                $originalSlug = $category->slug;
                $counter = 1;
                while (static::where('slug', $category->slug)->exists()) {
                    $category->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $category->slug = Str::slug($category->name);

                // Ensure slug is unique (exclude current record)
                $originalSlug = $category->slug;
                $counter = 1;
                while (static::where('slug', $category->slug)->where('id', '!=', $category->id)->exists()) {
                    $category->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
        });
    }
}
