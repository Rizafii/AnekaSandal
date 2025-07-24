<div>
    <!-- Mobile menu button -->
    <button wire:click="toggleSidebar" type="button"
        class="lg:hidden p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- User dropdown button -->
    <div class="relative ml-3">
        <button wire:click="toggleUserDropdown" type="button"
            class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
            id="user-menu-button">
            <img class="h-8 w-8 rounded-full"
                src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=3b82f6&color=fff" alt="">
        </button>

        <!-- User dropdown menu -->
        @if($showUserDropdown)
            <div wire:click.outside="closeUserDropdown"
                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                <div class="px-4 py-2 text-sm text-gray-700 border-b">
                    <div class="font-medium">{{ auth()->user()->name }}</div>
                    <div class="text-gray-500">{{ auth()->user()->email }}</div>
                </div>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Mobile sidebar overlay -->
    @if($showSidebar)
        <div wire:click="closeSidebar" class="fixed inset-0 bg-gray-600 bg-opacity-75 z-20 lg:hidden"></div>
    @endif

    <!-- Mobile sidebar -->
    <div
        class="lg:hidden fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 transform {{ $showSidebar ? 'translate-x-0' : '-translate-x-full' }} transition-transform duration-300 ease-in-out">
        <div class="flex items-center justify-between h-16 px-4">
            <div class="text-white font-bold text-xl">Admin Panel</div>
            <button wire:click="closeSidebar" class="text-gray-400 hover:text-white">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <!-- Sidebar content here -->
        <nav class="mt-8">
            <a href="{{ route('admin.dashboard') }}"
                class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">
                Dashboard
            </a>
            <a href="{{ route('admin.orders.index') }}"
                class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white">
                Orders
            </a>
            <!-- Add other menu items -->
        </nav>
    </div>
</div>
