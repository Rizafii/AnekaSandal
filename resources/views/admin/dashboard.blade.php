@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="min-h-screen max-w-7xl bg-gray-50 overflow-x-hidden">
        <!-- Header -->
        <div class="shadow w-full">
            <div class=" px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
                        <p class="mt-1 text-sm text-gray-600">Kelola transaksi dan pesanan</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">{{ now()->format('d M Y, H:i') }}</span>
                        <a href="{{ route('admin.orders.index') }}"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Kelola Pesanan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full px-4 sm:px-6 lg:px-8 py-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Orders -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Pesanan</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ number_format($stats['total_orders']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Payment -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Menunggu Konfirmasi</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ number_format($stats['pending_payments']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-yellow-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.orders.index', ['payment_status' => 'menunggu_konfirmasi']) }}"
                                class="font-medium text-yellow-700 hover:text-yellow-600">
                                Lihat detail →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Shipping Orders -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Sedang Dikirim</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ number_format($stats['shipping_orders']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-purple-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Pendapatan</dt>
                                    <dd class="text-lg font-medium text-gray-900">Rp
                                        {{ number_format($stats['total_revenue']) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product & Category Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Products -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-indigo-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Produk</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ number_format($stats['total_products']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-indigo-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.products.index') }}"
                                class="font-medium text-indigo-700 hover:text-indigo-600">
                                Kelola produk →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Active Products -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Produk Aktif</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ number_format($stats['active_products']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Categories -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-orange-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Kategori</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ number_format($stats['total_categories']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-orange-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.categories.index') }}"
                                class="font-medium text-orange-700 hover:text-orange-600">
                                Kelola kategori →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Active Categories -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-teal-100 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Kategori Aktif</dt>
                                    <dd class="text-lg font-medium text-gray-900">
                                        {{ number_format($stats['active_categories']) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Orders -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Pesanan Terbaru</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Pesanan</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Customer</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentOrders as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $order->created_at->format('d M Y, H:i') }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $order->user->name ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">{{ $order->shipping_name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClass = match ($order->status) {
                                                        'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                                        'sedang_dikirim' => 'bg-blue-100 text-blue-800',
                                                        'selesai' => 'bg-green-100 text-green-800',
                                                        default => 'bg-red-100 text-red-800'
                                                    };
                                                @endphp
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                </span>
                                                @if($order->payment_status === 'menunggu_konfirmasi')
                                                    <div class="mt-1">
                                                        <span
                                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                                            Perlu Konfirmasi
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rp {{ number_format($order->final_amount) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                                    class="text-blue-600 hover:text-blue-900">Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                                Belum ada pesanan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-3 border-t border-gray-200">
                            <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:text-blue-900">
                                Lihat semua pesanan →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Order Status Chart -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Status Pesanan</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-yellow-400 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Menunggu Pembayaran</span>
                                </div>
                                <span
                                    class="text-sm font-medium text-gray-900">{{ $ordersByStatus['menunggu_pembayaran'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-blue-400 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Sedang Dikirim</span>
                                </div>
                                <span
                                    class="text-sm font-medium text-gray-900">{{ $ordersByStatus['sedang_dikirim'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-green-400 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Selesai</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $ordersByStatus['selesai'] }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 bg-red-400 rounded-full mr-3"></div>
                                    <span class="text-sm text-gray-600">Dibatalkan</span>
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $ordersByStatus['dibatalkan'] }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white shadow rounded-lg p-6 mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.orders.index', ['payment_status' => 'menunggu_konfirmasi']) }}"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                📋 Konfirmasi Pembayaran
                            </a>
                            <a href="{{ route('admin.orders.index', ['status' => 'sedang_dikirim']) }}"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                🚚 Kelola Pengiriman
                            </a>
                            <a href="{{ route('admin.orders.index') }}"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">
                                📊 Semua Pesanan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection