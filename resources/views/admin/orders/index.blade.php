@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
    <div class="min-h-screen bg-gray-50/50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200/60 shadow-sm">
            <div class="px-6 lg:px-8">
                <div class="flex justify-between items-center py-8">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Kelola Pesanan</h1>
                        <p class="mt-2 text-sm text-gray-600">Kelola semua pesanan pelanggan toko Anda</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded-lg border">
                            Total: {{ $orders->total() }} pesanan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 lg:px-8 py-8">
            <!-- Filters & Search -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor pesanan atau nama customer..."
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="lg:w-48">
                        <select name="status"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="menunggu_pembayaran" {{ request('status') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="sedang_diproses" {{ request('status') === 'sedang_diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="sedang_dikirim" {{ request('status') === 'sedang_dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-colors font-medium">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.orders.index') }}"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Table Container with Horizontal Scroll -->
                <div class="overflow-x-auto">
                    <div class="min-w-full">
                        <!-- Vertical Scroll Container -->
                        <div class="max-h-[600px] overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <!-- Fixed Header -->
                                <thead class="bg-gray-50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[200px]">
                                            Pesanan
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[200px]">
                                            Customer
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[120px]">
                                            Total
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[150px]">
                                            Status Pesanan
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[120px]">
                                            Tanggal
                                        </th>
                                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[150px]">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <!-- Scrollable Body -->
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($orders as $order)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap min-w-[200px]">
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">{{ $order->order_number }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">{{ $order->items->count() }} item(s)</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap min-w-[200px]">
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">{{ $order->user->username ?? 'N/A' }}</div>
                                                    <div class="text-xs text-gray-500 mt-1">{{ $order->shipping_name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $order->shipping_phone }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap min-w-[120px]">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    Rp {{ number_format($order->final_amount) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap min-w-[150px]">
                                                @php
                                                    $statusClass = match ($order->status) {
                                                        'menunggu_pembayaran' => 'bg-gray-100 text-gray-800',
                                                        'sedang_diproses' => 'bg-blue-100 text-blue-800',
                                                        'sedang_dikirim' => 'bg-yellow-100 text-yellow-800',
                                                        'selesai' => 'bg-emerald-100 text-emerald-800',
                                                        'dibatalkan' => 'bg-red-100 text-red-800',
                                                        default => 'bg-gray-100 text-gray-800'
                                                    };
                                                @endphp
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                </span>
                                                @if($order->status === 'menunggu_pembayaran')
                                                    <div class="mt-1">
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                            ⚠️ Perlu Aksi
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap min-w-[120px]">
                                                <div class="text-sm text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                                                <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center min-w-[150px]">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors text-xs font-medium">
                                                        <i class="fas fa-eye mr-1"></i>Detail
                                                    </a>
                                                    @if(in_array($order->status, ['sedang_diproses', 'menunggu_pembayaran']))
                                                        <button onclick="openShippingModal({{ $order->id }})"
                                                            class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors text-xs font-medium">
                                                            <i class="fas fa-shipping-fast mr-1"></i>Kirim
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada pesanan</h3>
                                                    <p class="text-gray-600">Belum ada pesanan yang masuk</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mt-8 p-6">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Menampilkan {{ $orders->firstItem() }} hingga {{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
                </div>
                <div>
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @endif

    <script>
        function openShippingModal(orderId) {
            window.location.href = `/admin/orders/${orderId}#shipping-form`;
        }
    </script>

@endsection