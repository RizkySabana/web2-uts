# 📚  Sistem Peminjaman Buku Perpustakaan

Project UTS Pemrograman Web 2 — Studi Kasus Sistem Peminjaman Buku Perpustakaan Digital

---

## Deskripsi Project

LibraryEase merupakan aplikasi berbasis Laravel 13 yang digunakan untuk mengelola data perpustakaan kampus, termasuk koleksi buku, data anggota, dan transaksi peminjaman buku.

Sistem ini membantu proses pencatatan koleksi buku, pengelolaan anggota perpustakaan, pemantauan status peminjaman dan pengembalian buku, serta pembuatan laporan dalam format PDF maupun Excel.

---

## Fitur Utama

### Dashboard
- Total Buku
- Total Anggota
- Total Sedang Dipinjam
- Total Sudah Dikembalikan
- Jumlah Keterlambatan Pengembalian
- Grafik Transaksi per Bulan (Bar Chart)
- Grafik Status Peminjaman (Doughnut Chart)
- Tabel 5 Buku Terpopuler

### Buku
- Tambah Buku
- Lihat Daftar Buku
- Detail Buku
- Edit Buku
- Hapus Buku
- Upload Cover Buku
- Filter Kategori
- Pencarian Judul / Pengarang
- Riwayat Peminjaman per Buku

### Anggota
- Tambah Anggota
- Lihat Daftar Anggota
- Detail Anggota
- Edit Anggota
- Hapus Anggota
- Pencarian Nama / Nomor Anggota
- Riwayat Peminjaman per Anggota

### Transaksi Peminjaman
- Catat Peminjaman Baru
- Lihat Semua Transaksi
- Detail Transaksi
- Proses Pengembalian Buku
- Hapus Data Transaksi
- Filter Status (Dipinjam / Dikembalikan)
- Deteksi Otomatis Keterlambatan
- Stok Buku Otomatis Berkurang dan Bertambah saat Pengembalian

### Transaksi AJAX
- Filter Real-time Tanpa Reload Halaman
- Modal Detail Transaksi dengan Cover Buku
- Proses Pengembalian via AJAX
- Hapus Data via AJAX
- Pagination Dinamis

### Laporan
- Filter Laporan berdasarkan Keyword, Status, Tanggal, Buku, dan Anggota
- Preview Laporan dengan Statistik Ringkasan
- Export PDF format A4 Landscape menggunakan DomPDF
- Export Excel format .xlsx menggunakan Maatwebsite Excel

---

## Hak Akses

### Admin
- Mengelola semua data buku (Tambah, Edit, Hapus, Upload Cover)
- Mengelola semua data anggota (Tambah, Edit, Hapus)
- Mencatat peminjaman untuk anggota manapun
- Memproses pengembalian buku
- Menghapus data transaksi
- Mengakses laporan dan export PDF maupun Excel
- Mengakses semua fitur dashboard dan halaman AJAX

### Anggota
- Melihat koleksi buku perpustakaan
- Meminjam buku hanya untuk diri sendiri
- Melihat riwayat transaksi milik sendiri
- Mengakses halaman AJAX hanya untuk melihat data
- Dashboard pribadi berisi statistik peminjaman sendiri

---

## Teknologi Yang Digunakan

- Laravel 13.14.0
- PHP 8.4.22
- MySQL / SQLite
- Bootstrap 5.3.3
- jQuery 3.7.1
- Chart.js untuk Grafik Dashboard
- Font Awesome 6.5.0
- barryvdh/laravel-dompdf versi ^3.1 untuk Export PDF
- maatwebsite/excel versi ^3.1 untuk Export Excel
- AJAX menggunakan jQuery $.get dan $.ajax

---

## Struktur Database

### Tabel users
- id
- name
- email
- password
- role (admin / anggota)
- anggota_id (nullable, relasi ke tabel anggotas)

### Tabel bukus
- id
- kode_buku
- judul
- pengarang
- penerbit
- tahun_terbit
- kategori
- stok_total
- stok_tersedia
- cover_path (nullable, path gambar cover)
- deskripsi

### Tabel anggotas
- id
- nomor_anggota
- nama
- email
- telepon
- alamat
- tanggal_daftar
- status (aktif / nonaktif)

### Tabel transaksis
- id
- buku_id (FK ke bukus)
- anggota_id (FK ke anggotas)
- tanggal_pinjam
- tanggal_kembali_rencana (batas pengembalian 7 hari)
- tanggal_kembali_aktual (nullable)
- status (dipinjam / dikembalikan)

---

## Cara Instalasi

### 1. Clone Repository
```
git clone https://github.com/RizkySabana/web2-uts
```

### 2. Masuk ke Folder Project
```
cd libraryease
```

### 3. Install Dependency PHP
```
composer install
```

### 4. Copy Environment
Windows:
```
copy .env.example .env
```
Linux / Mac:
```
cp .env.example .env
```

### 5. Generate Key
```
php artisan key:generate
```

### 6. Konfigurasi Database

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web2-uts
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Migrasi dan Seeder
```
php artisan migrate:fresh --seed
```

### 8. Storage Link
```
php artisan storage:link
```

### 9. Jalankan Server
```
php artisan serve
```

### 10. Buka Browser
```
http://127.0.0.1:8000
```

---

## Akun Login Seeder

Admin
- Email    : admin@perpus.test
- Password : password123
- Akses    : Penuh (semua fitur)

Anggota
- Email    : budi.pratama@perpus.test
- Password : password123
- Akses    : Terbatas (lihat buku, pinjam sendiri)

- Email    : siti.aminah@perpus.test
- Password : password123

- Email    : rizky.maulana@perpus.test
- Password : password123

- Email    : dewi.sartika@perpus.test
- Password : password123

---

## Perintah Artisan Penting

Reset database dan isi ulang data:
```
php artisan migrate:fresh --seed
```

Hapus cache route:
```
php artisan route:clear
```

Hapus cache view:
```
php artisan view:clear
```

Hapus semua cache aplikasi:
```
php artisan cache:clear
```

Cek semua route yang terdaftar:
```
php artisan route:list
```

Masuk ke Tinker untuk debug database:
```
php artisan tinker
```

---

## Struktur Folder Penting

```
libraryease/
├── app/
│   ├── Exports/
│   │   └── PeminjamanExport.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── BukuController.php
│   │   │   ├── AnggotaController.php
│   │   │   ├── TransaksiController.php
│   │   │   ├── TransaksiAjaxController.php
│   │   │   └── LaporanController.php
│   │   └── Middleware/
│   │       ├── IsAdmin.php
│   │       └── IsAnggota.php
│   ├── Interfaces/
│   │   └── PeminjamanInterface.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Buku.php
│   │   ├── Anggota.php
│   │   └── Transaksi.php
│   └── Services/
│       └── PeminjamanService.php
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_bukus_table.php
│   │   ├── xxxx_create_anggotas_table.php
│   │   ├── xxxx_create_transaksis_table.php
│   │   └── xxxx_add_role_to_users_table.php
│   └── seeders/
│       ├── UserSeeder.php
│       ├── BukuSeeder.php
│       ├── AnggotaSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       ├── dashboard/
│       │   ├── index.blade.php
│       │   └── anggota.blade.php
│       ├── buku/
│       ├── anggota/
│       ├── transaksi/
│       │   ├── ajax.blade.php
│       │   └── partials/_table_ajax.blade.php
│       └── laporan/
│           ├── index.blade.php
│           └── pdf.blade.php
└── routes/
    └── web.php
```

---

## Implementasi Modul

Modul 2 - OOP
Menggunakan Interface PeminjamanInterface dan Service Class PeminjamanService yang mengimplementasikan interface tersebut. Logika bisnis peminjaman dan pengembalian buku dipisahkan dari controller menggunakan Dependency Injection.

Modul 3 - MVC Routing, Controller, View Dasar
Terdapat 7 Controller dengan routing terstruktur menggunakan Route::resource, Route::group, Route::prefix, dan Route::middleware untuk proteksi akses.

Modul 4 - Blade Template, Layout, dan Form
Menggunakan master layout app.blade.php dengan @yield dan @section. Form menggunakan @csrf, @error untuk validasi, @old untuk mempertahankan input, dan @push/@stack untuk script per halaman.

Modul 5 - Database, Migration, Eloquent, CRUD
Terdapat 4 tabel dengan migration lengkap. Model Eloquent menggunakan relasi hasMany dan belongsTo. CRUD lengkap di semua modul dengan pagination, pencarian, dan filter. Data awal diisi menggunakan Seeder.

Modul 6 - Keamanan Aplikasi
Sistem autentikasi menggunakan Auth::attempt dengan session regenerate untuk mencegah session fixation. Middleware IsAdmin melindungi route sensitif. Setiap form dilindungi CSRF token.

Modul 7 - Penanganan File dan Gambar
Upload cover buku menggunakan Storage::disk public dengan validasi tipe gambar dan maksimal 2MB. File lama dihapus otomatis saat update. Storage link dibuat dengan php artisan storage:link.

Modul 8 - AJAX dan jQuery
Halaman Transaksi AJAX menggunakan jQuery untuk filter real-time dengan debounce, modal detail menampilkan cover buku, proses pengembalian dan hapus data tanpa reload halaman menggunakan method PATCH dan DELETE.

Modul 9 - Konversi PDF dan Excel
Export PDF menggunakan DomPDF dengan tampilan landscape A4. Export Excel menggunakan Maatwebsite dengan WithHeadings, WithMapping, dan ShouldAutoSize. Keduanya mendukung filter data sebelum diekspor.

---

## Repository

https://github.com/RizkySabana/web2-uts

---

## Author

Project UTS Pemrograman Web 2
Studi Kasus Sistem Peminjaman Buku Perpustakaan

LibraryEase - Sistem Peminjaman Buku Perpustakaan Digital
Dibangun dengan Laravel 13 - Tema Krem dan Hijau Safir