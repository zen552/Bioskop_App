# 🎬 BioskopKu - Sistem Pemesanan Tiket Bioskop

BioskopKu adalah aplikasi *web-based* simulasi pemesanan tiket bioskop komprehensif yang dibangun menggunakan Laravel 12. Proyek ini dikembangkan sebagai tugas kuliah untuk mereplikasi alur kerja *end-to-end* dari sistem bioskop modern, mulai dari manajemen film oleh admin hingga pemesanan kursi dan pembayaran oleh pelanggan.

## ✨ Fitur Utama

### 👑 Panel Admin (Manajemen)
- **Satu Pintu Login:** Sistem autentikasi cerdas yang menggunakan satu halaman login terpusat (`/login`). Akses admin akan otomatis diarahkan ke *Dashboard*.
- **CRUD Film:** Admin dapat menambah, mengedit, dan menghapus data film beserta unggahan poster film.
- **Manajemen Jadwal Tayang:** Mengatur jadwal penayangan, studio, dan penentuan harga tiket.

### 👥 Portal Pelanggan (User)
- **Autentikasi User:** Fitur pendaftaran (Register) dan Login bagi pelanggan bioskop.
- **Beranda & Eksplorasi Film:** Katalog film yang sedang tayang dengan desain *dark mode* modern.
- **Sistem Pemesanan Kursi:** Memilih jadwal tayang dan memilih nomor kursi secara interaktif.
- **Simulasi Pembayaran (Mock Payment):** Antarmuka *checkout* bergaya profesional yang mensimulasikan pembayaran melalui BCA Virtual Account, BNI, dan QRIS.
- **E-Ticket QR Code:** Menghasilkan tiket elektronik secara otomatis menggunakan QR Code siap cetak setelah pembayaran berhasil.
- **Riwayat Transaksi (Tiket Saya):** Melacak dan melihat ulang daftar e-ticket dari semua transaksi yang telah lalu.

## 🛠️ Tech Stack

| Kategori | Teknologi |
|---|---|
| Backend Framework | Laravel 12.x (PHP 8.4) |
| Database | MySQL / MariaDB |
| Frontend Styling | Tailwind CSS |
| Templating | Laravel Blade + Alpine.js |
| Autentikasi | Laravel Breeze |
| QR Code | `simplesoftwareio/simple-qrcode` |

## 🚀 Panduan Instalasi

### Prasyarat
Pastikan komputer kamu sudah menginstal:
- **PHP** >= 8.2
- **Composer**
- **Node.js & NPM**
- **MySQL** (XAMPP / WAMP / Laragon)

---

### Langkah 1 — Clone Repositori
```bash
git clone https://github.com/USERNAME/bioskopku.git
cd bioskopku
```

### Langkah 2 — Instalasi Dependensi
```bash
composer install
npm install
```

### Langkah 3 — Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` yang baru dibuat, lalu sesuaikan konfigurasi database:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_kamu
DB_USERNAME=root
DB_PASSWORD=
```
> Pastikan database kosong dengan nama yang sesuai sudah dibuat di MySQL sebelum melanjutkan.

### Langkah 4 — Migrasi & Seeding Database
```bash
php artisan migrate:fresh --seed
```

### Langkah 5 — Hubungkan Storage (Wajib untuk Poster Film)
```bash
php artisan storage:link
```

### Langkah 6 — Jalankan Server

Buka **dua terminal terpisah** dan jalankan masing-masing perintah berikut:

**Terminal 1 — Backend:**
```bash
php artisan serve
```

**Terminal 2 — Frontend:**
```bash
npm run dev
```

Aplikasi kini dapat diakses di browser pada: **[http://localhost:8000](http://localhost:8000)**

---

## 🔑 Akun Default

| Role | Email | Password |
|---|---|---|
| Admin | `admin@bioskopku.test` | `password` |
| User | `user@bioskopku.test` | `password` |

> Akun admin dibuat secara manual di database oleh superadmin. Tidak ada fitur registrasi untuk admin.

---

*Dikembangkan dengan ☕ sebagai Proyek Tugas Kuliah.*
