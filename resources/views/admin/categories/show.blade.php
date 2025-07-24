@extends('layouts.admin')

@section('title', 'Detail Kategori')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Detail Kategori: {{ $category->name }}</h2>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Category Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Kategori</h3>
                    </div>
                    
                    <div class="p-6">
                        <dl class="grid grid-cols-1 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Nama Kategori</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $category->name }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Slug</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $category->slug }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Deskripsi</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $category->description ?: 'Tidak ada deskripsi' }}
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
                                    @if($category->is_active)
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
                                <dt class="text-sm font-medium text-gray-500">Jumlah Produk</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $category->products->count() }} produk</dd>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('d M Y H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Diperbarui</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('d M Y H:i') }}</dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Category Image -->
            <div>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Gambar Kategori</h3>
                    </div>
                    
                    <div class="p-6">
                        @if($category->image)
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" 
                                 class="w-full h-48 object-cover rounded-lg border">
                        @else
                            <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
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

        <!-- Products List -->
        @if($category->products->count() > 0)
            <div class="mt-8">
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Produk dalam Kategori</h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($category->products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($product->images->first())
                                                    <img src="{{ $product->images->first()->image_path }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="h-10 w-10 rounded object-cover">
                                                @else
                                                    <div class="h-10 w-10 bg-gray-200 rounded flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $product->slug }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($product->is_active)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.products.show', $product) }}" 
                                                   class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.products.edit', $product) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
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
