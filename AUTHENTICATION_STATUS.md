# Implementasi Autentikasi dan Navbar - AnekaSandal

## Yang Sudah Diimplementasi

### 1. **Routes Autentikasi**

File: `routes/web.php`

✅ **Routes yang tersedia:**

-   `GET /login` - Halaman login
-   `POST /login` - Proses login
-   `GET /register` - Halaman registrasi
-   `POST /register` - Proses registrasi
-   `POST /logout` - Logout (dengan middleware auth)

✅ **Setelah login/register:** User akan diredirect ke halaman home (`/`) - TIDAK ada redirect ke dashboard

### 2. **Model User**

File: `app/Models/User.php`

✅ **Fillable fields yang sesuai dengan database:**

```php
'username', 'email', 'password', 'full_name', 'phone', 'address', 'role'
```

### 3. **Halaman Autentikasi**

✅ **Login Page** (`resources/views/auth/login.blade.php`):

-   Form login dengan email & password
-   Link ke halaman register
-   Error handling
-   Responsive design dengan Tailwind CSS

✅ **Register Page** (`resources/views/auth/register.blade.php`):

-   Form register dengan: username, full_name, email, phone (opsional), password, password_confirmation
-   Link ke halaman login
-   Error handling
-   Sesuai dengan struktur database

### 4. **Navbar Livewire Component**

File: `app/Livewire/Navbar.php` & `resources/views/livewire/navbar.blade.php`

✅ **Fitur Dynamic Navbar:**

**Saat USER BELUM LOGIN:**

-   Desktop: Tombol "Masuk" dan "Daftar" di kanan atas
-   Mobile: Menu "Masuk" dan "Daftar" di bagian bawah mobile menu

**Saat USER SUDAH LOGIN:**

-   Desktop: Avatar dengan initial nama user + dropdown menu
-   Mobile: Menu keranjang + profil di mobile menu
-   Dropdown berisi: Profile, Pesanan Saya, Settings, Keluar
-   Menampilkan nama lengkap, email, dan role user

✅ **Avatar Dinamis:**

-   Avatar menampilkan initial huruf pertama dari `full_name` atau `username`
-   Background biru dengan text putih
-   Badge role (Customer/Admin) ditampilkan

### 5. **Struktur Database**

✅ **Sesuai dengan migration yang ada:**

-   `username` (unique, 50 chars)
-   `email` (unique, 100 chars)
-   `full_name` (100 chars)
-   `phone` (nullable, 20 chars)
-   `address` (nullable, text)
-   `role` (enum: customer/admin, default: customer)

## Cara Menggunakan

### 1. **Testing Registrasi**

1. Buka `http://localhost:8000`
2. Klik tombol "Daftar" di navbar
3. Isi form registrasi:
    - Username: test123
    - Nama Lengkap: Test User
    - Email: test@example.com
    - No. Telepon: 081234567890 (opsional)
    - Password: password123
    - Konfirmasi Password: password123
4. Submit - akan otomatis login dan redirect ke home

### 2. **Testing Login**

1. Klik "Masuk" di navbar
2. Gunakan kredensial yang sudah terdaftar atau:
    - Email: admin@anekasandal.com
    - Password: password
3. Submit - akan redirect ke home dengan navbar berubah menampilkan avatar

### 3. **Testing Navbar States**

-   **Sebelum login:** Navbar menampilkan "Masuk" dan "Daftar"
-   **Setelah login:** Navbar menampilkan avatar dengan initial + dropdown menu

### 4. **Testing Logout**

1. Saat sudah login, klik avatar di navbar
2. Pilih "Keluar" dari dropdown
3. Akan logout dan navbar kembali menampilkan "Masuk"/"Daftar"

## Akun Testing yang Tersedia

(Dari UserSeeder.php)

```
Admin:
- Email: admin@anekasandal.com
- Password: password
- Role: admin

Customer:
- Email: customer1@gmail.com
- Password: password
- Role: customer
```

## Next Steps (Belum Diimplementasi)

### 1. **Dashboard Admin (Nanti)**

-   Route `/admin/dashboard` (hanya untuk role admin)
-   Halaman admin untuk manage produk, orders, dll

### 2. **Profile Management (Nanti)**

-   Halaman edit profile user
-   Upload avatar
-   Ganti password

### 3. **Shopping Cart (Nanti)**

-   Shopping cart functionality
-   Add to cart dari product pages

### 4. **Order Management (Nanti)**

-   Halaman "Pesanan Saya"
-   Track order status

## Notes

✅ **Authentication flow sudah bekerja sepenuhnya**
✅ **Navbar responsive sudah mendukung login/logout states**
✅ **User model sudah sesuai dengan database schema**
✅ **Tidak ada redirect ke dashboard - user tetap di halaman home setelah login**

🚀 **Server berjalan di:** `http://localhost:8000`
