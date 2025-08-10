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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2H5a2 2 0 00-2 2v2M5 11h14"></path>
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
                                        <div class="flex items-center gap-6 p-6 bg-gray-50/50 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                            <div class="flex-shrink-0 w-24 h-24 relative">
                                                @if($item->product && $item->product->images->count() > 0)
                                                    <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product_name }}"
                                                        class="w-24 h-24 object-cover rounded-xl shadow-md">
                                                @else
                                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-100 rounded-xl flex items-center justify-center shadow-md">
                                                        <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                                clip-rule="evenodd"></path>
                                                    </div>
                                                @endif
                                                <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary text-white text-sm rounded-full flex items-center justify-center font-bold shadow-lg">
                                                    {{ $item->quantity }}
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $item->product_name }}</h3>
                                                @if($item->variant_info)
                                                    <p class="text-sm text-gray-600 mb-3 flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                        </svg>
                                                        {{ $item->variant_info }}
                                                    </p>
                                                @endif
                                                <div class="flex items-center justify-between">
                                                    <p class="text-gray-600 flex items-center gap-2">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            Ringkasan Pembayaran
                                        </h3>
                                        <div class="space-y-3">
                                            <div class="flex justify-between items-center py-2">
                                                <span class="text-gray-600">Subtotal</span>
                                                <span class="font-semibold text-gray-900">Rp {{ number_format((float) $order->total_amount) }}</span>
                                            </div>
                                            <div class="flex justify-between items-center py-2">
                                                <span class="text-gray-600">Ongkos Kirim</span>
                                                <span class="font-semibold text-gray-900">Rp {{ number_format((float) $order->shipping_cost) }}</span>
                                            </div>
                                            <hr class="border-gray-300">
                                            <div class="flex justify-between items-center py-3 bg-gradient-to-r from-primary/10 to-primary/5 rounded-lg px-4">
                                                <span class="text-lg font-bold text-gray-800">Total Pembayaran</span>
                                                <span class="text-2xl font-bold text-primary">Rp {{ number_format((float) $order->final_amount) }}</span>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
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
                                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold {{ $statusConfig['class'] }}">
                                            {{ $statusConfig['text'] }}
                                        </span>
                                    </div>

                                    <!-- Order Details -->
                                    <div class="space-y-4">
                                        <div class="flex flex-col gap-1">
                                            <label class="text-sm font-semibold text-gray-700">Nomor Pesanan:</label>
                                            <p class="text-gray-900 font-mono bg-gray-50 px-3 py-2 rounded-lg border">{{ $order->order_number }}</p>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <label class="text-sm font-semibold text-gray-700">Tanggal Pesanan:</label>
                                            <p class="text-gray-900 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                        @if($order->notes)
                                            <div class="flex flex-col gap-1">
                                                <label class="text-sm font-semibold text-gray-700">Catatan:</label>
                                                <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg border italic">{{ $order->notes }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Shipping Info -->
                                    <div class="border-t border-gray-200 pt-4">
                                        <h4 class="text-md font-bold text-gray-800 mb-3 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
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
                                                <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg border text-sm leading-relaxed">{{ $order->shipping_address }}</p>
                                            </div>
                                            @if($order->shipping_city)
                                                <div class="flex flex-col gap-1">
                                                    <label class="text-sm font-semibold text-gray-700">Kota:</label>
                                                    <p class="text-gray-900">{{ $order->shipping_city }}</p>
                                                </div>
                                            @endif
                                            @if($order->shipping_postal_code)
                                                <div class="flex flex-col gap-1">
                                                    <label class="text-sm font-semibold text-gray-700">Kode Pos:</label>
                                                    <p class="text-gray-900 font-mono">{{ $order->shipping_postal_code }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="border-t border-gray-200 pt-4">
                                        <livewire:order-confirmation :order="$order" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection