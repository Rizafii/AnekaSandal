@extends('app')

@section('title', 'Pembayaran')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Pembayaran</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($order) && $order)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Payment Instructions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Instruksi Pembayaran</h2>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-blue-800 mb-2">Nomor Pesanan: {{ $order->order_number }}</h3>
                        <p class="text-blue-700">Total Pembayaran: <span class="font-bold text-lg">Rp
                                {{ number_format($order->final_amount, 0, ',', '.') }}</span></p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">1. Transfer ke Rekening Berikut:</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="font-medium">Bank BCA</p>
                                <p class="text-lg font-bold">1234567890</p>
                                <p class="text-gray-600">a.n. Aneka Sandal Store</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800 mb-2">2. Kirim Bukti Transfer</h3>
                            <p class="text-gray-600 mb-3">Setelah melakukan transfer, kirimkan bukti transfer ke WhatsApp admin
                                atau upload di bawah ini.</p>

                            <div class="flex items-center space-x-4">
                                <a href="https://wa.me/6281234567890?text=Halo,%20saya%20sudah%20transfer%20untuk%20pesanan%20{{ urlencode($order->order_number) }}"
                                    target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                    </svg>
                                    Kirim ke WhatsApp
                                </a>
                                <span class="text-gray-500">atau</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Payment Proof -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Upload Bukti Transfer</h2>

                    @if($order->canUploadPayment())
                        <form action="{{ route('checkout.upload.payment', $order->id) }}" method="POST"
                            enctype="multipart/form-data" id="payment-form">
                            @csrf

                            <div class="mb-6">
                                <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-2">Bukti
                                    Transfer</label>
                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="payment_proof"
                                                class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Upload file</span>
                                                <input id="payment_proof" name="payment_proof" type="file" accept="image/*"
                                                    class="sr-only" required>
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                                    </div>
                                </div>
                                @error('payment_proof')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                Upload Bukti Transfer
                            </button>
                        </form>
                    @else
                        <div class="text-center py-8">
                            @if($order->payment_status === 'menunggu_konfirmasi')
                                <div class="text-yellow-600">
                                    <svg class="mx-auto h-16 w-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium">Menunggu Konfirmasi</h3>
                                    <p class="text-sm text-gray-600 mt-2">Bukti pembayaran Anda sedang diverifikasi oleh admin</p>
                                </div>
                            @elseif($order->payment_status === 'terkonfirmasi')
                                <div class="text-green-600">
                                    <svg class="mx-auto h-16 w-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium">Pembayaran Dikonfirmasi</h3>
                                    <p class="text-sm text-gray-600 mt-2">Pembayaran Anda telah dikonfirmasi dan pesanan sedang diproses
                                    </p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Show current payment proof if exists -->
                    @if($order->payment_proof)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h3 class="font-semibold mb-2">Bukti Pembayaran Saat Ini</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <img src="{{ Storage::url($order->payment_proof) }}" alt="Bukti Pembayaran"
                                    class="max-w-full h-auto rounded-lg shadow-sm">
                            </div>
                            <p class="text-sm text-gray-600 mt-2">
                                Status: <span class="font-medium">{{ $order->payment_status_label }}</span>
                            </p>
                        </div>
                    @endif

                    <!-- Order Summary -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="font-semibold mb-4">Detail Pesanan</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nomor Pesanan</span>
                                <span class="font-medium">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                <span class="font-medium">{{ $order->status_label }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status Pembayaran</span>
                                <span class="font-medium">{{ $order->payment_status_label }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Pembayaran</span>
                                <span class="font-bold text-blue-600">Rp
                                    {{ number_format($order->final_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-4 flex space-x-3">
                            <a href="{{ route('orders.show', $order->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                Lihat Detail Pesanan
                            </a>

                            @if($order->canBeCancelled())
                                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors"
                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                        Batalkan Pesanan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <p>Order tidak ditemukan atau terjadi kesalahan.</p>
                <a href="{{ route('home') }}" class="text-red-800 underline">Kembali ke beranda</a>
            </div>
        @endif
    </div>
@endsection