@extends('app')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center mb-6">
            <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan #{{ $order->order_number }}</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Order Status -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Status Pesanan</h2>

                    <!-- Status Progress -->
                    <div class="flex items-center justify-between mb-6">
                        @php
                            $statusClass = match ($order->status) {
                                'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                'sedang_dikirim' => 'bg-blue-100 text-blue-800',
                                'selesai' => 'bg-green-100 text-green-800',
                                'dibatalkan' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            };

                        @endphp
                        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-full {{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">

                        <livewire:order-confirmation :order="$order" />
                    </div>

                    <!-- Status Information -->
                    <div class="mt-6 text-sm text-gray-600">
                        @if($order->payment_status === 'menunggu_konfirmasi')
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                                <p class="text-orange-800">⏳ Bukti pembayaran Anda sedang diverifikasi oleh admin. Mohon tunggu
                                    konfirmasi.</p>
                            </div>
                        @elseif($order->payment_status === 'ditolak')
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <p class="text-red-800">❌ Pembayaran ditolak. Silakan upload bukti pembayaran yang valid.</p>
                            </div>
                        @elseif($order->status === 'sedang_dikirim' && $order->shipped_at)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <p class="text-blue-800">🚚 Pesanan Anda sedang dalam perjalanan.</p>
                                @if($order->tracking_number)
                                    <p class="text-blue-800 mt-1"><strong>Nomor Resi:</strong> {{ $order->tracking_number }}</p>
                                @endif
                                <p class="text-blue-800 mt-1"><strong>Tanggal Pengiriman:</strong>
                                    {{ $order->shipped_at->format('d M Y, H:i') }}</p>
                            </div>
                        @elseif($order->status === 'selesai')
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-green-800">✅ Pesanan selesai. Terima kasih telah berbelanja!</p>
                                @if($order->delivered_at)
                                    <p class="text-green-800 mt-1"><strong>Diterima pada:</strong>
                                        {{ $order->delivered_at->format('d M Y, H:i') }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold mb-4">Item Pesanan</h2>

                    <div class="space-y-4">
                        @foreach($order->items as $item)
                            <div class="flex items-center border-b border-gray-200 pb-4 last:border-b-0">
                                <div class="flex-shrink-0 w-20 h-20">
                                    @if($item->product && $item->product->images->count() > 0)
                                        <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product_name }}"
                                            class="w-20 h-20 object-cover rounded-lg">
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-6 flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $item->product_name }}</h3>
                                    @if($item->variant_info)
                                        <p class="text-sm text-gray-600 mt-1">{{ $item->variant_info }}</p>
                                    @endif
                                    <div class="flex items-center justify-between mt-2">
                                        <p class="text-sm text-gray-600">Rp {{ number_format($item->price) }} x
                                            {{ $item->quantity }}
                                        </p>
                                        <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($item->subtotal) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Total -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900">Rp {{ number_format($order->total_amount) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span class="text-gray-900">Rp {{ number_format($order->shipping_cost) }}</span>
                            </div>
                            <div class="flex justify-between text-lg font-semibold pt-2 border-t border-gray-200">
                                <span>Total</span>
                                <span>Rp {{ number_format($order->final_amount) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Logs -->
                @if($order->statusLogs->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">Riwayat Status</h2>
                        <div class="space-y-4">
                            @foreach($order->statusLogs->sortByDesc('created_at') as $log)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-3 h-3 bg-blue-500 rounded-full mt-2"></div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ ucfirst(str_replace('_', ' ', $log->status)) }}
                                        </p>
                                        @if($log->notes)
                                            <p class="text-sm text-gray-600 mt-1">{{ $log->notes }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1">{{ $log->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Order Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pesanan</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <label class="font-medium text-gray-700">Nomor Pesanan:</label>
                            <p class="text-gray-900">{{ $order->order_number }}</p>
                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Tanggal Pesanan:</label>
                            <p class="text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        @if($order->notes)
                            <div>
                                <label class="font-medium text-gray-700">Catatan:</label>
                                <p class="text-gray-900">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold mb-4">Informasi Pengiriman</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <label class="font-medium text-gray-700">Nama Penerima:</label>
                            <p class="text-gray-900">{{ $order->shipping_name }}</p>
                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Telepon:</label>
                            <p class="text-gray-900">{{ $order->shipping_phone }}</p>
                        </div>
                        <div>
                            <label class="font-medium text-gray-700">Alamat:</label>
                            <p class="text-gray-900">{{ $order->shipping_address }}</p>
                        </div>
                        @if($order->shipping_city)
                            <div>
                                <label class="font-medium text-gray-700">Kota:</label>
                                <p class="text-gray-900">{{ $order->shipping_city }}</p>
                            </div>
                        @endif
                        @if($order->shipping_postal_code)
                            <div>
                                <label class="font-medium text-gray-700">Kode Pos:</label>
                                <p class="text-gray-900">{{ $order->shipping_postal_code }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection