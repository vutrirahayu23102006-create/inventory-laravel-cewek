# INVENTORY MANAGEMENT SYSTEM

## 1. Deskripsi Proyek

Inventory Management System adalah aplikasi berbasis web yang dikembangkan menggunakan Laravel untuk membantu pengelolaan inventaris barang. Aplikasi ini digunakan untuk mencatat, melihat, menambah, mengubah, dan menghapus data produk serta mengelompokkan produk berdasarkan kategori.

Aplikasi juga menyediakan dashboard untuk melihat ringkasan jumlah produk, kategori, total stok, dan produk dengan stok rendah.

## 2. Fitur Aplikasi

- Dashboard ringkasan inventaris.
- CRUD produk (Create, Read, Update, Delete).
- Pengelolaan kategori produk.
- Relasi antara produk dan kategori.
- Pencarian produk berdasarkan nama, SKU, dan kategori.
- Pengurutan produk berdasarkan nama, stok, dan harga.
- Pagination untuk membagi daftar produk.
- Validasi formulir.
- Informasi stok minimum untuk membantu memantau stok rendah.
- Factory dan Seeder untuk membuat data contoh.

## 3. Teknologi yang Digunakan

- PHP 8.3
- Laravel 12
- MySQL
- Blade Template
- HTML dan CSS
- Eloquent ORM
- Laravel Migration, Factory, dan Seeder

## 4. Struktur MVC

### Model

Model Product dan Category digunakan untuk berinteraksi dengan database dan mengatur relasi antar-data.

### View

View menggunakan Blade Template untuk menampilkan dashboard, daftar produk, formulir tambah dan edit produk, serta halaman detail produk.

### Controller

DashboardController mengatur data ringkasan dashboard, sedangkan ProductController menangani proses CRUD, pencarian, pengurutan, dan validasi produk.

### Route

File routes/web.php mengatur alamat URL aplikasi dan menghubungkannya dengan controller yang sesuai.

## 5. Struktur Database

### Tabel categories

- id
- name
- description
- created_at
- updated_at

### Tabel products

- id
- name
- category
- sku
- stock
- minimum_stock
- price
- category_id
- created_at
- updated_at

Relasi: satu kategori dapat memiliki banyak produk, sedangkan satu produk terhubung dengan satu kategori melalui category_id.

## 6. Cara Menjalankan Aplikasi

1. Pastikan PHP dan database MySQL sudah aktif.
2. Buka terminal pada folder proyek.
3. Jalankan migration jika database belum dibuat:

   `C:\php83\php.exe artisan migrate`

4. Isi data kategori contoh:

   `C:\php83\php.exe artisan db:seed --class=CategorySeeder`

5. Jalankan server Laravel:

   `C:\php83\php.exe artisan serve --host=127.0.0.1 --port=8020`

6. Buka browser dan akses:

   `http://127.0.0.1:8020`

Catatan: sesuaikan konfigurasi database pada file .env dengan database yang digunakan. Jangan menjalankan migration ulang jika struktur database sudah tersedia tanpa memeriksa statusnya terlebih dahulu.

## 7. Pengujian Aplikasi

Pengujian dilakukan terhadap fitur tambah produk, menampilkan produk, mengubah produk, menghapus produk, pencarian, pengurutan, validasi input, dan relasi kategori.

Hasil pengujian dicatat berdasarkan kondisi aplikasi yang benar-benar dijalankan.

## 8. Dokumentasi Screenshot

Screenshot aplikasi disimpan pada folder `screenshots`, meliputi:

- Dashboard
- Daftar produk
- Form tambah produk
- Form edit produk
- Detail produk
- Validasi formulir
- Struktur database

## 9. Pengembang

Nama: [Isi nama mahasiswa]

Program Studi: Sistem Informasi

Universitas: Universitas Malikussaleh