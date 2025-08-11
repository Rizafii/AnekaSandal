@extends('layouts.admin')

@section('title', 'Pengaturan Toko')

@section('content')
    <div class="min-h-screen bg-gray-50/50">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mx-6 lg:mx-8 mt-6">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-emerald-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-6 lg:mx-8 mt-6">
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-times-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="bg-white border-b border-gray-200/60 shadow-sm">
            <div class="px-6 lg:px-8">
                <div class="py-8">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">Pengaturan Toko</h1>
                        <p class="mt-2 text-sm text-gray-600">Kelola informasi dasar toko, pengaturan pengiriman, dan
                            pembayaran</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 lg:px-8 py-8">
            <form action="{{ route('admin.store-settings.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Store Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200/60">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-store mr-3 text-gray-600"></i>
                            Informasi Toko
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Informasi dasar tentang toko Anda</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="store_name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Toko</label>
                                <input type="text" id="store_name" name="store_name"
                                    value="{{ old('store_name', $settings['store_info']['store_name']['value'] ?? '') }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    required>
                                @error('store_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="store_phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                    Telepon</label>
                                <input type="text" id="store_phone" name="store_phone"
                                    value="{{ old('store_phone', $settings['store_info']['store_phone']['value'] ?? '') }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    required>
                                @error('store_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="store_email" class="block text-sm font-medium text-gray-700 mb-2">Email Toko</label>
                            <input type="email" id="store_email" name="store_email"
                                value="{{ old('store_email', $settings['store_info']['store_email']['value'] ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                required>
                            @error('store_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="store_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat
                                Toko</label>
                            <textarea id="store_address" name="store_address" rows="3"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"
                                placeholder="Masukkan alamat lengkap toko"
                                required>{{ old('store_address', $settings['store_info']['store_address']['value'] ?? '') }}</textarea>
                            @error('store_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200/60">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-credit-card mr-3 text-gray-600"></i>
                            Pengaturan Pembayaran
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Informasi rekening bank untuk pembayaran customer</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Bank</label>
                                <input type="text" id="bank_name" name="bank_name"
                                    value="{{ old('bank_name', $settings['payment']['bank_name']['value'] ?? '') }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    required>
                                @error('bank_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="bank_account_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor
                                    Rekening</label>
                                <input type="text" id="bank_account_number" name="bank_account_number"
                                    value="{{ old('bank_account_number', $settings['payment']['bank_account_number']['value'] ?? '') }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    required>
                                @error('bank_account_number')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="bank_account_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik
                                Rekening</label>
                            <input type="text" id="bank_account_name" name="bank_account_name"
                                value="{{ old('bank_account_name', $settings['payment']['bank_account_name']['value'] ?? '') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                required>
                            @error('bank_account_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-sm">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    @endpush
@endsection