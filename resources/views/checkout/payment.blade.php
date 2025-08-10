@extends('app')

@section('title', 'Pembayaran')

@section('content')
    <div class="px-3 py-10 mt-16 bg-secondary min-h-screen">
        <div class="w-full mx-auto space-y-6">
            <!-- Breadcrumb -->
            <nav class="text-sm mb-6" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2 text-gray-500">
                    <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a></li>
                    <li class="text-gray-400">/</li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-primary transition-colors">Keranjang</a></li>
                    <li class="text-gray-400">/</li>
                    <li><a href="{{ route('checkout.index') }}" class="hover:text-primary transition-colors">Checkout</a>
                    </li>
                    <li class="text-gray-400">/</li>
                    <li class="text-gray-700 font-medium">Pembayaran</li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900">Pembayaran</h1>
                            <p class="text-sm text-gray-600 mt-1">Selesaikan pembayaran pesanan Anda</p>
                        </div>
                    </div>
                </div>
                <!-- Progress Steps -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-green-600">Checkout</span>
                    </div>
                    <div class="w-8 h-0.5 bg-primary"></div>
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm font-semibold">
                            2</div>
                        <span class="text-sm font-medium text-primary">Pembayaran</span>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div
                    class="rounded-xl bg-green-50 border border-green-200 px-5 py-3 flex items-start gap-3 text-sm text-green-700">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <div class="flex-1">{{ session('success') }}</div>
                    <button type="button" class="text-green-500 hover:text-green-700"
                        onclick="this.parentElement.remove()">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div class="rounded-xl bg-red-50 border border-red-200 px-5 py-3 flex items-start gap-3 text-sm text-red-700">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <div class="flex-1">{{ session('error') }}</div>
                    <button type="button" class="text-red-500 hover:text-red-700"
                        onclick="this.parentElement.remove()">✕</button>
                </div>
            @endif

            @if(isset($order) && $order)
                <!-- Order Summary Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/50 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-primary/5 to-primary/10 border-b border-gray-200/70">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-lg font-bold text-gray-900">Detail Pesanan</h2>
                                <p class="text-sm text-gray-600">Nomor: {{ $order->order_number }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-primary">Rp
                                    {{ number_format($order->final_amount, 0, ',', '.') }}
                                </div>
                                <div class="text-sm text-gray-600">Total Pembayaran</div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Bank Transfer Section -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">1. Transfer ke Rekening Berikut</h3>
                                </div>

                                <div
                                    class="bg-gradient-to-r from-blue-50 to-blue-100/50 p-6 rounded-2xl border border-blue-200">
                                    <div class="flex justify-center">
                                        <!-- Bank Account Info -->
                                        <div class="bg-white rounded-xl p-6 border border-blue-200 shadow-sm max-w-md w-full">
                                            <div class="flex items-center gap-3 mb-4">
                                                <div class="w-12 h-8 bg-blue-600 rounded flex items-center justify-center">
                                                    <span
                                                        class="text-white text-xs font-bold">{{ strtoupper(substr($paymentInfo['bank_name'] ?? 'BANK', 0, 3)) }}</span>
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900">
                                                        {{ $paymentInfo['bank_name'] ?? 'Bank' }}</div>
                                                    <div class="text-sm text-gray-600">a.n.
                                                        {{ $paymentInfo['bank_account_name'] ?? 'Aneka Sandal' }}</div>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div class="text-xl font-bold text-gray-900">
                                                    {{ $paymentInfo['bank_account_number'] ?? '1234567890' }}</div>
                                                <button
                                                    onclick="copyToClipboard('{{ $paymentInfo['bank_account_number'] ?? '1234567890' }}')"
                                                    class="text-blue-600 hover:text-blue-800 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="mt-4 p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-yellow-600 flex-shrink-0" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                                    </svg>
                                                    <div class="text-sm text-yellow-800">
                                                        <strong>Nominal Transfer: Rp
                                                            {{ number_format((float) $order->final_amount, 0, ',', '.') }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp Section -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">2. Konfirmasi Pembayaran via WhatsApp</h3>
                                </div>

                                <div class="bg-green-50 rounded-2xl p-6 border border-green-200">
                                    <p class="text-sm text-green-800 mb-4">
                                        Setelah melakukan transfer, silakan konfirmasi pembayaran dan kirim bukti transfer
                                        melalui WhatsApp admin kami.
                                    </p>
                                    <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $storePhone ?: '6281234567890') }}?text=Halo%20Admin%2C%20saya%20telah%20melakukan%20transfer%20untuk%20pesanan%20{{ urlencode($order->order_number) }}%20dengan%20total%20Rp%20{{ urlencode(number_format((float) $order->final_amount, 0, '.', '.')) }}.%20Mohon%20konfirmasi%20pembayaran.%20Terima%20kasih."
                                        target="_blank"
                                        class="inline-flex items-center gap-3 px-6 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488" />
                                        </svg>
                                        Konfirmasi via WhatsApp
                                    </a>
                                </div>
                            </div>

                            <!-- View Orders Section -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900">3. Pantau Status Pesanan</h3>
                                </div>

                                <div class="bg-blue-50 rounded-2xl p-6 border border-blue-200">
                                    <p class="text-sm text-blue-800 mb-4">
                                        Pantau status pembayaran dan pengiriman pesanan Anda secara real-time di halaman pesanan.
                                    </p>
                                    <a href="{{ route('orders.index') }}"
                                        class="inline-flex items-center gap-3 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                        </svg>
                                        Lihat Pesanan Saya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="bg-yellow-50 rounded-2xl p-6 border border-yellow-200">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-yellow-800 mb-2">Penting untuk Diperhatikan:</h4>
                            <ul class="text-sm text-yellow-700 space-y-1">
                                <li>• Transfer sesuai dengan nominal yang tertera: <strong>Rp
                                        {{ number_format((float) $order->final_amount, 0, ',', '.') }}</strong></li>
                                <li>• Konfirmasi pembayaran via WhatsApp dan kirim bukti transfer</li>
                                <li>• Pembayaran akan dikonfirmasi dalam 1x24 jam setelah admin menerima bukti transfer</li>
                                <li>• Simpan nomor pesanan <strong>{{ $order->order_number }}</strong> untuk tracking status
                                </li>
                                <li>• Pesanan akan diproses setelah pembayaran dikonfirmasi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow-sm border border-red-200 p-8 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Pesanan Tidak Ditemukan</h3>
                    <p class="text-gray-600 mb-6">Order tidak ditemukan atau terjadi kesalahan sistem.</p>
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-xl font-semibold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Copy to clipboard functionality
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function () {
                // Show success message
                const originalText = event.target.innerHTML;
                event.target.innerHTML = '<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                setTimeout(() => {
                    event.target.innerHTML = originalText;
                }, 1000);
            });
        }
    </script>
@endsection