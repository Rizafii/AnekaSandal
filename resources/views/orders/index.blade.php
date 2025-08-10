@extends('app')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="container mx-auto px-4 py-8 mt-16 relative z-10">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800">Pesanan Saya</h1>
            <p class="text-xl text-gray-600 mt-1">Kelola dan pantau status pesanan Anda</p>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-8">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100/50 backdrop-blur-sm">
                        <!-- Order Header -->
                        <div class="bg-gradient-to-r from-primary/5 to-primary/10 border-b border-gray-200/70">
                            <div class="px-8 py-6">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900">{{ $order->order_number }}</h3>
                                            <p class="text-sm text-gray-600 flex items-center gap-2 mt-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $order->created_at->format('d M Y, H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $statusConfig = match ($order->status) {
                                                'menunggu_pembayaran' => [
                                                    'class' => 'bg-gradient-to-r from-yellow-100 to-yellow-50 text-yellow-800 border-yellow-200',
                                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                                                ],
                                                'sedang_dikirim' => [
                                                    'class' => 'bg-gradient-to-r from-blue-100 to-blue-50 text-blue-800 border-blue-200',
                                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                                                ],
                                                'selesai' => [
                                                    'class' => 'bg-gradient-to-r from-green-100 to-green-50 text-green-800 border-green-200',
                                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                                                ],
                                                'dibatalkan' => [
                                                    'class' => 'bg-gradient-to-r from-red-100 to-red-50 text-red-800 border-red-200',
                                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                                                ],
                                                default => [
                                                    'class' => 'bg-gradient-to-r from-gray-100 to-gray-50 text-gray-800 border-gray-200',
                                                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                                                ]
                                            };
                                        @endphp
                                        <span class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-xl border {{ $statusConfig['class'] }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                {!! $statusConfig['icon'] !!}
                                            </svg>
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="px-8 py-6">
                            <div class="space-y-6">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-6 p-4 bg-gray-50/50 rounded-xl border border-gray-100 hover:bg-gray-50 transition-colors">
                                        <div class="flex-shrink-0 w-20 h-20 relative">
                                            @if($item->product && $item->product->images->count() > 0)
                                                <img src="{{ $item->product->images->first()->url }}" alt="{{ $item->product_name }}"
                                                    class="w-20 h-20 object-cover rounded-xl shadow-sm">
                                            @else
                                                <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-100 rounded-xl flex items-center justify-center shadow-sm">
                                                    <svg class="w-10 h-10 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-primary text-white text-xs rounded-full flex items-center justify-center font-bold shadow-lg">
                                                {{ $item->quantity }}
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-lg font-bold text-gray-900 truncate">{{ $item->product_name }}</h4>
                                            @if($item->variant_info)
                                                <p class="text-sm text-gray-600 mt-1 flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                    {{ $item->variant_info }}
                                                </p>
                                            @endif
                                            <p class="text-sm text-gray-600 mt-2 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                                Rp {{ number_format($item->price) }} × {{ $item->quantity }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xl font-bold text-primary">Rp {{ number_format($item->subtotal) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Order Footer -->
                        <div class="bg-gradient-to-r from-gray-50/80 to-gray-50/50 px-8 py-6 border-t border-gray-200/70">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-6">
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 7a2 2 0 012-2h10a2 2 0 012 2v2M5 11h14"></path>
                                        </svg>
                                        <span class="font-medium">{{ $order->items->count() }} item</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-600">Total:</span>
                                        <span class="text-2xl font-bold text-primary">Rp {{ number_format($order->final_amount) }}</span>
                                    </div>
                                </div>
                                <div class="flex space-x-4">
                                    <a href="{{ route('orders.show', $order->id) }}"
                                        class="group relative bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary text-white px-6 py-3 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
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
                <div class="mt-12 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="relative mb-8">
                    <div class="w-32 h-32 bg-gradient-to-br from-primary/20 to-primary/10 rounded-3xl mx-auto flex items-center justify-center shadow-xl">
                        <svg class="w-16 h-16 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <!-- Floating decorations -->
                    <div class="absolute -top-4 -right-4 w-8 h-8 bg-primary/20 rounded-full animate-bounce"></div>
                    <div class="absolute -bottom-4 -left-4 w-6 h-6 bg-primary/30 rounded-full animate-pulse"></div>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Belum ada pesanan</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">Mulai berbelanja sekarang dan temukan koleksi sandal berkualitas tinggi untuk kenyamanan Anda</p>
                
                <a href="{{ route('home') }}"
                    class="group inline-flex items-center gap-3 bg-gradient-to-r from-primary to-primary/90 hover:from-primary/90 hover:to-primary text-white px-8 py-4 rounded-2xl font-bold shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Mulai Belanja
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>

@endsection