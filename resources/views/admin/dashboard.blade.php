@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="min-h-screen bg-gray-50/50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200/60 shadow-sm">
            <div class="px-6 lg:px-8">
                <div class="flex justify-between items-center py-8">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Dashboard Admin</h1>
                        <p class="mt-2 text-sm text-gray-600">Kelola transaksi dan pesanan toko Anda</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded-lg border">
                            {{ now()->format('d M Y, H:i') }}
                        </div>
                        <a href="{{ route('admin.orders.index') }}"
                            class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition-colors duration-200 font-medium text-sm shadow-sm">
                            Kelola Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 lg:px-8 py-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Total Orders -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Total Pesanan</p>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_orders']) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50/50 px-6 py-3 border-t border-blue-100/50 rounded-b-2xl">
                        <a href="{{ route('admin.orders.index') }}"
                            class="text-sm font-medium text-blue-700 hover:text-blue-800 transition-colors">
                            Lihat semua pesanan →
                        </a>
                    </div>
                </div>

                <!-- Pending Payment -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Menunggu Konfirmasi</p>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['pending_payments']) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-amber-50/50 px-6 py-3 border-t border-amber-100/50 rounded-b-2xl">
                        <a href="{{ route('admin.orders.index', ['payment_status' => 'menunggu_konfirmasi']) }}"
                            class="text-sm font-medium text-amber-700 hover:text-amber-800 transition-colors">
                            Lihat detail →
                        </a>
                    </div>
                </div>

                <!-- Shipping Orders -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Sedang Dikirim</p>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['shipping_orders']) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-emerald-50/50 px-6 py-3 border-t border-emerald-100/50 rounded-b-2xl">
                        <a href="{{ route('admin.orders.index', ['status' => 'sedang_dikirim']) }}"
                            class="text-sm font-medium text-emerald-700 hover:text-emerald-800 transition-colors">
                            Kelola pengiriman →
                        </a>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Total Pendapatan</p>
                                <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($stats['total_revenue']) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50/50 px-6 py-3 border-t border-purple-100/50 rounded-b-2xl">
                        <a href="{{ route('admin.orders.index', ['status' => 'selesai']) }}"
                            class="text-sm font-medium text-purple-700 hover:text-purple-800 transition-colors">
                            Lihat pesanan selesai →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product & Category Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Total Products -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Total Produk</p>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_products']) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-indigo-50/50 px-6 py-3 border-t border-indigo-100/50 rounded-b-2xl">
                        <a href="{{ route('admin.products.index') }}"
                            class="text-sm font-medium text-indigo-700 hover:text-indigo-800 transition-colors">
                            Kelola produk →
                        </a>
                    </div>
                </div>

                <!-- Active Products -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Produk Aktif</p>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['active_products']) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-emerald-50/50 px-6 py-3 border-t border-emerald-100/50 rounded-b-2xl">
                        <a href="{{ route('admin.products.index', ['status' => 'active']) }}"
                            class="text-sm font-medium text-emerald-700 hover:text-emerald-800 transition-colors">
                            Kelola produk aktif →
                        </a>
                    </div>
                </div>

                <!-- Total Categories -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Total Kategori</p>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_categories']) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50/50 px-6 py-3 border-t border-orange-100/50 rounded-b-2xl">
                        <a href="{{ route('admin.categories.index') }}"
                            class="text-sm font-medium text-orange-700 hover:text-orange-800 transition-colors">
                            Kelola kategori →
                        </a>
                    </div>
                </div>

                <!-- Active Categories -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 mb-2">Kategori Aktif</p>
                                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['active_categories']) }}</p>
                            </div>
                            <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="bg-teal-50/50 px-6 py-3 border-t border-teal-100/50 rounded-b-2xl">
                        <a href="{{ route('admin.categories.index', ['status' => 'active']) }}"
                            class="text-sm font-medium text-teal-700 hover:text-teal-800 transition-colors">
                            Kelola kategori aktif →
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Recent Orders -->
                <div class="xl:col-span-2">
                    <div class="bg-white shadow-sm rounded-2xl border border-gray-100">
                        <div class="px-6 py-5 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h3>
                            <p class="text-sm text-gray-600 mt-1">Daftar pesanan yang baru masuk</p>
                        </div>
                        <div class="overflow-hidden">
                            <table class="min-w-full">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Pesanan</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Customer</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Total</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($recentOrders as $order)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">{{ $order->order_number }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        {{ $order->created_at->format('d M Y, H:i') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $order->user->username ?? 'N/A' }}</div>
                                                <div class="text-xs text-gray-500 mt-1">{{ $order->shipping_name }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $statusClass = match ($order->status) {
                                                        'menunggu_pembayaran' => 'bg-amber-100 text-amber-800 border-amber-200',
                                                        'sedang_dikirim' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                        'selesai' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                                        default => 'bg-red-100 text-red-800 border-red-200'
                                                    };
                                                @endphp
                                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full border {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                </span>
                                                @if($order->payment_status === 'menunggu_konfirmasi')
                                                    <div class="mt-1">
                                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full border bg-orange-100 text-orange-800 border-orange-200">
                                                            Perlu Konfirmasi
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                Rp {{ number_format($order->final_amount) }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm transition-colors">Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center">
                                                <div class="text-gray-500">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                                    </svg>
                                                    <p class="text-sm">Belum ada pesanan</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30 rounded-b-2xl">
                            <a href="{{ route('admin.orders.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                                Lihat semua pesanan →
                            </a>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Order Status Chart -->
                    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Status Pesanan</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 rounded-xl bg-amber-50/50 border border-amber-100">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-amber-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-gray-700">Menunggu Pembayaran</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900 bg-white px-2 py-1 rounded-lg">{{ $ordersByStatus['menunggu_pembayaran'] }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-xl bg-blue-50/50 border border-blue-100">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-gray-700">Sedang Dikirim</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900 bg-white px-2 py-1 rounded-lg">{{ $ordersByStatus['sedang_dikirim'] }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-xl bg-emerald-50/50 border border-emerald-100">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-emerald-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-gray-700">Selesai</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900 bg-white px-2 py-1 rounded-lg">{{ $ordersByStatus['selesai'] }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-xl bg-red-50/50 border border-red-100">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-400 rounded-full mr-3"></div>
                                    <span class="text-sm font-medium text-gray-700">Dibatalkan</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900 bg-white px-2 py-1 rounded-lg">{{ $ordersByStatus['dibatalkan'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Aksi Cepat</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.orders.index', ['payment_status' => 'menunggu_konfirmasi']) }}"
                                class="block w-full text-left px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl border border-gray-100 transition-colors group">
                                <span class="text-lg mr-3">📋</span>Konfirmasi Pembayaran
                            </a>
                            <a href="{{ route('admin.orders.index', ['status' => 'sedang_dikirim']) }}"
                                class="block w-full text-left px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl border border-gray-100 transition-colors group">
                                <span class="text-lg mr-3">🚚</span>Kelola Pengiriman
                            </a>
                            <a href="{{ route('admin.orders.index') }}"
                                class="block w-full text-left px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-xl border border-gray-100 transition-colors group">
                                <span class="text-lg mr-3">📊</span>Semua Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection