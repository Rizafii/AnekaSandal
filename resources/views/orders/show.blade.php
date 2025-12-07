@extends('app')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')

    <div class="container mx-auto px-4 py-8 mt-16 relative z-10">
        <!-- Header with Back Button -->
        <div class="flex items-center gap-6 mb-8">
            <div>
                <h1 class="text-4xl font-bold text-gray-800">Detail Pesanan</h1>
                <p class="text-xl text-primary font-semibold mt-1">#{{ $order->order_number }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-primary/5 to-primary/10 border-b border-gray-200/70">
                        <div class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2M5 11h14">
                                        </path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-800">Item Pesanan</h2>
                                <span class="ml-auto bg-primary/10 text-primary px-3 py-1 rounded-lg text-sm font-semibold">
                                    {{ $order->items->count() }} Item
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="space-y-6">
                            @foreach($order->items as $item)
                                <div
                                    class="flex items-center gap-6 p-6 bg-gray-50/50 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                    <div class="flex-shrink-0 w-24 h-24 relative">
                                        @if($item->product && $item->product->images->count() > 0)
                                            <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product_name }}"
                                                class="w-24 h-24 object-cover rounded-xl shadow-md">
                                        @else
                                            <div
                                                class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-100 rounded-xl flex items-center justify-center shadow-md">
                                                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                        clip-rule="evenodd"></path>
                                            </div>
                                        @endif
                                        <div
                                            class="absolute -top-2 -right-2 w-8 h-8 bg-primary text-white text-sm rounded-full flex items-center justify-center font-bold shadow-lg">
                                            {{ $item->quantity }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $item->product_name }}</h3>
                                        @if($item->variant_info)
                                            <p class="text-sm text-gray-600 mb-3 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                    </path>
                                                </svg>
                                                {{ $item->variant_info }}
                                            </p>
                                        @endif
                                        <div class="flex items-center justify-between">
                                            <p class="text-gray-600 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                                    </path>
                                                </svg>
                                                Rp {{ number_format((float) $item->price) }} × {{ $item->quantity }}
                                            </p>
                                            <p class="text-2xl font-bold text-primary">
                                                Rp {{ number_format((float) $item->subtotal) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Total -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 rounded-xl p-6 border border-gray-200">
                                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Ringkasan Pembayaran
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="font-semibold text-gray-900">Rp
                                            {{ number_format((float) $order->total_amount) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-gray-600">Ongkos Kirim</span>
                                        <span class="font-semibold text-gray-900">Rp
                                            {{ number_format((float) $order->shipping_cost) }}</span>
                                    </div>
                                    <hr class="border-gray-300">
                                    <div
                                        class="flex justify-between items-center py-3 bg-gradient-to-r from-primary/10 to-primary/5 rounded-lg px-4">
                                        <span class="text-lg font-bold text-gray-800">Total Pembayaran</span>
                                        <span class="text-2xl font-bold text-primary">Rp
                                            {{ number_format((float) $order->final_amount) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Information -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 overflow-hidden">
                    <div class="bg-gradient-to-r from-primary/5 to-primary/10 border-b border-gray-200/70">
                        <div class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">Informasi Pesanan</h3>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Status Pesanan -->
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                                <label class="text-sm font-semibold text-gray-700 mb-2 block">Status Pesanan:</label>
                                @php
                                    $statusConfig = match ($order->status) {
                                        'menunggu_pembayaran' => [
                                            'class' => 'bg-yellow-500 text-white',
                                            'text' => 'Menunggu Pembayaran'
                                        ],
                                        'sedang_dikirim' => [
                                            'class' => 'bg-blue-500 text-white',
                                            'text' => 'Sedang Dikirim'
                                        ],
                                        'selesai' => [
                                            'class' => 'bg-green-500 text-white',
                                            'text' => 'Selesai'
                                        ],
                                        'dibatalkan' => [
                                            'class' => 'bg-red-500 text-white',
                                            'text' => 'Dibatalkan'
                                        ],
                                        default => [
                                            'class' => 'bg-gray-500 text-white',
                                            'text' => ucfirst(str_replace('_', ' ', $order->status))
                                        ]
                                    };
                                @endphp
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold {{ $statusConfig['class'] }}">
                                    {{ $statusConfig['text'] }}
                                </span>

                                @if($order->status === 'sedang_dikirim' && $order->tracking_number && $order->courier)
                                    <!-- Tracking Summary -->\n <div id="trackingSummary" class="mt-4 hidden">
                                        <div class="bg-white rounded-lg p-3 border border-primary/20">
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                                                    </path>
                                                </svg>
                                                <span class="text-xs font-semibold text-gray-700">Status Pengiriman:</span>
                                            </div>
                                            <p class="text-sm font-semibold text-gray-900" id="summaryStatus">Memuat data...</p>
                                            <p class="text-xs text-gray-600 mt-1" id="summaryDate">-</p>
                                            <button onclick="openTrackingModal()"
                                                class="mt-3 w-full bg-primary/10 hover:bg-primary/20 text-primary font-medium py-2 px-3 rounded-lg text-xs transition-colors">
                                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Lihat Selengkapnya
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Loading State -->
                                    <div id="trackingSummaryLoading" class="mt-4">
                                        <div class="bg-white rounded-lg p-3 border border-gray-200">
                                            <div class="flex items-center gap-2">
                                                <svg class="animate-spin h-4 w-4 text-primary" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                <span class="text-xs text-gray-600">Memuat status pengiriman...</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Order Details -->
                            <div class="space-y-4">
                                <div class="flex flex-col gap-1">
                                    <label class="text-sm font-semibold text-gray-700">Nomor Pesanan:</label>
                                    <p class="text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded-lg border">
                                        {{ $order->order_number }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="text-sm font-semibold text-gray-700">Tanggal Pesanan:</label>
                                    <p class="text-gray-900 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                @if($order->notes)
                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm font-semibold text-gray-700">Catatan:</label>
                                        <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg border italic">
                                            {{ $order->notes }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Shipping Info -->
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="text-md font-bold text-gray-800 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Informasi Pengiriman
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm font-semibold text-gray-700">Nama Penerima:</label>
                                        <p class="text-gray-900">{{ $order->shipping_name }}</p>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm font-semibold text-gray-700">Telepon:</label>
                                        <p class="text-gray-900">{{ $order->shipping_phone }}</p>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-sm font-semibold text-gray-700">Alamat:</label>
                                        <p
                                            class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg border text-sm leading-relaxed">
                                            {{ $order->shipping_address }}
                                        </p>
                                    </div>
                                    @if($order->shipping_postal_code)
                                        <div class="flex flex-col gap-1">
                                            <label class="text-sm font-semibold text-gray-700">Kode Pos:</label>
                                            <p class="text-gray-900 font-mono">{{ $order->shipping_postal_code }}</p>
                                        </div>
                                    @endif
                                    @if($order->courier)
                                        <div class="flex flex-col gap-1">
                                            <label class="text-sm font-semibold text-gray-700">Kurir:</label>
                                            <p class="text-gray-900">{{ strtoupper($order->courier) }}</p>
                                        </div>
                                    @endif
                                    @if($order->tracking_number)
                                        <div class="flex flex-col gap-1">
                                            <label class="text-sm font-semibold text-gray-700">Nomor Resi:</label>
                                            <p class="text-gray-900 font-mono">{{ $order->tracking_number }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="border-t border-gray-200 pt-4">
                                <livewire:order-confirmation :order="$order" />
                            </div>

                            <!-- Testimonial Section -->
                            @if($order->status === 'selesai')
                                <div class="border-t border-gray-200 pt-6 mt-6">
                                    <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        Berikan Testimoni
                                    </h4>
                                    <p class="text-gray-600 mb-4">Bagikan pengalaman Anda dengan produk yang sudah diterima!</p>

                                    <!-- Daftar produk untuk testimoni -->
                                    <div class="space-y-4">
                                        @foreach($order->items as $item)
                                            @php
                                                $hasTestimonial = $order->testimonials()
                                                    ->where('product_id', $item->product_id)
                                                    ->where('user_id', auth()->id())
                                                    ->exists();
                                            @endphp

                                            <div class="bg-gray-50 rounded-lg p-4 border">
                                                <div class="flex items-center gap-4 mb-3">
                                                    @if($item->product && $item->product->images->count() > 0)
                                                        <img src="{{ $item->product->images->first()->url }}"
                                                            alt="{{ $item->product_name }}" class="w-16 h-16 object-cover rounded-lg">
                                                    @else
                                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd"
                                                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="flex-1">
                                                        <h5 class="font-semibold text-gray-900">{{ $item->product_name }}</h5>
                                                        @if($item->variant_info)
                                                            <p class="text-sm text-gray-600">{{ $item->variant_info }}</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($hasTestimonial)
                                                    <div class="flex items-center gap-2 text-green-600">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="font-medium">Testimoni sudah diberikan</span>
                                                    </div>
                                                @else
                                                    <!-- Form Testimoni -->
                                                    <form action="{{ route('testimonials.store') }}" method="POST"
                                                        enctype="multipart/form-data" class="space-y-4">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">

                                                        <!-- Rating -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                                            <div class="flex gap-1" data-rating-input>
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <button type="button"
                                                                        class="rating-star text-2xl text-gray-300 hover:text-yellow-400 transition-colors"
                                                                        data-value="{{ $i }}">
                                                                        ★
                                                                    </button>
                                                                @endfor
                                                                <input type="hidden" name="rating" value="5" required>
                                                            </div>
                                                        </div>

                                                        <!-- Review -->
                                                        <div>
                                                            <label for="review-{{ $item->product_id }}"
                                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                                Ulasan (Opsional)
                                                            </label>
                                                            <textarea id="review-{{ $item->product_id }}" name="review" rows="3"
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50"
                                                                placeholder="Ceritakan pengalaman Anda dengan produk ini..."></textarea>
                                                        </div>

                                                        <!-- Image Upload -->
                                                        <div>
                                                            <label for="image-{{ $item->product_id }}"
                                                                class="block text-sm font-medium text-gray-700 mb-2">
                                                                Foto Produk (Opsional)
                                                            </label>
                                                            <input type="file" id="image-{{ $item->product_id }}" name="image"
                                                                accept="image/jpeg,image/jpg,image/png"
                                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary/50">
                                                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                                                        </div>

                                                        <!-- Submit Button -->
                                                        <button type="submit"
                                                            class="w-full bg-primary text-white py-2 px-4 rounded-md hover:bg-primary/90 transition-colors font-medium">
                                                            Kirim Testimoni
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tracking Modal -->
    @if($order->status === 'sedang_dikirim' && $order->tracking_number && $order->courier)
        <div id="trackingModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-2xl bg-white">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-4 pb-4 border-b">
                    <h3 class="text-xl font-bold text-gray-900">Detail Tracking Pengiriman</h3>
                    <button onclick="closeTrackingModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Content -->
                <div class="max-h-[70vh] overflow-y-auto">
                    <!-- Tracking Info -->
                    <div id="modalTrackingInfo">
                        <div class="bg-gray-50 rounded-xl p-4 mb-4">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">No. Resi:</span>
                                    <span class="font-semibold text-gray-900 block"
                                        id="modalTrackingWaybill">{{ $order->tracking_number }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Kurir:</span>
                                    <span class="font-semibold text-gray-900 block"
                                        id="modalTrackingCourier">{{ strtoupper($order->courier) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div id="modalTrackingStatus" class="bg-primary/10 border border-primary/20 rounded-xl p-4 mb-4">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-primary mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-semibold text-gray-900" id="modalStatusDescription">-</h4>
                                    <p class="text-sm text-gray-600" id="modalStatusLocation">-</p>
                                </div>
                            </div>
                        </div>

                        <!-- History Timeline -->
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Riwayat Pengiriman</h4>
                            <div id="modalTrackingHistory" class="space-y-3">
                                <!-- Will be filled by JavaScript -->
                            </div>
                        </div>

                        <!-- API Source -->
                        <div class="mt-4 text-xs text-gray-500 text-right">
                            Data dari: <span id="modalApiSource" class="font-medium">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Handle rating stars
            const ratingInputs = document.querySelectorAll('[data-rating-input]');

            ratingInputs.forEach(ratingInput => {
                const stars = ratingInput.querySelectorAll('.rating-star');
                const hiddenInput = ratingInput.querySelector('input[name="rating"]');

                stars.forEach((star, index) => {
                    star.addEventListener('click', function () {
                        const value = parseInt(this.dataset.value);
                        hiddenInput.value = value;

                        // Update star colors
                        stars.forEach((s, i) => {
                            if (i < value) {
                                s.classList.remove('text-gray-300');
                                s.classList.add('text-yellow-400');
                            } else {
                                s.classList.remove('text-yellow-400');
                                s.classList.add('text-gray-300');
                            }
                        });
                    });

                    star.addEventListener('mouseenter', function () {
                        const value = parseInt(this.dataset.value);

                        stars.forEach((s, i) => {
                            if (i < value) {
                                s.classList.add('text-yellow-300');
                            } else {
                                s.classList.remove('text-yellow-300');
                            }
                        });
                    });
                });

                ratingInput.addEventListener('mouseleave', function () {
                    const currentValue = parseInt(hiddenInput.value);

                    stars.forEach((s, i) => {
                        s.classList.remove('text-yellow-300');
                        if (i < currentValue) {
                            s.classList.add('text-yellow-400');
                        } else {
                            s.classList.add('text-gray-300');
                        }
                    });
                });

                // Set initial state (default 5 stars)
                const initialValue = parseInt(hiddenInput.value);
                stars.forEach((s, i) => {
                    if (i < initialValue) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-yellow-400');
                    }
                });
            });
        });

        // Tracking functionality
        const CACHE_DURATION = 30 * 60 * 1000; // 30 minutes in milliseconds
        const orderId = {{ $order->id }};
        const trackingNumber = '{{ $order->tracking_number ?? '' }}';
        const courier = '{{ $order->courier ?? '' }}';
        let trackingData = null;

        function getCacheKey() {
            return `tracking_${orderId}_${courier}_${trackingNumber}`;
        }

        function openTrackingModal() {
            document.getElementById('trackingModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeTrackingModal() {
            document.getElementById('trackingModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function getCachedData() {
            try {
                const cacheKey = getCacheKey();
                const cached = localStorage.getItem(cacheKey);

                if (cached) {
                    const data = JSON.parse(cached);
                    const now = new Date().getTime();

                    // Check if cache is still valid
                    if (now - data.timestamp < CACHE_DURATION) {
                        console.log('Using cached tracking data');
                        return data.result;
                    } else {
                        // Clear expired cache
                        localStorage.removeItem(cacheKey);
                    }
                }
            } catch (e) {
                console.error('Error reading cache:', e);
            }
            return null;
        }

        function setCachedData(result) {
            try {
                const cacheKey = getCacheKey();
                const data = {
                    timestamp: new Date().getTime(),
                    result: result
                };
                localStorage.setItem(cacheKey, JSON.stringify(data));
                console.log('Tracking data cached');
            } catch (e) {
                console.error('Error saving cache:', e);
            }
        }

        function displayTrackingData(result) {
            if (!result.success) {
                // Hide loading, keep summary hidden
                const loadingEl = document.getElementById('trackingSummaryLoading');
                if (loadingEl) loadingEl.classList.add('hidden');
                return;
            }

            trackingData = result;
            const data = result.data;

            // Update summary in status section
            const summaryEl = document.getElementById('trackingSummary');
            const loadingEl = document.getElementById('trackingSummaryLoading');
            const summaryStatusEl = document.getElementById('summaryStatus');
            const summaryDateEl = document.getElementById('summaryDate');

            if (summaryEl && summaryStatusEl && summaryDateEl) {
                summaryStatusEl.textContent = data.status.description || 'Dalam proses pengiriman';
                if (data.history && data.history.length > 0) {
                    const latestHistory = data.history[0];
                    summaryDateEl.textContent = `${latestHistory.date || '-'} ${latestHistory.time || ''}`;
                }
                loadingEl.classList.add('hidden');
                summaryEl.classList.remove('hidden');
            }

            // Update modal content
            document.getElementById('modalTrackingWaybill').textContent = data.waybill || trackingNumber;
            document.getElementById('modalTrackingCourier').textContent = data.courier || courier.toUpperCase();
            document.getElementById('modalStatusDescription').textContent = data.status.description || 'Dalam proses pengiriman';
            document.getElementById('modalStatusLocation').textContent = data.status.code || '-';

            // Update history in modal
            const historyContainer = document.getElementById('modalTrackingHistory');
            historyContainer.innerHTML = '';

            if (data.history && data.history.length > 0) {
                data.history.forEach((item, index) => {
                    const historyItem = document.createElement('div');
                    historyItem.className = 'flex gap-3';

                    historyItem.innerHTML = `
                            <div class="flex-shrink-0 w-2 h-2 rounded-full ${index === 0 ? 'bg-primary' : 'bg-gray-300'} mt-2"></div>
                            <div class="flex-1 pb-3 ${index !== data.history.length - 1 ? 'border-l-2 border-gray-200 pl-3 ml-1' : 'pl-3 ml-1'}">
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                    <div class="flex items-start justify-between mb-1">
                                        <span class="text-xs font-semibold text-gray-500">${item.date || '-'} ${item.time || ''}</span>
                                        ${item.location ? `<span class="text-xs text-gray-500">${item.location}</span>` : ''}
                                    </div>
                                    <p class="text-sm text-gray-900">${item.description || '-'}</p>
                                </div>
                            </div>
                        `;

                    historyContainer.appendChild(historyItem);
                });
            } else {
                historyContainer.innerHTML = '<p class="text-sm text-gray-500 text-center py-4">Tidak ada riwayat pengiriman</p>';
            }

            // Update API source
            document.getElementById('modalApiSource').textContent = result.source === 'rajaongkir' ? 'RajaOngkir' : 'BinderByte';
        }

        async function loadTracking() {
            // Check if tracking info is available
            if (!trackingNumber || !courier) {
                console.log('No tracking info available');
                return;
            }

            // Check cache first
            const cached = getCachedData();
            if (cached) {
                displayTrackingData(cached);
                return;
            }

            // Fetch from API
            try {
                const response = await fetch(`{{ route('orders.track', $order->id) }}`);
                const result = await response.json();

                if (result.success) {
                    // Cache the result
                    setCachedData(result);
                    displayTrackingData(result);
                } else {
                    console.error('Tracking failed:', result.message);
                    const loadingEl = document.getElementById('trackingSummaryLoading');
                    if (loadingEl) loadingEl.classList.add('hidden');
                }
            } catch (error) {
                console.error('Error fetching tracking data:', error);
                const loadingEl = document.getElementById('trackingSummaryLoading');
                if (loadingEl) loadingEl.classList.add('hidden');
            }
        }

        // Auto-load tracking when page loads if status is sedang_dikirim
        @if($order->status === 'sedang_dikirim' && $order->tracking_number && $order->courier)
            document.addEventListener('DOMContentLoaded', function () {
                loadTracking();
            });
        @endif
    </script>
@endpush