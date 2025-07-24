# Komponen Livewire Navbar - AnekaSandal

## Deskripsi

Komponen navbar yang telah dibuat menggunakan Livewire dengan fitur pencarian yang responsif dan interactive.

## Fitur Yang Tersedia

### 1. **Navigasi Responsif**

-   Menu mobile yang dapat dibuka/tutup
-   Dropdown user menu
-   Navigation links yang dapat disesuaikan

### 2. **Fitur Pencarian**

-   Search bar yang tersedia di desktop dan mobile
-   Live search dengan debouncing (delay 300ms)
-   Hasil pencarian real-time
-   Clear search button
-   Search results dropdown dengan preview produk

### 3. **User Authentication**

-   User dropdown dengan informasi user yang sedang login
-   Menu berbeda untuk user yang sudah login vs guest
-   Logout functionality

## File Yang Dibuat

### 1. **app/Livewire/Navbar.php**

Class Livewire untuk navbar dengan properties:

-   `$search` - untuk menyimpan kata kunci pencarian
-   `$showMobileMenu` - toggle mobile menu
-   `$showUserDropdown` - toggle user dropdown

Methods:

-   `toggleMobileMenu()` - toggle mobile menu
-   `toggleUserDropdown()` - toggle user dropdown
-   `searchProducts()` - handle pencarian produk
-   `clearSearch()` - clear search input

### 2. **app/Livewire/SearchResults.php**

Class Livewire untuk menampilkan hasil pencarian:

-   Live search results dari database
-   Preview produk dengan gambar
-   Navigation ke detail produk

### 3. **resources/views/livewire/navbar.blade.php**

Template navbar dengan:

-   Responsive design (mobile & desktop)
-   Search functionality
-   User authentication states
-   Dark mode support

### 4. **resources/views/livewire/search-results.blade.php**

Template untuk hasil pencarian dengan preview produk

### 5. **resources/views/app.blade.php**

Layout utama aplikasi yang sudah include navbar dan Livewire scripts

### 6. **resources/views/home.blade.php**

Halaman home sebagai contoh penggunaan navbar

## Cara Menggunakan

### 1. **Menggunakan di Layout**

```blade
<!-- Di file layout utama -->
@livewire('navbar')
```

### 2. **Menggunakan di Template Specific**

```blade
<!-- Di halaman tertentu -->
<livewire:navbar />
```

### 3. **Kustomisasi Menu Links**

Edit file `resources/views/livewire/navbar.blade.php` pada bagian navigation links:

```blade
<ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
    <li>
        <a href="{{ route('home') }}" class="...">Home</a>
    </li>
    <!-- Tambah menu lain di sini -->
</ul>
```

### 4. **Handle Search Events**

Untuk menangani pencarian, Anda bisa listen event `search-products`:

```javascript
// Di JavaScript
$wire.on("search-products", (event) => {
    // Handle search
    console.log("Searching for:", event.search);
    // Redirect ke halaman search
    window.location.href = "/search?q=" + encodeURIComponent(event.search);
});
```

## Kustomisasi

### 1. **Mengubah Logo & Brand Name**

Edit di `navbar.blade.php`:

```blade
<a href="{{ route('home') ?? '/' }}" class="flex items-center space-x-3 rtl:space-x-reverse">
    <img src="path/to/your/logo.svg" class="h-8" alt="Your Logo" />
    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Your Brand</span>
</a>
```

### 2. **Menambah Menu Items**

Tambahkan di bagian navigation links:

```blade
<li>
    <a href="{{ route('your-route') }}" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Your Menu</a>
</li>
```

### 3. **Kustomisasi Search Functionality**

Edit method `searchProducts()` di `app/Livewire/Navbar.php`:

```php
public function searchProducts()
{
    if ($this->search) {
        // Custom search logic
        return redirect()->route('search.results', ['q' => $this->search]);
    }
}
```

## Dependencies

Pastikan Anda memiliki:

1. **Livewire 3.x** (sudah terinstall)
2. **Tailwind CSS** (sudah terkonfigurasi)
3. **Laravel Breeze/Jetstream** untuk authentication (opsional)

## Catatan Penting

1. **Routes**: Pastikan route `home`, `login`, `register`, `logout` sudah didefinisikan
2. **Products Model**: Sesuaikan query di `SearchResults.php` dengan struktur database Anda
3. **Authentication**: Komponen sudah support authentication Laravel standard
4. **Mobile Responsive**: Navbar sudah fully responsive untuk semua device

## Testing

Untuk testing komponen ini:

1. Buka halaman home
2. Test search functionality di desktop dan mobile
3. Test mobile menu toggle
4. Test user dropdown (jika sudah ada authentication)
5. Test navigation links

## Troubleshooting

### 1. **Livewire Scripts Tidak Load**

Pastikan di layout ada:

```blade
@livewireStyles
<!-- di head -->

@livewireScripts
<!-- sebelum closing body -->
```

### 2. **Search Tidak Berfungsi**

-   Pastikan Products model sudah ada
-   Check database connection
-   Pastikan field `name` dan `description` ada di table products

### 3. **Styling Tidak Muncul**

-   Pastikan Tailwind CSS sudah ter-compile
-   Run `npm run dev` atau `npm run build`
-   Check vite configuration
