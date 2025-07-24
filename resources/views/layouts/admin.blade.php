<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - AnekaSandal</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200 fixed w-full z-30 top-0">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
                        class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded">
                        <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <svg id="toggleSidebarMobileClose" class="w-6 h-6 hidden" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold flex items-center lg:ml-2.5">
                        <span class="self-center whitespace-nowrap">AnekaSandal Admin</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="hidden lg:flex items-center space-x-3">
                        <!-- Notifications -->
                        <div class="relative">
                            <button
                                class="text-gray-500 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-gray-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <!-- User Menu -->
                        <div class="relative">
                            <button type="button"
                                class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                                <span class="sr-only">Open user menu</span>
                                <div
                                    class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white text-sm font-medium">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </button>
                            <div class="hidden z-50 my-4 text-base list-none bg-white rounded divide-y divide-gray-100 shadow"
                                id="dropdown">
                                <div class="py-3 px-4">
                                    <span class="block text-sm text-gray-900">{{ auth()->user()->name }}</span>
                                    <span
                                        class="block text-sm font-medium text-gray-500 truncate">{{ auth()->user()->email }}</span>
                                </div>
                                <ul class="py-1">
                                    <li>
                                        <a href="{{ route('home') }}"
                                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">Lihat
                                            Website</a>
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="block w-full text-left py-2 px-4 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed z-20 h-full top-0 left-0 pt-16 hidden lg:flex flex-shrink-0 flex-col w-64 transition-width duration-75"
        aria-label="Sidebar">
        <div class="relative flex-1 flex flex-col min-h-0 border-r border-gray-200 bg-white pt-0">
            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                <div class="flex-1 px-3 bg-white divide-y space-y-1">
                    <ul class="space-y-2 pb-2">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-base text-gray-900 font-normal rounded-lg flex items-center p-2 hover:bg-gray-100 group {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100' : '' }}">
                                <svg class="w-6 h-6 text-gray-500 group-hover:text-gray-900 transition duration-75"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                                </svg>
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.categories.index') }}"
                                class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group {{ request()->routeIs('admin.categories.*') ? 'bg-gray-100' : '' }}">
                                <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-3 flex-1 whitespace-nowrap">Kelola Kategori</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.products.index') }}"
                                class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group {{ request()->routeIs('admin.products.*') ? 'bg-gray-100' : '' }}">
                                <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 2L3 7v11a1 1 0 001 1h5v-6a1 1 0 011-1h2a1 1 0 011 1v6h5a1 1 0 001-1V7l-7-5z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-3 flex-1 whitespace-nowrap">Kelola Produk</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.orders.index') }}"
                                class="text-base text-gray-900 font-normal rounded-lg hover:bg-gray-100 flex items-center p-2 group {{ request()->routeIs('admin.orders.*') ? 'bg-gray-100' : '' }}">
                                <svg class="w-6 h-6 text-gray-500 flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                                <span class="ml-3 flex-1 whitespace-nowrap">Kelola Pesanan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-64">
        <main class="pt-16">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>