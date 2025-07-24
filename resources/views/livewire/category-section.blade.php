<div class="py-16 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Kategori Produk
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                Temukan berbagai koleksi sandal berkualitas dalam kategori yang sesuai dengan kebutuhan Anda
            </p>
        </div>

        <!-- Categories Horizontal Scroll -->
        <div class="relative">
            <!-- Scroll Buttons -->
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10">
                <button wire:click="scrollLeft"
                    class="bg-white dark:bg-gray-800 shadow-lg rounded-full p-2 hover:shadow-xl transition-all duration-300 {{ !$canScrollLeft ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ !$canScrollLeft ? 'disabled' : '' }}>
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10">
                <button wire:click="scrollRight"
                    class="bg-white dark:bg-gray-800 shadow-lg rounded-full p-2 hover:shadow-xl transition-all duration-300 {{ !$canScrollRight ? 'opacity-50 cursor-not-allowed' : '' }}"
                    {{ !$canScrollRight ? 'disabled' : '' }}>
                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Categories Container -->
            <div class="flex gap-4 overflow-hidden pb-4" style="scroll-behavior: smooth;">
                @foreach($visibleCategories as $category)
                    <div class="flex-none w-64 group cursor-pointer">
                        <div
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:scale-105 h-32">
                            <div class="flex h-full">
                                <!-- Category Content -->
                                <div class="flex-1 p-4 flex flex-col justify-between">
                                    <!-- Category Name -->
                                    <h3
                                        class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 leading-tight">
                                        {{ $category['name'] }}
                                    </h3>

                                    <!-- Description -->
                                    @if($category['description'])
                                        <p class="text-gray-600 dark:text-gray-300 text-xs leading-relaxed mb-2 line-clamp-2">
                                            {{ Str::limit($category['description'], 60) }}
                                        </p>
                                    @endif

                                    <!-- Action Button -->
                                    <button
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-xs font-medium transition-colors duration-300 self-start">
                                        Lihat Produk
                                    </button>
                                </div>

                                <!-- Category Image -->
                                <div class="w-20 relative overflow-hidden">
                                    @if($category['image'])
                                        <img src="{{ asset('storage/' . $category['image']) }}" alt="{{ $category['name'] }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div
                                            class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-600 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white dark:text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Product Count Badge -->
                                    <div class="absolute top-1 right-1">
                                        <span
                                            class="bg-white/90 dark:bg-gray-800/90 text-gray-800 dark:text-white px-1.5 py-0.5 rounded-full text-xs font-medium shadow-sm">
                                            {{ $category['products_count'] ?? 0 }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Empty State -->
        @if(count($categories) === 0)
            <div class="text-center py-12">
                <div
                    class="w-24 h-24 mx-auto mb-6 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Belum ada kategori</h3>
                <p class="text-gray-500 dark:text-gray-400">Kategori produk akan ditampilkan di sini</p>
            </div>
        @endif
    </div>
</div>

<!-- CSS for styling -->
@push('styles')
    <style>
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
@endpush
