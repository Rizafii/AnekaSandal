<div>
    <!-- Cancel Order Button -->
    @if($order->status === 'menunggu_pembayaran')
        <div class="mb-4">
            <button type="button" onclick="openCancelModal{{ $order->id }}()"
                class="bg-red-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-red-700 transition-colors w-full flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Batalkan Pesanan
            </button>
        </div>

        <!-- Cancel Modal -->
        <div id="cancelModal{{ $order->id }}"
            class="hidden fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4"
            onclick="if(event.target === this) closeCancelModal{{ $order->id }}()">
            <div class="relative p-6 w-full max-w-md shadow-2xl rounded-2xl bg-white transform transition-all"
                onclick="event.stopPropagation()">
                <div class="text-center">
                    <!-- Close Button -->
                    <button type="button" onclick="closeCancelModal{{ $order->id }}()"
                        class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>

                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                        <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-4">Batalkan Pesanan?</h3>

                    <div class="mb-6">
                        <p class="text-sm text-gray-600 mb-3">Apakah Anda yakin ingin membatalkan pesanan</p>
                    </div>

                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                        @csrf
                        <div class="flex gap-3">
                            <button type="button" onclick="closeCancelModal{{ $order->id }}()"
                                class="flex-1 px-4 py-2.5 bg-gray-500 text-white text-sm font-semibold rounded-lg hover:bg-gray-600 transition-colors">
                                Tidak
                            </button>
                            <button type="submit"
                                class="flex-1 px-4 py-2.5 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                Ya, Batalkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openCancelModal{{ $order->id }}() {
                document.getElementById('cancelModal{{ $order->id }}').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeCancelModal{{ $order->id }}() {
                document.getElementById('cancelModal{{ $order->id }}').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        </script>
    @endif

    <!-- Confirm Receipt Button -->
    @if($order->status === 'sedang_dikirim' && $order->shipped_at)
        <button wire:click="openModal"
            class="bg-purple-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-purple-700 w-full flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Konfirmasi Terima Barang
        </button>

        <!-- Confirmation Modal -->
        @if($showModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
                wire:click.self="closeModal">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Konfirmasi Penerimaan Barang</h3>

                        <div class="mb-4">
                            <label for="deliveryProof" class="block text-sm font-medium text-gray-700 mb-2 text-left">
                                Upload Foto Bukti Penerimaan (Opsional)
                            </label>
                            <input type="file" wire:model="deliveryProof" id="deliveryProof" accept="image/*"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
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
                                class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md hover:bg-green-700 disabled:opacity-50">
                                <span wire:loading.remove wire:target="confirmReceived">Konfirmasi Terima</span>
                                <span wire:loading wire:target="confirmReceived">Memproses...</span>
                            </button>
                            <button wire:click="closeModal"
                                class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md hover:bg-gray-600">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>