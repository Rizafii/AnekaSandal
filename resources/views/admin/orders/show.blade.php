@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
    <div class="min-h-screen bg-gray-50/50">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mx-6 lg:mx-8 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mx-6 lg:mx-8 mt-6">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="bg-white border-b border-gray-200/60 shadow-sm">
            <div class="px-6 lg:px-8">
                <div class="py-8">
                    <!-- Breadcrumb -->
                    <nav class="flex mb-6" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                            <li class="inline-flex items-center">
                                <a href="{{ route('admin.orders.index') }}"
                                    class="inline-flex items-center text-gray-500 hover:text-blue-600 transition-colors">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Kelola Pesanan
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                    <span class="text-gray-400">Detail Pesanan</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <!-- Header Content -->
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Detail Pesanan
                                #{{ $order->order_number }}</h1>
                            <p class="mt-2 text-sm text-gray-600">Informasi lengkap pesanan customer</p>
                        </div>

                        <!-- Status Badge -->
                        <div class="flex items-center space-x-3">
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
                            <span class="inline-flex px-3 py-1.5 text-sm font-semibold rounded-xl {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Order Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pesanan</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Pesanan</label>
                                    <p class="text-sm font-semibold text-gray-900">{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pesanan</label>
                                    <p class="text-sm text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <h4 class="text-md font-semibold text-gray-900 mb-4">Item Pesanan</h4>
                            <div class="bg-gray-50 rounded-xl p-6">
                                <div class="space-y-4">
                                    @foreach($order->items as $item)
                                        <div class="flex items-center space-x-4 p-4 bg-white rounded-lg border border-gray-100">
                                            <div class="h-16 w-16 flex-shrink-0">
                                                @if($item->product->image)
                                                    <img class="h-16 w-16 rounded-lg object-cover border border-gray-200"
                                                        src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}">
                                                @else
                                                    <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h5 class="text-sm font-semibold text-gray-900 truncate">
                                                    {{ $item->product->name }}</h5>
                                                @if($item->size)
                                                    <p class="text-xs text-gray-500 mt-1">Ukuran: {{ $item->size }}</p>
                                                @endif
                                                <div class="flex items-center space-x-4 mt-2">
                                                    <span class="text-xs text-gray-500">Qty: {{ $item->quantity }}</span>
                                                    <span class="text-xs text-gray-500">@</span>
                                                    <span class="text-xs font-medium text-gray-900">Rp
                                                        {{ number_format($item->price) }}</span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-gray-900">
                                                    Rp {{ number_format($item->price * $item->quantity) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Customer</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama</label>
                                    <p class="text-sm text-gray-900">{{ $order->user->username ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                                    <p class="text-sm text-gray-900">{{ $order->user->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pengiriman</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Nama Penerima</label>
                                    <p class="text-sm text-gray-900">{{ $order->shipping_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Telepon</label>
                                    <p class="text-sm text-gray-900">{{ $order->shipping_phone }}</p>
                                </div>
                                <div class="md:col-span-2 lg:col-span-1">
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                                    <p class="text-sm text-gray-900">{{ $order->shipping_address }}</p>
                                </div>

                                @if($order->courier)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Kurir</label>
                                        <p class="text-sm text-gray-900">{{ $order->courier }}</p>
                                    </div>
                                @endif

                                @if($order->tracking_number)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Resi</label>
                                        <p class="text-sm text-gray-900">{{ $order->tracking_number }}</p>
                                    </div>
                                @endif

                                @if($order->shipped_at)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Dikirim</label>
                                        <p class="text-sm text-gray-900">{{ $order->shipped_at->format('d M Y H:i') }}</p>
                                    </div>
                                @endif
                            </div>

                            @if($order->shipping_image)
                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-500 mb-3">Foto Barang Dikirim</label>
                                    <img src="{{ asset('storage/' . $order->shipping_image) }}" alt="Foto pengiriman"
                                        class="h-48 w-auto rounded-xl shadow-sm border border-gray-200">
                                </div>
                            @endif

                            @if($order->notes)
                                <div class="mt-6">
                                    <label class="block text-sm font-medium text-gray-500 mb-1">Catatan Pengiriman</label>
                                    <p class="text-sm text-gray-900">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Order Summary -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">Ringkasan Pesanan</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Subtotal</span>
                                    <span class="text-sm font-medium text-gray-900">Rp
                                        {{ number_format($order->subtotal) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Ongkir</span>
                                    <span class="text-sm font-medium text-gray-900">Rp
                                        {{ number_format($order->shipping_cost) }}</span>
                                </div>
                                @if($order->discount_amount > 0)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Diskon</span>
                                        <span class="text-sm font-medium text-red-600">-Rp
                                            {{ number_format($order->discount_amount) }}</span>
                                    </div>
                                @endif
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-semibold text-gray-900">Total</span>
                                        <span class="text-base font-semibold text-gray-900">Rp
                                            {{ number_format($order->final_amount) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Action Form -->
                    @if(!in_array($order->status, ['sedang_dikirim', 'selesai', 'dibatalkan']))
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-6">Kirim Pesanan</h3>

                                <!-- Display errors if any -->
                                @if ($errors->any())
                                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative mb-6">
                                        <strong class="font-bold">Terjadi kesalahan:</strong>
                                        <ul class="mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>• {{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('admin.orders.ship', $order->id) }}" method="POST"
                                    enctype="multipart/form-data" id="shipForm">
                                    @csrf
                                    @method('PATCH')

                                    <div class="space-y-6">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="courier" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Kurir <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="courier" id="courier" value="{{ old('courier') }}"
                                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    placeholder="Contoh: JNE, TIKI, POS" required>
                                            </div>

                                            <div>
                                                <label for="tracking_number"
                                                    class="block text-sm font-medium text-gray-700 mb-2">
                                                    Nomor Resi <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" name="tracking_number" id="tracking_number"
                                                    value="{{ old('tracking_number') }}"
                                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                    placeholder="Masukkan nomor resi" required>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="shipped_at" class="block text-sm font-medium text-gray-700 mb-2">
                                                Tanggal Pengiriman <span class="text-red-500">*</span>
                                            </label>
                                            <input type="datetime-local" name="shipped_at" id="shipped_at"
                                                value="{{ old('shipped_at', now()->format('Y-m-d\TH:i')) }}"
                                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                required>
                                        </div>

                                        <div>
                                            <label for="shipping_image" class="block text-sm font-medium text-gray-700 mb-2">
                                                Foto Barang Dikirim <span class="text-red-500">*</span>
                                            </label>
                                            <div
                                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-gray-400 transition-colors">
                                                <div class="space-y-1 text-center">
                                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                                    <div class="flex text-sm text-gray-600">
                                                        <label for="shipping_image"
                                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                            <span>Upload foto</span>
                                                            <input id="shipping_image" name="shipping_image" type="file"
                                                                class="sr-only" accept="image/*" required>
                                                        </label>
                                                        <p class="pl-1">atau drag and drop</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
                                                    <div id="file-info" class="text-sm text-gray-600 hidden mt-2"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                                Catatan Pengiriman (Opsional)
                                            </label>
                                            <textarea name="notes" id="notes" rows="3"
                                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Tambahkan catatan pengiriman jika diperlukan">{{ old('notes') }}</textarea>
                                        </div>

                                        <div class="flex justify-end pt-4">
                                            <button type="submit" id="submitBtn"
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                                <span id="submitText">
                                                    <i class="fas fa-shipping-fast mr-2"></i>Kirim Pesanan
                                                </span>
                                                <span id="submitLoader" class="hidden">
                                                    <i class="fas fa-spinner fa-spin mr-2"></i>Memproses...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Information Alerts -->
        @if($order->status === 'menunggu_pembayaran')
            <div class="px-6 lg:px-8 pb-8">
                <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-orange-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-orange-800">Pesanan Menunggu Pembayaran!</h3>
                            <div class="mt-1 text-sm text-orange-700">
                                Pesanan ini masih menunggu pembayaran dari customer.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($order->status === 'sedang_dikirim')
            <div class="px-6 lg:px-8 pb-8">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-truck text-blue-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-blue-800">Pesanan Sedang Dikirim!</h3>
                            <div class="mt-1 text-sm text-blue-700">
                                Pesanan ini sedang dalam proses pengiriman.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($order->status === 'selesai')
            <div class="px-6 lg:px-8 pb-8">
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-emerald-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-emerald-800">Pesanan Selesai!</h3>
                            <div class="mt-1 text-sm text-emerald-700">
                                Pesanan ini telah selesai.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($order->status === 'dibatalkan')
            <div class="px-6 lg:px-8 pb-8">
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-times-circle text-red-400 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-semibold text-red-800">Pesanan Dibatalkan!</h3>
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