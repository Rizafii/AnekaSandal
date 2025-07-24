<div>
    @if($order->payment_status === 'menunggu_konfirmasi')
        <button wire:click="openModal" type="button"
            class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
            ❌ Tolak Pembayaran
        </button>

        <!-- Rejection Modal -->
        @if($showModal)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto h-full w-full z-50"
                wire:click.self="closeModal">
                <div class="relative top-20 mx-auto p-5 border max-w-lg shadow-lg rounded-md bg-white">
                    <div class="text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Pembayaran</h3>

                        <div class="mb-4">
                            <label for="rejectionReason" class="block text-sm font-medium text-gray-700 mb-2 text-left">
                                Alasan Penolakan
                            </label>
                            <textarea wire:model="rejectionReason" id="rejectionReason" rows="4"
                                placeholder="Jelaskan alasan mengapa pembayaran ditolak..."
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2">
                                    </textarea>
                            @error('rejectionReason')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-center space-x-3">
                            <button wire:click="rejectPayment" wire:loading.attr="disabled"
                                class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 disabled:opacity-50">
                                <span wire:loading.remove wire:target="rejectPayment">Tolak Pembayaran</span>
                                <span wire:loading wire:target="rejectPayment">Memproses...</span>
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
