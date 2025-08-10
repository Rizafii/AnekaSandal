<div class="px-3 py-10 mt-16 bg-secondary">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Breadcrumb -->
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2 text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-primary">Beranda</a></li>
                <li class="text-gray-400">/</li>
                <li><a href="{{ route('products') }}" class="hover:text-primary">Produk</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-700 font-medium line-clamp-1">{{ $product['name'] ?? 'Produk' }}</li>
            </ol>
        </nav>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div
                class="rounded-xl bg-green-50 border border-green-200 px-5 py-3 flex items-start gap-3 text-sm text-green-700">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <div class="flex-1">{{ session('success') }}</div>
                <button type="button" class="text-green-500 hover:text-green-700"
                    onclick="this.parentElement.remove()">✕</button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="rounded-xl bg-red-50 border border-red-200 px-5 py-3 flex items-start gap-3 text-sm text-red-700">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <div class="flex-1">{{ session('error') }}</div>
                <button type="button" class="text-red-500 hover:text-red-700"
                    onclick="this.parentElement.remove()">✕</button>
            </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Gallery -->
            <div class="space-y-4">
                <div class="group relative rounded-2xl overflow-hidden shadow-lg bg-gray-100 h-full">
                    @if(isset($product['images']) && is_array($product['images']) && count($product['images']) > 0)
                        <img id="mainProductImage"
                            src="{{ $product['images'][0]['image_url'] ?? 'https://via.placeholder.com/600x600/f3f4f6/6b7280?text=No+Image' }}"
                            alt="{{ $product['name'] ?? 'Product Image' }}"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="mt-4 text-sm">Tidak ada gambar</p>
                        </div>
                    @endif
                    <div
                        class="absolute inset-0 pointer-events-none bg-gradient-to-tr from-black/10 via-transparent to-primary/10 opacity-0 group-hover:opacity-100 transition">
                    </div>
                </div>

                @if(isset($product['images']) && is_array($product['images']) && count($product['images']) > 1)
                    <div class="flex gap-3 overflow-x-auto scrollbar-hide pb-1" id="thumbContainer">
                        @foreach($product['images'] as $idx => $image)
                            <button type="button" data-image="{{ $image['image_url'] ?? '' }}"
                                class="thumb-btn shrink-0 relative w-24 h-24 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary focus:outline-none focus:ring-2 focus:ring-primary/40 transition">
                                <img src="{{ $image['image_url'] ?? 'https://via.placeholder.com/100x100/f3f4f6/6b7280?text=No+Image' }}"
                                    alt="Thumbnail {{ $idx + 1 }}" class="w-full h-full object-cover" />
                                <span class="absolute inset-0 bg-primary/0 hover:bg-primary/10 transition"></span>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Info Card -->
            <div class="space-y-8">
                <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
                    <div class="space-y-4">
                        <div class="flex flex-wrap items-center gap-3">
                            @if(!empty($product['category']))
                                <span
                                    class="px-3 py-1 text-xs font-medium rounded-full bg-primary text-white shadow">{{ $product['category'] }}</span>
                            @endif
                            @if(!empty($product['discount']) && $product['discount'] > 0)
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-rose-100 text-rose-600">-{{ $product['discount'] }}%</span>
                            @endif
                        </div>
                        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                            {{ $product['name'] ?? 'Nama Produk' }}</h1>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="flex items-center gap-1 text-amber-500">
                                @php $rating = $product['rating'] ?? 4.5; @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @if($rating >= $i)
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.175 0L7.11 16.28c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.476 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @elseif($rating > $i - 1)
                                        <svg class="w-5 h-5" viewBox="0 0 20 20">
                                            <defs>
                                                <linearGradient id="half">
                                                    <stop offset="50%" stop-color="currentColor" />
                                                    <stop offset="50%" stop-color="transparent" />
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half)" stroke="currentColor"
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.175 0L7.11 16.28c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.476 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.802 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.802-2.034a1 1 0 00-1.175 0L7.11 16.28c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L3.476 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                                <span
                                    class="text-xs font-medium text-gray-500 ml-1">{{ number_format($rating, 1) }}</span>
                            </div>
                            @if(isset($product['sold_count']))
                                <span class="text-xs text-gray-500">Terjual
                                    {{ number_format($product['sold_count']) }}</span>
                            @endif
                            @if(isset($product['stock']))
                                <span class="text-xs px-2 py-1 rounded bg-emerald-50 text-emerald-600 font-medium">Stok
                                    total {{ $product['stock'] }}</span>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-end gap-3">
                                <span class="text-3xl font-extrabold text-primary">Rp
                                    {{ number_format($product['price'] ?? 0, 0, ',', '.') }}</span>
                                @if(!empty($product['original_price']))
                                    <span class="text-lg line-through text-gray-400">Rp
                                        {{ number_format($product['original_price'], 0, ',', '.') }}</span>
                                @endif
                            </div>
                        </div>
                        @if(isset($product['description']) && $product['description'])
                            <div class="prose max-w-none text-gray-600 leading-relaxed">
                                <p class="text-sm md:text-base">{{ $product['description'] }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Size Selection -->
                    @if(count($availableSizes) > 0)
                        <div class="space-y-3">
                            <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Ukuran</h3>
                            <div class="grid grid-cols-5 sm:grid-cols-6 md:grid-cols-7 gap-2">
                                @foreach($availableSizes as $sizeData)
                                    <button type="button" wire:click="selectSize('{{ $sizeData['size'] }}')"
                                        class="relative group text-sm font-medium rounded-lg px-3 py-2 border transition focus:outline-none focus:ring-2 focus:ring-primary/40
                                                    {{ $sizeData['total_stock'] == 0 ? 'cursor-not-allowed opacity-50' : 'hover:border-primary hover:text-primary' }}
                                                    {{ $selectedSize === $sizeData['size'] ? 'bg-primary text-white border-primary shadow' : 'bg-white border-gray-300 text-gray-700' }}">
                                        {{ $sizeData['size'] }}
                                        @if($sizeData['total_stock'] == 0)
                                            <span
                                                class="absolute inset-0 flex items-center justify-center text-[10px] font-semibold text-red-600 bg-white/70">Habis</span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Color Selection -->
                    @if(count($availableColors) > 0)
                        <div class="space-y-3">
                            <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Warna</h3>
                            @php
                                $colorClassMap = [
                                    'black' => 'bg-black text-white',
                                    'white' => 'bg-white border border-gray-300',
                                    'red' => 'bg-red-600',
                                    'maroon' => 'bg-red-800',
                                    'blue' => 'bg-blue-600',
                                    'navy' => 'bg-blue-900',
                                    'sky' => 'bg-sky-400',
                                    'green' => 'bg-green-600',
                                    'olive' => 'bg-green-800',
                                    'yellow' => 'bg-yellow-400',
                                    'nude' => 'bg-yellow-200',
                                    'orange' => 'bg-orange-500',
                                    'purple' => 'bg-purple-600',
                                    'pink' => 'bg-pink-500',
                                    'gray' => 'bg-gray-500',
                                    'brown' => 'bg-amber-800',
                                ];
                            @endphp
                            <div class="flex flex-wrap gap-3">
                                @foreach($availableColors as $colorData)
                                    @php $c = strtolower($colorData['color']);
                                    $cls = $colorClassMap[$c] ?? 'bg-gradient-to-br from-primary to-primary/70'; @endphp
                                    <button type="button" wire:click="selectColor('{{ $colorData['color'] }}')" class="relative w-11 h-11 rounded-full flex items-center justify-center ring-offset-2 transition
                                                    {{ $colorData['available'] ? 'cursor-pointer' : 'cursor-not-allowed opacity-40' }}
                                                    {{ $selectedColor === $colorData['color'] ? 'ring-2 ring-primary scale-105' : 'hover:scale-105' }}
                                                    {{ $cls }}">
                                        @if(!$colorData['available'])
                                            <span class="absolute inset-0 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white drop-shadow" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                            @if($selectedColor)
                                <p class="text-xs text-gray-500">Warna terpilih: <span
                                        class="capitalize font-medium text-gray-800">{{ $selectedColor }}</span></p>
                            @endif
                        </div>
                    @endif

                    <!-- Quantity -->
                    <div class="space-y-3">
                        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wide">Jumlah</h3>
                        <div class="flex flex-wrap items-center gap-6">
                            <div class="flex items-center border border-gray-300 rounded-xl bg-gray-50">
                                <button wire:click="decreaseQuantity"
                                    class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-gray-900 disabled:opacity-40"
                                    {{ $quantity <= 1 || !$showStock ? 'disabled' : '' }} aria-label="Kurangi">-</button>
                                <input type="number" wire:model.live="quantity" min="1" max="{{ $currentStock ?: 1 }}"
                                    class="w-14 text-center bg-transparent border-x border-gray-200 h-10 focus:outline-none focus:ring-0"
                                    {{ !$showStock ? 'disabled' : '' }} aria-label="Jumlah">
                                <button wire:click="increaseQuantity"
                                    class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-gray-900 disabled:opacity-40"
                                    {{ $quantity >= $currentStock || !$showStock ? 'disabled' : '' }}
                                    aria-label="Tambah">+</button>
                            </div>
                            <div class="space-y-1">
                                @if($showStock)
                                    @if($currentStock > 0)
                                        <p class="text-sm text-emerald-600 font-medium">Stok tersedia: {{ $currentStock }}</p>
                                        @if($currentStock <= 5)
                                            <p class="text-xs text-amber-600 bg-amber-50 inline-block px-2 py-0.5 rounded">Stok
                                                terbatas</p>
                                        @endif
                                    @else
                                        <p class="text-sm text-red-600 font-medium">Stok habis untuk varian ini</p>
                                    @endif
                                @else
                                    <p class="text-sm text-amber-600">Pilih ukuran & warna untuk melihat stok</p>
                                @endif
                                @if($selectedSize && $selectedColor && $currentStock === 0)
                                    <p class="text-xs text-red-500">Varian {{ $selectedSize }} - {{ $selectedColor }} tidak
                                        tersedia</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button wire:click="addToCart" wire:loading.attr="disabled"
                                class="flex-1 bg-primary hover:bg-primary/90 text-white font-semibold py-3 px-6 rounded-xl shadow-inner shadow-primary/30 transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                                {{ (!$showStock || $currentStock === 0) ? 'disabled' : '' }}>
                                <div wire:loading wire:target="addToCart"
                                    class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent">
                                </div>
                                <span wire:loading.remove wire:target="addToCart">Tambah ke Keranjang</span>
                                <span wire:loading wire:target="addToCart">Menambahkan...</span>
                            </button>
                            <button wire:click="buyNow"
                                class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 px-6 rounded-xl transition disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ (!$showStock || $currentStock === 0) ? 'disabled' : '' }}>Beli Sekarang</button>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button wire:click="toggleWishlist" type="button"
                                class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-xl border border-gray-300 bg-white hover:border-primary hover:text-primary transition">
                                <svg class="w-5 h-5 {{ $isInWishlist ? 'text-rose-500 fill-rose-500' : 'text-gray-500' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span>{{ $isInWishlist ? 'Hapus Wishlist' : 'Tambah Wishlist' }}</span>
                            </button>
                            <button type="button"
                                onclick="navigator.share && navigator.share({title: '{{ $product['name'] ?? '' }}', url: window.location.href})"
                                class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium rounded-xl border border-gray-300 bg-white hover:border-primary hover:text-primary transition">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 12v.01M12 4v.01M12 20v.01M20 12v.01M7.76 7.76l.01.01M16.24 7.76l.01.01M16.24 16.24l.01.01M7.76 16.24l.01.01M9 12a3 3 0 006 0 3 3 0 00-6 0z" />
                                </svg>
                                <span>Bagikan</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Trust / Advantages -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <div class="flex items-center gap-3 bg-white rounded-xl p-4 shadow hover:shadow-md transition">
                        <span
                            class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary"><svg
                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7l6 6-6 6M13 7l6 6-6 6" />
                            </svg></span>
                        <p class="text-xs font-medium text-gray-700 leading-tight">Pilihan Model</p>
                    </div>
                    <div class="flex items-center gap-3 bg-white rounded-xl p-4 shadow hover:shadow-md transition">
                        <span
                            class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary"><svg
                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h18v4H3zM8 7v13m8-13v13M3 21h18" />
                            </svg></span>
                        <p class="text-xs font-medium text-gray-700 leading-tight">Kemasan Aman</p>
                    </div>
                    <div class="flex items-center gap-3 bg-white rounded-xl p-4 shadow hover:shadow-md transition">
                        <span
                            class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary"><svg
                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.5 4.21l.82 1.61a1 1 0 00.75.55l1.78.26a1 1 0 01.55 1.7l-1.29 1.26a1 1 0 00-.29.88l.3 1.77a1 1 0 01-1.45 1.05L8 13.77a1 1 0 00-.93 0l-1.6.84a1 1 0 01-1.45-1.05l.3-1.77a1 1 0 00-.29-.88L2.74 8.33a1 1 0 01.55-1.7l1.78-.26a1 1 0 00.75-.55l.82-1.61a1 1 0 011.86 0z" />
                            </svg></span>
                        <p class="text-xs font-medium text-gray-700 leading-tight">Kualitas Teruji</p>
                    </div>
                    <div class="flex items-center gap-3 bg-white rounded-xl p-4 shadow hover:shadow-md transition">
                        <span
                            class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary"><svg
                                class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-9 4v8" />
                            </svg></span>
                        <p class="text-xs font-medium text-gray-700 leading-tight">Pengiriman Cepat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mainImg = document.getElementById('mainProductImage');
            const thumbs = document.querySelectorAll('.thumb-btn');
            thumbs.forEach(btn => {
                btn.addEventListener('click', () => {
                    const url = btn.getAttribute('data-image');
                    if (url && mainImg) {
                        mainImg.src = url;
                        thumbs.forEach(b => b.classList.remove('ring-2', 'ring-primary'));
                        btn.classList.add('ring-2', 'ring-primary');
                    }
                });
            });
            if (thumbs.length) { thumbs[0].classList.add('ring-2', 'ring-primary'); }
        });
    </script>
</div>