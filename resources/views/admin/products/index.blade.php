@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Kelola Produk</h1>
            </div>

            <!-- Filters -->
            <div class="sm:flex">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0">
                    <form class="lg:pr-3" action="{{ route('admin.products.index') }}" method="GET">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" id="search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5" placeholder="Cari produk...">
                        </div>
                    </form>
                </div>

                <div class="flex items-center space-x-2 sm:space-x-3">
                    <!-- Category Filter -->
                    <div class="relative">
                        <select name="category_id" onchange="this.form.submit()" form="filter-form" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="relative">
                        <select name="status" onchange="this.form.submit()" form="filter-form" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <a href="{{ route('admin.products.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                        <svg class="-ml-1 mr-2 h-6 w-6 inline" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Tambah Produk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <form id="filter-form" action="{{ route('admin.products.index') }}" method="GET" style="display: none;">
        <input type="hidden" name="search" value="{{ request('search') }}">
    </form>

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

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <table class="table-fixed min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Produk
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Kategori
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Harga
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Stok
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Status
                                </th>
                                <th scope="col" class="p-4 text-left text-xs font-medium text-gray-500 uppercase">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-100">
                                    <td class="p-4 flex items-center whitespace-nowrap space-x-6 mr-12 lg:mr-0">
                                        <img class="h-10 w-10 rounded-lg object-cover" 
                                             src="{{ $product->images->first()?->url ?? 'https://via.placeholder.com/40x40/f3f4f6/6b7280?text=No+Image' }}" 
                                             alt="{{ $product->name }}">
                                        <div class="text-sm font-normal text-gray-500">
                                            <div class="text-base font-semibold text-gray-900">{{ $product->name }}</div>
                                            <div class="text-sm font-normal text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                                        </div>
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-base font-medium text-gray-900">
                                        {{ $product->category->name ?? 'Tidak ada kategori' }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-base font-medium text-gray-900">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-base font-medium text-gray-900">
                                        {{ $product->variants->sum('stock') }}
                                    </td>
                                    <td class="p-4 whitespace-nowrap text-base font-medium">
                                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md transition-colors">
                                                @if($product->is_active)
                                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Aktif</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Nonaktif</span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>
                                    <td class="p-4 whitespace-nowrap space-x-2">
                                        <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="text-yellow-600 hover:text-yellow-900">
                                            <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">
                                        Tidak ada produk ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="bg-white sticky sm:flex items-center w-full sm:justify-between bottom-0 right-0 border-t border-gray-200 p-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif

@endsection
