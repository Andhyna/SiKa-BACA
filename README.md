# SiKa-BACA — Sistem Informasi Katalog & Bacaan

**SiKa-BACA** adalah aplikasi web manajemen perpustakaan berbasis **Laravel (MVC)** dengan antarmuka **Tailwind CSS** bertema *Maroon–Gold* Universitas Singaperbangsa Karawang (**UNSIKA**). Aplikasi ini dirancang untuk mengelola katalog koleksi buku, kategori, data keanggotaan, serta transaksi sirkulasi peminjaman dan pengembalian secara terintegrasi dengan kontrol hak akses berbasis peran (*Role-Based Access Control*).

---

## Fitur Utama

- **Dashboard Analitik Sirkulasi**
  Menampilkan ringkasan jumlah judul buku, total eksemplar tersedia, anggota aktif, statistik transaksi berjalan, grafik tren sirkulasi, serta riwayat peminjaman terbaru.
- **Manajemen Katalog Buku & Kategori**
  Operasi CRUD lengkap dengan pencarian cepat, filter kategori, informasi detail buku, kontrol stok otomatis, serta optimasi query menggunakan *Eager Loading* (`with()`) untuk mencegah *N+1 query problem*.
- **Manajemen Keanggotaan Perpustakaan**
  Pendataan profil anggota aktif, nomor identitas anggota, status keanggotaan, dan riwayat peminjaman per individu.
- **Transaksi Sirkulasi Peminjaman & Pengembalian**
  Pencatatan transaksi peminjaman multi-eksemplar (`borrowings` & `borrowing_details`), penentuan tanggal jatuh tempo, pemrosesan pengembalian buku, serta pembaruan stok buku secara otomatis dan transaksional.
- **Autentikasi & Role-Based Access Control (RBAC)**
  Pembagian hak akses menggunakan **Laravel Gates** untuk memisahkan kewenangan antara **Admin** (akses penuh termasuk manajemen pengguna dan master kategori) dan **Petugas** (operasional katalog, anggota, dan sirkulasi).

---

## Teknologi yang Digunakan

- **Backend:** PHP 8.2+ (kompatibel hingga PHP 8.6), Laravel Framework
- **Frontend:** Blade Template Engine, Tailwind CSS, Vite
- **Database:** MySQL / MariaDB
- **Arsitektur:** Model-View-Controller (MVC), Eloquent ORM, Laravel Gates

---

## Struktur Modul Aplikasi

```text
app/
├── Http/Controllers/
│   ├── AuthController.php        # Autentikasi login & logout sesi
│   ├── DashboardController.php   # Agregasi statistik & grafik sirkulasi
│   ├── BookController.php        # CRUD katalog buku & pencarian
│   ├── CategoryController.php    # CRUD kategori koleksi (Admin)
│   ├── MemberController.php      # CRUD data anggota & riwayat pinjam
│   ├── BorrowingController.php   # Transaksi peminjaman & pengembalian
│   └── UserController.php        # Manajemen akun Admin & Petugas (Admin)
├── Models/
│   ├── Book.php
│   ├── Category.php
│   ├── Member.php
│   ├── Borrowing.php
│   ├── BorrowingDetail.php
│   └── User.php
└── Providers/
    └── AppServiceProvider.php    # Definisi RBAC Gates & View Composer