@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
    <div class="min-h-screen bg-gray-50/50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200/60 shadow-sm">
            <div class="px-6 lg:px-8">
                <div class="flex justify-between items-center py-8">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Edit Kategori</h1>
                        <p class="mt-2 text-sm text-gray-600">Perbarui informasi kategori {{ $category->name }}</p>
                    </div>
                    <a href="{{ route('admin.categories.index') }}"
                        class="bg-gray-600 text-white px-5 py-2.5 rounded-xl hover:bg-gray-700 transition-colors duration-200 font-medium text-sm shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="px-6 lg:px-8 py-8">
            <div class="w-full mx-auto">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="px-8 py-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Kategori</h2>
                        <p class="text-sm text-gray-600 mt-1">Perbarui form di bawah untuk mengubah kategori</p>
                    </div>

                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                        enctype="multipart/form-data" class="p-8 space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-300 @enderror"
                                placeholder="Masukkan nama kategori">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-300 @enderror"
                                placeholder="Masukkan deskripsi kategori (opsional)">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div>
                            <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                                Gambar Kategori
                            </label>

                            <!-- Current Image -->
                            @if($category->image)
                                <div class="mb-4">
                                    <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                    <div
                                        class="h-48 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center rounded-xl overflow-hidden">
                                        <img src="{{ $category->image }}" alt="{{ $category->name }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                </div>
                            @endif

                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>{{ $category->image ? 'Ganti gambar' : 'Upload gambar' }}</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*"
                                                onchange="previewImage(this)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                </div>
                            </div>
                            <div id="image-preview" class="mt-4 hidden">
                                <p class="text-sm text-gray-600 mb-2">Preview gambar baru:</p>
                                <div
                                    class="h-48 bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center rounded-xl overflow-hidden">
                                    <img id="preview-img" class="w-full h-full object-cover" src="" alt="Preview">
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center">
                                    <input type="radio" name="is_active" value="1" {{ old('is_active', $category->is_active) == '1' ? 'checked' : '' }}
                                        class="form-radio text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="is_active" value="0" {{ old('is_active', $category->is_active) == '0' ? 'checked' : '' }}
                                        class="form-radio text-red-600 focus:ring-red-500">
                                    <span class="ml-2 text-sm text-gray-700">Tidak Aktif</span>
                                </label>
                            </div>
                            @error('is_active')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.categories.index') }}"
                                class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium">
                                Batal
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium shadow-sm">
                                <i class="fas fa-save mr-2"></i>Perbarui Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('image-preview').classList.remove('hidden');
                    document.getElementById('preview-img').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush