<div>
    @if($showResults && count($results) > 0)
        <div class="bg-white border border-gray-200 rounded-lg shadow-lg mt-2 max-w-md">
            <div class="p-2">
                <h3 class="text-sm font-semibold text-gray-700 mb-2">Hasil Pencarian untuk "{{ $search }}"</h3>
                <ul class="space-y-1">
                    @foreach($results as $product)
                        <li>
                            <button wire:click="selectProduct({{ $product->id }})"
                                class="w-full text-left p-2 hover:bg-gray-100 rounded flex items-center space-x-3">
                                @if($product->images->first())
                                    <img src="{{ $product->images->first()->image_url }}" alt="{{ $product->name }}"
                                        class="w-10 h-10 object-cover rounded">
                                @else
                                    <div class="w-10 h-10 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                </div>
                            </button>
                        </li>
                    @endforeach
                </ul>
                @if(count($results) >= 5)
                    <div class="pt-2 border-t border-gray-100">
                        <a href="{{ route('search', ['q' => $search]) }}"
                            class="block text-center text-sm text-blue-600 hover:text-blue-800">
                            Lihat semua hasil ({{ count($results) }}+)
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @elseif($showResults && $search)
        <div class="bg-white border border-gray-200 rounded-lg shadow-lg mt-2 max-w-md">
            <div class="p-4 text-center">
                <p class="text-sm text-gray-500">Tidak ada produk ditemukan untuk "{{ $search }}"</p>
            </div>
        </div>
    @endif
</div>
