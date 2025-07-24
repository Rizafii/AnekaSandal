@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-gray-700 hover:text-primary-600 ml-1 md:ml-0">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('admin.orders.index') }}"
                                    class="text-gray-700 hover:text-primary-600 ml-1 md:ml-0">Pesanan</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-400 ml-1 md:ml-0">{{ $order->order_number }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Detail Pesanan #{{ $order->order_number }}</h1>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4">
        <!-- Main Content -->
        <div class="mb-4 col-span-full xl:mb-2">
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Order Status and Actions -->
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Status Pesanan</h3>
                    <div class="flex space-x-2">
                        @php
                            $statusClass = match ($order->status) {
                                'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                'sedang_dikirm' => 'bg-blue-100 text-blue-800',
                                'selesai' => 'bg-green-100 text-green-800',
                                'dibatalkan' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            };

                            $paymentStatusClass = match ($order->payment_status) {
                                'belum_bayar' => 'bg-gray-100 text-gray-800',
                                'menunggu_konfirmasi' => 'bg-orange-100 text-orange-800',
                                'terkonfirmasi' => 'bg-green-100 text-green-800',
                                'ditolak' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $paymentStatusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </div>
                </div>

                <!-- Payment Confirmation Actions -->
                @if($order->payment_status === 'menunggu_konfirmasi')
                    <div class="p-4 mb-4 bg-orange-50 border border-orange-200 rounded-lg">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 mr-2 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <h4 class="text-lg font-medium text-orange-800">Konfirmasi Pembayaran Diperlukan</h4>
                        </div>

                        @if($order->payment_proof)
                            <div class="mb-4">
                                <p class="text-sm text-orange-700 mb-2">Bukti transfer telah diunggah customer:</p>
                                <img src="{{ Storage::url($order->payment_proof) }}" alt="Bukti Pembayaran"
                                    class="max-w-xs rounded-lg border">
                            </div>
                        @endif

                        <div class="flex space-x-3">
                            <form action="{{ route('admin.orders.update-payment-status', $order->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="payment_status" value="terkonfirmasi">
                                <button type="submit"
                                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    ✅ Konfirmasi Pembayaran
                                </button>
                            </form>

                            <livewire:admin.reject-payment-modal :order="$order" />
                        </div>
                    </div>
                @endif

                <!-- Shipping Actions -->
                @if($order->payment_status === 'terkonfirmasi' && $order->status === 'sedang_dikirm' && !$order->shipped_at)
                    <div class="p-4 mb-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-lg font-medium text-blue-800 mb-3">Upload Bukti Pengiriman</h4>
                        <form action="{{ route('admin.orders.upload-shipping-proof', $order->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="shipping_proof" class="block text-sm font-medium text-gray-700 mb-2">Foto Bukti
                                        Pengiriman</label>
                                    <input type="file" name="shipping_proof" id="shipping_proof" accept="image/*" required
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                </div>
                                <div>
                                    <label for="tracking_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Resi
                                        (Opsional)</label>
                                    <input type="text" name="tracking_number" id="tracking_number"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan
                                    Pengiriman</label>
                                <textarea name="notes" id="notes" rows="3"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Catatan tambahan untuk pengiriman..."></textarea>
                            </div>
                            <div class="mt-4">
                                <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    🚚 Upload Bukti Pengiriman
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- Shipping Info Display -->
                @if($order->shipped_at)
                    <div class="p-4 mb-4 bg-green-50 border border-green-200 rounded-lg">
                        <h4 class="text-lg font-medium text-green-800 mb-3">📦 Informasi Pengiriman</h4>
                        <div class="text-sm text-green-700">
                            <p><strong>Tanggal Pengiriman:</strong> {{ $order->shipped_at->format('d M Y, H:i') }}</p>
                            @if($order->tracking_number)
                                <p><strong>Nomor Resi:</strong> {{ $order->tracking_number }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Order Items -->
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Pesanan</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">Produk</th>
                                <th scope="col" class="px-6 py-3">Varian</th>
                                <th scope="col" class="px-6 py-3">Harga</th>
                                <th scope="col" class="px-6 py-3">Qty</th>
                                <th scope="col" class="px-6 py-3">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($item->product && $item->product->images->count() > 0)
                                                <img src="{{ $item->product->images->first()->url }}"
                                                    alt="{{ $item->product_name }}" class="w-12 h-12 object-cover rounded-lg mr-3">
                                            @endif
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $item->product_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->variant_info ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        Rp {{ number_format($item->price) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 font-medium">
                                        Rp {{ number_format($item->subtotal) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-semibold text-gray-900">
                                <td colspan="4" class="px-6 py-3 text-right">Subtotal:</td>
                                <td class="px-6 py-3">Rp {{ number_format($order->total_amount) }}</td>
                            </tr>
                            <tr class="font-semibold text-gray-900">
                                <td colspan="4" class="px-6 py-3 text-right">Ongkir:</td>
                                <td class="px-6 py-3">Rp {{ number_format($order->shipping_cost) }}</td>
                            </tr>
                            <tr class="font-semibold text-gray-900 text-lg">
                                <td colspan="4" class="px-6 py-3 text-right">Total:</td>
                                <td class="px-6 py-3">Rp {{ number_format($order->final_amount) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-span-full xl:col-auto">
            <!-- Customer Info -->
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Customer</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <label class="font-medium text-gray-700">Nama:</label>
                        <p class="text-gray-900">{{ $order->user->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="font-medium text-gray-700">Email:</label>
                        <p class="text-gray-900">{{ $order->user->email ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengiriman</h3>
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

            <!-- Order Info -->
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pesanan</h3>
                <div class="space-y-3 text-sm">
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
        </div>
    </div>


    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('admin.orders.update-payment-status', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="payment_status" value="ditolak">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.267 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Tolak Pembayaran
                            </h3>
                            <div class="mt-4">
                                <label for="reject_notes" class="block text-sm font-medium text-gray-700 mb-2">Alasan
                                    Penolakan</label>
                                <textarea name="notes" id="reject_notes" rows="3" required
                                    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    placeholder="Masukkan alasan penolakan pembayaran..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Tolak Pembayaran
                    </button>
                    <button type="button" wire:click="$dispatch('close-reject-modal')"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>

@endsection