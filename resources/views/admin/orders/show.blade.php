@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="p-4 bg-white w-7xl block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="mb-1 ">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.orders.index') }}"
                                class="inline-flex items-center text-gray-700 hover:text-primary-600">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                    </path>
                                </svg>
                                Kelola Pesanan
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-gray-400 md:ml-2">Detail Pesanan</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Detail Pesanan #{{ $order->order_number }}
                </h1>
            </div>
        </div>
    </div>

    <div class="flex flex-col space-y-6">
        <!-- Order Information -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Pesanan</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nomor Pesanan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tanggal Pesanan</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status Pesanan</label>
                        @php
                            $statusClass = match ($order->status) {
                                'menunggu_pembayaran' => 'bg-gray-100 text-gray-800',
                                'sedang_diproses' => 'bg-blue-100 text-blue-800',
                                'sedang_dikirim' => 'bg-yellow-100 text-yellow-800',
                                'selesai' => 'bg-green-100 text-green-800',
                                'dibatalkan' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Order Items -->
                <h4 class="text-md font-medium text-gray-900 mb-3">Item Pesanan</h4>
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Produk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Qty</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($item->product->image)
                                                <img class="h-10 w-10 rounded object-cover"
                                                    src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}">
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}
                                                </div>
                                                @if($item->size)
                                                    <div class="text-sm text-gray-500">Ukuran: {{ $item->size }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($item->price) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($item->price * $item->quantity) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Customer</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $order->user->username ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $order->user->email ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Informasi Pengiriman</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Nama Penerima</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $order->shipping_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Telepon</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $order->shipping_phone }}</p>
                    </div>
                    <div class="md:col-span-2 lg:col-span-1">
                        <label class="block text-sm font-medium text-gray-500">Alamat</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</p>
                    </div>

                    @if($order->courier)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Kurir</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $order->courier }}</p>
                        </div>
                    @endif

                    @if($order->tracking_number)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Nomor Resi</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $order->tracking_number }}</p>
                        </div>
                    @endif

                    @if($order->shipped_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tanggal Dikirim</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $order->shipped_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>

                @if($order->shipping_image)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Foto Barang Dikirim</label>
                        <img src="{{ asset('storage/' . $order->shipping_image) }}" alt="Foto pengiriman"
                            class="h-32 w-auto rounded-lg shadow-sm">
                    </div>
                @endif

                @if($order->notes)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-500">Catatan Pengiriman</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Ringkasan Pesanan</h3>
                <div class="max-w-md">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Subtotal</span>
                        <span class="text-sm text-gray-900">Rp {{ number_format($order->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Ongkir</span>
                        <span class="text-sm text-gray-900">Rp {{ number_format($order->shipping_cost) }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Diskon</span>
                            <span class="text-sm text-red-600">-Rp {{ number_format($order->discount_amount) }}</span>
                        </div>
                    @endif
                    <div class="border-t pt-2">
                        <div class="flex justify-between">
                            <span class="text-base font-medium text-gray-900">Total</span>
                            <span class="text-base font-medium text-gray-900">Rp
                                {{ number_format($order->final_amount) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Action -->
        @if(!in_array($order->status, ['sedang_dikirim', 'selesai', 'dibatalkan']))
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Kirim Pesanan</h3>

                    <!-- Display errors if any -->
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative mb-4">
                            <strong class="font-bold">Terjadi kesalahan:</strong>
                            <ul class="mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.orders.ship', $order->id) }}" method="POST" enctype="multipart/form-data"
                        id="shipForm">
                        @csrf
                        @method('PATCH')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="courier" class="block text-sm font-medium text-gray-700">Kurir <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="courier" id="courier" value="{{ old('courier') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Contoh: JNE, TIKI, POS" required>
                            </div>

                            <div>
                                <label for="tracking_number" class="block text-sm font-medium text-gray-700">Nomor Resi <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="tracking_number" id="tracking_number"
                                    value="{{ old('tracking_number') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Masukkan nomor resi" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="shipped_at" class="block text-sm font-medium text-gray-700">Tanggal Pengiriman <span
                                    class="text-red-500">*</span></label>
                            <input type="datetime-local" name="shipped_at" id="shipped_at"
                                value="{{ old('shipped_at', now()->format('Y-m-d\TH:i')) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="shipping_image" class="block text-sm font-medium text-gray-700">Foto Barang Dikirim
                                <span class="text-red-500">*</span></label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="shipping_image"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload foto</span>
                                            <input id="shipping_image" name="shipping_image" type="file" class="sr-only"
                                                accept="image/*" required>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                    <div id="file-info" class="text-sm text-gray-600 hidden"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Pengiriman
                                (Opsional)</label>
                            <textarea name="notes" id="notes" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Tambahkan catatan pengiriman jika diperlukan">{{ old('notes') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" id="submitBtn"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="submitText">Kirim Pesanan</span>
                                <span id="submitLoader" class="hidden">Memproses...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Status Information -->
        @if($order->status === 'menunggu_pembayaran')
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div
                        class="flex items-center p-4 mb-4 text-sm text-orange-800 border border-orange-300 rounded-lg bg-orange-50">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <div>
                            <span class="font-medium">Pesanan Menunggu Pembayaran!</span>
                            <div class="mt-1 text-sm text-orange-700">
                                Pesanan ini masih menunggu pembayaran dari customer.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($order->status === 'sedang_dikirim')
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center p-4 mb-4 text-sm text-blue-800 border border-blue-300 rounded-lg bg-blue-50">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <div>
                            <span class="font-medium">Pesanan Sedang Dikirim!</span>
                            <div class="mt-1 text-sm text-blue-700">
                                Pesanan ini sedang dalam proses pengiriman.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($order->status === 'selesai')
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div
                        class="flex items-center p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <div>
                            <span class="font-medium">Pesanan Selesai!</span>
                            <div class="mt-1 text-sm text-green-700">
                                Pesanan ini telah selesai.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($order->status === 'dibatalkan')
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50">
                        <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <div>
                            <span class="font-medium">Pesanan Dibatalkan!</span>
                            <div class="mt-1 text-sm text-red-700">
                                Pesanan ini telah dibatalkan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('shipForm');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitLoader = document.getElementById('submitLoader');
            const fileInput = document.getElementById('shipping_image');
            const fileInfo = document.getElementById('file-info');

            // Handle file input change
            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    fileInfo.textContent = 'File dipilih: ' + this.files[0].name;
                    fileInfo.classList.remove('hidden');
                } else {
                    fileInfo.classList.add('hidden');
                }
            });

            // Handle form submission
            form.addEventListener('submit', function (e) {
                // Disable submit button and show loading
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                submitLoader.classList.remove('hidden');

                // Basic validation
                const courier = document.getElementById('courier').value.trim();
                const trackingNumber = document.getElementById('tracking_number').value.trim();
                const shippedAt = document.getElementById('shipped_at').value;
                const shippingImage = fileInput.files[0];

                if (!courier || !trackingNumber || !shippedAt || !shippingImage) {
                    e.preventDefault();
                    alert('Semua field yang wajib harus diisi!');

                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    submitLoader.classList.add('hidden');
                    return false;
                }

                // Check file size (10MB = 10 * 1024 * 1024 bytes)
                if (shippingImage && shippingImage.size > 10 * 1024 * 1024) {
                    e.preventDefault();
                    alert('Ukuran file maksimal 10MB!');

                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    submitLoader.classList.add('hidden');
                    return false;
                }

                // Check file type
                if (shippingImage) {
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(shippingImage.type)) {
                        e.preventDefault();
                        alert('Format file harus JPEG, PNG, atau JPG!');

                        // Re-enable submit button
                        submitBtn.disabled = false;
                        submitText.classList.remove('hidden');
                        submitLoader.classList.add('hidden');
                        return false;
                    }
                }

                console.log('Form validation passed, submitting...');
            });
        });
    </script>
@endsection