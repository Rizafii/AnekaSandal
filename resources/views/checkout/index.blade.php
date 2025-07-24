@extends('app')

@section('title', 'Checkout')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Checkout</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-4">
                        @foreach($items as $item)
                            <div class="flex items-center bg-gray-50 p-4 rounded-lg">
                                <div class="flex-shrink-0 w-16 h-16">
                                    <img src="{{ $item->product->images->first()?->url ?? 'https://via.placeholder.com/64x64' }}"
                                        alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-md">
                                </div>
                                <div class="flex-grow ml-4">
                                    <h3 class="font-medium text-gray-800">{{ $item->product->name }}</h3>
                                    @if($item->variant)
                                        <p class="text-sm text-gray-600">
                                            Ukuran: {{ $item->variant->size }}
                                            @if($item->variant->color)
                                                | Warna: {{ $item->variant->color }}
                                            @endif
                                        </p>
                                    @endif
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-800">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Information Form -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Informasi Pengiriman</h2>

                    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                        @csrf

                        <!-- Pass selected items if from cart -->
                        @if(request('selected_items'))
                            @foreach(request('selected_items') as $itemId)
                                <input type="hidden" name="selected_items[]" value="{{ $itemId }}">
                            @endforeach
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Lengkap</label>
                                <input type="text" name="shipping_name" id="shipping_name"
                                    value="{{ old('shipping_name', auth()->user()->full_name) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error('shipping_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                    HP</label>
                                <input type="text" name="shipping_phone" id="shipping_phone"
                                    value="{{ old('shipping_phone', auth()->user()->phone) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error('shipping_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat
                                    Lengkap</label>
                                <textarea name="shipping_address" id="shipping_address" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                @error('shipping_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-2">Kota</label>
                                <input type="text" name="shipping_city" id="shipping_city"
                                    value="{{ old('shipping_city') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error('shipping_city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-2">Kode
                                    Pos</label>
                                <input type="text" name="shipping_postal_code" id="shipping_postal_code"
                                    value="{{ old('shipping_postal_code') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                                @error('shipping_postal_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="submit" id="checkout-btn"
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="btn-text">Lanjutkan ke Pembayaran</span>
                                <span id="btn-loading" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Total -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                    <h2 class="text-xl font-semibold mb-4">Ringkasan Biaya</h2>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Ongkos Kirim</span>
                            <span class="font-medium">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>

                        <hr class="my-3">

                        <div class="flex justify-between text-lg font-semibold">
                            <span>Total</span>
                            <span class="text-blue-600">Rp {{ number_format($finalAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h3 class="font-medium text-blue-800 mb-2">Metode Pembayaran</h3>
                        <p class="text-sm text-blue-700">Transfer Bank (Manual)</p>
                        <p class="text-xs text-blue-600 mt-1">Anda akan diarahkan untuk melakukan pembayaran setelah
                            mengkonfirmasi pesanan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('checkout-form').addEventListener('submit', function (e) {
            console.log('Form submission started');

            const btn = document.getElementById('checkout-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');

            // Disable button and show loading
            btn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');

            // Log all form data
            const formData = new FormData(this);
            console.log('Form data being submitted:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ':', value);
            }

            // Re-enable after 15 seconds as fallback
            setTimeout(function () {
                btn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
            }, 15000);
        });
    </script>
@endsection