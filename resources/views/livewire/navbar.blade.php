<nav class="bg-white border-gray-200 dark:bg-gray-900 fixed top-5 left-5 right-5 z-50 rounded-xl shadow-lg border">
    <div class="flex flex-wrap items-center justify-between mx-auto p-2 relative">
        <!-- Left Side: Brand Logo -->
        <a href="{{ route('home') ?? '/' }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white pl-4">Aneka Sandal</span>
        </a>

        <!-- Center: Categories and Products (Absolute Position) -->
        <div class="absolute left-1/2 transform -translate-x-1/2 flex items-center space-x-6">
            <a href="{{ route('categories') ?? '#' }}"
                class="text-gray-700 hover:text-primary dark:text-gray-300 dark:hover:text-blue-400 font-medium">
                Kategori
            </a>
            <a href="{{ route('products') ?? '#' }}"
                class="text-gray-700 hover:text-primary dark:text-gray-300 dark:hover:text-blue-400 font-medium">
                Produk
            </a>
        </div>

        <!-- Right Side: Search Bar & User Menu -->
        <div class="flex items-center space-x-4">
            <!-- Search Bar -->
            <div class="relative w-50">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" wire:model.live.debounce.300ms="search" wire:keydown.enter="searchProducts"
                    class="block w-full p-2 pl-10 text-sm outline-none focus:border-primary text-gray-900 border-b border-gray-300  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white "
                    placeholder="Cari produk sandal..." />
                @if($search)
                    <button wire:click="clearSearch" type="button"
                        class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="w-4 h-4 text-gray-500 hover:text-gray-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                @endif
                <!-- Search Results Component -->
                @livewire('search-results', ['search' => $search])
            </div>

            @auth
                <!-- User Dropdown Button (when logged in) -->
                <div class="relative">
                    <button type="button"
                        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        data-dropdown-toggle="user-dropdown" wire:click="toggleUserDropdown"
                        aria-expanded="{{ $showUserDropdown ? 'true' : 'false' }}">
                        <span class="sr-only">Open user menu</span>
                        <div
                            class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-sm">
                            {{ strtoupper(substr(auth()->user()->full_name ?? auth()->user()->username, 0, 1)) }}
                        </div>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="user-dropdown"
                        class="absolute top-full right-0 mt-2 w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 z-50 {{ $showUserDropdown ? 'block' : 'hidden' }}"
                        style="position: absolute; z-index: 1000;">
                        <div class="px-4 py-3">
                            <span
                                class="block text-sm text-gray-900 dark:text-white">{{ auth()->user()->full_name ?? auth()->user()->username }}</span>
                            <span
                                class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ auth()->user()->email }}</span>
                            <span
                                class="inline-block mt-1 px-2 py-1 text-xs font-semibold text-white bg-blue-600 rounded-full">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                <a href="{{ route('cart.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    Keranjang
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                                <li>
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                        Dashboard Admin
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('orders.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    Pesanan Saya
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                        Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <!-- Login/Register buttons (when not logged in) -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('login') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-primary px-3 py-2 rounded-md text-sm font-medium">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-primary  text-white px-4 py-2 rounded-md text-sm font-medium">
                        Daftar
                    </a>
                </div>
            @endauth

            <!-- Mobile menu button -->
            <button wire:click="toggleMobileMenu" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-user" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="items-center justify-between {{ $showMobileMenu ? '' : 'hidden' }} w-full md:hidden mt-4"
            id="navbar-user">
            <!-- Navigation Links - Mobile -->
            <ul
                class="flex flex-col font-medium p-4 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 space-y-2">
                <li>
                    <a href="{{ route('categories') ?? '#' }}"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                        Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('products') ?? '#' }}"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                        Produk
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

@script
<script>
    // Close dropdowns when clicking outside
    document.addEventListener('click', function (event) {
        const userDropdown = document.getElementById('user-dropdown');
        const userMenuButton = document.querySelector('[data-dropdown-toggle="user-dropdown"]');
        const mobileMenuButton = document.querySelector('[data-collapse-toggle="navbar-user"]');

        // Close user dropdown if clicking outside
        if (userDropdown && !userDropdown.contains(event.target) && !userMenuButton?.contains(event.target)) {
            $wire.set('showUserDropdown', false);
        }

        // Close mobile menu if clicking outside
        if (mobileMenuButton && !mobileMenuButton.contains(event.target) && !document.getElementById('navbar-user').contains(event.target)) {
            $wire.set('showMobileMenu', false);
        }
    });

    // Prevent dropdown from closing when clicking inside it
    document.addEventListener('click', function (event) {
        const userDropdown = document.getElementById('user-dropdown');
        if (userDropdown && userDropdown.contains(event.target)) {
            event.stopPropagation();
        }
    });
</script>
@endscript