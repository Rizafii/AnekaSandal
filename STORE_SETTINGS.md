# Store Settings - Pengaturan Toko

## Overview

Fitur Store Settings memungkinkan admin untuk mengelola pengaturan dasar toko melalui panel admin, termasuk:

-   Informasi toko (nama, alamat, telepon, email)
-   Pengaturan pengiriman (lokasi asal pengiriman)
-   Pengaturan pembayaran (rekening bank)

## Features

### 1. Manajemen Informasi Toko

-   **Nama Toko**: Nama yang ditampilkan di aplikasi
-   **Alamat Toko**: Alamat lengkap toko
-   **Telepon**: Nomor telepon kontak toko
-   **Email**: Email kontak toko

### 2. Pengaturan Origin Pengiriman

-   **Pemilihan Lokasi**: Provinsi → Kota → Kecamatan
-   **Integrasi RajaOngkir**: Menggunakan API RajaOngkir untuk data lokasi
-   **Dynamic Origin**: Origin pengiriman tidak lagi hardcode, dapat diubah melalui admin panel
-   **Berat Default**: Pengaturan berat default produk untuk kalkulasi ongkir

### 3. Pengaturan Pembayaran

-   **Nama Bank**: Bank tujuan transfer
-   **Nomor Rekening**: Nomor rekening tujuan
-   **Nama Pemilik**: Nama pemilik rekening

## Technical Implementation

### 1. Database Schema

```sql
-- Tabel store_settings
CREATE TABLE store_settings (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    key VARCHAR(255) UNIQUE NOT NULL,
    value TEXT NULL,
    type VARCHAR(50) DEFAULT 'string',
    description TEXT NULL,
    `group` VARCHAR(50) DEFAULT 'general',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### 2. Model StoreSetting

-   **Static Methods**: `get()`, `set()`, `getAllGrouped()`
-   **Helper Methods**: `getShippingOrigin()`, `getStoreName()`, etc.
-   **Type Conversion**: Automatic conversion based on field type

### 3. Controller StoreSettingController

-   **Index**: Menampilkan form pengaturan
-   **Update**: Menyimpan perubahan pengaturan
-   **API Endpoints**: Provinces, Cities, Districts untuk dropdown

### 4. Integration Points

#### Shipping Service Update

```php
// Sebelum (hardcode)
const origin = '1391';

// Sesudah (dynamic)
const origin = '{{ App\Models\StoreSetting::getShippingOrigin() }}';
```

#### Service Classes

-   `ShippingService::getDefaultOriginCity()` - Menggunakan setting database
-   `ShippingService::calculateProductWeight()` - Menggunakan default weight dari setting

## Usage

### Admin Panel Access

1. Login sebagai admin
2. Navigasi ke "Pengaturan Toko" di sidebar
3. Update pengaturan sesuai kebutuhan
4. Klik "Simpan Perubahan"

### Setting Origin Pengiriman

1. Pilih Provinsi dari dropdown
2. Pilih Kota/Kabupaten (auto-load berdasarkan provinsi)
3. Pilih Kecamatan (auto-load berdasarkan kota)
4. Simpan perubahan

### Programmatic Access

```php
// Mendapatkan setting
$storeName = StoreSetting::get('store_name', 'Default Store');
$origin = StoreSetting::getShippingOrigin();

// Mengatur setting
StoreSetting::set('store_name', 'New Store Name');
```

## Routes

-   `GET /admin/store-settings` - Form pengaturan
-   `PUT /admin/store-settings` - Update pengaturan
-   `GET /admin/store-settings/provinces` - Data provinsi
-   `GET /admin/store-settings/cities/{provinceId}` - Data kota
-   `GET /admin/store-settings/districts/{cityId}` - Data kecamatan

## Default Settings

Seeder otomatis mengisi setting default:

-   Store name: "Aneka Sandal"
-   Shipping origin: Jakarta Barat (ID: 1391)
-   Default product weight: 300 gram
-   Bank: BCA

## Benefits

1. **No More Hardcode**: Origin pengiriman dapat diubah tanpa edit code
2. **User Friendly**: Interface admin yang mudah digunakan
3. **Data Consistency**: Semua setting terpusat di satu tempat
4. **Flexibility**: Mudah menambah setting baru
5. **Integration Ready**: RajaOngkir API terintegrasi untuk data lokasi

## Migration & Deployment

```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder untuk data default
php artisan db:seed --class=StoreSettingSeeder

# Clear cache jika diperlukan
php artisan view:clear
php artisan config:clear
```
