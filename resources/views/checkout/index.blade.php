@extends('app')

@section('title', 'Checkout')

@section('content')
    <div class="px-3 py-10 mt-16 bg-secondary min-h-screen">
        <div class="max-w-7xl mx-auto space-y-6">
            <!-- Breadcrumb -->
            <nav class="text-sm mb-6" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2 text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a></li>
                    <li class="text-gray-400">/</li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-primary transition-colors">Keranjang</a></li>
                    <li class="text-gray-400">/</li>
                    <li class="text-gray-700 font-medium">Checkout</li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900">Checkout</h1>
                            <p class="text-sm text-gray-600 mt-1">Lengkapi informasi pesanan Anda</p>
                        </div>
                    </div>
                </div>
                <!-- Progress Steps -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            1</div>
                        <span class="text-sm font-medium text-primary">Checkout</span>
                    </div>
                    <div class="w-8 h-0.5 bg-gray-300"></div>
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-semibold">
                            2</div>
                        <span class="text-sm text-gray-500">Pembayaran</span>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
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

            @if(session('error'))
                <div class="rounded-xl bg-red-50 border border-red-200 px-5 py-3 flex items-start gap-3 text-sm text-red-700">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <div class="flex-1">{{ session('error') }}</div>
                    <button type="button" class="text-red-500 hover:text-red-700"
                        onclick="this.parentElement.remove()">✕</button>
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-xl bg-red-50 border border-red-200 px-5 py-3 text-sm text-red-700">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                        <div class="flex-1">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="text-red-500 hover:text-red-700"
                            onclick="this.parentElement.parentElement.remove()">✕</button>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100/50 border-b border-gray-200/70">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <h2 class="text-lg font-bold text-gray-900">Ringkasan Pesanan</h2>
                                <span
                                    class="ml-auto px-3 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full">
                                    {{ count($items) }} Item
                                </span>
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            @foreach($items as $item)
                                <div class="flex items-center gap-4 p-4 bg-gray-50/50 rounded-xl border border-gray-100">
                                    <div class="relative flex-shrink-0 w-16 h-16">
                                        <img src="{{ $item->product->images->first()?->url ?? 'https://via.placeholder.com/64x64/f3f4f6/6b7280?text=No+Image' }}"
                                            alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                        <div
                                            class="absolute -top-2 -right-2 w-6 h-6 bg-primary text-white text-xs font-bold rounded-full flex items-center justify-center">
                                            {{ $item->quantity }}
                                        </div>
                                    </div>
                                    <div class="flex-grow min-w-0">
                                        <h3 class="font-semibold text-gray-900 line-clamp-1">{{ $item->product->name }}</h3>
                                        @if($item->variant)
                                            <div class="flex flex-wrap gap-2 mt-1">
                                                <span class="px-2 py-1 bg-gray-200 text-gray-700 text-xs rounded-md">
                                                    {{ $item->variant->size }}
                                                </span>
                                                @if($item->variant->color)
                                                    <span class="px-2 py-1 bg-gray-200 text-gray-700 text-xs rounded-md">
                                                        {{ $item->variant->color }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                        <p class="text-sm text-gray-600 mt-1">{{ $item->quantity }} x Rp
                                            {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-lg text-gray-900">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipping Information Form -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100/50 border-b border-gray-200/70">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <h2 class="text-lg font-bold text-gray-900">Informasi Pengiriman</h2>
                            </div>
                        </div>

                        <div class="p-6">
                            <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                                @csrf

                                <!-- Pass selected items if from cart -->
                                @if(request('selected_items'))
                                    @foreach(request('selected_items') as $itemId)
                                        <input type="hidden" name="selected_items[]" value="{{ $itemId }}">
                                    @endforeach
                                @endif

                                <div class="space-y-6">
                                    <!-- Contact Information -->
                                    <div class="space-y-4">
                                        <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Informasi Kontak
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="shipping_name"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Nama
                                                    Lengkap</label>
                                                <input type="text" name="shipping_name" id="shipping_name"
                                                    value="{{ old('shipping_name', auth()->user()->full_name) }}"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors"
                                                    placeholder="Masukkan nama lengkap" required>
                                                @error('shipping_name')
                                                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="shipping_phone"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                                                <input type="text" name="shipping_phone" id="shipping_phone"
                                                    value="{{ old('shipping_phone', auth()->user()->phone) }}"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors"
                                                    placeholder="08xxxxxxxxxx" required>
                                                @error('shipping_phone')
                                                    <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Shipping Address -->
                                    <div class="space-y-4">
                                        <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            Alamat Pengiriman
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="province"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                                                <select name="province_id" id="province"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors"
                                                    required>
                                                    <option value="">Pilih Provinsi</option>
                                                </select>
                                                @error('province_id')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="city"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten</label>
                                                <select name="city_id" id="city"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors"
                                                    required disabled>
                                                    <option value="">Pilih Kota/Kabupaten</option>
                                                </select>
                                                @error('city_id')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="district"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                                                <select name="district_id" id="district"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors"
                                                    required disabled>
                                                    <option value="">Pilih Kecamatan</option>
                                                </select>
                                                @error('district_id')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="shipping_postal_code"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Kode Pos</label>
                                                <input type="text" name="shipping_postal_code" id="shipping_postal_code"
                                                    value="{{ old('shipping_postal_code') }}"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors"
                                                    placeholder="12345" required>
                                                @error('shipping_postal_code')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="courier"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Kurir</label>
                                                <select name="courier" id="courier"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors"
                                                    required>
                                                    <option value="">Pilih Kurir</option>
                                                    <option value="jne">JNE</option>
                                                    <option value="sicepat">SiCepat</option>
                                                    <option value="ide">IDE</option>
                                                    <option value="sap">SAP</option>
                                                    <option value="jnt">J&T Express</option>
                                                    <option value="ninja">Ninja Express</option>
                                                    <option value="tiki">TIKI</option>
                                                    <option value="lion">Lion Parcel</option>
                                                    <option value="anteraja">AnterAja</option>
                                                    <option value="pos">POS Indonesia</option>
                                                </select>
                                                @error('courier')
                                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                        <div>
                                            <label for="shipping_address"
                                                class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                                            <textarea name="shipping_address" id="shipping_address" rows="3"
                                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors resize-none"
                                                placeholder="Masukkan alamat lengkap termasuk nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan"
                                                required>{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                            @error('shipping_address')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Shipping Service Selection -->
                                    <div id="shipping-services" class="space-y-4 hidden">
                                        <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                            Pilih Layanan Pengiriman
                                        </h3>
                                        <div id="service-options" class="space-y-3">
                                            <!-- Service options will be loaded here -->
                                            <div id="loading-services" class="hidden">
                                                <div class="flex items-center justify-center py-8">
                                                    <div class="flex items-center gap-3">
                                                        <svg class="animate-spin w-5 h-5 text-primary" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                                stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                            </path>
                                                        </svg>
                                                        <span class="text-sm text-gray-600">Memuat layanan
                                                            pengiriman...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="shipping_service" id="selected-service">
                                        <input type="hidden" name="shipping_cost" id="selected-cost">
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <button type="submit" id="checkout-btn"
                                        class="w-full bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary text-white py-4 px-6 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                        <span id="btn-text" class="flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            Lanjutkan ke Pembayaran
                                        </span>
                                        <span id="btn-loading" class="hidden">
                                            <div class="flex items-center justify-center gap-2">
                                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                Memproses...
                                            </div>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Order Total Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        <!-- Order Summary Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
                            <div
                                class="px-6 py-4 bg-gradient-to-r from-primary/5 to-primary/10 border-b border-gray-200/70">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h2 class="text-lg font-bold text-gray-900">Ringkasan Biaya</h2>
                                </div>
                            </div>

                            <div class="p-6 space-y-4">
                                <!-- Cost Breakdown -->
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-sm text-gray-600">Subtotal ({{ count($items) }} item)</span>
                                        <span class="text-sm font-semibold text-gray-900">Rp
                                            {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>

                                    <div class="flex justify-between items-center py-2 border-t border-gray-100">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-gray-600">Ongkos Kirim</span>
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <span id="shipping-cost-display" class="text-sm font-semibold text-gray-900">
                                            <span class="text-gray-500">Pilih alamat dulu</span>
                                        </span>
                                    </div>

                                    <div class="flex justify-between items-center py-3 border-t-2 border-gray-200">
                                        <span class="text-base font-bold text-gray-900">Total Pembayaran</span>
                                        <span id="final-amount-display" class="text-lg font-bold text-primary">
                                            Rp {{ number_format($total, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Info -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
                            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-blue-100/50 border-b border-blue-200/70">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-gray-900">Metode Pembayaran</h3>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-center gap-3 p-4 bg-blue-50 rounded-xl border border-blue-200">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-blue-900">Transfer Bank Manual</h4>
                                        <p class="text-xs text-blue-700 mt-1">Anda akan diarahkan untuk melakukan pembayaran
                                            setelah konfirmasi pesanan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Security Badge -->
                        <div class="bg-white rounded-xl p-4 border border-gray-200/50">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-xs font-semibold text-gray-900">Transaksi Aman</h4>
                                    <p class="text-xs text-gray-600">Data Anda dilindungi dengan enkripsi SSL</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const provinceSelect = document.getElementById('province');
                const citySelect = document.getElementById('city');
                const districtSelect = document.getElementById('district');
                const courierSelect = document.getElementById('courier');
                const shippingServices = document.getElementById('shipping-services');
                const serviceOptions = document.getElementById('service-options');
                const loadingServices = document.getElementById('loading-services');
                const shippingCostDisplay = document.getElementById('shipping-cost-display');
                const finalAmountDisplay = document.getElementById('final-amount-display');
                const subtotal = {{ $total }};

                // Load provinces on page load
                loadProvinces();

                // Province change handler
                provinceSelect.addEventListener('change', function () {
                    const provinceId = this.value;
                    if (provinceId) {
                        loadCities(provinceId);
                        resetShipping();
                        resetDistricts();
                    } else {
                        citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                        citySelect.disabled = true;
                        resetShipping();
                        resetDistricts();
                    }
                });

                // City change handler
                citySelect.addEventListener('change', function () {
                    const cityId = this.value;
                    if (cityId) {
                        loadDistricts(cityId);
                        resetShipping();
                    } else {
                        resetDistricts();
                        resetShipping();
                    }
                });

                // District change handler
                districtSelect.addEventListener('change', function () {
                    const districtId = this.value;
                    const courier = courierSelect.value;

                    if (districtId && courier) {
                        loadShippingCosts(districtId, courier);
                    } else {
                        resetShipping();
                    }
                });

                // Courier change handler
                courierSelect.addEventListener('change', function () {
                    const districtId = districtSelect.value;
                    const courier = this.value;

                    if (districtId && courier) {
                        loadShippingCosts(districtId, courier);
                    } else {
                        resetShipping();
                    }
                });

                function loadProvinces() {
                    fetch('/api/rajaongkir/provinces')
                        .then(response => response.json())
                        .then(data => {
                            provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                            data.forEach(province => {
                                provinceSelect.innerHTML += `<option value="${province.id}">${province.name}</option>`;
                            });
                        })
                        .catch(error => {
                            console.error('Error loading provinces:', error);
                            showAlert('error', 'Gagal memuat daftar provinsi');
                        });
                }

                function loadCities(provinceId) {
                    citySelect.disabled = true;
                    citySelect.innerHTML = '<option value="">Memuat...</option>';
                    resetDistricts();

                    fetch(`/api/rajaongkir/cities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                            data.forEach(city => {
                                citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                            });
                            citySelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error loading cities:', error);
                            citySelect.innerHTML = '<option value="">Gagal memuat kota</option>';
                            showAlert('error', 'Gagal memuat daftar kota');
                        });
                }

                function loadDistricts(cityId) {
                    districtSelect.disabled = true;
                    districtSelect.innerHTML = '<option value="">Memuat...</option>';

                    fetch(`/api/rajaongkir/districts/${cityId}`)
                        .then(response => response.json())
                        .then(data => {
                            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                            data.forEach(district => {
                                districtSelect.innerHTML += `<option value="${district.id}">${district.name}</option>`;
                            });
                            districtSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error loading districts:', error);
                            districtSelect.innerHTML = '<option value="">Gagal memuat kecamatan</option>';
                            showAlert('error', 'Gagal memuat daftar kecamatan');
                        });
                }

                function loadShippingCosts(destination, courier) {
                    shippingServices.classList.remove('hidden');
                    serviceOptions.innerHTML = '';
                    loadingServices.classList.remove('hidden');

                    // Calculate total weight from items
                    const items = @json($items);
                    let totalWeight = 0;
                    items.forEach(item => {
                        // Default weight per item is 500g if not specified
                        const itemWeight = item.product?.weight || 500;
                        const quantity = item.quantity || 1;
                        totalWeight += itemWeight * quantity;
                    });

                    // Minimum weight 1kg for shipping calculation
                    const weight = Math.max(totalWeight, 1000);

                    // Origin city ID - configured from store settings
                    const origin = '{{ App\Models\StoreSetting::getShippingOrigin() }}';
                    console.log('Loading shipping costs with:', {
                        origin,
                    });

                    fetch('/api/rajaongkir/shipping-cost', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: new URLSearchParams({
                            origin: origin,
                            destination: destination,
                            weight: weight,
                            courier: courier
                        })
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Shipping cost response:', data);
                            loadingServices.classList.add('hidden');

                            // Check if the response has the expected structure
                            const services = data.success && data.data ? data.data : [];
                            console.log('Services found:', services.length, services);

                            if (services.length > 0) {
                                services.forEach((service, index) => {
                                    console.log('Processing service:', service);
                                    if (service.costs && service.costs.length > 0) {
                                        service.costs.forEach(cost => {
                                            const serviceCard = createServiceCard(service.code, service.name, cost, index === 0);
                                            serviceOptions.appendChild(serviceCard);
                                        });
                                    }
                                });
                            } else {
                                console.log('No services available');
                                serviceOptions.innerHTML = '<div class="text-center py-4 text-gray-500">Tidak ada layanan pengiriman tersedia</div>';
                            }
                        })
                        .catch(error => {
                            console.error('Error loading shipping costs:', error);
                            loadingServices.classList.add('hidden');
                            serviceOptions.innerHTML = '<div class="text-center py-4 text-red-500">Gagal memuat biaya pengiriman</div>';
                            showAlert('error', 'Gagal memuat biaya pengiriman');
                        });
                }

                function createServiceCard(courierCode, courierName, cost, isSelected = false) {
                    const card = document.createElement('div');
                    card.className = `border rounded-xl p-4 cursor-pointer transition-all duration-200 ${isSelected ? 'border-primary bg-primary/5' : 'border-gray-200 hover:border-primary/50'}`;

                    card.innerHTML = `
                                                        <div class="flex items-center justify-between">
                                                            <div class="flex items-center gap-3">
                                                                <input type="radio" name="shipping_service_radio" value="${courierCode}_${cost.service}" 
                                                                       class="w-4 h-4 text-primary border-gray-300 focus:ring-primary" ${isSelected ? 'checked' : ''}>
                                                                <div>
                                                                    <div class="font-semibold text-gray-900">${courierName.toUpperCase()} - ${cost.service}</div>
                                                                    <div class="text-sm text-gray-600">${cost.description}</div>
                                                                    <div class="text-xs text-gray-500">Estimasi: ${cost.cost[0].etd} hari</div>
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <div class="font-bold text-lg text-gray-900">Rp ${cost.cost[0].value.toLocaleString('id-ID')}</div>
                                                            </div>
                                                        </div>
                                                    `;

                    card.addEventListener('click', function () {
                        // Uncheck all other radio buttons
                        document.querySelectorAll('input[name="shipping_service_radio"]').forEach(radio => {
                            radio.checked = false;
                            radio.closest('.border').classList.remove('border-primary', 'bg-primary/5');
                            radio.closest('.border').classList.add('border-gray-200');
                        });

                        // Check this radio button
                        const radio = card.querySelector('input[type="radio"]');
                        radio.checked = true;
                        card.classList.remove('border-gray-200');
                        card.classList.add('border-primary', 'bg-primary/5');

                        // Update hidden fields
                        document.getElementById('selected-service').value = `${courierCode}_${cost.service}`;
                        document.getElementById('selected-cost').value = cost.cost[0].value;

                        // Update display
                        updateCostDisplay(cost.cost[0].value);
                    });

                    // If this is selected by default
                    if (isSelected) {
                        document.getElementById('selected-service').value = `${courierCode}_${cost.service}`;
                        document.getElementById('selected-cost').value = cost.cost[0].value;
                        updateCostDisplay(cost.cost[0].value);
                    }

                    return card;
                }

                function updateCostDisplay(shippingCost) {
                    const finalAmount = subtotal + shippingCost;
                    shippingCostDisplay.innerHTML = `Rp ${shippingCost.toLocaleString('id-ID')}`;
                    finalAmountDisplay.innerHTML = `Rp ${finalAmount.toLocaleString('id-ID')}`;
                }

                function resetDistricts() {
                    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    districtSelect.disabled = true;
                }

                function resetShipping() {
                    shippingServices.classList.add('hidden');
                    serviceOptions.innerHTML = '';
                    shippingCostDisplay.innerHTML = '<span class="text-gray-500">Pilih alamat dulu</span>';
                    finalAmountDisplay.innerHTML = `Rp ${subtotal.toLocaleString('id-ID')}`;
                    document.getElementById('selected-service').value = '';
                    document.getElementById('selected-cost').value = '';
                }

                function showAlert(type, message) {
                    // You can implement a toast notification here
                    alert(message);
                }

                // Form submission handler
                document.getElementById('checkout-form').addEventListener('submit', function (e) {
                    console.log('Form submission started');

                    const btn = document.getElementById('checkout-btn');
                    const btnText = document.getElementById('btn-text');
                    const btnLoading = document.getElementById('btn-loading');

                    // Validate shipping service selection
                    const selectedService = document.getElementById('selected-service').value;
                    if (!selectedService) {
                        e.preventDefault();
                        showAlert('error', 'Silakan pilih layanan pengiriman terlebih dahulu');
                        return;
                    }

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
            });
        </script>
@endsection