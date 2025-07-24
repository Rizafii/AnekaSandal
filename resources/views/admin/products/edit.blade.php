@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900">Edit Produk: {{ $product->name }}</h2>
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-8">
                    <!-- Basic Information -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Product Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Produk <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                       class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @else border-gray-300 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category Selection with Option to Add New -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <select name="category_id" id="category_id" required
                                            class="flex-1 w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('category_id') border-red-500 @else border-gray-300 @enderror">
                                        <option value="">Pilih kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="openCategoryModal()" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap">
                                        <i class="fas fa-plus mr-1"></i>Baru
                                    </button>
                                </div>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                
                                <!-- Add New Category Option -->
                                <div class="mt-3">
                                    <label class="flex items-center">
                                        <input type="checkbox" id="add_new_category" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">Tambah kategori baru</span>
                                    </label>
                                    
                                    <div id="new_category_fields" class="mt-3 space-y-3 hidden">
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

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea name="description" id="description" rows="4" required
                                          class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @else border-gray-300 @enderror">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Price and Weight -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                        Harga (Rp) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0" step="0.01"
                                           class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @else border-gray-300 @enderror">
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                                        Berat (gram) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="weight" id="weight" value="{{ old('weight', $product->weight) }}" required min="0" step="0.01"
                                           class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('weight') border-red-500 @else border-gray-300 @enderror">
                                    @error('weight')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Images -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Gambar Produk</h3>
                        
                        <!-- Current Images -->
                        @if($product->images->count() > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($product->images as $image)
                                        <div class="relative">
                                            <img src="{{ $image->image_path }}" alt="{{ $product->name }}" 
                                                 class="w-full h-24 object-cover rounded-lg border">
                                            @if($image->is_primary)
                                                <span class="absolute top-1 left-1 bg-blue-600 text-white text-xs px-1 rounded">Utama</span>
                                            @endif
                                            <label class="absolute top-1 right-1">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" 
                                                       class="h-4 w-4 text-red-600 border-gray-300 rounded">
                                                <span class="sr-only">Hapus gambar</span>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Centang gambar yang ingin dihapus</p>
                            </div>
                        @endif

                        <!-- Upload New Images -->
                        <div>
                            <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Tambah Gambar Baru</label>
                            <input type="file" name="images[]" id="images" multiple accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-sm text-gray-500 mt-1">Pilih beberapa gambar (PNG, JPG, JPEG). Gambar pertama akan menjadi gambar utama.</p>
                            @error('images.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Product Variants -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Varian Produk</h3>
                        
                        <div id="variants-container">
                            @foreach($product->variants as $index => $variant)
                                <div class="variant-row border border-gray-200 rounded-lg p-4 mb-4">
                                    <div class="flex justify-between items-center mb-3">
                                        <h4 class="text-md font-medium text-gray-800">Varian {{ $index + 1 }}</h4>
                                        <button type="button" onclick="removeVariant(this)" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                    
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran</label>
                                            <input type="text" name="variants[{{ $index }}][size]" value="{{ old("variants.$index.size", $variant->size) }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                                            <input type="text" name="variants[{{ $index }}][color]" value="{{ old("variants.$index.color", $variant->color) }}"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Harga Tambahan</label>
                                            <input type="number" name="variants[{{ $index }}][additional_price]" value="{{ old("variants.$index.additional_price", $variant->additional_price) }}" min="0" step="0.01"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                                            <input type="number" name="variants[{{ $index }}][stock]" value="{{ old("variants.$index.stock", $variant->stock) }}" min="0"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="variants[{{ $index }}][is_active]" value="1" {{ old("variants.$index.is_active", $variant->is_active) ? 'checked' : '' }}
                                                   class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                            <span class="ml-2 text-sm text-gray-700">Varian aktif</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <button type="button" onclick="addVariant()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-plus mr-2"></i>Tambah Varian
                        </button>
                    </div>

                    <!-- Product Status -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Status Produk</h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Produk aktif</span>
                            </label>
                            
                            <label class="flex items-center">
                                <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Produk unggulan</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.products.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-save mr-2"></i>Update Produk
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Toggle new category fields
document.getElementById('add_new_category').addEventListener('change', function() {
    const fields = document.getElementById('new_category_fields');
    const categorySelect = document.getElementById('category_id');
    
    if (this.checked) {
        fields.classList.remove('hidden');
        categorySelect.disabled = true;
        categorySelect.value = '';
    } else {
        fields.classList.add('hidden');
        categorySelect.disabled = false;
    }
});

let variantIndex = {{ $product->variants->count() }};

function addVariant() {
    const container = document.getElementById('variants-container');
    const variantHtml = `
        <div class="variant-row border border-gray-200 rounded-lg p-4 mb-4">
            <div class="flex justify-between items-center mb-3">
                <h4 class="text-md font-medium text-gray-800">Varian ${variantIndex + 1}</h4>
                <button type="button" onclick="removeVariant(this)" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ukuran</label>
                    <input type="text" name="variants[${variantIndex}][size]"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                    <input type="text" name="variants[${variantIndex}][color]"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Tambahan</label>
                    <input type="number" name="variants[${variantIndex}][additional_price]" min="0" step="0.01"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input type="number" name="variants[${variantIndex}][stock]" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>
            
            <div class="mt-3">
                <label class="flex items-center">
                    <input type="checkbox" name="variants[${variantIndex}][is_active]" value="1" checked
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-700">Varian aktif</span>
                </label>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', variantHtml);
    variantIndex++;
}

function removeVariant(button) {
    button.closest('.variant-row').remove();
}

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

@endsection
