<div class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">Keranjang Belanja</h1>
        <span class="ml-3 bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
            {{ count($cartItems) }} item
        </span>
    </div>

    @if(count($cartItems) > 0)
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <!-- Header with select all -->
            <div class="p-4 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="selectAll"
                        class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                    <label class="ml-3 text-sm font-medium text-gray-700">Pilih Semua</label>
                </div>
            </div>

            <!-- Cart items list -->
            <div class="divide-y divide-gray-100">
                @foreach($cartItems as $item)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-150">
                        <div class="flex items-start md:items-center">
                            <input type="checkbox" wire:model.live="selectedItems" value="{{ $item['id'] }}"
                                class="mt-1 md:mt-0 w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">

                            <div class="flex-shrink-0 ml-3 w-20 h-20">
                                <img src="{{ $item['product']['images'][0]['image_url'] ?? asset('images/placeholder.png') }}"
                                    alt="{{ $item['product']['name'] }}" class="w-full h-full object-cover rounded-lg">
                            </div>

                            <div class="flex-1 ml-4">
                                <div class="flex justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $item['product']['name'] }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $item['product']['description'] ?? '' }}</p>
                                        @if($item['variant'])
                                            <p class="text-sm text-gray-600">
                                                Ukuran: {{ $item['variant']['size'] }} | Warna: {{ $item['variant']['color'] }}
                                                @if($item['variant']['additional_price'] > 0)
                                                    <span
                                                        class="text-blue-600">+Rp{{ number_format($item['variant']['additional_price'], 0, ',', '.') }}</span>
                                                @endif
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-right ml-2">
                                        <p class="font-semibold text-blue-600">
                                            Rp{{ number_format($item['product']['price'] + ($item['variant']['additional_price'] ?? 0), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex items-center">
                                            <button type="button" wire:click="decreaseQuantity({{ $item['id'] }})"
                                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-l-md hover:bg-gray-200 transition-colors"
                                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            <input type="number"
                                                wire:change="updateQuantity({{ $item['id'] }}, $event.target.value)"
                                                value="{{ $item['quantity'] }}" min="1"
                                                class="w-12 text-center border-t border-b border-gray-200 h-8 py-1 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                                            <button type="button" wire:click="increaseQuantity({{ $item['id'] }})"
                                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-r-md hover:bg-gray-200 transition-colors">
                                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        @php
                                            $itemPrice = $item['product']['price'] + ($item['variant']['additional_price'] ?? 0);
                                            $itemSubtotal = $item['subtotal'] ?? ($itemPrice * $item['quantity']);
                                        @endphp
                                        <p class="font-semibold text-gray-800 whitespace-nowrap">
                                            Rp{{ number_format($itemSubtotal, 0, ',', '.') }}
                                        </p>
                                        <button wire:click="removeItem({{ $item['id'] }})"
                                            wire:confirm="Hapus item ini dari keranjang?"
                                            class="text-gray-400 hover:text-red-500 transition-colors" aria-label="Hapus item">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Checkout summary -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 px-6 py-4 shadow-sm">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">
                            <span>{{ $selectedCount }}</span> item dipilih
                        </p>
                        <p class="text-lg font-semibold text-gray-800">
                            Total: <span class="text-blue-600">Rp{{ number_format($selectedTotal, 0, ',', '.') }}</span>
                        </p>
                    </div>
                    <button wire:click="checkout"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200 disabled:bg-gray-300 disabled:cursor-not-allowed"
                        {{ $selectedCount === 0 ? 'disabled' : '' }}>
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <div class="mx-auto w-24 h-24 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Keranjang belanja kosong</h3>
            <p class="mt-2 text-gray-500">Tambahkan produk ke keranjang untuk mulai berbelanja</p>
            <div class="mt-6">
                <a href="{{ route('products') }}"
                    class="inline-flex items-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Temukan Produk
                </a>
            </div>
        </div>
    @endif

    <!-- Loading State -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-gray-700">Memproses...</span>
        </div>
    </div>
</div>