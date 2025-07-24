<section class="py-20 px-4 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Produk <span class="text-pink-600">Terbaru</span>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Temukan koleksi sandal terbaru kami dengan desain modern dan kualitas terbaik untuk gaya hidup Anda
            </p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @forelse($latestProducts ?? [] as $product)
                <div
                    class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                    <!-- Product Image -->
                    <div class="relative overflow-hidden">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"
                            class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">

                        <!-- Discount Badge (if any) -->
                        @if(isset($product['discount']) && $product['discount'] > 0)
                            <div
                                class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                -{{ $product['discount'] }}%
                            </div>
                        @endif

                        <!-- Quick Action Buttons -->
                        <div
                            class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 space-y-2">
                            <button
                                class="bg-white p-2 rounded-full shadow-lg hover:bg-pink-50 transition-colors duration-200">
                                <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                    </path>
                                </svg>
                            </button>
                            <button
                                class="bg-white p-2 rounded-full shadow-lg hover:bg-pink-50 transition-colors duration-200">
                                <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </button>
                        </div>

                        <!-- New Badge -->
                        <div
                            class="absolute bottom-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                            BARU
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <!-- Category -->
                        <span class="text-sm text-pink-600 font-medium uppercase tracking-wide">
                            {{ $product['category'] }}
                        </span>

                        <!-- Product Name -->
                        <h3
                            class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-pink-600 transition-colors duration-300">
                            {{ $product['name'] }}
                        </h3>

                        <!-- Product Description -->
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ Str::limit($product['description'], 80) }}
                        </p>

                        <!-- Rating -->
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-400">
                                @for ($star = 1; $star <= 5; $star++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path
                                            d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-gray-600 text-sm ml-2">({{ $product['rating'] }})</span>
                        </div>

                        <!-- Price -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                @if(isset($product['original_price']) && $product['original_price'] > $product['price'])
                                    <span class="text-gray-400 line-through text-sm">
                                        Rp {{ number_format($product['original_price'], 0, ',', '.') }}
                                    </span>
                                @endif
                                <span class="text-2xl font-bold text-pink-600">
                                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Add to Cart Button -->
                        <a href="{{ route('product.detail', $product['id']) }}"
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-300 transform hover:scale-105 block text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                                <span>Lihat Detail</span>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                @for ($j = 1; $j <= 3; $j++)
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                        <!-- Fallback content if no products -->
                        <div class="relative overflow-hidden">
                            <img src="https://via.placeholder.com/300x300/f3f4f6/6b7280?text=Sandal+{{ $j }}"
                                alt="Sandal {{ $j }}"
                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="p-6">
                            <span class="text-sm text-pink-600 font-medium uppercase tracking-wide">
                                {{ ['Sandal Wanita', 'Sandal Pria', 'Sandal Anak'][($j - 1) % 3] }}
                            </span>
                            <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3">
                                Sandal Premium Model {{ $j }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4">
                                Produk akan segera tersedia
                            </p>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>

        <!-- View All Button -->
        <div class="text-center">
            <a href="{{ route('products') }}"
                class="inline-flex items-center space-x-3 bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 text-white font-semibold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                <span class="text-lg">Lihat Selengkapnya</span>
                <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform duration-300" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</section>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>