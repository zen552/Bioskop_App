# BioskopKu

Sistem bioskop berbasis Laravel untuk pengelolaan film, jadwal tayang, pemesanan kursi, pembayaran, e-ticket, dan pemisahan akses admin-user.

## Gambaran Proyek

BioskopKu dibuat untuk mensimulasikan alur utama pada sistem bioskop modern, mulai dari pengguna melihat film, memilih jadwal, memilih kursi, melakukan pembayaran, hingga menerima e-ticket.  
Di sisi admin, sistem menyediakan panel terpisah untuk mengelola film dan jadwal tayang, serta mode live preview untuk melihat halaman user tanpa masuk ke alur transaksi.

## Fitur Utama

### User
- Register dan login user
- Landing page katalog film
- Halaman detail film dan jadwal tayang
- Pemilihan kursi
- Alur pembayaran
- Riwayat tiket melalui fitur `Tiket Saya`
- Halaman e-ticket dengan QR code

### Admin
- Login admin terpisah dari login user
- Dashboard admin
- CRUD film
- CRUD jadwal tayang
- Live preview halaman user dalam mode read-only
- Pembatasan akses admin agar tidak masuk ke flow pembelian user

## Tech Stack

- PHP 8.2+
- Laravel 12
- Laravel Breeze
- Blade
- Tailwind CSS
- Vite
- MySQL atau MariaDB
- Midtrans PHP SDK
- Simple QrCode

## Struktur Role

- `user`: dapat mengakses fitur penelusuran film, booking, pembayaran, dan history tiket
- `admin`: dapat mengakses panel admin, kelola film, kelola jadwal, dan live preview user

## Akun Seeder Default

### Admin
- Email: `admin@bioskop.com`
- Password: `password123`

### User
- Email: `test@example.com`
- Password: `password`

## Setup Project

### 1. Clone repository

```bash
git clone https://github.com/zen552/Bioskop_App.git
cd Bioskop_App
```

### 2. Install dependency PHP

```bash
composer install
```

### 3. Install dependency frontend

```bash
npm install
```

### 4. Salin file environment

```bash
copy .env.example .env
```

Jika memakai Git Bash atau terminal Unix-like:

```bash
cp .env.example .env
```

### 5. Atur konfigurasi `.env`

Minimal sesuaikan bagian berikut:

```env
APP_NAME=BioskopKu
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost/Bioskop_App/public

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bioskop_app
DB_USERNAME=root
DB_PASSWORD=
```

Catatan:
- Jika project dijalankan dari folder `c:\wamp64\www\Bioskop_App`, gunakan `APP_URL=http://localhost/Bioskop_App/public`
- Jika sudah dikonfigurasi ke virtual host tanpa `/public`, sesuaikan `APP_URL` dengan domain lokal kamu

### 6. Generate application key

```bash
php artisan key:generate
```

### 7. Buat database

Buat database baru, misalnya:

```sql
CREATE DATABASE bioskop_app;
```

### 8. Jalankan migration

```bash
php artisan migrate
```

### 9. Jalankan seeder

Jika ingin akun default tersedia:

```bash
php artisan db:seed --class=DatabaseSeeder
php artisan db:seed --class=AdminSeeder
```

Atau jalankan keduanya sekaligus bila sudah dihubungkan sesuai kebutuhan:

```bash
php artisan db:seed
```

### 10. Pastikan symbolic link storage tersedia

```bash
php artisan storage:link
```

Langkah ini penting agar poster film dapat tampil dengan benar.

### 11. Jalankan Vite

Untuk development:

```bash
npm run dev
```

Untuk build production:

```bash
npm run build
```

### 12. Jalankan server Laravel

```bash
php artisan serve
```

Jika menggunakan WAMP, kamu juga bisa langsung membuka project dari:

```text
http://localhost/Bioskop_App/public
```

## Route Penting

### User
- `/`
- `/login`
- `/register`
- `/films/{film}`
- `/booking/seats/{schedule}`
- `/pembayaran/{order_id}`
- `/tiket-saya`

### Admin
- `/admin/login`
- `/admin/dashboard`
- `/admin/films`
- `/admin/schedules`
- `/admin/preview`

## Alur Penggunaan

### User Flow
1. User membuka landing page
2. User memilih film
3. User memilih jadwal
4. User memilih kursi
5. User masuk ke pembayaran
6. User menerima e-ticket
7. User melihat riwayat melalui `Tiket Saya`

### Admin Flow
1. Admin login melalui `/admin/login`
2. Admin membuka dashboard admin
3. Admin mengelola film atau jadwal
4. Admin membuka live preview user untuk verifikasi tampilan

## Catatan Penting

- Login admin dan login user dipisahkan
- Register hanya untuk user
- Admin tidak dapat mengakses flow booking, pembayaran, dan e-ticket user
- Live preview admin bersifat read-only
- URL poster film dipengaruhi oleh `APP_URL` dan `storage:link`

## Perintah Berguna

```bash
php artisan route:list
php artisan migrate:fresh --seed
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan storage:link
```

## Troubleshooting

### Poster film tidak muncul
- Pastikan `php artisan storage:link` sudah dijalankan
- Pastikan `APP_URL` sesuai dengan URL project yang dipakai
- Pastikan file poster benar-benar ada di `storage/app/public/posters`

### Admin tidak bisa login
- Gunakan route `/admin/login`
- Pastikan akun admin ada di database
- Jalankan `AdminSeeder` bila perlu

### User tidak bisa login
- Gunakan route `/login`
- Pastikan akun user ada di database
- Jalankan `DatabaseSeeder` bila perlu

## Status Pengembangan

Project ini sedang dikembangkan bertahap dengan pembagian sprint:
- Sprint 1: Admin Authority
- Sprint 2: User View
- Sprint 3: Payment
- Sprint 4: Features

## License

Project ini dibuat untuk kebutuhan pembelajaran dan pengembangan sistem bioskop.
