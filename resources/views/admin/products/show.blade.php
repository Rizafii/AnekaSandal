@extends('layouts.admin')

@section('title', 'Detail Produk')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Detail Produk: {{ $product->name }}</h2>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.products.edit', $product) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.products.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Product Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Produk</h3>
                    </div>
                    
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama Produk</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->name }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->slug }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->category->name }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $product->description }}</dd>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Harga</dt>
                                    <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Berat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->weight }} gram</dd>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        @if($product->is_active)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Featured</dt>
                                    <dd class="mt-1">
                                        @if($product->featured)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Ya
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Tidak
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('d M Y H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Diperbarui</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $product->updated_at->format('d M Y H:i') }}</dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Product Images -->
            <div>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Gambar Produk</h3>
                    </div>
                    
                    <div class="p-6">
                        @if($product->images->count() > 0)
                            <div class="space-y-3">
                                @foreach($product->images as $image)
                                    <div class="relative">
                                        <img src="{{ $image->image_path }}" alt="{{ $product->name }}" 
                                             class="w-full h-32 object-cover rounded-lg border">
                                        @if($image->is_primary)
                                            <span class="absolute top-2 left-2 bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                                Utama
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-500">Tidak ada gambar</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Variants -->
        @if($product->variants->count() > 0)
            <div class="mt-8">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Varian Produk</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ukuran</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warna</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Tambahan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($product->variants as $variant)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $variant->size ?: '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $variant->color ?: '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($variant->additional_price > 0)
                                                    +Rp {{ number_format($variant->additional_price, 0, ',', '.') }}
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $variant->stock }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($variant->is_active)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
