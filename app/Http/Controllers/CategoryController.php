<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::active()
            ->withCount('products')
            ->get();

        return view('categories', compact('categories'));
    }

    public function show($slug)
    {
        $category = Category::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $products = Products::active()
            ->where('category_id', $category->id)
            ->with(['category', 'images', 'variants'])
            ->paginate(12);

        return view('category-products', compact('category', 'products'));
    }
}
