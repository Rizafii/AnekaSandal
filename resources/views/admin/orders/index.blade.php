@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Kelola Pesanan</h1>
            </div>

            <!-- Filters -->
            <div class="sm:flex">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0">
                    <form class="lg:pr-3" action="{{ route('admin.orders.index') }}" method="GET">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative mt-1 lg:w-64 xl:w-96">
                            <input type="text" name="search" id="search" value="{{ request('search') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                placeholder="Cari nomor pesanan atau nama customer">
                        </div>
                    </form>
                </div>

                <div class="flex items-center space-x-2 sm:space-x-3">
                    <!-- Status Filter -->
                    <div class="relative">
                        <form action="{{ route('admin.orders.index') }}" method="GET" id="statusFilterForm">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="payment_status" value="{{ request('payment_status') }}">
                            <select name="status" onchange="document.getElementById('statusFilterForm').submit()"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">Semua Status</option>
                                <option value="menunggu_pembayaran" {{ request('status') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                <option value="sedang_dikirm" {{ request('status') === 'sedang_dikirm' ? 'selected' : '' }}>
                                    Sedang Dikirim</option>
                                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan</option>
                            </select>
                        </form>
                    </div>

                    <!-- Payment Status Filter -->
                    <div class="relative">
                        <form action="{{ route('admin.orders.index') }}" method="GET" id="paymentStatusFilterForm">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="status" value="{{ request('status') }}">
                            <select name="payment_status"
                                onchange="document.getElementById('paymentStatusFilterForm').submit()"
                                class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">Semua Status Pembayaran</option>
                                <option value="belum_bayar" {{ request('payment_status') === 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                                <option value="menunggu_konfirmasi" {{ request('payment_status') === 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                <option value="terkonfirmasi" {{ request('payment_status') === 'terkonfirmasi' ? 'selected' : '' }}>Terkonfirmasi</option>
                                <option value="ditolak" {{ request('payment_status') === 'ditolak' ? 'selected' : '' }}>
                                    Ditolak</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Pesanan
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Customer
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Total
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Status Pesanan
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Status Pembayaran
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Tanggal
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($orders as $order)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-4 whitespace-nowrap text-base font-medium text-gray-900">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $order->order_number }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->items->count() }} item(s)</div>
                                        </div>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-base font-medium text-gray-900">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $order->user->name ?? 'N/A' }}
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $order->shipping_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->shipping_phone }}</div>
                                        </div>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-base font-medium text-gray-900">
                                        Rp {{ number_format($order->final_amount) }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-base font-medium">
                                        @php
                                            $statusClass = match ($order->status) {
                                                'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                                'sedang_dikirm' => 'bg-blue-100 text-blue-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'dibatalkan' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-base font-medium">
                                        @php
                                            $paymentStatusClass = match ($order->payment_status) {
                                                'belum_bayar' => 'bg-gray-100 text-gray-800',
                                                'menunggu_konfirmasi' => 'bg-orange-100 text-orange-800',
                                                'terkonfirmasi' => 'bg-green-100 text-green-800',
                                                'ditolak' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $paymentStatusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                        </span>
                                        @if($order->payment_status === 'menunggu_konfirmasi')
                                            <div class="mt-1">
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    ⚠️ Perlu Aksi
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-base font-medium text-gray-900">
                                        <div class="text-sm text-gray-900">{{ $order->created_at->format('d M Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="p-4 whitespace-nowrap space-x-2">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 text-center inline-flex items-center">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500">
                                        Tidak ada pesanan ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div
            class="bg-white sticky sm:flex items-center w-full sm:justify-between bottom-0 right-0 border-t border-gray-200 p-4">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    @endif

@endsection