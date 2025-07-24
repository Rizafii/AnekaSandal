@extends('app')

@section('content')
    @livewire('products-page')
@endsection

<!-- Sort Filter -->
<select class="px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-transparent">
    <option value="newest">Terbaru</option>
    <option value="oldest">Terlama</option>
    <option value="price-low">Harga Terendah</option>
    <option value="price-high">Harga Tertinggi</option>
    <option value="rating">Rating Tertinggi</option>
</select>
</div>
</div>
</div>
</section>

<!-- Products Grid Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Results Info -->
        <div class="flex justify-between items-center mb-8">
            <p class="text-gray-600">
                Menampilkan <span class="font-semibold text-gray-900">1-24</span> dari <span
                    class="font-semibold text-gray-900">156</span> produk
            </p>

            <!-- View Toggle -->
            <div class="flex bg-gray-100 rounded-lg p-1">
                <button class="px-3 py-2 bg-white text-pink-600 rounded-md shadow-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                </button>
                <button class="px-3 py-2 text-gray-500 hover:text-pink-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 mb-12">
            @forelse($products as $product)
                <a href="{{ route('product.detail', ['id' => $product->id]) }}" class="group">
                    <div
                        class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">

                            <!-- Discount Badge -->
                            @if($product->discount > 0)
                                <div
                                    class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    -{{ $product->discount }}%
                                </div>
                            @endif

                            <!-- Quick Actions -->
                            <div
                                class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 space-y-2">
                                <button
                                    class="bg-white p-2 rounded-full shadow-lg hover:bg-pink-50 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>
                                <button
                                    class="bg-white p-2 rounded-full shadow-lg hover:bg-pink-50 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Stock Badge -->
                            @if($product->stock <= 5)
                                <div
                                    class="absolute bottom-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    STOK TERBATAS
                                </div>
                            @elseif($product->stock > 0)
                                <div
                                    class="absolute bottom-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    TERSEDIA
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-6">
                            <!-- Category -->
                            <span class="text-sm text-pink-600 font-medium uppercase tracking-wide">
                                {{ $product->category }}
                            </span>

                            <!-- Product Name -->
                            <h3
                                class="text-xl font-bold text-gray-900 mt-2 mb-3 group-hover:text-pink-600 transition-colors duration-300">
                                {{ $product->name }}
                            </h3>

                            <!-- Product Description -->
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                {{ $product->description }}
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
                                <span class="text-gray-600 text-sm ml-2">({{ $product->rating }})</span>
                            </div>

                            <!-- Price -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    @if($product->original_price && $product->original_price > $product->price)
                                        <span class="text-gray-400 line-through text-sm">
                                            Rp {{ number_format($product->original_price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                    <span class="text-2xl font-bold text-pink-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Add to Cart Button -->
                            <button
                                class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-300 transform hover:scale-105">
                                <div class="flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5H6m1 0a1 1 0 11-2 0 1 1 0 012 0zm10 0a1 1 0 11-2 0 1 1 0 012 0z">
                                        </path>
                                    </svg>
                                    <span>Tambah ke Keranjang</span>
                                </div>
                            </button>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="max-w-md mx-auto">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2M4 13h2m13-8V4a2 2 0 00-2-2H9a2 2 0 00-2 2v1M4 13h2m13-8V4a2 2 0 00-2-2H9a2 2 0 00-2 2v1" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada produk yang tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
        </nav>
    </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 bg-gradient-to-r from-pink-600 to-rose-600">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h3 class="text-3xl font-bold text-white mb-4">
            Dapatkan Update Produk Terbaru
        </h3>
        <p class="text-pink-100 mb-8">
            Berlangganan newsletter kami untuk mendapatkan informasi tentang produk terbaru dan penawaran khusus
        </p>
        <div class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            <input type="email" placeholder="Masukkan email Anda"
                class="flex-1 px-6 py-3 rounded-xl border-0 focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-pink-600">
            <button
                class="px-8 py-3 bg-white text-pink-600 font-semibold rounded-xl hover:bg-gray-50 transition-colors duration-300">
                Berlangganan
            </button>
        </div>
    </div>
</section>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection