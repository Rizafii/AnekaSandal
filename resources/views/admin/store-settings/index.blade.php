@extends('layouts.admin')

@section('title', 'Pengaturan Toko')

@section('content')
    <div class="bg-white">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Pengaturan Toko</h1>
                <p class="mt-2 text-sm text-gray-600">Kelola informasi dasar toko, pengaturan pengiriman, dan pembayaran</p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.store-settings.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- Store Information -->
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Informasi Toko
                        </h2>
                    </div>
                    <div class="px-6 py-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="store_name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Toko</label>
                                <input type="text" id="store_name" name="store_name"
                                    value="{{ old('store_name', $settings['store_info']['store_name']['value'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            @error('store_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="store_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat
                                Toko</label>
                            <textarea id="store_address" name="store_address" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                placeholder="Masukkan alamat lengkap toko"
                                required>{{ old('store_address', $settings['store_info']['store_address']['value'] ?? '') }}</textarea>
                            @error('store_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Shipping Settings -->
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2v0a2 2 0 01-2-2v-2a2 2 0 00-2-2H8z" />
                            </svg>
                            Pengaturan Pengiriman
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Lokasi asal pengiriman untuk perhitungan ongkos kirim</p>
                    </div>
                    <div class="px-6 py-6 space-y-6">
                        <!-- Current Shipping Origin Display -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-blue-900 mb-2">Lokasi Asal Pengiriman Saat Ini:</h3>
                            <div class="text-sm text-blue-800">
                                <p><span class="font-medium">Provinsi:</span>
                                    {{ $settings['shipping']['shipping_origin_province_name']['value'] ?? 'Belum diset' }}
                                </p>
                                <p><span class="font-medium">Kota:</span>
                                    {{ $settings['shipping']['shipping_origin_city_name']['value'] ?? 'Belum diset' }}</p>
                                <p><span class="font-medium">Kecamatan:</span>
                                    {{ $settings['shipping']['shipping_origin_district_name']['value'] ?? 'Belum diset' }}
                                </p>
                            </div>
                        </div>

                        <!-- Location Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="province_select"
                                    class="block text-sm font-medium text-gray-700 mb-2">Provinsi</label>
                                <select id="province_select"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>

                            <div>
                                <label for="city_select"
                                    class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten</label>
                                <select id="city_select"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    disabled>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                            </div>

                            <div>
                                <label for="district_select"
                                    class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                                <select id="district_select" name="shipping_origin_district_id"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                    disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('shipping_origin_district_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-sm text-yellow-800">
                                <strong>Catatan:</strong> Jika tidak ada perubahan lokasi pengiriman, biarkan dropdown
                                kosong.
                                Hanya ubah jika Anda ingin mengganti lokasi asal pengiriman.
                            </p>
                        </div>

                        <div>
                            <label for="default_product_weight" class="block text-sm font-medium text-gray-700 mb-2">Berat
                                Default Produk (gram)</label>
                            <input type="number" id="default_product_weight" name="default_product_weight"
                                value="{{ old('default_product_weight', $settings['shipping']['default_product_weight']['value'] ?? '300') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                min="1" required>
                            <p class="text-sm text-gray-500 mt-1">Berat yang akan digunakan jika produk tidak memiliki berat
                                spesifik</p>
                            @error('default_product_weight')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 rounded-xl">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Pengaturan Pembayaran
                        </h2>
                    </div>
                    <div class="px-6 py-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Bank</label>
                                <input type="text" id="bank_name" name="bank_name"
                                    value="{{ old('bank_name', $settings['payment']['bank_name']['value'] ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                required>
                            @error('bank_account_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const provinceSelect = document.getElementById('province_select');
                const citySelect = document.getElementById('city_select');
                const districtSelect = document.getElementById('district_select');

                // Get current values from server-side
                const currentProvinceId = '{{ $settings["shipping"]["shipping_origin_province_id"]["value"] ?? "" }}';
                const currentCityId = '{{ $settings["shipping"]["shipping_origin_city_id"]["value"] ?? "" }}';
                const currentDistrictId = '{{ old("shipping_origin_district_id", $settings["shipping"]["shipping_origin_district_id"]["value"] ?? "") }}';

                // Load provinces on page load
                loadProvinces();

                // Province change handler
                provinceSelect.addEventListener('change', function () {
                    const provinceId = this.value;
                    if (provinceId) {
                        loadCities(provinceId);
                    } else {
                        resetCities();
                        resetDistricts();
                    }
                });

                // City change handler
                citySelect.addEventListener('change', function () {
                    const cityId = this.value;
                    if (cityId) {
                        loadDistricts(cityId);
                    } else {
                        resetDistricts();
                    }
                });

                function loadProvinces() {
                    fetch('/admin/store-settings/provinces')
                        .then(response => response.json())
                        .then(data => {
                            provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                            if (data.success) {
                                data.data.forEach(province => {
                                    const selected = province.id === currentProvinceId ? 'selected' : '';
                                    provinceSelect.innerHTML += `<option value="${province.id}" ${selected}>${province.name}</option>`;
                                });

                                // If there's a current province, load cities
                                if (currentProvinceId) {
                                    loadCities(currentProvinceId);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error loading provinces:', error);
                            alert('Gagal memuat daftar provinsi');
                        });
                }

                function loadCities(provinceId) {
                    citySelect.disabled = true;
                    citySelect.innerHTML = '<option value="">Memuat...</option>';
                    resetDistricts();

                    fetch(`/admin/store-settings/cities/${provinceId}`)
                        .then(response => response.json())
                        .then(data => {
                            citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                            if (data.success) {
                                data.data.forEach(city => {
                                    const selected = city.id === currentCityId ? 'selected' : '';
                                    citySelect.innerHTML += `<option value="${city.id}" ${selected}>${city.type} ${city.name}</option>`;
                                });
                                citySelect.disabled = false;

                                // If there's a current city, load districts
                                if (currentCityId) {
                                    loadDistricts(currentCityId);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error loading cities:', error);
                            citySelect.innerHTML = '<option value="">Gagal memuat kota</option>';
                            alert('Gagal memuat daftar kota');
                        });
                }

                function loadDistricts(cityId) {
                    districtSelect.disabled = true;
                    districtSelect.innerHTML = '<option value="">Memuat...</option>';

                    fetch(`/admin/store-settings/districts/${cityId}`)
                        .then(response => response.json())
                        .then(data => {
                            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                            if (data.success) {
                                data.data.forEach(district => {
                                    const selected = district.id === currentDistrictId ? 'selected' : '';
                                    districtSelect.innerHTML += `<option value="${district.id}" ${selected}>${district.name}</option>`;
                                });
                                districtSelect.disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error loading districts:', error);
                            districtSelect.innerHTML = '<option value="">Gagal memuat kecamatan</option>';
                            alert('Gagal memuat daftar kecamatan');
                        });
                }

                function resetCities() {
                    citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
                    citySelect.disabled = true;
                }

                function resetDistricts() {
                    districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    districtSelect.disabled = true;
                }
            });
        </script>
    @endpush
@endsection