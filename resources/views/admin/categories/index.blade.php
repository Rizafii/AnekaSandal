@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="min-h-screen bg-gray-50/50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200/60 shadow-sm">
            <div class="px-6 lg:px-8">
                <div class="flex justify-between items-center py-8">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Kelola Kategori</h1>
                        <p class="mt-2 text-sm text-gray-600">Kelola semua kategori produk toko Anda</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-sm text-gray-500 bg-gray-50 px-3 py-2 rounded-lg border">
                            Total: {{ $categories->total() }} kategori
                        </div>
                        <a href="{{ route('admin.categories.create') }}"
                            class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 transition-colors duration-200 font-medium text-sm shadow-sm">
                            <i class="fas fa-plus mr-2"></i>Tambah Kategori
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 lg:px-8 py-8">
            <!-- Filters & Search -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="sm:w-48">
                        <select name="status"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif
                            </option>
                        </select>
                    </div>
                    <button type="submit"
                        class="px-6 py-2.5 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-colors font-medium">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.categories.index') }}"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors font-medium">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($categories as $category)
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 overflow-hidden">
                        <!-- Category Image -->
                        <div class="h-48 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                            @if($category->image)
                                <img src="{{$category->image}}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <i class="fas fa-folder text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-500">Tidak ada gambar</p>
                                </div>
                            @endif
                        </div>

                        <!-- Category Info -->
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $category->name }}</h3>
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $category->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>

                            @if($category->description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $category->description }}</p>
                            @endif

                            <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                                <span>{{ $category->products_count ?? 0 }} produk</span>
                                <span>{{ $category->created_at->format('d M Y') }}</span>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="flex-1 px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors font-medium text-sm text-center">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <button onclick="deleteCategory({{ $category->id }})"
                                    class="flex-1 px-3 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors font-medium text-sm">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada kategori</h3>
                            <p class="text-gray-600 mb-6">Mulai dengan menambahkan kategori pertama Anda</p>
                            <a href="{{ route('admin.categories.create') }}"
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium">
                                <i class="fas fa-plus mr-2"></i>Tambah Kategori
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                        {{ $categories->links() }}
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

        function deleteCategory(id) {
            // Show confirmation dialog first
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Kategori ini akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Perform delete using form submission
                    const form = document.getElementById('delete-form');
                    form.action = `/admin/categories/${id}`;

                    // Add event listener for form submission
                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        // Use fetch for better error handling
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
                                    text: 'Terjadi kesalahan saat menghapus kategori.',
                                    icon: 'error',
                                    confirmButtonColor: '#ef4444'
                                });
                            });
                    });

                    // Submit the form
                    form.submit();
                }
            });
        }

        // Add click event listeners to all delete buttons
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('[onclick^="deleteCategory"]');
            deleteButtons.forEach(button => {
                // Remove the onclick attribute and add event listener
                const onclickValue = button.getAttribute('onclick');
                const categoryId = onclickValue.match(/deleteCategory\((\d+)\)/)[1];
                button.removeAttribute('onclick');

                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    deleteCategory(categoryId);
                });
            });
        });
    </script>
@endpush