# SiKa-BACA — Sistem Informasi Katalog & Bacaan

**SiKa-BACA** adalah aplikasi web manajemen perpustakaan berbasis **Laravel (MVC)** dengan antarmuka **Tailwind CSS** bertema *Maroon–Gold* Universitas Singaperbangsa Karawang (**UNSIKA**). Aplikasi ini mengelola katalog buku, kategori, data keanggotaan, serta transaksi peminjaman dan pengembalian, dengan kontrol hak akses berbasis peran (*Role-Based Access Control*).

---

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Hak Akses Pengguna](#hak-akses-pengguna)
- [Teknologi](#teknologi)
- [Struktur Proyek](#struktur-proyek)
- [Instalasi Lokal](#instalasi-lokal)
- [Akun Demo](#akun-demo)
- [Alur Kolaborasi Git](#alur-kolaborasi-git)
- [Tim Pengembang](#tim-pengembang)

---

## Fitur Utama

- **Dashboard Analitik Sirkulasi** — ringkasan jumlah judul buku, eksemplar tersedia, anggota aktif, statistik transaksi berjalan, grafik tren sirkulasi, dan riwayat peminjaman terbaru.
- **Manajemen Katalog Buku & Kategori** — CRUD lengkap dengan pencarian cepat, filter kategori, detail buku, dan kontrol stok otomatis. Query dioptimalkan dengan *Eager Loading* (`with()`) untuk mencegah *N+1 query problem*.
- **Manajemen Keanggotaan** — pendataan profil anggota, nomor identitas, status keanggotaan, dan riwayat peminjaman per anggota.
- **Sirkulasi Peminjaman & Pengembalian** — pencatatan peminjaman multi-eksemplar (`borrowings` dan `borrowing_details`), penentuan tanggal jatuh tempo, pemrosesan pengembalian, dan pembaruan stok otomatis. Integritas data dijaga melalui:
  - *database locking* (`lockForUpdate`) untuk mencegah stok buku bernilai minus saat transaksi berjalan bersamaan;
  - validasi pencegahan hapus pada data (buku, anggota, dan sejenisnya) yang sudah memiliki riwayat sirkulasi;
  - zona waktu otomatis WIB (`Asia/Jakarta`) untuk seluruh pencatatan waktu transaksi.
- **Autentikasi & RBAC** — pembagian hak akses dengan **Laravel Gates** antara **Admin** dan **Petugas**.

## Hak Akses Pengguna

| Modul                         | Admin | Petugas |
| ----------------------------- | :---: | :-----: |
| Dashboard                     |   ✓   |    ✓    |
| Katalog Buku                  |   ✓   |    ✓    |
| Keanggotaan                   |   ✓   |    ✓    |
| Sirkulasi Peminjaman          |   ✓   |    ✓    |
| Kategori Koleksi              |   ✓   |    —    |
| Kelola Pengguna (`/users`)    |   ✓   |    —    |

Petugas yang mengakses halaman khusus Admin akan menerima respons **HTTP 403 (Forbidden)**.

## Teknologi

| Lapisan      | Teknologi                                         |
| ------------ | ------------------------------------------------- |
| Backend      | PHP **8.3+**, Laravel **13.x**                    |
| Frontend     | Blade, Tailwind CSS, Vite                         |
| Database     | MySQL / MariaDB                                   |
| Arsitektur   | MVC, Eloquent ORM, Laravel Gates                  |

## Struktur Proyek

```text
app/
├── Http/Controllers/
│   ├── AuthController.php        # Login & logout
│   ├── DashboardController.php   # Statistik & grafik sirkulasi
│   ├── BookController.php        # CRUD buku & pencarian
│   ├── CategoryController.php    # CRUD kategori (Admin)
│   ├── MemberController.php      # CRUD anggota & riwayat pinjam
│   ├── BorrowingController.php   # Peminjaman & pengembalian
│   └── UserController.php        # Manajemen pengguna (Admin)
├── Models/                       # Book, Category, Member, Borrowing, BorrowingDetail, User
└── Providers/
    └── AppServiceProvider.php    # Definisi RBAC Gates & View Composer
database/                         # Migrasi tabel & seeder
resources/views/                  # Template Blade
routes/web.php                    # Definisi rute aplikasi
tests/                            # Pengujian otomatis
```

## Instalasi Lokal

**Prasyarat:** PHP 8.3+, Composer, Node.js & npm, MySQL/MariaDB (mis. XAMPP), Git.

```bash
git clone https://github.com/Andhyna/SiKa-BACA.git
cd SiKa-BACA
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate
```

Buat database `library_system` (mis. lewat phpMyAdmin), lalu atur koneksi pada file `.env`:

```env
DB_DATABASE=library_system
DB_PORT=3306   # sesuaikan dengan port MySQL pada XAMPP
```

Jalankan migrasi beserta data awal, lalu nyalakan server:

```bash
php artisan migrate --seed
php artisan serve
```

Aplikasi dapat diakses di <http://127.0.0.1:8000>.

> **Catatan PHP 8.6:** bila muncul peringatan *deprecation*, tambahkan `LOG_DEPRECATIONS_CHANNEL="null"` pada `.env`.

**Memperbarui proyek yang sudah ada:**

```bash
git checkout main
git pull origin main
composer install
php artisan migrate
php artisan optimize:clear
php artisan serve
```

> Perintah di atas sengaja tanpa `--seed` agar data demo tidak terduplikasi pada database yang sudah pernah di-seed. Gunakan `php artisan migrate --seed` hanya pada instalasi pertama.

## Akun Demo

| Peran   | Email                | Kata sandi |
| ------- | -------------------- | ---------- |
| Admin   | `admin@example.com`   | `password` |
| Petugas | `petugas@example.com` | `password` |

> Akun ini hanya untuk pengembangan dan pengujian lokal. Ganti kata sandi sebelum aplikasi dipakai di lingkungan produksi.

## Alur Kolaborasi Git

Setiap fitur dikerjakan pada branch terpisah (`feature/database`, `feature/auth`, `feature/MVC`), digabungkan ke branch integrasi `master` melalui Pull Request, lalu dirilis ke `main` setelah pengujian lintas peran.

## Tim Pengembang

| Anggota                                                          | Peran                                                         |
| ---------------------------------------------------------------- | ------------------------------------------------------------- |
| Darrel ([@Andhyna](https://github.com/Andhyna))                  | Skema database, relasi model, autentikasi awal; pengujian keamanan rute (`403 Forbidden`), penguncian stok (`lockForUpdate`), proteksi penghapusan histori transaksi, dan pengaturan zona waktu WIB |
| Vicky Adam Pamungkas ([@VickyAdamPamungkas](https://github.com/VickyAdamPamungkas)) | Modul MVC, optimasi query, RBAC, rebranding, dokumentasi |