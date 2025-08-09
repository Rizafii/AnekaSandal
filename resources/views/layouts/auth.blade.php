<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Auth') - {{ config('app.name', 'AnekaSandal') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body
    class="font-sans antialiased auth-bg bg-gradient-to-br from-secondary via-primary/5 to-secondary min-h-screen relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-primary/20 to-primary/5 rounded-full blur-3xl">
        </div>
        <div
            class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-primary/15 to-primary/5 rounded-full blur-3xl">
        </div>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-primary/10 to-secondary/30 rounded-full blur-3xl">
        </div>
    </div>

    <!-- Page Content -->
    <main class="relative z-10 min-h-screen flex items-center justify-center px-4">
        <div class="auth-container auth-float">
            @yield('content')
        </div>
    </main>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>

</html>