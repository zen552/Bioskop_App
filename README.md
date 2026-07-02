# 🎬 BioskopKu - Cinema Ticketing System

BioskopKu adalah aplikasi pemesanan tiket bioskop modern berbasis web. Aplikasi ini dibangun dengan framework **Laravel**, antarmuka yang elegan menggunakan **TailwindCSS** (Dark Mode), dan fitur transaksi *real-time* yang terintegrasi penuh dengan **Midtrans Payment Gateway**.

Aplikasi ini dibuat dengan sangat memperhatikan *User Experience* (UX) dan keamanan data, mencakup sistem pemilihan kursi yang interaktif, pengiriman E-Ticket PDF via email *background queue*, hingga sistem *Soft Deletes* untuk menjaga integritas *history* transaksi.

---

## ✨ Fitur Utama

- **Sistem Autentikasi & Role (Admin / User)**
- **Katalog Film & Jadwal Tayang**: UI modern dengan layout grid, *glassmorphism*, dan *hover effects*.
- **Live Seat Selection**: Pemilihan kursi bioskop secara visual (maks 8 kursi per transaksi).
- **Payment Gateway Midtrans**: Mendukung pembayaran *sandbox/production* via QRIS, GoPay, Virtual Account, dll.
- **Background Mailer**: Pengiriman email otomatis (menggunakan *queue worker*) ke pelanggan setelah pembayaran berhasil (tanpa lag di UI).
- **PDF E-Ticket Generator**: Pembuatan struk tiket bioskop digital beserta QR Code untuk *check-in* studio.
- **Admin Workspace**: Panel manajemen lengkap untuk CRUD Film dan Jadwal Tayang.
- **Cascading Soft Deletes**: Penghapusan data master (Film/Jadwal) dijamin tidak akan merusak riwayat transaksi pelanggan lama.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Frontend**: Blade Templating, TailwindCSS, Alpine.js
- **Database**: MySQL
- **Payments**: Midtrans PHP Client
- **PDF Generation**: DomPDF (Barryvdh)
- **Asset Bundler**: Vite

---

## 🚀 Panduan Instalasi (Untuk Developer)

Ikuti langkah-langkah di bawah ini untuk meng-*clone* dan menjalankan aplikasi di komputer (*local environment*) Anda.

### 1. Persiapan Awal
Pastikan Anda sudah menginstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- XAMPP / MySQL Database

### 2. Clone Repository & Install Dependencies
Buka terminal dan jalankan perintah berikut:
```bash
git clone <URL_REPOSITORY_ANDA> bioskop-app
cd bioskop-app

# Install dependency backend
composer install

# Install dependency frontend
npm install
```

### 3. Konfigurasi Environment (`.env`)
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Generate kunci aplikasi Laravel:
```bash
php artisan key:generate
```

Buka file `.env` dan atur konfigurasi berikut:

**A. Database:**
Buat database kosong di MySQL (misal: `bioskop_db`), lalu sesuaikan di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bioskop_db
DB_USERNAME=root
DB_PASSWORD=
```

**B. Midtrans (Payment Gateway):**
Buat akun Midtrans Sandbox, dapatkan kunci API-nya, dan masukkan:
```env
MIDTRANS_SERVER_KEY="SB-Mid-server-xxxxxxxxx"
MIDTRANS_CLIENT_KEY="SB-Mid-client-xxxxxxxxx"
MIDTRANS_IS_PRODUCTION=false
```

**C. Email SMTP (Untuk E-Ticket):**
Disarankan menggunakan Mailtrap untuk *testing local*:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username_mailtrap_anda
MAIL_PASSWORD=password_mailtrap_anda
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@bioskopku.com"
MAIL_FROM_NAME="BioskopKu Ticket"
```

**D. Konfigurasi Antrean (Queue):**
Pastikan queue menggunakan database agar *loading* pembayaran instan.
```env
QUEUE_CONNECTION=database
```

### 4. Setup Database & Assets
Jalankan migrasi untuk membuat seluruh tabel di database:
```bash
php artisan migrate
```

Hubungkan folder *storage* (agar gambar/poster bisa dibaca oleh *public*):
```bash
php artisan storage:link
```

Build semua aset *frontend* (Tailwind & JS) untuk produksi. (Ini membuat Anda tidak perlu terus-menerus menjalankan `npm run dev` saat presentasi/menjalankan aplikasi).
```bash
npm run build
```

---

## 🏃‍♂️ Menjalankan Aplikasi (Run Local)

Karena kita menggunakan sistem pengiriman email di *background* (`QUEUE_CONNECTION=database`), Anda wajib membuka **2 terminal** secara bersamaan.

**Terminal 1 (Menjalankan Web Server):**
```bash
php artisan serve
```

**Terminal 2 (Menjalankan Background Worker untuk Email):**
```bash
php artisan queue:work
```

Aplikasi kini dapat diakses di browser melalui URL: **`http://127.0.0.1:8000`**

---

## 👥 Akun Default

Jika Anda menjalankan *seeder* (jika ada) atau perlu membuat akun, Anda dapat mendaftar (*register*) seperti biasa di halaman web. 

**Untuk menjadikan sebuah akun sebagai Admin:**
1. Daftar melalui halaman registrasi web.
2. Buka *database GUI* (seperti phpMyAdmin).
3. Buka tabel `users`, cari akun Anda.
4. Ubah nilai kolom `role` menjadi `admin`.

---

*Project ini dikembangkan sebagai tugas UAS, mengusung standar penulisan kode (clean code) dan keamanan siber (security fixes terhadap celah mass-assignment dan IDOR).*
