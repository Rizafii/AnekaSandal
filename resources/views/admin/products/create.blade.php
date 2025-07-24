@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5">
                    <ol class="inline-flex items-center space-x-1 text-sm font-medium md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-gray-700 hover:text-primary-600">
                                Produk
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-400 ml-1 md:ml-2">Tambah Produk</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-xl sm:text-2xl font-semibold text-gray-900">Tambah Produk Baru</h1>
            </div>
        </div>
    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="align-middle inline-block min-w-full">
                <div class="shadow overflow-hidden">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Basic Information -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                            @error('name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                            <textarea name="description" id="description" rows="4" 
                                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>{{ old('description') }}</textarea>
                                            @error('description')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                                                <input type="number" name="price" id="price" value="{{ old('price') }}" min="0" step="0.01"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                @error('price')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="weight" class="block text-sm font-medium text-gray-700">Berat (gram)</label>
                                                <input type="number" name="weight" id="weight" value="{{ old('weight') }}" min="0" step="0.01"
                                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                @error('weight')
                                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category Selection -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Kategori</h3>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label for="category_id" class="block text-sm font-medium text-gray-700">Pilih Kategori</label>
                                            <div class="flex gap-2">
                                                <select name="category_id" id="category_id" 
                                                        class="flex-1 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                    <option value="">Pilih kategori...</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="button" onclick="openCategoryModal()" 
                                                        class="mt-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap">
                                                    <i class="fas fa-plus mr-1"></i>Baru
                                                </button>
                                            </div>
                                            @error('category_id')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Quick Add Category (Legacy - Hidden) -->
                                        <div class="border-t pt-4 hidden">
                                            <div class="flex items-center mb-2">
                                                <input type="checkbox" id="add_new_category" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                                <label for="add_new_category" class="ml-2 text-sm text-gray-700">Tambah kategori baru</label>
                                            </div>
                                            
                                            <div id="new_category_fields" class="space-y-3 hidden">
                                                <div>
                                                    <label for="new_category_name" class="block text-sm font-medium text-gray-700">Nama Kategori Baru</label>
                                                    <input type="text" name="new_category_name" id="new_category_name" value="{{ old('new_category_name') }}"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                    @error('new_category_name')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="new_category_description" class="block text-sm font-medium text-gray-700">Deskripsi Kategori</label>
                                                    <textarea name="new_category_description" id="new_category_description" rows="2"
                                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('new_category_description') }}</textarea>
                                                    @error('new_category_description')
                                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Status -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Status Produk</h3>
                                    
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                                   {{ old('is_active', true) ? 'checked' : '' }}
                                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                            <label for="is_active" class="ml-2 text-sm text-gray-700">Produk Aktif</label>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="checkbox" name="featured" id="featured" value="1" 
                                                   {{ old('featured') ? 'checked' : '' }}
                                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                            <label for="featured" class="ml-2 text-sm text-gray-700">Produk Unggulan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Product Images -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Gambar Produk</h3>
                                    
                                    <div>
                                        <label for="images" class="block text-sm font-medium text-gray-700">Upload Gambar</label>
                                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        <p class="mt-1 text-sm text-gray-500">Upload beberapa gambar sekaligus. Gambar pertama akan menjadi gambar utama.</p>
                                        @error('images.*')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Product Variants -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Varian Produk</h3>
                                    
                                    <div id="variants-container">
                                        <div class="variant-item border border-gray-200 rounded-lg p-4 mb-3">
                                            <div class="grid grid-cols-2 gap-4 mb-3">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Ukuran</label>
                                                    <input type="text" name="variants[0][size]" placeholder="Contoh: 38, 39, 40" 
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Warna</label>
                                                    <input type="text" name="variants[0][color]" placeholder="Contoh: Hitam, Putih" 
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Harga Tambahan (Rp)</label>
                                                    <input type="number" name="variants[0][additional_price]" value="0" min="0" step="0.01"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700">Stok</label>
                                                    <input type="number" name="variants[0][stock]" value="0" min="0"
                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" id="add-variant" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="-ml-0.5 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Tambah Varian
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-6 flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.products.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle new category fields
            const addCategoryCheckbox = document.getElementById('add_new_category');
            const newCategoryFields = document.getElementById('new_category_fields');
            const categorySelect = document.getElementById('category_id');

            addCategoryCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    newCategoryFields.classList.remove('hidden');
                    categorySelect.disabled = true;
                    categorySelect.value = '';
                } else {
                    newCategoryFields.classList.add('hidden');
                    categorySelect.disabled = false;
                }
            });

            // Add variant functionality
            let variantIndex = 1;
            const addVariantBtn = document.getElementById('add-variant');
            const variantsContainer = document.getElementById('variants-container');

            addVariantBtn.addEventListener('click', function() {
                const variantHtml = `
                    <div class="variant-item border border-gray-200 rounded-lg p-4 mb-3">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="text-sm font-medium text-gray-700">Varian ${variantIndex + 1}</h4>
                            <button type="button" class="remove-variant text-red-600 hover:text-red-800">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ukuran</label>
                                <input type="text" name="variants[${variantIndex}][size]" placeholder="Contoh: 38, 39, 40" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Warna</label>
                                <input type="text" name="variants[${variantIndex}][color]" placeholder="Contoh: Hitam, Putih" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga Tambahan (Rp)</label>
                                <input type="number" name="variants[${variantIndex}][additional_price]" value="0" min="0" step="0.01"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Stok</label>
                                <input type="number" name="variants[${variantIndex}][stock]" value="0" min="0"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                    </div>
                `;
                
                variantsContainer.insertAdjacentHTML('beforeend', variantHtml);
                variantIndex++;
            });

            // Remove variant functionality
            variantsContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-variant')) {
                    e.target.closest('.variant-item').remove();
                }
            });
        });
    </script>
</div>

<!-- Add Category Modal -->
<div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Tambah Kategori Baru</h3>
                <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form id="categoryForm">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="modal_category_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="modal_category_name" name="name" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan nama kategori">
                        <div id="modal_name_error" class="hidden mt-1 text-sm text-red-600"></div>
                    </div>
                    
                    <div>
                        <label for="modal_category_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea id="modal_category_description" name="description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="Masukkan deskripsi kategori (opsional)"></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeCategoryModal()" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                        Batal
                    </button>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <span id="modal_submit_text">Simpan Kategori</span>
                        <span id="modal_loading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Category Modal Functions
function openCategoryModal() {
    document.getElementById('categoryModal').classList.remove('hidden');
    document.getElementById('modal_category_name').focus();
}

function closeCategoryModal() {
    document.getElementById('categoryModal').classList.add('hidden');
    document.getElementById('categoryForm').reset();
    document.getElementById('modal_name_error').classList.add('hidden');
}

// Handle category form submission
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.querySelector('#categoryForm button[type="submit"]');
    const submitText = document.getElementById('modal_submit_text');
    const loadingText = document.getElementById('modal_loading');
    const errorDiv = document.getElementById('modal_name_error');
    
    // Show loading state
    submitBtn.disabled = true;
    submitText.classList.add('hidden');
    loadingText.classList.remove('hidden');
    errorDiv.classList.add('hidden');
    
    const formData = new FormData(this);
    
    fetch('{{ route("admin.categories.quick-create") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add new category to select dropdown
            const categorySelect = document.getElementById('category_id');
            const newOption = document.createElement('option');
            newOption.value = data.category.id;
            newOption.textContent = data.category.name;
            newOption.selected = true;
            categorySelect.appendChild(newOption);
            
            // Close modal and show success message
            closeCategoryModal();
            
            // Show success notification
            showNotification('success', data.message);
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.message.includes('already been taken')) {
            errorDiv.textContent = 'Nama kategori sudah digunakan';
            errorDiv.classList.remove('hidden');
        } else {
            showNotification('error', 'Terjadi kesalahan saat menambah kategori');
        }
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        submitText.classList.remove('hidden');
        loadingText.classList.add('hidden');
    });
});

// Simple notification function
function showNotification(type, message) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${
        type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Close modal on outside click
document.getElementById('categoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCategoryModal();
    }
});
</script>

@endsection
