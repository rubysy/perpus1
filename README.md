# Panduan Setup Project Perpustakaan (Laravel 12)

Dokumen ini berisi langkah-langkah detail untuk menginstal dan menjalankan project Web Perpustakaan di perangkat lokal/server. Pastikan mengikuti langkah-langkah di bawah ini secara berurutan untuk menghindari error saat menjalankan program.

## 📋 Persyaratan Minimum Sistem
Sebelum memulai, pastikan perangkat Anda sudah terinstal perangkat lunak berikut dengan versi yang disarankan:

- **PHP**: versi `8.2` atau lebih baru (Disarankan versi `8.3`)
- **Composer**: versi `2.7` atau lebih baru
- **Node.js**: versi `20.x` atau lebih baru
- **NPM**: versi `10.x` atau lebih baru
- **MySQL/MariaDB**: via XAMPP / Laragon

> **Catatan:** Project ini dikembangkan menggunakan Laravel versi 12.

---

## 🛠️ Langkah-langkah Instalasi (Wajib lakuin semua)

### 1. Ekstrak / Clone Project
Jika Anda mendapatkan file dalam bentuk zip, ekstrak terlebih dahulu ke folder web server Anda (contoh: `c:\laragon\www` atau `c:\xampp\htdocs`). Jika via git:
```bash
git clone https://github.com/rubysy/perpus1.git
cd perpus1
```

### 2. Install Dependensi PHP (Vendor)
Buka terminal/Command Prompt, arahkan ke dalam folder project, lalu jalankan perintah:
```bash
composer install
```
*Proses ini akan men-download semua library PHP yang dibutuhkan oleh Laravel ke folder `vendor/`. Pastikan koneksi internet stabil.*

### 3. Install Dependensi Node.js (Node Modules)
Setelah composer selesai, jalankan perintah berikut untuk menginstal library Javascript dan CSS (seperti TailwindCSS):
```bash
npm install
```
*Proses ini akan men-download kebutuhan frontend ke folder `node_modules/`.*

### 4. Setup File Environment (.env)
1. Copy file konfigurasi default dengan menjalankan perintah:
```bash
cp .env.example .env
```
*(Atau Anda bisa copy-paste file `.env.example` secara manual dan rename hasil copy-nya menjadi `.env`)*

2. Buka file `.env` dengan text editor, lalu sesuaikan bagian konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpus_1   # Ganti dengan nama database yang Anda buat
DB_USERNAME=root       # Sesuaikan dengan username db lokal Anda
DB_PASSWORD=           # Kosongkan jika menggunakan XAMPP/Laragon bawaan
```

### 5. Generate Application Key 
Jalankan perintah ini untuk membuat enkripsi unik (APP_KEY) untuk aplikasi:
```bash
php artisan key:generate
```

### 6. Setup Database & Migration
1. Buka phpMyAdmin (atau aplikasi database manager lainnya) dan buat database kosong dengan nama sesuai yang Anda tulis di `DB_DATABASE` (contoh: `perpus_1`).
2. Kembali ke terminal, jalankan perintah migrasi ini untuk membuat tabel otomatis beserta data awal (Seeder seperti akun Admin standar):
```bash
php artisan migrate:fresh --seed
```

### 7. Hubungkan Folder Storage untuk Foto/Gambar (PENTING!)
Agar gambar (seperti cover buku dan foto profil) yang di-upload bisa ditampilkan, Anda **wajib** menjalankan perintah ini:
```bash
php artisan storage:link
```
*Jika tidak dijalankan, gambar tidak akan muncul di website.*

### 8. Jalankan Server Lokal
Untuk menjalankan project, Anda perlu membuka **dua terminal/CMD berbeda**.

**Terminal 1 (Jalankan Backend Laravel):**
```bash
php artisan serve
```

**Terminal 2 (Jalankan Frontend Vite/Tailwind):**
```bash
npm run dev
```

🌐 **Selesai!** Sekarang buka browser dan akses aplikasi melalui `http://localhost:8000` atau `http://perpus-1.test` jika menggunakan Laragon.

---

## 🐞 Solusi Troubleshooting (Jika Terjadi Error)

1. **Error: `No application encryption key has been specified.`**
   *Solusi:* Ingat untuk copy file `.env.example` ke `.env` dan jalankan `php artisan key:generate`.

2. **Error: Gambar/Cover Buku Tidak Muncul (Broken Image)**
   *Solusi:* Buka terminal dan jalankan ulang `php artisan storage:link`. Jika muncul pesan symlink already exists, hapus manual folder `public/storage` lalu jalankan perintah tadi lagi.

3. **Error: Tampilan Berantakan / CSS Tidak Termuat / Halaman Putih Terus Loading**
   *Solusi:* Pastikan Anda sudah menjalankan `npm run dev` di terminal secara bersamaan saat Anda membuka web.

4. **Error: `SQLSTATE[HY000] [1049] Unknown database 'perpus_1'`**
   *Solusi:* Anda belum membuat database kosong di phpMyAdmin atau nama database di config MySQL berbeda dengan yang ada di file `.env`. Pastikan namanya sama.

5. **Error saat `composer install` (Versi PHP tidak cocok)**
   *Solusi:* Laravel 12 membutuhkan minimal PHP 8.2. Jika Anda masih menggunakan XAMPP versi lama (PHP 7.4 / 8.0 / 8.1), silakan update/dowload versi XAMPP terbaru yang menggunakan PHP 8.2 atau 8.3.
