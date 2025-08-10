@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="min-h-screen bg-gray-50/50">
        <!-- Header -->
        <div class="bg-white border-b border-gray-200/60 shadow-sm">
            <div class="px-6 lg:px-8">
                <div class="flex justify-between items-center py-8">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Edit Produk</h1>
                        <p class="mt-2 text-sm text-gray-600">Perbarui informasi produk {{ $product->name }}</p>
                    </div>
                    <a href="{{ route('admin.products.index') }}"
                        class="bg-gray-600 text-white px-5 py-2.5 rounded-xl hover:bg-gray-700 transition-colors duration-200 font-medium text-sm shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="px-6 lg:px-8 py-8">
            <div class="w-full mx-auto">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column - Main Information -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Basic Information -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                                <div class="px-8 py-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900">Informasi Dasar</h2>
                                    <p class="text-sm text-gray-600 mt-1">Perbarui informasi dasar produk</p>
                                </div>

                                <div class="p-8 space-y-6">
                                    <!-- Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Nama Produk <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-300 @enderror"
                                            placeholder="Masukkan nama produk">
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <!-- Description -->
                                    <div>
                                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Deskripsi <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="description" id="description" rows="5"
                                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-300 @enderror"
                                            placeholder="Masukkan deskripsi lengkap produk">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing & Inventory -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                                <div class="px-8 py-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900">Harga & Inventori</h2>
                                    <p class="text-sm text-gray-600 mt-1">Perbarui harga dan stok produk</p>
                                </div>

                                <div class="p-8 space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Price -->
                                        <div>
                                            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                                Harga <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                                <input type="number" name="price" id="price"
                                                    value="{{ old('price', $product->price) }}" min="0" step="0.01"
                                                    class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('price') border-red-300 @enderror"
                                                    placeholder="0">
                                            </div>
                                            @error('price')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Compare Price -->
                                        <div>
                                            <label for="compare_price"
                                                class="block text-sm font-semibold text-gray-700 mb-2">
                                                Harga Coret
                                            </label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-3 text-gray-500">Rp</span>
                                                <input type="number" name="compare_price" id="compare_price"
                                                    value="{{ old('compare_price', $product->compare_price) }}" min="0"
                                                    step="0.01"
                                                    class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('compare_price') border-red-300 @enderror"
                                                    placeholder="0">
                                            </div>
                                            @error('compare_price')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Stock -->
                                        <div>
                                            <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                                                Stok <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" name="stock" id="stock"
                                                value="{{ old('stock', $product->stock) }}" min="0"
                                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('stock') border-red-300 @enderror"
                                                placeholder="0">
                                            @error('stock')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Weight -->
                                        <div>
                                            <label for="weight" class="block text-sm font-semibold text-gray-700 mb-2">
                                                Berat (gram)
                                            </label>
                                            <input type="number" name="weight" id="weight"
                                                value="{{ old('weight', $product->weight) }}" min="0" step="0.01"
                                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('weight') border-red-300 @enderror"
                                                placeholder="0">
                                            @error('weight')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Images -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                                <div class="px-8 py-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900">Gambar Produk</h2>
                                    <p class="text-sm text-gray-600 mt-1">Kelola gambar produk</p>
                                </div>

                                <div class="p-8 space-y-6">
                                    <!-- Current Images -->
                                    @if($product->images->count() > 0)
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">Gambar Saat
                                                Ini</label>
                                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                                @foreach($product->images as $image)
                                                    <div class="relative group">
                                                        <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
                                                            <img src="{{ $image->image_path }}" alt="{{ $product->name }}"
                                                                class="w-full h-full object-cover">
                                                        </div>
                                                        <div
                                                            class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                            <label
                                                                class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 cursor-pointer">
                                                                <input type="checkbox" name="delete_images[]"
                                                                    value="{{ $image->id }}" class="sr-only">
                                                                ×
                                                            </label>
                                                        </div>
                                                        @if($loop->first)
                                                            <div
                                                                class="absolute bottom-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                                                Utama</div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2">Klik tanda × untuk menghapus gambar</p>
                                        </div>
                                    @endif

                                    <!-- Upload New Images -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            {{ $product->images->count() > 0 ? 'Tambah Gambar Baru' : 'Upload Gambar' }}
                                        </label>
                                        <div
                                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-gray-400 transition-colors">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="images"
                                                        class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                        <span>Upload gambar</span>
                                                        <input id="images" name="images[]" type="file" multiple
                                                            accept="image/*" class="sr-only" onchange="previewImages(this)">
                                                    </label>
                                                    <p class="pl-1">atau drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB per file</p>
                                            </div>
                                        </div>
                                        <div id="images-preview" class="mt-4 hidden">
                                            <div id="preview-container"
                                                class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
                                        </div>
                                        @error('images.*')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Product Variants -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                                <div class="px-8 py-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900">Varian Produk</h2>
                                    <p class="text-sm text-gray-600 mt-1">Kelola varian ukuran dan warna</p>
                                </div>

                                <div class="p-8">
                                    <div id="variants-container">
                                        @foreach($product->variants as $index => $variant)
                                            <div class="variant-item border border-gray-200 rounded-xl p-6 mb-4">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h4 class="text-md font-semibold text-gray-800">Varian {{ $index + 1 }}</h4>
                                                    <button type="button" onclick="removeVariant(this)" class="text-red-600 hover:text-red-800 p-2">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                
                                                <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                                
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ukuran</label>
                                                        <input type="text" name="variants[{{ $index }}][size]" value="{{ old("variants.$index.size", $variant->size) }}"
                                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Warna</label>
                                                        <input type="text" name="variants[{{ $index }}][color]" value="{{ old("variants.$index.color", $variant->color) }}"
                                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Tambahan</label>
                                                        <input type="number" name="variants[{{ $index }}][additional_price]" value="{{ old("variants.$index.additional_price", $variant->additional_price) }}" min="0" step="0.01"
                                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Stok</label>
                                                        <input type="number" name="variants[{{ $index }}][stock]" value="{{ old("variants.$index.stock", $variant->stock) }}" min="0"
                                                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                                    </div>
                                                    <div class="flex items-end">
                                                        <label class="flex items-center">
                                                            <input type="checkbox" name="variants[{{ $index }}][is_active]" value="1" {{ old("variants.$index.is_active", $variant->is_active) ? 'checked' : '' }}
                                                                   class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                                            <span class="ml-2 text-sm font-medium text-gray-700">Aktif</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <button type="button" id="add-variant" 
                                        class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors font-medium text-sm">
                                        <i class="fas fa-plus mr-2"></i>Tambah Varian
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Settings -->
                        <div class="space-y-8">
                            <!-- Category -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                                <div class="px-8 py-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900">Kategori</h2>
                                    <p class="text-sm text-gray-600 mt-1">Pilih kategori produk</p>
                                </div>

                                <div class="p-8">
                                    <div>
                                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                            Kategori <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex gap-2">
                                            <select name="category_id" id="category_id"
                                                class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-300 @enderror">
                                                <option value="">Pilih kategori...</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <button type="button" onclick="openCategoryModal()"
                                                class="px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors font-medium whitespace-nowrap">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                        @error('category_id')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                                <div class="px-8 py-6 border-b border-gray-100">
                                    <h2 class="text-lg font-semibold text-gray-900">Status Produk</h2>
                                    <p class="text-sm text-gray-600 mt-1">Atur visibilitas produk</p>
                                </div>

                                <div class="p-8">
                                    <div class="space-y-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                                class="form-checkbox h-5 w-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300">
                                            <span class="ml-3 text-sm font-medium text-gray-700">Produk Aktif</span>
                                        </label>
                                        <p class="text-xs text-gray-500 ml-8">Produk akan terlihat di toko</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                                <div class="p-8">
                                    <div class="flex flex-col space-y-3">
                                        <button type="submit"
                                            class="w-full px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium shadow-sm">
                                            <i class="fas fa-save mr-2"></i>Perbarui Produk
                                        </button>
                                        <a href="{{ route('admin.products.index') }}"
                                            class="w-full px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium text-center">
                                            Batal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4">
                <div class="px-6 py-4 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-gray-900">Tambah Kategori Baru</h3>
                        <button onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <form id="categoryForm" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="modal_category_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="modal_category_name" name="name" required
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan nama kategori">
                            <div id="modal_name_error" class="hidden mt-2 text-sm text-red-600"></div>
                        </div>

                        <div>
                            <label for="modal_category_description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea id="modal_category_description" name="description" rows="3"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan deskripsi kategori (opsional)"></textarea>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeCategoryModal()"
                            class="px-6 py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition-colors font-medium">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium">
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

            // Preview multiple images
            function previewImages(input) {
                const previewContainer = document.getElementById('preview-container');
                const previewSection = document.getElementById('images-preview');

                previewContainer.innerHTML = '';

                if (input.files && input.files.length > 0) {
                    previewSection.classList.remove('hidden');

                    Array.from(input.files).forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            const div = document.createElement('div');
                            div.className = 'relative group';
                            div.innerHTML = `
                            <div class="aspect-square bg-gray-100 rounded-xl overflow-hidden">
                                <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" onclick="removePreview(this)" class="bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                    ×
                                </button>
                            </div>
                            ${index === 0 ? '<div class="absolute bottom-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded">Utama</div>' : ''}
                        `;
                            previewContainer.appendChild(div);
                        }
                        reader.readAsDataURL(file);
                    });
                } else {
                    previewSection.classList.add('hidden');
                }
            }

        function removePreview(button) {
            button.closest('.relative').remove();
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
        document.getElementById('categoryForm').addEventListener('submit', function (e) {
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

                        Swal.fire({
                            title: 'Berhasil!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#10b981',
                            timer: 2000,
                            timerProgressBar: true
                        });
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorDiv.textContent = 'Terjadi kesalahan saat menambah kategori';
                    errorDiv.classList.remove('hidden');
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitText.classList.remove('hidden');
                    loadingText.classList.add('hidden');
                });
        });

        // Close modal on outside click
        document.getElementById('categoryModal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeCategoryModal();
            }
        });

        let variantIndex = {{ $product->variants->count() }};

        document.getElementById('add-variant').addEventListener('click', function() {
            const container = document.getElementById('variants-container');
            const variantHtml = `
                <div class="variant-item border border-gray-200 rounded-xl p-6 mb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-md font-semibold text-gray-800">Varian ${variantIndex + 1}</h4>
                        <button type="button" onclick="removeVariant(this)" class="text-red-600 hover:text-red-800 p-2">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Ukuran</label>
                            <input type="text" name="variants[${variantIndex}][size]"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Warna</label>
                            <input type="text" name="variants[${variantIndex}][color]"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Tambahan</label>
                            <input type="number" name="variants[${variantIndex}][additional_price]" value="0" min="0" step="0.01"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Stok</label>
                            <input type="number" name="variants[${variantIndex}][stock]" value="0" min="0"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center">
                                <input type="checkbox" name="variants[${variantIndex}][is_active]" value="1" checked
                                       class="form-checkbox h-5 w-5 text-blue-600 rounded">
                                <span class="ml-2 text-sm font-medium text-gray-700">Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', variantHtml);
            variantIndex++;
        });

        function removeVariant(button) {
            button.closest('.variant-item').remove();
        }
    </script>
@endpush