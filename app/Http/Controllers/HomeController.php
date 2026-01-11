<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class HomeController extends Controller
{
    public function index()
    {

        // Ambil 6 produk terbaru untuk homepage
        $latestProducts = Products::active()
            ->with(['category', 'images', 'variants'])
            ->latest()
            ->take(6)
            ->get();

        return view('home', ['latestProducts' => $latestProducts]);
    }

    public function promos()
    {
        return view('home'); // You can create specific pages later
    }

    public function contact()
    {
        return view('home'); // You can create specific pages later
    }
}
