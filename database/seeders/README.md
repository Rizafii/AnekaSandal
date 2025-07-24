# Database Seeders untuk AnekaSandal

Seeder ini berisi data dummy untuk semua tabel dalam aplikasi AnekaSandal.

## Daftar Seeder

1. **UserSeeder** - Data user (admin dan customer)
2. **CategorySeeder** - Data kategori produk sandal
3. **ProductSeeder** - Data produk (basic structure)
4. **ProductImageSeeder** - Data gambar produk
5. **ProductVariantSeeder** - Data varian produk (ukuran, warna, stok)
6. **CartSeeder** - Data keranjang belanja customer
7. **OrderSeeder** - Data pesanan customer
8. **OrderItemSeeder** - Data item dalam pesanan
9. **OrderStatusLogSeeder** - Data log perubahan status pesanan

## Cara Menjalankan Seeder

```bash
# Menjalankan semua seeder
php artisan db:seed

# Atau menjalankan seeder tertentu
php artisan db:seed --class=CategorySeeder
```

## Data yang Dibuat

### Users

-   1 admin (username: admin, email: admin@anekasandal.com)
-   4 customer dengan data lengkap

### Categories

-   5 kategori: Sandal Pria, Sandal Wanita, Sandal Anak, Sandal Jepit, Sandal Gunung

### Products

-   8 produk sandal dengan ID 1-8
-   Field: id, category_id, name, slug, description, price, weight, is_active, featured
-   Stock dikelola melalui product_variants, tidak ada field stock di tabel products

### Product Images

-   Setiap produk memiliki minimal 1 gambar utama
-   Beberapa produk memiliki gambar tambahan

### Product Variants

-   Setiap produk memiliki berbagai ukuran dan warna
-   Stok bervariasi untuk setiap varian
-   Additional price untuk varian tertentu

### Orders

-   5 pesanan dengan status berbeda:
    -   1 selesai
    -   1 sedang dikirim
    -   2 menunggu pembayaran
    -   1 dibatalkan

### Order Status Logs

-   History perubahan status untuk setiap pesanan

## Catatan Penting

1. Password default untuk semua user adalah: `password`
2. Seeder dijalankan dalam urutan yang benar sesuai foreign key constraints
3. Data dibuat dengan timestamp yang realistis
4. File gambar yang direferensikan perlu disiapkan di folder storage yang sesuai
5. Product stock tidak ada di tabel products - semua stok dikelola melalui product_variants
6. Total stok produk = jumlah stok dari semua varian aktif

## Struktur Data

### User Roles

-   `admin`: Dapat mengelola pesanan dan produk
-   `customer`: Dapat berbelanja dan membuat pesanan

### Order Status

-   `menunggu_pembayaran`: Pesanan baru, belum bayar
-   `sedang_dikirm`: Sudah bayar, barang dikirim
-   `selesai`: Barang sudah sampai
-   `dibatalkan`: Pesanan dibatalkan

### Payment Status

-   `belum_bayar`: Customer belum upload bukti bayar
-   `menunggu_konfirmasi`: Bukti bayar diupload, menunggu konfirmasi admin
-   `terkonfirmasi`: Pembayaran sudah dikonfirmasi admin
-   `ditolak`: Bukti pembayaran ditolak admin

### Product Price Structure

-   Base price di tabel products
-   Additional price di product_variants untuk varian khusus
-   Final price = base price + additional price
-   Stock hanya dikelola di product_variants
