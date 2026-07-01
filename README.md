# Mini ERP - MoneyTrack

Aplikasi pencatatan keuangan dan pengelolaan aset (inventory) sederhana yang dibangun menggunakan Laravel 11. Aplikasi ini memiliki desain minimalis, interaktif, dan mudah digunakan untuk pemula yang ingin belajar pengembangan web.

## Fitur Utama

1. **Dashboard Analytics**:
   - Menampilkan total saldo, total pemasukan, dan total pengeluaran.
   - Grafik interaktif menggunakan **Chart.js** untuk melihat tren arus kas (30 hari terakhir) dan distribusi pengeluaran berdasarkan kategori.
   - Panel aktivitas transaksi terbaru.
2. **Manajemen Kategori**:
   - Menambahkan dan mengedit kategori untuk pemasukan (`income`) maupun pengeluaran (`expense`).
   - Sistem keamanan yang memblokir penghapusan kategori jika masih digunakan oleh transaksi aktif.
3. **Manajemen Transaksi**:
   - Mencatat transaksi dengan tanggal, deskripsi, kategori, dan nominal.
   - Fitur upload foto/file kuitansi (*receipt*) serta melihatnya kembali secara langsung.
4. **Vault Aset (Inventory)**:
   - Mencatat pendaftaran aset baru (otomatis mengurangi kas pembelian) beserta kuitansi pembeliannya.
   - Melakukan penjualan aset (otomatis menambah kas hasil penjualan) beserta kuitansi penjualannya.
   - Menghitung keuntungan bersih dari penjualan aset secara otomatis.
   - Sistem hapus berantai (*cascade delete*) yang secara aman menghapus transaksi & berkas foto terkait ketika data aset dihapus.
5. **Laporan Keuangan & Ekspor PDF**:
   - Menyaring transaksi keuangan berdasarkan periode tanggal tertentu.
   - Mengekspor laporan keuangan yang informatif ke dalam format berkas PDF dengan tabel dan ringkasan metrik yang rapi.
6. **Autentikasi Sederhana**:
   - Sistem login dan logout menggunakan fitur bawaan Laravel (`Auth`).

---

## Spesifikasi Teknologi

- **Backend**: Laravel 11 & PHP 8.2+
- **Frontend**: Blade Templates, TailwindCSS, Chart.js (CDN)
- **Database**: MySQL / MariaDB
- **Ekspor PDF**: Barryvdh Laravel-DomPDF

---

## Cara Instalasi & Menjalankan Projek

Ikuti langkah-langkah berikut untuk menjalankan projek ini di komputer lokal Anda:

1. **Salin / Pindahkan Projek** ke dalam folder web server Anda (misalnya di `C:\laragon\www\mini-erp-projek`).
2. **Buka Terminal** di direktori projek tersebut dan jalankan perintah untuk mengunduh semua dependency PHP:
   ```bash
   composer install
   ```
3. **Salin File Environment**:
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
4. **Konfigurasi Database** di dalam file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=root
   DB_PASSWORD=
   ```
5. **Jalankan Migrasi & Suntik Data Dummy** (10 data simulasi lengkap beserta kategori):
   ```bash
   php artisan migrate --seed
   ```
6. **Jalankan Aplikasi**:
   Jika menggunakan Laragon, aplikasi bisa langsung diakses melalui alamat virtual host (misalnya `http://mini-erp-projek.test`). Jika menggunakan php server biasa, jalankan:
   ```bash
   php artisan serve
   ```
   Lalu buka alamat `http://127.0.0.1:8000` di browser Anda.

---

## Akun Login Dummy (Default)

Setelah melakukan seeder di atas, Anda dapat login menggunakan akun pengujian berikut:
- **Email**: `sifen@example.com`
- **Password**: `fnbao`
