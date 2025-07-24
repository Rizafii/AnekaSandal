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
            <div class="grid grid-cols-1 gap-8">
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
                            </div>
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