<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function () {
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        request()->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->name('login.post')->middleware('guest');

Route::get('/register', function () {
    return view('auth.register');
})->name('register')->middleware('guest');

Route::post('/register', function () {
    $validated = request()->validate([
        'username' => 'required|string|max:50|unique:users',
        'full_name' => 'required|string|max:100',
        'email' => 'required|string|email|max:100|unique:users',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = \App\Models\User::create([
        'username' => $validated['username'],
        'full_name' => $validated['full_name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'] ?? null,
        'address' => $validated['address'] ?? null,
        'password' => bcrypt($validated['password']),
        'role' => 'customer',
    ]);

    Auth::login($user);

    return redirect('/');
})->name('register.post')->middleware('guest');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

// Additional routes for the navbar links
Route::get('/products', function () {
    return view('home'); // You can create specific pages later
})->name('products');

Route::get('/categories', function () {
    return view('home'); // You can create specific pages later
})->name('categories');

Route::get('/promos', function () {
    return view('home'); // You can create specific pages later
})->name('promos');

Route::get('/contact', function () {
    return view('home'); // You can create specific pages later
})->name('contact');
