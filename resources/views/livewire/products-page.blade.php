<div>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-pink-500 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Koleksi Sandal Terbaru</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                Temukan sandal impian Anda dari berbagai kategori dan model eksklusif
            </p>

            <!-- Search Bar -->
            <div class="max-w-2xl mx-auto">
                <div class="relative">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari sandal favorit Anda..."
                        class="w-full px-6 py-4 text-lg text-gray-900 bg-white rounded-full focus:outline-none focus:ring-4 focus:ring-white/30 pr-16">
                    <button
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-pink-600 hover:bg-pink-700 text-white rounded-full p-3 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <!-- Category Filter -->
                <select wire:model.live="categoryFilter"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>

                <!-- Price Filter -->
                <select wire:model.live="priceRange"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="">Semua Harga</option>
                    <option value="0-100000">Di bawah Rp 100.000</option>
                    <option value="100000-200000">Rp 100.000 - 200.000</option>
                    <option value="200000-300000">Rp 200.000 - 300.000</option>
                    <option value="300000-up">Di atas Rp 300.000</option>
                </select>

                <!-- Sort Filter -->
                <select wire:model.live="sortBy"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="price_low">Harga Terendah</option>
                    <option value="price_high">Harga Tertinggi</option>
                    <option value="popular">Terpopuler</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Products Grid Section -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Results Info -->
            <div class="flex justify-between items-center mb-8">
                <p class="text-gray-600">
                    Menampilkan <span
                        class="font-semibold text-gray-900">{{ $this->getFirstItem() }}-{{ $this->getLastItem() }}</span>
                    dari
                    <span class="font-semibold text-gray-900">{{ $total }}</span> produk
                </p>

                <!-- View Toggle -->
                <div class="flex bg-gray-100 rounded-lg p-1">
                    <button wire:click="setViewType('grid')"
                        class="px-3 py-2 {{ $viewType === 'grid' ? 'bg-white text-pink-600 shadow-sm' : 'text-gray-500 hover:text-pink-600' }} rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                    </button>
                    <button wire:click="setViewType('list')"
                        class="px-3 py-2 {{ $viewType === 'list' ? 'bg-white text-pink-600 shadow-sm' : 'text-gray-500 hover:text-pink-600' }} rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Products Grid/List -->
            <div wire:loading.class="opacity-50" class="transition-opacity duration-200">
                @if($viewType === 'grid')
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($products as $product)
                            <div class="group">
                                <a href="{{ route('product.detail', $product['id']) }}"
                                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-105 block">

                                    <!-- Product Image -->
                                    <div class="relative overflow-hidden">
                                        @if(!empty($product['primary_image']))
                                            <img src="{{ asset('storage/' . $product['primary_image']) }}"
                                                alt="{{ $product['name'] }}"
                                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-400">No Image</span>
                                            </div>
                                        @endif

                                        <!-- Stock Badge -->
                                        @if($product['total_stock'] <= 5 && $product['total_stock'] > 0)
                                            <div
                                                class="absolute bottom-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                                STOK TERBATAS
                                            </div>
                                        @elseif($product['total_stock'] > 5)
                                            <div
                                                class="absolute bottom-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                                TERSEDIA
                                            </div>
                                        @elseif($product['total_stock'] == 0)
                                            <div
                                                class="absolute bottom-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                                HABIS
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-6">
                                        <h3
                                            class="text-lg font-bold text-gray-900 mb-2 group-hover:text-pink-600 transition-colors duration-300">
                                            {{ $product['name'] }}
                                        </h3>
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                            {{ Str::limit($product['description'], 80) }}
                                        </p>

                                        <!-- Rating -->
                                        <div class="flex items-center mb-3">
                                            <div class="flex text-yellow-400">
                                                @for($star = 1; $star <= 5; $star++)
                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                @endfor
                                            </div>
                                            <span class="text-gray-600 text-sm ml-2">(5.0)</span>
                                        </div>

                                        <!-- Price -->
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-2xl font-bold text-pink-600">
                                                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <div class="max-w-md mx-auto">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk</h3>
                                    <p class="mt-1 text-sm text-gray-500">Tidak ada produk yang sesuai dengan filter Anda.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                @else
                    <!-- List View -->
                    <div class="space-y-6">
                        @forelse($products as $product)
                            <div
                                class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300">
                                <a href="{{ route('product.detail', $product['id']) }}" class="flex flex-col md:flex-row">
                                    <!-- Product Image -->
                                    <div class="md:w-1/3 relative overflow-hidden">
                                        @if(!empty($product['primary_image']))
                                            <img src="{{ asset('storage/' . $product['primary_image']) }}"
                                                alt="{{ $product['name'] }}"
                                                class="w-full h-48 md:h-full object-cover hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-48 md:h-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-400">No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="md:w-2/3 p-6 flex flex-col justify-between">
                                        <div>
                                            <h3
                                                class="text-xl font-bold text-gray-900 mb-2 hover:text-pink-600 transition-colors duration-300">
                                                {{ $product['name'] }}
                                            </h3>
                                            <p class="text-gray-600 mb-4">{{ Str::limit($product['description'], 150) }}</p>

                                            <!-- Rating -->
                                            <div class="flex items-center mb-3">
                                                <div class="flex text-yellow-400">
                                                    @for($star = 1; $star <= 5; $star++)
                                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="text-gray-600 text-sm ml-2">(5.0)</span>
                                            </div>
                                        </div>

                                        <!-- Price and Actions -->
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-2xl font-bold text-pink-600">
                                                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                                                </span>
                                            </div>

                                            <div class="flex items-center space-x-2">
                                                @if($product['total_stock'] > 0)
                                                    <span class="text-sm text-green-600 font-medium">Tersedia</span>
                                                @else
                                                    <span class="text-sm text-red-600 font-medium">Habis</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="max-w-md mx-auto">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk</h3>
                                    <p class="mt-1 text-sm text-gray-500">Tidak ada produk yang sesuai dengan filter Anda.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            @if($lastPage > 1)
                <div class="mt-12">
                    <nav class="flex items-center justify-center space-x-2">
                        <!-- Previous Button -->
                        <button wire:click="previousPage" @if($currentPage == 1) disabled @endif
                            class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            Previous
                        </button>

                        <!-- Page Numbers -->
                        @for($page = 1; $page <= $lastPage; $page++)
                            @if($page == $currentPage)
                                <span
                                    class="px-3 py-2 text-sm font-medium text-white bg-pink-600 border border-pink-600 rounded-md">
                                    {{ $page }}
                                </span>
                            @elseif($page == 1 || $page == $lastPage || ($page >= $currentPage - 2 && $page <= $currentPage + 2))
                                <button wire:click="gotoPage({{ $page }})"
                                    class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                    {{ $page }}
                                </button>
                            @elseif($page == $currentPage - 3 || $page == $currentPage + 3)
                                <span class="px-3 py-2 text-sm font-medium text-gray-500">...</span>
                            @endif
                        @endfor

                        <!-- Next Button -->
                        <button wire:click="nextPage" @if($currentPage == $lastPage) disabled @endif
                            class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 hover:text-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
                            Next
                        </button>
                    </nav>
                </div>
            @endif

            <!-- Loading indicator -->
            <div wire:loading class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-pink-600"></div>
                    <span class="text-gray-700">Memuat produk...</span>
                </div>
            </div>
        </div>
    </section>
</div>