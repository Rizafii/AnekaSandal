@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
    <div class="min-h-screen bg-gray-50/50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200/60 shadow-sm">
            <div class="px-6 lg:px-8">
                <div class="flex justify-between items-center py-8">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Detail Produk</h1>
                        <p class="mt-2 text-sm text-gray-600">Informasi lengkap produk {{ $product->name }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition-colors duration-200 font-medium text-sm shadow-sm">
                            <i class="fas fa-edit mr-2"></i>Edit Produk
                        </a>
                        <a href="{{ route('admin.products.index') }}"
                            class="bg-gray-600 text-white px-5 py-2.5 rounded-xl hover:bg-gray-700 transition-colors duration-200 font-medium text-sm shadow-sm">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Images -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Gambar Produk</h3>
                        @if($product->images->count() > 0)
                            <div class="space-y-4">
                                <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
                                    <img src="{{ $product->images->first()->image_path }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover" id="mainImage">
                                </div>
                                @if($product->images->count() > 1)
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach($product->images as $image)
                                            <button type="button" onclick="changeMainImage('{{ $image->image_path }}')"
                                                class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 border-transparent hover:border-blue-500 transition-colors">
                                                <img src="{{ $image->image_path }}" alt="{{ $product->name }}"
                                                    class="w-full h-full object-cover">
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="aspect-square bg-gray-100 rounded-xl flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-500">Tidak ada gambar</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Product Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Produk</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                                    <p class="text-gray-900 font-semibold">{{ $product->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                                    <p class="text-gray-900">{{ $product->sku ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                                    <span
                                        class="inline-flex px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-lg">
                                        {{ $product->category->name ?? '-' }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                    <span
                                        class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                            {{ $product->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <p class="text-gray-900">{{ $product->description ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Stock -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">Harga & Stok</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                                    <p class="text-xl font-bold text-green-600">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                                @if($product->compare_price)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Coret</label>
                                        <p class="text-lg text-gray-500 line-through">Rp
                                            {{ number_format($product->compare_price, 0, ',', '.') }}</p>
                                    </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Total Stok</label>
                                    <p class="text-xl font-bold text-blue-600">{{ $product->total_stock }}</p>
                                </div>
                                @if($product->weight)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Berat</label>
                                        <p class="text-gray-900">{{ $product->weight }} gram</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Product Variants -->
                    @if($product->variants->count() > 0)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h3 class="text-lg font-semibold text-gray-900">Varian Produk</h3>
                            </div>
                            <div class="p-6">
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="border-b border-gray-200">
                                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Ukuran</th>
                                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Warna</th>
                                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Harga Tambahan</th>
                                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Stok</th>
                                                <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($product->variants as $variant)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="py-3 px-4">{{ $variant->size ?? '-' }}</td>
                                                    <td class="py-3 px-4">{{ $variant->color ?? '-' }}</td>
                                                    <td class="py-3 px-4">
                                                        @if($variant->additional_price > 0)
                                                            +Rp {{ number_format($variant->additional_price, 0, ',', '.') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="py-3 px-4">
                                                        <span
                                                            class="font-semibold {{ $variant->stock <= 5 ? 'text-red-600' : 'text-green-600' }}">
                                                            {{ $variant->stock }}
                                                        </span>
                                                    </td>
                                                    <td class="py-3 px-4">
                                                        <span
                                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                                        {{ $variant->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                                            {{ $variant->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Metadata -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Tambahan</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Dibuat</label>
                                    <p class="text-gray-900">{{ $product->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Terakhir Diubah</label>
                                    <p class="text-gray-900">{{ $product->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function changeMainImage(src) {
            document.getElementById('mainImage').src = src;
        }
    </script>
@endpush