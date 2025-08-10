<div class="px-3 py-10 mt-16 bg-secondary min-h-screen">
    <div class="w-full mx-auto">
        <!-- Breadcrumb -->
        <nav class="text-sm mb-6" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2 text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-700 font-medium">Keranjang Belanja</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900">Keranjang Belanja</h1>
                        <p class="text-sm text-gray-600 mt-1">Kelola produk yang ingin Anda beli</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-primary/10 text-primary text-sm font-semibold rounded-full border border-primary/20">
                    {{ count($cartItems) }} Item
                </span>
            </div>
        </div>

        @if(count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Cart Items Section -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
                        <!-- Select All Header -->
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100/50 border-b border-gray-200/70">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <input type="checkbox" wire:model.live="selectAll" id="selectAll"
                                        class="w-5 h-5 text-primary rounded border-gray-300 focus:ring-primary/30 focus:ring-2 transition-all duration-200">
                                    <label for="selectAll" class="text-sm font-semibold text-gray-700 cursor-pointer">Pilih Semua Produk</label>
                                </div>
                                <span class="text-xs text-gray-500 bg-white/70 px-3 py-1 rounded-full">
                                    {{ count($cartItems) }} produk tersedia
                                </span>
                            </div>
                        </div>

                        <!-- Cart Items List -->
                        <div class="divide-y divide-gray-100">
                            @foreach($cartItems as $item)
                                <div class="group p-6 hover:bg-gradient-to-r hover:from-gray-50/50 hover:to-transparent transition-all duration-300">
                                    <div class="flex gap-4">
                                        <!-- Checkbox -->
                                        <div class="flex items-start pt-2">
                                            <input type="checkbox" wire:model.live="selectedItems" value="{{ $item['id'] }}" id="item-{{ $item['id'] }}"
                                                class="w-5 h-5 text-primary rounded border-gray-300 focus:ring-primary/30 focus:ring-2 transition-all duration-200">
                                        </div>

                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            <div class="relative w-24 h-24 md:w-28 md:h-28 rounded-xl overflow-hidden bg-gray-100 border border-gray-200/50 group-hover:shadow-md transition-all duration-300">
                                                <img src="{{ $item['product']['images'][0]['image_url'] ?? asset('images/placeholder.png') }}"
                                                    alt="{{ $item['product']['name'] }}" 
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                                <div class="absolute inset-0 bg-gradient-to-tr from-black/5 via-transparent to-primary/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                            </div>
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="text-lg font-semibold text-gray-900 truncate group-hover:text-primary transition-colors duration-200">
                                                        {{ $item['product']['name'] }}
                                                    </h3>
                                                    @if($item['product']['description'])
                                                        <p class="text-sm text-gray-600 mt-1 line-clamp-2">{{ $item['product']['description'] }}</p>
                                                    @endif
                                                    
                                                    @if($item['variant'])
                                                        <div class="flex flex-wrap gap-2 mt-3">
                                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h2a2 2 0 002-2V5z"/>
                                                                </svg>
                                                                {{ $item['variant']['size'] }}
                                                            </span>
                                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                                                <div class="w-2 h-2 rounded-full bg-current mr-1.5"></div>
                                                                {{ $item['variant']['color'] }}
                                                            </span>
                                                            @if($item['variant']['additional_price'] > 0)
                                                                <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-primary/10 text-primary rounded-full">
                                                                    +Rp{{ number_format($item['variant']['additional_price'], 0, ',', '.') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Price & Controls -->
                                                <div class="flex flex-col items-end gap-4">
                                                    <!-- Price -->
                                                    <div class="text-right">
                                                        <p class="text-xl font-bold text-primary">
                                                            Rp{{ number_format($item['product']['price'] + ($item['variant']['additional_price'] ?? 0), 0, ',', '.') }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">per unit</p>
                                                    </div>

                                                    <!-- Quantity Controls -->
                                                    <div class="flex items-center gap-3">
                                                        <div class="flex items-center bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                                                            <button type="button" wire:click="decreaseQuantity({{ $item['id'] }})"
                                                                class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                                </svg>
                                                            </button>
                                                            <input type="number"
                                                                wire:change="updateQuantity({{ $item['id'] }}, $event.target.value)"
                                                                value="{{ $item['quantity'] }}" min="1"
                                                                class="w-14 text-center bg-transparent border-0 py-2 text-sm font-semibold text-gray-900 focus:ring-0 focus:outline-none">
                                                            <button type="button" wire:click="increaseQuantity({{ $item['id'] }})"
                                                                class="w-10 h-10 flex items-center justify-center hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors duration-200">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Subtotal and Remove -->
                                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                                                <div class="flex items-center gap-2">
                                                    <button wire:click="removeItem({{ $item['id'] }})"
                                                        wire:confirm="Hapus item ini dari keranjang?"
                                                        class="inline-flex items-center gap-2 px-3 py-2 text-sm text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200 group/remove">
                                                        <svg class="w-4 h-4 group-hover/remove:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-sm text-gray-500">Subtotal</p>
                                                    @php
                                                        $itemPrice = $item['product']['price'] + ($item['variant']['additional_price'] ?? 0);
                                                        $itemSubtotal = $item['subtotal'] ?? ($itemPrice * $item['quantity']);
                                                    @endphp
                                                    <p class="text-xl font-bold text-gray-900">
                                                        Rp{{ number_format($itemSubtotal, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        <!-- Summary Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-primary/5 to-primary/10 border-b border-gray-200/70">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    Ringkasan Pesanan
                                </h3>
                            </div>

                            <div class="p-6 space-y-4">
                                <!-- Selected Items Info -->
                                <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-xl">
                                    <span class="text-sm text-gray-600">Item dipilih</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $selectedCount }} dari {{ count($cartItems) }}</span>
                                </div>

                                <!-- Price Breakdown -->
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Subtotal</span>
                                        <span class="text-sm font-medium text-gray-900">Rp{{ number_format($selectedTotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Biaya Pengiriman</span>
                                        <span class="text-sm text-gray-500">Dihitung saat checkout</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-base font-semibold text-gray-900">Total</span>
                                            <span class="text-xl font-bold text-primary">Rp{{ number_format($selectedTotal, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Checkout Button -->
                                <button wire:click="checkout"
                                    class="w-full mt-6 px-6 py-4 bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed disabled:shadow-none transform hover:scale-[1.02] disabled:hover:scale-100"
                                    {{ $selectedCount === 0 ? 'disabled' : '' }}>
                                    <div class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        <span>Lanjut ke Checkout</span>
                                    </div>
                                </button>

                                @if($selectedCount === 0)
                                    <p class="text-xs text-center text-gray-500 mt-2">Pilih minimal 1 item untuk melanjutkan</p>
                                @endif
                            </div>
                        </div>

                        <!-- Security Badge -->
                        <div class="bg-white rounded-xl p-4 border border-gray-200/50">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.031 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Transaksi Aman</p>
                                    <p class="text-xs text-gray-500">Dilindungi dengan enkripsi SSL</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart State -->
            <div class="text-center py-16">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 p-12 max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Keranjang Belanja Kosong</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Belum ada produk yang ditambahkan ke keranjang. Yuk, mulai berbelanja dan temukan produk terbaik untuk Anda!
                    </p>
                    <div class="space-y-3">
                        <a href="{{ route('products') }}"
                            class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Jelajahi Produk
                        </a>
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center justify-center w-full px-6 py-3 text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>