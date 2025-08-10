@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
    <div class="min-h-screen bg-gray-50/50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200/60 shadow-sm">
            <div class="px-6 lg:px-8">
                <div class="flex justify-between items-center py-8">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Kelola Produk</h1>
                        <p class="mt-2 text-sm text-gray-600">Kelola semua produk toko Anda</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded-lg border">
                            Total: {{ $products->total() }} produk
                        </div>
                        <a href="{{ route('admin.products.create') }}"
                            class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition-colors duration-200 font-medium text-sm shadow-sm">
                            <i class="fas fa-plus mr-2"></i>Tambah Produk
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 lg:px-8 py-8">
            <!-- Filters & Search -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="lg:w-48">
                        <select name="category"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="lg:w-48">
                        <select name="status"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="lg:w-48">
                        <select name="stock"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Stok</option>
                            <option value="in_stock" {{ request('stock') === 'in_stock' ? 'selected' : '' }}>Tersedia</option>
                            <option value="low_stock" {{ request('stock') === 'low_stock' ? 'selected' : '' }}>Stok Rendah</option>
                            <option value="out_of_stock" {{ request('stock') === 'out_of_stock' ? 'selected' : '' }}>Habis</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-colors font-medium">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    @if(request()->hasAny(['search', 'category', 'status', 'stock']))
                        <a href="{{ route('admin.products.index') }}"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Table Container with Horizontal Scroll -->
                <div class="overflow-x-auto">
                    <div class="min-w-full">
                        <!-- Vertical Scroll Container -->
                        <div class="max-h-[600px] overflow-y-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <!-- Fixed Header -->
                                <thead class="bg-gray-50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[280px]">
                                            Produk
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[120px]">
                                            Kategori
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[120px]">
                                            Harga
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[100px]">
                                            Stok
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[100px]">
                                            Status
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[100px]">
                                            Tanggal
                                        </th>
                                        <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider whitespace-nowrap min-w-[150px]">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <!-- Scrollable Body -->
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($products as $product)
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap min-w-[280px]">
                                                <div class="flex items-center">
                                                    <div class="h-16 w-16 flex-shrink-0">
                                                        @if($product->images->isNotEmpty())
                                                            <img class="h-16 w-16 rounded-lg object-cover" 
                                                                 src="{{ $product->images->first()->image_path }}" 
                                                                 alt="{{ $product->name }}">
                                                        @else
                                                            <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                                                <i class="fas fa-image text-gray-400"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4 flex-1 min-w-0">
                                                        <div class="text-sm font-semibold text-gray-900 truncate max-w-[180px]" title="{{ $product->name }}">
                                                            {{ $product->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap min-w-[120px]">
                                                <span class="inline-flex px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-lg">
                                                    {{ $product->category->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap min-w-[120px]">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </div>
                                                @if($product->compare_price)
                                                    <div class="text-xs text-gray-500 line-through">
                                                        Rp {{ number_format($product->compare_price, 0, ',', '.') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap min-w-[100px]">
                                                <div class="text-sm font-semibold text-gray-900">
                                                    {{ $product->calculated_stock ?? $product->variants->where('is_active', true)->sum('stock') }}
                                                </div>
                                                @php
                                                    $stock = $product->calculated_stock ?? $product->variants->where('is_active', true)->sum('stock');
                                                @endphp
                                                @if($stock <= 5 && $stock > 0)
                                                    <span class="inline-flex px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded">
                                                        Stok Rendah
                                                    </span>
                                                @elseif($stock <= 0)
                                                    <span class="inline-flex px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">
                                                        Habis
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap min-w-[100px]">
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                    {{ $product->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 min-w-[100px]">
                                                {{ $product->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center min-w-[150px]">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors text-xs font-medium">
                                                        <i class="fas fa-eye mr-1"></i>Lihat
                                                    </a>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors text-xs font-medium">
                                                        <i class="fas fa-edit mr-1"></i>Edit
                                                    </a>
                                                    <button onclick="deleteProduct({{ $product->id }})"
                                                        class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors text-xs font-medium">
                                                        <i class="fas fa-trash mr-1"></i>Hapus
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada produk</h3>
                                                    <p class="text-gray-600 mb-6">Mulai dengan menambahkan produk pertama Anda</p>
                                                    <a href="{{ route('admin.products.create') }}"
                                                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium">
                                                        <i class="fas fa-plus mr-2"></i>Tambah Produk
                                                    </a>
                                                </div>
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
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Form -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Show flash messages with SweetAlert
        @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#10b981',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
        @endif

        function deleteProduct(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Produk ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const form = document.getElementById('delete-form');
                    form.action = `/admin/products/${id}`;
                    
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            _method: 'DELETE'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#10b981'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: data.message,
                                icon: 'error',
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus produk.',
                            icon: 'error',
                            confirmButtonColor: '#ef4444'
                        });
                    });
                }
            });
        }
    </script>
@endpush
