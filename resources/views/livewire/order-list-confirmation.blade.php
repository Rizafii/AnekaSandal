<div>
    <!-- Cancel Order Button -->
    @if($order->status === 'menunggu_pembayaran')
        <button type="button" onclick="openCancelModal{{ $order->id }}()"
            class="bg-red-600 text-white px-4 py-3 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Batalkan
        </button>
    @endif

    <!-- Confirm Receipt Button -->
    @if($order->status === 'sedang_dikirim' && $order->shipped_at)
        <button wire:click="openModal"
            class="bg-green-600 text-white px-4 py-3 rounded-lg text-sm font-medium hover:bg-green-700 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Konfirmasi Terima
        </button>

        <!-- Confirmation Modal -->
        @if($showModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-50"
                wire:click.self="closeModal">
                <div class="relative top-20 mx-auto p-5 border max-w-md shadow-lg rounded-md bg-white">
                    <div class="text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Penerimaan</h3>

                        <div class="mb-4">
                            <label for="deliveryProof" class="block text-sm font-medium text-gray-700 mb-2 text-left">
                                Upload Foto Bukti Penerimaan (Opsional)
                            </label>
                            <input type="file" wire:model="deliveryProof" id="deliveryProof" accept="image/*"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                            <p class="text-xs text-gray-500 mt-1 text-left">
                                Upload foto Anda dengan barang yang diterima (Opsional)
                            </p>
                            @error('deliveryProof')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div wire:loading wire:target="deliveryProof" class="mb-4">
                            <p class="text-blue-500 text-sm">Mengupload gambar...</p>
                        </div>

                        @if ($deliveryProof)
                            <div class="mb-4">
                                <img src="{{ $deliveryProof->temporaryUrl() }}" class="w-32 h-32 object-cover mx-auto rounded">
                            </div>
                        @endif

                        <div class="flex justify-center space-x-3">
                            <button wire:click="confirmReceived" wire:loading.attr="disabled"
                                class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 disabled:opacity-50">
                                <span wire:loading.remove wire:target="confirmReceived">Konfirmasi</span>
                                <span wire:loading wire:target="confirmReceived">Memproses...</span>
                            </button>
                            <button wire:click="closeModal"
                                class="px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-600">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>