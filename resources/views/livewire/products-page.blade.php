<div>
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg animate-pulse">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-4 rounded-xl shadow-lg animate-pulse">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="px-3 mt-3 bg-secondary">
        <div class="mx-auto">
            <div class="grid rounded-2xl px-4 pt-32 py-24 mx-auto bg-primary bg-center bg-cover relative">
                <!-- Decorative Pattern -->
                <div class="absolute inset-0 opacity-10 rounded-2xl">
                    <svg class="w-full h-full" viewBox="0 0 100 100" fill="none">
                        <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                            <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" />
                        </pattern>
                        <rect width="100" height="100" fill="url(#grid)" />
                    </svg>
                </div>

                <div class="items-center flex flex-col mx-auto text-center text-white relative z-10">
                    <h1
                        class="max-w-4xl mb-6 text-4xl font-extrabold tracking-tight leading-none md:text-5xl xl:text-6xl">
                        Koleksi Sandal Berkualitas Tinggi
                    </h1>
                    <p class="max-w-2xl mb-8 font-normal text-white/90 md:text-lg lg:text-xl">
                        Temukan sandal impian Anda dari berbagai kategori dan model eksklusif dengan kenyamanan maksimal
                    </p>

                    <!-- Search Bar -->
                    <div class="max-w-2xl mx-auto w-full">
                        <div class="relative">
                            <input wire:model.live.debounce.300ms="search" type="text"
                                placeholder="Cari sandal favorit Anda..."
                                class="w-full px-6 py-4 text-lg text-gray-900 bg-white/95 backdrop-blur-sm rounded-2xl focus:outline-none focus:ring-4 focus:ring-white/30 focus:bg-white pr-16 transition-all duration-300">
                            <button
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-primary hover:bg-primary/80 text-white rounded-xl p-3 transition-all duration-300 hover:scale-105">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="px-3 bg-secondary">
        <div class="mx-auto">
            <div class="bg-white rounded-2xl shadow-lg p-6 -mt-8 relative z-20">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Produk</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Category Filter -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Kategori</label>
                        <select wire:model.live="categoryFilter"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50 transition-all duration-300">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Filter -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Rentang Harga</label>
                        <select wire:model.live="priceRange"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50 transition-all duration-300">
                            <option value="">Semua Harga</option>
                            <option value="0-100000">Di bawah Rp 100.000</option>
                            <option value="100000-200000">Rp 100.000 - 200.000</option>
                            <option value="200000-300000">Rp 200.000 - 300.000</option>
                            <option value="300000-up">Di atas Rp 300.000</option>
                        </select>
                    </div>

                    <!-- Sort Filter -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Urutkan</label>
                        <select wire:model.live="sortBy"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-50 transition-all duration-300">
                            <option value="newest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="price_low">Harga Terendah</option>
                            <option value="price_high">Harga Tertinggi</option>
                            <option value="popular">Terpopuler</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Grid Section -->
    <section class="px-3 py-8 bg-secondary">
        <div class="mx-auto">

            <!-- Products Grid -->
            <div wire:loading.class="opacity-50" class="transition-opacity duration-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($products as $product)
                        @php
                            $isOutOfStock = $product['total_stock'] == 0;
                            $isLowStock = $product['total_stock'] <= 5 && $product['total_stock'] > 0;
                        @endphp
                        <div class="group relative {{ $isOutOfStock ? 'opacity-75' : '' }}">
                            @if($isOutOfStock)
                                <!-- Non-clickable wrapper for out of stock products -->
                                <div
                                    class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 cursor-not-allowed">
                            @else
                                    <!-- Clickable wrapper for available products -->
                                    <a href="{{ route('product.detail', $product['id']) }}"
                                        class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 block border border-gray-100">
                                @endif

                                    <!-- Product Image -->
                                    <div
                                        class="relative overflow-hidden aspect-square {{ $isOutOfStock ? 'grayscale' : '' }}">
                                        @if(!empty($product['primary_image']))
                                            <img src="{{ $product['primary_image'] }}" alt="{{ $product['name'] }}"
                                                class="w-full h-full object-cover {{ $isOutOfStock ? '' : 'group-hover:scale-110' }} transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif

                                        <!-- Stock Badge -->
                                        @if($isLowStock)
                                            <div
                                                class="absolute top-3 right-3 bg-orange-500 text-white px-3 py-1 rounded-xl text-xs font-semibold shadow-lg">
                                                STOK TERBATAS
                                            </div>
                                        @elseif($product['total_stock'] > 5)
                                            <div
                                                class="absolute top-3 right-3 bg-green-500 text-white px-3 py-1 rounded-xl text-xs font-semibold shadow-lg">
                                                TERSEDIA
                                            </div>
                                        @elseif($isOutOfStock)
                                            <div
                                                class="absolute top-3 right-3 bg-red-500 text-white px-3 py-1 rounded-xl text-xs font-semibold shadow-lg">
                                                HABIS
                                            </div>
                                        @endif

                                        @if($isOutOfStock)
                                            <!-- Out of stock overlay -->
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                                <div class="bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2">
                                                    <span class="text-gray-900 font-semibold text-sm">Stok Habis</span>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Hover overlay gradient -->
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-6">
                                        <h3
                                            class="text-lg font-bold text-gray-900 mb-2 {{ $isOutOfStock ? 'text-gray-500' : 'group-hover:text-primary' }} transition-colors duration-300 line-clamp-2">
                                            {{ $product['name'] }}
                                        </h3>
                                        <p
                                            class="text-gray-600 text-sm mb-4 line-clamp-2 {{ $isOutOfStock ? 'text-gray-400' : '' }}">
                                            {{ Str::limit($product['description'], 80) }}
                                        </p>

                                        <!-- Rating -->
                                        <div class="flex items-center mb-4">
                                            <div class="flex text-yellow-400 {{ $isOutOfStock ? 'opacity-50' : '' }}">
                                                @for($star = 1; $star <= 5; $star++)
                                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                        <path
                                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span
                                                class="text-gray-500 text-sm ml-2 {{ $isOutOfStock ? 'opacity-50' : '' }}">(5.0)</span>
                                        </div>

                                        <!-- Price -->
                                        <div class="mb-4">
                                            <span
                                                class="text-2xl font-bold {{ $isOutOfStock ? 'text-gray-400' : 'text-primary' }}">
                                                Rp {{ number_format($product['price'], 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <!-- CTA Buttons -->
                                        @if(!$isOutOfStock)
                                            <div class="flex flex-col gap-2">
                                                <!-- Beli Sekarang Button -->
                                                <button wire:click="buyNow({{ $product['id'] }})"
                                                    class="w-full bg-primary text-white py-3 px-4 rounded-xl font-semibold hover:bg-primary/90 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                                    Beli Sekarang
                                                </button>

                                            </div>
                                        @else
                                            <div class="flex flex-col gap-2">
                                                <button disabled
                                                    class="w-full bg-gray-200 text-gray-400 py-3 px-4 rounded-xl font-semibold cursor-not-allowed">
                                                    Stok Habis
                                                </button>
                                            </div>
                                        @endif
                                    </div>

                                    @if($isOutOfStock)
                                        </div>
                                    @else
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                                <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                                <p class="text-gray-500 mb-6">Tidak ada produk aktif yang sesuai dengan filter yang Anda
                                    pilih.</p>
                                <button wire:click="resetFilters"
                                    class="bg-primary text-white px-6 py-3 rounded-xl hover:bg-primary/90 transition-colors duration-300">
                                    Reset Filter
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($lastPage > 1)
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-2">
                        <nav class="flex items-center space-x-1">
                            <!-- Previous Button -->
                            <button wire:click="previousPage" @if($currentPage == 1) disabled @endif
                                class="px-4 py-2 text-sm font-medium {{ $currentPage == 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:text-primary hover:bg-primary/10' }} rounded-xl transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>

                            <!-- Page Numbers -->
                            @for($page = 1; $page <= $lastPage; $page++)
                                @if($page == $currentPage)
                                    <span class="px-4 py-2 text-sm font-semibold text-white bg-primary rounded-xl shadow-sm">
                                        {{ $page }}
                                    </span>
                                @elseif($page == 1 || $page == $lastPage || ($page >= $currentPage - 2 && $page <= $currentPage + 2))
                                    <button wire:click="gotoPage({{ $page }})"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-primary hover:bg-primary/10 rounded-xl transition-all duration-300">
                                        {{ $page }}
                                    </button>
                                @elseif($page == $currentPage - 3 || $page == $currentPage + 3)
                                    <span class="px-2 py-2 text-sm font-medium text-gray-400">...</span>
                                @endif
                            @endfor

                            <!-- Next Button -->
                            <button wire:click="nextPage" @if($currentPage == $lastPage) disabled @endif
                                class="px-4 py-2 text-sm font-medium {{ $currentPage == $lastPage ? 'text-gray-300 cursor-not-allowed' : 'text-gray-700 hover:text-primary hover:bg-primary/10' }} rounded-xl transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>

<script>
    // Auto hide flash messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function () {
        const flashMessages = document.querySelectorAll('.animate-pulse');
        flashMessages.forEach(function (message) {
            setTimeout(function () {
                message.style.transition = 'opacity 0.5s ease-out';
                message.style.opacity = '0';
                setTimeout(function () {
                    message.remove();
                }, 500);
            }, 5000);
        });
    });
</script>