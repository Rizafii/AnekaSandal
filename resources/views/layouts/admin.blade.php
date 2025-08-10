<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - AnekaSandal</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

    * {
        font-family: 'Inter', sans-serif;
    }
</style>

<body class="bg-gray-100 font-sans">

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed z-20 h-full top-0 left-0 flex flex-shrink-0 flex-col w-64 bg-white border-r border-gray-300 shadow-sm"
        aria-label="Sidebar">
        <!-- Logo Header -->
        <div class="flex items-center justify-center h-16 border-b border-gray-300 bg-blue-600">
            <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold text-white">
                AnekaSandal Admin
            </a>
        </div>

        <!-- Sidebar Content -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <div class="flex-1 py-4">
                <nav class="px-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-blue-500' : 'text-gray-400' }}"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.categories.*') ? 'text-blue-500' : 'text-gray-400' }}"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Kelola Kategori
                    </a>

                    <a href="{{ route('admin.products.index') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.products.*') ? 'text-blue-500' : 'text-gray-400' }}"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 2L3 7v11a1 1 0 001 1h5v-6a1 1 0 011-1h2a1 1 0 011 1v6h5a1 1 0 001-1V7l-7-5z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Kelola Produk
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.orders.*') ? 'text-blue-500' : 'text-gray-400' }}"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        Kelola Pesanan
                    </a>

                    <a href="{{ route('admin.store-settings.index') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.store-settings.*') ? 'bg-blue-100 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3 {{ request()->routeIs('admin.store-settings.*') ? 'text-blue-500' : 'text-gray-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Pengaturan Toko
                    </a>
                </nav>

                <!-- User Menu at Bottom -->
                <div class="mt-8 pt-4 border-t border-gray-200 px-3">
                    <div class="bg-gray-50 rounded-md p-3 mb-3">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                <span
                                    class="text-white text-sm font-medium">{{ substr(auth()->user()->username, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->username }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <a href="{{ route('home') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            Lihat Website
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-red-50 hover:text-red-700 transition-colors">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 ml-64 min-h-screen bg-gray-100">
        <main class="h-full">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>