# 🎥 BioskopKu - Sistem Pemesanan Tiket Bioskop

Sistem informasi bioskop modern berbasis web yang dirancang menggunakan framework **Laravel 12**, **Blade**, dan **Tailwind CSS**. Aplikasi ini mendukung alur pemesanan lengkap mulai dari katalog film, pemilihan kursi dinamis, simulasi pembayaran, hingga penerbitan e-ticket dengan QR Code, serta panel kontrol administrasi khusus.

---

## 📝 Gambaran Proyek

**BioskopKu** dibangun untuk mempermudah operasional bioskop modern dan memberikan pengalaman bertransaksi yang mulus bagi penonton. Aplikasi ini menerapkan pemisahan peran yang ketat antara **Pengguna (User)** yang bertransaksi dan **Administrator (Admin)** yang mengelola konten serta jadwal penayangan.

Sistem juga dilengkapi dengan fitur keamanan database seperti pencegahan *double-booking* kursi pada jadwal tayang yang sama, serta antarmuka administrasi berupa **Live Preview Sandbox** untuk memantau tampilan pengguna tanpa memengaruhi transaksi yang sedang berlangsung.

---

## ✨ Fitur Utama

### 👥 Portal Pengguna (User)
*   **Registrasi & Login**: Autentikasi aman terintegrasi menggunakan Laravel Breeze.
*   **Katalog Film**: Halaman utama berisi daftar film terbaru yang sedang tayang.
*   **Detail Film & Jadwal**: Halaman detail yang menyajikan sinopsis, genre, durasi, dan pilihan tanggal serta jam tayang secara real-time.
*   **Pemilihan Kursi Interaktif**: Layout denah studio dengan penanda warna kursi (Tersedia, Terpilih, Terisi/Sold). Proteksi bawaan mencegah pemesanan ganda.
*   **Simulasi Pembayaran (Mock Checkout)**: Alur pembayaran aman untuk memproses pesanan (`order_id`) dari status *pending* menjadi *success*.
*   **E-Ticket Dinamis**: Tiket elektronik yang dilengkapi QR Code berisi detail pesanan, data film, dan nomor kursi untuk proses check-in.
*   **Riwayat Transaksi ("Tiket Saya")**: Halaman khusus bagi pengguna untuk melihat kembali e-ticket dari pesanan yang sukses.

### 🛡️ Portal Administrator (Admin)
*   **Halaman Login Terpisah**: Jalur masuk admin khusus lewat `/admin/login` untuk mencegah pencampuran otoritas.
*   **Dashboard Statistik**: Dashboard ringkas untuk memantau aktivitas sistem.
*   **CRUD Film**: Panel khusus untuk mengelola data film lengkap dengan unggah gambar poster film.
*   **CRUD Jadwal Tayang**: Pengelolaan studio, tanggal tayang, jam tayang, dan harga tiket untuk setiap film.
*   **Live Preview Sandbox**: Fitur unik bagi admin untuk meninjau halaman utama pengguna dalam mode *read-only* (tidak dapat memesan tiket saat dalam mode preview).

---

## 🛠️ Tech Stack

*   **Core Framework**: [Laravel 12](https://laravel.com/) (PHP 8.2+)
*   **Starter Kit**: [Laravel Breeze](https://laravel.com/docs/12.x/breeze) (Blade & Alpine.js)
*   **Frontend & Styling**: [Tailwind CSS](https://tailwindcss.com/) & [Vite](https://vite.dev/)
*   **Database**: MySQL / MariaDB
*   **Libraries / Packages**:
    *   `simplesoftwareio/simple-qrcode` - Pembuatan QR Code dinamis secara lokal.
    *   `midtrans/midtrans-php` - Siap untuk integrasi payment gateway masa depan.

---

## 💾 Struktur Database Utama

Aplikasi ini menggunakan 4 tabel utama yang saling berelasi:

1.  **`users`**: Menyimpan kredensial pengguna dan peran akses (`role` bernilai `user` atau `admin`).
2.  **`films`**: Menyimpan detail film seperti judul, genre, durasi, deskripsi, dan path poster film.
3.  **`schedules`**: Menyimpan jadwal tayang yang menghubungkan film ke studio, tanggal, jam tayang, dan harga tiket.
4.  **`bookings`**: Menyimpan detail pemesanan kursi per order, status pembayaran (`pending` / `success`), serta token transaksi.
    > [!NOTE]
    > Tabel `bookings` memiliki indeks unik gabungan (`unique(['schedule_id', 'seat_number'])`) di tingkat database untuk memastikan perlindungan mutlak dari masalah *race condition* atau *double-booking* kursi.

---

## 🔑 Akun Uji Coba Default

Jika Anda menjalankan Database Seeder bawaan, akun-akun berikut akan otomatis terdaftar di sistem:

### 🛡️ Administrator (Admin)
*   **Email**: `admin@bioskop.com`
*   **Password**: `password123`
*   **Rute Login**: `http://localhost/Bioskop_App/public/admin/login` *(atau port default artisan serve)*

### 👥 Pengguna Biasa (User)
*   **Email**: `test@example.com`
*   **Password**: `password`
*   **Rute Login**: `http://localhost/Bioskop_App/public/login` *(atau port default artisan serve)*

---

## 🚀 Panduan Setup & Instalasi Lengkap

Ikuti langkah-langkah di bawah ini untuk memasang dan menjalankan proyek di lingkungan lokal Anda.

### 📌 Prasyarat Sistem
Pastikan komputer Anda telah terinstal:
*   PHP >= 8.2 (dengan ekstensi `pdo_mysql`, `gd`, `bcmath`, `ctype`, `fileinfo`, `openssl` aktif)
*   [Composer](https://getcomposer.org/)
*   [Node.js & NPM](https://nodejs.org/)
*   Web Server lokal seperti [WampServer](https://www.wampserver.com/), [Laragon](https://laragon.org/), atau XAMPP yang menjalankan MySQL.

---

### Langkah 1: Clone Repository
Buka terminal/CMD Anda, arahkan ke direktori web server (misal `C:\wamp64\www\`), lalu jalankan:
```bash
git clone https://github.com/zen552/Bioskop_App.git
cd Bioskop_App
```

### Langkah 2: Install Dependensi PHP
Unduh seluruh package PHP yang dibutuhkan aplikasi menggunakan Composer:
```bash
composer install
```

### Langkah 3: Install Dependensi Frontend
Unduh library Javascript/CSS yang diperlukan untuk build aset:
```bash
npm install
```

### Langkah 4: Salin Konfigurasi Lingkungan (`.env`)
Salin file `.env.example` menjadi `.env` baru:

**Melalui Command Prompt (Windows CMD):**
```cmd
copy .env.example .env
```
**Melalui PowerShell / Git Bash / Linux Terminal:**
```bash
cp .env.example .env
```

### Langkah 5: Konfigurasi File `.env`
Buka file `.env` yang baru dibuat dengan teks editor Anda, sesuaikan pengaturan database sesuai dengan lingkungan Anda. 

Contoh konfigurasi standar:
```env
APP_NAME="BioskopKu"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost/Bioskop_App/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bioskop_app
DB_USERNAME=root
DB_PASSWORD=            # Isi password MySQL Anda (misal "root" jika pakai WampServer)
```
> [!TIP]
> Jika Anda menjalankan proyek menggunakan perintah `php artisan serve`, ubah `APP_URL` menjadi `http://127.0.0.1:8000`.

### Langkah 6: Generate Application Key
Jalankan perintah ini untuk membuat key enkripsi unik aplikasi Laravel:
```bash
php artisan key:generate
```

### Langkah 7: Siapkan Database
Buka aplikasi pengelola database Anda (seperti phpMyAdmin, HeidiSQL, atau DBeaver), lalu buat sebuah database baru bernama:
```sql
CREATE DATABASE bioskop_app;
```

### Langkah 8: Jalankan Migrasi & Seeder Database
Kirim seluruh tabel ke database baru Anda dan isi dengan data uji coba bawaan (User seeder & Admin seeder):
```bash
# Jalankan seluruh migrasi database
php artisan migrate

# Jalankan seeder akun user dan admin default
php artisan db:seed --class=DatabaseSeeder
php artisan db:seed --class=AdminSeeder
```
*Atau, Anda dapat melakukan migrasi ulang beserta seeder sekaligus:*
```bash
php artisan migrate:fresh --seed
```

### Langkah 9: Buat Simbolik Link Storage
Langkah ini sangat penting agar file gambar/poster film yang diunggah oleh admin melalui dashboard dapat diakses dan ditampilkan di halaman katalog pengguna:
```bash
php artisan storage:link
```

### Langkah 10: Jalankan Aplikasi
Proyek ini memiliki skrip otomasi yang didefinisikan pada file `composer.json` untuk mempermudah pengembangan.

#### Cara Mudah (Single Command):
Jalankan perintah berikut untuk menjalankan server Laravel, server bundler Vite, queue handler, dan log viewer secara bersamaan di dalam satu terminal:
```bash
composer run dev
```

#### Cara Manual (Multi Terminal):
Jika Anda ingin menjalankan layanan secara terpisah:
1.  **Terminal 1**: Jalankan server lokal Laravel:
    ```bash
    php artisan serve
    ```
2.  **Terminal 2**: Jalankan compiler aset Vite untuk CSS & JS:
    ```bash
    npm run dev
    ```

Aplikasi kini dapat diakses di peramban Anda melalui alamat: **`http://127.0.0.1:8000`** atau **`http://localhost/Bioskop_App/public`**.

---

## 🗺️ Struktur Rute Penting (Routes)

Aplikasi ini menggunakan otorisasi middleware untuk membagi hak akses rute web:

| Otoritas | Rute URL | Controller / Method | Deskripsi |
| :--- | :--- | :--- | :--- |
| **Guest / Publik** | `/` | `welcome.blade.php` | Halaman katalog utama |
| | `/films/{film}` | Route Closure | Detail film & daftar jadwal tayang |
| **User (Terautentikasi)** | `/booking/seats/{schedule}` | `BookingController@selectSeats` | Pemilihan denah kursi bioskop |
| | `/booking/confirm/{schedule}`| `BookingController@confirm` | Proses checkout pesanan |
| | `/pembayaran/{order_id}` | `PaymentController@show` | Invoice & Simulasi Pembayaran |
| | `/tiket-saya` | `ETicketController@index` | Riwayat daftar e-ticket sukses |
| | `/e-ticket/{order_id}` | `ETicketController@show` | Detail Tiket Elektronik & QR Code |
| **Admin (Terautentikasi)** | `/admin/login` | Laravel Breeze | Pintu masuk login administrator |
| | `/admin/dashboard` | `AdminController@dashboard` | Panel statistik utama admin |
| | `/admin/films` | `FilmController` (Resource) | Manajemen CRUD Film |
| | `/admin/schedules` | `ScheduleController` (Resource)| Manajemen CRUD Jadwal Tayang |
| | `/admin/preview` | `AdminController@previewHome` | Uji coba halaman katalog (Preview) |

---

## 🔍 Pemecahan Masalah (Troubleshooting)

### 1. Gambar Poster Film Tidak Muncul
*   Pastikan Anda sudah menjalankan perintah `php artisan storage:link` di direktori utama proyek.
*   Cek apakah nilai variabel `APP_URL` di file `.env` Anda sudah tepat dan sesuai dengan URL yang sedang Anda buka di peramban (misal `http://127.0.0.1:8000` jika menggunakan `php artisan serve`).
*   Jika di Windows, pastikan folder pintasan (symlink) `public/storage` benar-benar mengarah ke folder asli `storage/app/public`.

### 2. Pesan Error Terkait Database Connection
*   Pastikan server MySQL Anda (Laragon/WAMP/XAMPP) sudah dalam keadaan menyala.
*   Periksa kembali kecocokan port database di `.env` (biasanya `3306`).
*   Khusus WAMP/Laragon, pastikan `DB_USERNAME` dan `DB_PASSWORD` sesuai dengan konfigurasi database manager lokal Anda (username bawaan biasanya `root` dan password kosong atau `root`).

### 3. Error Token / CSRF Mismatch
*   Saat mengirimkan formulir pemesanan atau login, jika Anda menjumpai pesan kedaluwarsa, jalankan pembersihan cache konfigurasi aplikasi:
    ```bash
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    ```

---

## 📄 Lisensi

Proyek ini dibangun untuk tujuan pembelajaran, portofolio pribadi, dan referensi implementasi aplikasi pemesanan tiket bioskop berbasis Laravel. Anda bebas menyalin dan memodifikasi proyek ini.
