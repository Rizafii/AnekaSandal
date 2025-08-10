<div class="px-3 py-10 mt-16 bg-secondary">
    <div class="w-full mx-auto space-y-8">
        <!-- Breadcrumb -->
        <nav class="text-sm" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2 text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-primary transition-colors">Beranda</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-700 font-medium">Kategori</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="text-center space-y-4">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary to-primary/80 rounded-2xl mb-6 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 7a2 2 0 012-2h10a2 2 0 012 2v2M5 11h14"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-gray-800">Kategori Sandal</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan berbagai koleksi sandal sesuai dengan kategori yang Anda inginkan</p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-md mx-auto">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input 
                    type="text" 
                    wire:model.live="search"
                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" 
                    placeholder="Cari kategori..."
                >
                @if($search)
                    <button 
                        wire:click="$set('search', '')"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($categories as $category)
                <div 
                    wire:click="selectCategory({{ $category->id }})"
                    class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2 border border-gray-100/50 overflow-hidden"
                >
                    <!-- Category Image -->
                    <div class="h-48 bg-gradient-to-br from-primary/10 to-primary/5 relative overflow-hidden">
                        @if($category->image)
                            <img 
                                src="{{ $category->image }}" 
                                alt="{{ $category->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            >
                        @else
                            <div class="flex items-center justify-center h-full">
                                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 7a2 2 0 012-2h10a2 2 0 012 2v2M5 11h14"></path>
                                    </svg>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/10 transition-all duration-300"></div>
                        
                        <!-- Arrow Icon -->
                        <div class="absolute top-4 right-4 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-2 group-hover:translate-x-0">
                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Category Info -->
                    <div class="p-6 space-y-3">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors">
                                {{ $category->name }}
                            </h3>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-primary/10 text-primary">
                                {{ $category->products_count ?? 0 }} Item
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-2">
                            {{ $category->description ?: 'Koleksi sandal berkualitas tinggi untuk berbagai kebutuhan dan aktivitas Anda' }}
                        </p>
                        
                        <div class="flex items-center justify-between pt-2">
                            <span class="inline-flex items-center text-xs font-medium text-gray-500">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ $category->slug }}
                            </span>
                            
                            <div class="flex items-center text-primary font-semibold text-sm opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-2 group-hover:translate-x-0">
                                Lihat Produk
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-16">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 7a2 2 0 012-2h10a2 2 0 012 2v2M5 11h14"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            @if($search)
                                Kategori tidak ditemukan
                            @else
                                Belum ada kategori
                            @endif
                        </h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            @if($search)
                                Tidak ditemukan kategori dengan kata kunci "{{ $search }}". Coba gunakan kata kunci lain.
                            @else
                                Belum ada kategori yang tersedia saat ini. Silakan cek kembali nanti.
                            @endif
                        </p>
                        @if($search)
                            <button 
                                wire:click="$set('search', '')"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-xl font-semibold transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Hapus Filter
                            </button>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Selected Category Modal -->
        @if($selectedCategory)
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4" wire:click="clearSelection">
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-auto border border-gray-100" wire:click.stop>
                    <!-- Close Button -->
                    <button 
                        wire:click="clearSelection"
                        class="absolute top-4 right-4 w-8 h-8 bg-gray-100 hover:bg-gray-200 rounded-full flex items-center justify-center text-gray-600 hover:text-gray-800 transition-colors z-10"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>

                    <!-- Category Image -->
                    <div class="h-48 bg-gradient-to-br from-primary/10 to-primary/5 rounded-t-2xl overflow-hidden">
                        @if($selectedCategory->image)
                            <img 
                                src="{{$selectedCategory->image }}" 
                                alt="{{ $selectedCategory->name }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <div class="flex items-center justify-center h-full">
                                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 7a2 2 0 012-2h10a2 2 0 012 2v2M5 11h14"></path>
                                    </svg>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Category Details -->
                    <div class="p-8 space-y-6">
                        <div class="text-center space-y-3">
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ $selectedCategory->name }}
                            </h3>
                            
                            <div class="flex items-center justify-center gap-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-primary/10 text-primary">
                                    {{ $selectedCategory->products_count ?? 0 }} Produk
                                </span>
                                <span class="inline-flex items-center text-sm font-medium text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    {{ $selectedCategory->slug }}
                                </span>
                            </div>
                            
                            <p class="text-gray-600 leading-relaxed">
                                {{ $selectedCategory->description ?: 'Koleksi sandal berkualitas tinggi untuk berbagai kebutuhan dan aktivitas Anda.' }}
                            </p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <button 
                                wire:click="clearSelection"
                                class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-semibold transition-colors"
                            >
                                Tutup
                            </button>
                            <a 
                                href="/products?category={{ $selectedCategory->slug }}"
                                class="flex-1 px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-xl font-semibold transition-colors text-center inline-flex items-center justify-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Produk
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
