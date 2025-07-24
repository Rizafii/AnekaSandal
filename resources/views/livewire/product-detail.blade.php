<div class="container mx-auto mt-20 px-4 py-8">
    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Images -->
        <div class="space-y-4">
            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                @if(isset($product['images']) && is_array($product['images']) && count($product['images']) > 0)
                    <img src="{{ $product['images'][0]['image_url'] ?? 'https://via.placeholder.com/400x400/f3f4f6/6b7280?text=No+Image' }}" 
                         alt="{{ $product['name'] ?? 'Product Image' }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            
            <!-- Thumbnail Images -->
            @if(isset($product['images']) && is_array($product['images']) && count($product['images']) > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach(array_slice($product['images'], 0, 4) as $image)
                        <div class="aspect-square bg-gray-100 rounded overflow-hidden cursor-pointer hover:opacity-75">
                            <img src="{{ $image['image_url'] ?? 'https://via.placeholder.com/100x100/f3f4f6/6b7280?text=No+Image' }}" 
                                 alt="{{ $product['name'] ?? 'Product Image' }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Information -->
        <div class="space-y-6">
            <!-- Product Title and Price -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $product['name'] ?? 'Nama Produk' }}</h1>
                <div class="mt-2">
                    <span class="text-3xl font-bold text-blue-600">Rp {{ number_format($product['price'] ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Product Description -->
            @if(isset($product['description']) && $product['description'])
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Deskripsi</h3>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $product['description'] }}</p>
                </div>
            @endif

            <!-- Size Selection -->
            @if(count($availableSizes) > 0)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Pilih Ukuran</h3>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($availableSizes as $sizeData)
                            <button
                                wire:click="selectSize('{{ $sizeData['size'] }}')"
                                class="px-4 py-2 text-sm font-medium border rounded-lg transition-colors
                                {{ $selectedSize === $sizeData['size'] 
                                    ? 'border-blue-500 bg-blue-50 text-blue-600' 
                                    : 'border-gray-300 hover:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500' }}
                                {{ $sizeData['total_stock'] == 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                {{ $sizeData['size'] }}
                                @if($sizeData['total_stock'] == 0)
                                    <span class="block text-xs text-red-500">Habis</span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Color Selection -->
            @if(count($availableColors) > 0)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Pilih Warna</h3>
                    <div class="flex space-x-3">
                        @foreach($availableColors as $colorData)
                            <button
                                wire:click="selectColor('{{ $colorData['color'] }}')"
                                class="w-10 h-10 rounded-full border-2 transition-colors relative
                                bg-{{ $colorData['color'] === 'navy' ? 'blue-900' : ($colorData['color'] === 'olive' ? 'green-800' : ($colorData['color'] === 'nude' ? 'yellow-200' : ($colorData['color'] === 'gray' ? 'gray-500' : $colorData['color'] . '-600'))) }}
                                {{ $selectedColor === $colorData['color'] 
                                    ? 'border-blue-500 ring-2 ring-blue-200' 
                                    : 'border-gray-300 focus:ring-2 focus:ring-blue-500' }}
                                {{ $colorData['available'] ? '' : 'opacity-50 cursor-not-allowed' }}">
                                @if(!$colorData['available'])
                                    <span class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                    @if($selectedColor)
                        <p class="text-sm text-gray-600 mt-2">Warna terpilih: <span class="capitalize font-medium">{{ $selectedColor }}</span></p>
                    @endif
                </div>
            @endif

            <!-- Quantity -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Jumlah</h3>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center border border-gray-300 rounded-lg">
                        <button 
                            wire:click="decreaseQuantity"
                            class="px-3 py-2 text-gray-600 hover:text-gray-800 focus:outline-none disabled:opacity-50"
                            {{ $quantity <= 1 || !$showStock ? 'disabled' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                        <input 
                            type="number" 
                            wire:model.live="quantity"
                            min="1" 
                            max="{{ $currentStock ?: 1 }}"
                            class="w-16 py-2 text-center border-0 focus:ring-0 focus:outline-none"
                            {{ !$showStock ? 'disabled' : '' }}>
                        <button 
                            wire:click="increaseQuantity"
                            class="px-3 py-2 text-gray-600 hover:text-gray-800 focus:outline-none disabled:opacity-50"
                            {{ $quantity >= $currentStock || !$showStock ? 'disabled' : '' }}>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                    
                    @if($showStock)
                        <div class="flex items-center space-x-2">
                            @if($currentStock > 0)
                                <span class="text-sm text-green-600 font-medium">
                                    Stok tersedia: {{ $currentStock }}
                                </span>
                                @if($currentStock <= 5)
                                    <span class="text-xs text-amber-600 bg-amber-100 px-2 py-1 rounded">
                                        Stok terbatas!
                                    </span>
                                @endif
                            @else
                                <span class="text-sm text-red-600 font-medium">
                                    Stok habis untuk varian ini
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
                
                @if(!$showStock)
                    <div class="mt-2">
                        <p class="text-sm text-amber-600">Silakan pilih ukuran dan warna untuk melihat stok</p>
                    </div>
                @endif

                @if($selectedSize && $selectedColor && $currentStock === 0)
                    <div class="mt-2">
                        <p class="text-sm text-red-600">Maaf, varian {{ $selectedSize }} - {{ $selectedColor }} sedang habis</p>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button
                    wire:click="addToCart"
                    wire:loading.attr="disabled"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ (!$showStock || $currentStock === 0) ? 'disabled' : '' }}>
                    <div wire:loading wire:target="addToCart" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                    <svg wire:loading.remove wire:target="addToCart" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 2.5M7 13l2.5 2.5M17 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2" />
                    </svg>
                    <span>
                        <span wire:loading.remove wire:target="addToCart">Tambah ke Keranjang</span>
                        <span wire:loading wire:target="addToCart">Menambahkan...</span>
                    </span>
                </button>
                <button
                    wire:click="buyNow"
                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ (!$showStock || $currentStock === 0) ? 'disabled' : '' }}>
                    Beli Sekarang
                </button>
                <button
                    wire:click="toggleWishlist"
                    class="w-full border border-gray-300 hover:border-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-colors duration-200 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <span>{{ $isInWishlist ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist' }}</span>
                </button>
            </div>
        </div>
    </div>
</div>
