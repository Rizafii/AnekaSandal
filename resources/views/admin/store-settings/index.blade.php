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

                <!-- Shipping Settings -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200/60">
                        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-shipping-fast mr-3 text-gray-600"></i>
                            Pengaturan Pengiriman
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Lokasi asal pengiriman untuk perhitungan ongkos kirim</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Current Shipping Origin Display -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <h3 class="text-sm font-semibold text-blue-900 mb-3 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                Lokasi Asal Pengiriman Saat Ini:
                            </h3>
                            <div class="text-sm text-blue-800 space-y-1">
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
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>

                            <div>
                                <label for="city_select"
                                    class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten</label>
                                <select id="city_select"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    disabled>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                </select>
                            </div>

                            <div>
                                <label for="district_select"
                                    class="block text-sm font-medium text-gray-700 mb-2">Kecamatan</label>
                                <select id="district_select" name="shipping_origin_district_id"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('shipping_origin_district_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-500 mt-0.5 mr-3"></i>
                                <div>
                                    <p class="text-sm text-yellow-800 font-medium">Catatan Penting:</p>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        Jika tidak ada perubahan lokasi pengiriman, biarkan dropdown kosong.
                                        Hanya ubah jika Anda ingin mengganti lokasi asal pengiriman.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="default_product_weight" class="block text-sm font-medium text-gray-700 mb-2">
                                Berat Default Produk (gram)
                            </label>
                            <input type="number" id="default_product_weight" name="default_product_weight"
                                value="{{ old('default_product_weight', $settings['shipping']['default_product_weight']['value'] ?? '300') }}"
                                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                min="1" required>
                            <p class="text-sm text-gray-500 mt-2">Berat yang akan digunakan jika produk tidak memiliki berat
                                spesifik</p>
                            @error('default_product_weight')
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