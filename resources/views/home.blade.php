@extends('app')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-20">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">Selamat Datang di AnekaSandal</h1>
            <p class="text-lg md:text-xl mb-8">Temukan koleksi sandal terbaik dengan kualitas premium dan harga terjangkau</p>
            <div class="space-x-4">
                <button class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                    Lihat Produk
                </button>
                <button class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                    Pelajari Lebih Lanjut
                </button>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Produk Unggulan</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Sample Product Cards -->
                @for ($i = 1; $i <= 4; $i++)
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                    <div class="h-48 bg-gray-200 dark:bg-gray-600"></div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Sandal Premium {{ $i }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 mb-4">Sandal berkualitas tinggi dengan desain modern</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">Rp 150.000</span>
                            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                                Beli Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>

    <!-- Search Demo Section -->
    <section class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Coba Fitur Pencarian</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                Gunakan kolom pencarian di navbar untuk mencari produk sandal favorit Anda
            </p>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-8 shadow-lg max-w-md mx-auto">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Kata Kunci Populer:</h3>
                <div class="flex flex-wrap gap-2 justify-center">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">sandal wanita</span>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">sandal pria</span>
                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">sandal anak</span>
                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">sandal kulit</span>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
