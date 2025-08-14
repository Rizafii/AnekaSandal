<section class="px-3 pt-3 bg-secondary">
    <div class="mx-auto">
        <div class="title grid grid-cols-1 w-full items-center justify-center p-5 rounded-2xl bg-primary text-center">
            <h2 class="text-4xl text-white">Produk Kami</h2>
        </div>

        <!-- Products Slider -->
        <div class="relative mb-12">
            <!-- Navigation Buttons -->
            <button id="prevBtn"
                class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-white/80 hover:bg-white p-3 rounded-full shadow-lg transition-all duration-300">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>

            <button id="nextBtn"
                class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-white/80 hover:bg-white p-3 rounded-full shadow-lg transition-all duration-300">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Products Container -->
            <div id="productSlider" class="flex snap-x overflow-x-auto scrollbar-hide space-x-3 pt-3"
                style="scroll-behavior: smooth;">
                @forelse($products as $product)
                    @php
                        $firstImage = optional($product->images->first());
                        $img = $firstImage->url
                            ?? $firstImage->path
                            ?? $firstImage->image
                            ?? 'https://via.placeholder.com/600x600/f3f4f6/6b7280?text=' . urlencode($product->name);
                    @endphp
                    <div class="flex-none w-[450px] h-[600px] snap-start group relative rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden bg-cover bg-center"
                        style="background-image: url('{{ $img }}');">
                        <!-- Category Badge -->
                        <span
                            class="absolute top-3 left-3 text-sm text-primary bg-white py-2 px-3 rounded-lg font-medium z-10">
                            {{ optional($product->category)->name ?? 'Tanpa Kategori' }}
                        </span>

                        <!-- Product Info - Positioned at bottom -->
                        <div class="absolute bottom-0 left-0 right-0 m-3 bg-white rounded-xl p-4 z-10">
                            <!-- Product Name -->
                            <h3
                                class="text-xl font-bold mb-3 text-gray-900 group-hover:text-primary transition-colors duration-300">
                                {{ $product->name }}
                            </h3>

                            <!-- Price -->
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-primary">
                                    Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="cta w-full flex gap-3">
                                <a href="{{ route('product.detail', $product->id) }}"
                                    class="w-full bg-primary  text-white font-semibold py-3 px-6 rounded-xl flex items-center justify-center text-center">
                                    <div class="flex items-center justify-center space-x-2 ">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        <span>Lihat Detail</span>
                                    </div>
                                </a>
                            </div>
                            <!-- Add to Cart Button -->

                        </div>
                    </div>
                @empty
                    @for ($j = 1; $j <= 4; $j++)
                        <div
                            class="flex-none w-80 group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
                            <!-- Fallback content if no products -->
                            <div class="relative overflow-hidden">
                                <img src="https://via.placeholder.com/300x300/f3f4f6/6b7280?text=Sandal+{{ $j }}"
                                    alt="Sandal {{ $j }}"
                                    class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-6">
                                <span class="text-sm text-primary font-medium uppercase tracking-wide">
                                    {{ ['Sandal Wanita', 'Sandal Pria', 'Sandal Anak'][($j - 1) % 3] }}
                                </span>
                                <h3 class="text-xl font-bold text-gray-900 mt-2 mb-3">
                                    Sandal Premium Model {{ $j }}
                                </h3>
                                <p class="text-gray-600 text-sm mb-4">
                                    Produk akan segera tersedia
                                </p>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>
</section>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.getElementById('productSlider');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const loadMoreBtn = document.getElementById('loadMoreBtn');

        let currentOffset = 0;

        // Auto scroll interval
        let autoScrollInterval = setInterval(() => {
            scrollNext();
        }, 5000);

        function scrollNext() {
            const cardWidth = 320 + 24; // card width + gap
            const maxScroll = slider.scrollWidth - slider.clientWidth;

            if (currentOffset >= maxScroll) {
                currentOffset = 0;
            } else {
                currentOffset += cardWidth;
            }

            slider.scrollTo({ left: currentOffset, behavior: 'smooth' });
        }

        function scrollPrev() {
            const cardWidth = 320 + 24;

            if (currentOffset <= 0) {
                currentOffset = slider.scrollWidth - slider.clientWidth;
            } else {
                currentOffset -= cardWidth;
            }

            slider.scrollTo({ left: currentOffset, behavior: 'smooth' });
        }

        nextBtn.addEventListener('click', () => {
            clearInterval(autoScrollInterval);
            scrollNext();
            autoScrollInterval = setInterval(scrollNext, 5000);
        });

        prevBtn.addEventListener('click', () => {
            clearInterval(autoScrollInterval);
            scrollPrev();
            autoScrollInterval = setInterval(scrollNext, 5000);
        });

        // Load more products
        loadMoreBtn.addEventListener('click', function () {
            this.innerHTML = '<span class="text-lg">Memuat...</span>';

            fetch('{{ route("products") }}')
                .then(response => response.text())
                .then(data => {
                    window.location.href = '{{ route("products") }}';
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.innerHTML = '<span class="text-lg">Muat Lebih Banyak</span>';
                });
        });

        // Pause auto-scroll on hover
        slider.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
        slider.addEventListener('mouseleave', () => {
            autoScrollInterval = setInterval(scrollNext, 5000);
        });
    });
</script>