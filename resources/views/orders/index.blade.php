@extends('app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Pesanan Saya</h1>

        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Order Header -->
                        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $order->order_number }}</h3>
                                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    @php
                                        $statusClass = match ($order->status) {
                                            'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                            'sedang_dikirim' => 'bg-blue-100 text-blue-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'dibatalkan' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusClass }} mb-2">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="px-6 py-4">
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-16 h-16">
                                            @if($item->product && $item->product->images->count() > 0)
                                                <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product_name }}"
                                                    class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex-1">
                                            <h4 class="text-lg font-medium text-gray-900">{{ $item->product_name }}</h4>
                                            @if($item->variant_info)
                                                <p class="text-sm text-gray-600">{{ $item->variant_info }}</p>
                                            @endif
                                            <p class="text-sm text-gray-600">{{ $item->quantity }}x Rp {{ number_format($item->price) }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($item->subtotal) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Order Footer -->
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    <p>{{ $order->items->count() }} item • Total: <span class="font-semibold text-gray-900">Rp
                                            {{ number_format($order->final_amount) }}</span></p>
                                </div>
                                <div class="flex space-x-3">
                                    <a href="{{ route('orders.show', $order->id) }}"
                                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                                        Detail
                                    </a>

                                    <livewire:order-list-confirmation :order="$order" :key="'confirm-' . $order->id" />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-xl font-medium text-gray-900 mt-4">Belum ada pesanan</h3>
                <p class="text-gray-600 mt-2">Mulai berbelanja untuk melihat pesanan Anda di sini</p>
                <a href="{{ route('home') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 mt-6">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>

@endsection