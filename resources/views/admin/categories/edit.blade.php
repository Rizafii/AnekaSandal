@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Edit Kategori: {{ $category->name }}</h2>
                <a href="{{ route('admin.categories.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-6">
                    <!-- Nama Kategori -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                               class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @else border-gray-300 @enderror"
                               placeholder="Masukkan nama kategori">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @else border-gray-300 @enderror"
                                  placeholder="Masukkan deskripsi kategori (opsional)">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gambar -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Gambar Kategori
                        </label>
                        
                        @if($category->image)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                <img src="{{ $category->image }}" alt="{{ $category->name }}" 
                                     class="h-32 w-32 object-cover rounded-lg border">
                            </div>
                        @endif
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <div id="image-preview" class="hidden">
                                    <img id="preview-img" class="mx-auto h-32 w-32 object-cover rounded-lg">
                                    <button type="button" onclick="removeImage()" 
                                            class="mt-2 text-sm text-red-600 hover:text-red-800">
                                        Hapus Gambar Baru
                                    </button>
                                </div>
                                <div id="upload-placeholder">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                            <span>{{ $category->image ? 'Ganti gambar' : 'Upload gambar' }}</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage(this)">
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                                </div>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="ml-2 text-sm text-gray-700">Kategori aktif</span>
                        </label>
                        @error('is_active')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-save mr-2"></i>Update Kategori
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    document.getElementById('image').value = '';
    document.getElementById('image-preview').classList.add('hidden');
    document.getElementById('upload-placeholder').classList.remove('hidden');
}
</script>

@endsection
