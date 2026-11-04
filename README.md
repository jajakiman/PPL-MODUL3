# Modul 3 PPL: Automated End-to-End Testing (Laravel Dusk)

Aplikasi **EISD Meowdopt** adalah platform sistem informasi shelter dan adopsi kucing kampus yang dikembangkan menggunakan **Laravel 12**. Repositori ini digunakan sebagai studi kasus praktikum **Modul 3 Praktikum Perangkat Lunak (PPL)** dengan fokus pengujian otomatis antarmuka web (*Browser / E2E Testing*) menggunakan **Laravel Dusk**.

---

## Setup

Ikuti tahapan berikut secara berurutan sebelum memulai pembuatan skenario pengujian:

### A. Clone & Install Dependencies
```bash
# 1. Masuk ke folder proyek setelah clone
cd PPL-MODUL3

# 2. Install dependensi PHP (Laravel)
composer install

# 3. Install Laravel Dusk untuk automated browser testing
composer require laravel/dusk --dev
php artisan dusk:install
```

### B. Konfigurasi Environment & Database
1. Salin file `.env.example` menjadi `.env`
2. Generate Application Key:
   ```bash
   php artisan key:generate
   ```
3. Pastikan service **MySQL (XAMPP / MariaDB)** sudah aktif di port `3306`. Buat database baru bernama `eisd_meowdopt`, atau biarkan terminal Laravel membuatnya secara otomatis saat proses migrasi.
4. Jalankan migrasi tabel sekaligus pengisian data awal (seeder):
   ```bash
   php artisan migrate --seed
   ```

### C. Running APP
Jalankan website di server lokal:
```bash
php artisan serve
```

---

## Akun Bawaan Seeder (`DatabaseSeeder.php`)

Gunakan akun berikut jika ingin melakukan pengecekan manual via browser:

| Role | Email | Password | Kegunaan |
|---|---|---|---|
| **Adopter** | `adopter@meowdopt.test` | `password` | Akun calon pengadopsi kucing. |
| **Staff Shelter** | `staff@meowdopt.test` | `password` | Akun pengelola shelter. |

---

## Daftar Skenario Pengujian Laravel Dusk

Gunakan tabel skenario berikut sebagai acuan utama dalam menyusun file pengujian Dusk (`tests/Browser/`):

| No | Skenario | Tujuan | Langkah Pengujian | Ekspektasi Hasil |
|:---:|---|---|---|---|
| **1** | **Registrasi Akun Adopter Berhasil** | Memastikan calon adopter baru dapat mendaftar melalui form registrasi dan diarahkan ke halaman login. | 1. Buka halaman `/register`.<br>2. Isi form registrasi`name`, `email`, `password` & `password_confirmation`(Minimal 8 karakter).<br>&nbsp;&nbsp;• Centang `cat_lover` (pernyataan pecinta kucing).<br>3. Klik tombol `Register`. | 1. Berpindah ke path `/login`.<br>2. Muncul pesan sukses: `Registrasi berhasil.`<br>3. Input email otomatis terisi dengan email yang didaftarkan. |
| **2** | **Login Adopter Berhasil** | Memastikan adopter yang telah terdaftar dapat login melalui form login dan masuk ke katalog kucing. | 1. Buka halaman `/login`.<br>2. Isi input `email` valid dan `password` valid.<br>3. Klik tombol `Login`. | 1. Berpindah ke path `/cats`.<br>2. Muncul notifikasi: `Login berhasil.`<br>3. Halaman memuat heading `Katalog Kucing Adopsi`. |
| **3** | **Tambah Pengajuan Adopsi Berhasil (Create)** | Memastikan alur pengajuan adopsi kucing oleh adopter tersimpan ke database. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman katalog `/cats`, lalu klik link `Ajukan Adopsi` pada kartu kucing.<br>3. Isi form pengajuan secara lengkap.<br>4. Klik tombol `Kirim Pengajuan`. | 1. Data pengajuan berhasil tersimpan.<br>2. Berpindah ke path riwayat `/adoptions`.<br>3. Muncul notifikasi: `Pengajuan adopsi berhasil dikirim.`<br>4. Baris data pengajuan kucing tampil di tabel riwayat. |
| **4** | **Lihat Katalog & Detail Kucing (Read)** | Memastikan katalog kucing tampil lengkap beserta informasi spesifikasi pada halaman detail. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman katalog `/cats`.<br>3. Verifikasi ketersediaan kartu kucing di katalog.<br>4. Klik tautan `Detail` pada salah satu kartu kucing. | 1. Pada `/cats`: Tampil judul `Katalog Kucing Adopsi` dan daftar kartu kucing.<br>2. Pada `/cats/{id}`: Menampilkan detail ras, sifat, umur, dan status vaksinasi kucing terpilih. |
| **5** | **Update Pengajuan Adopsi (Gagal)** | Memastikan validasi sistem menolak pembaruan data pengajuan jika input wajib dikosongkan. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman riwayat pengajuan `/adoptions`.<br>3. Klik tombol pemicu menu aksi `button[aria-label='Aksi pengajuan']` pada baris pengajuan.<br>4. Klik tautan `Edit Pengajuan` untuk membuka form edit.<br>5. Kosongkan alamat tempat tinggal.<br>6. Klik tombol `Perbarui Pengajuan`. | 1. Sistem membuka halaman edit `/adoptions/{id}/edit`.<br>2. Data tidak terupdate di database.<br>3. Sistem tetap bertahan di halaman edit (`/adoptions/{id}/edit`).<br>4. Muncul pesan error validasi: `Alamat tempat tinggal wajib diisi.` |
| **6** | **Hapus Pengajuan Adopsi Berhasil (Delete)** | Memastikan adopter dapat membatalkan/menghapus pengajuan adopsi miliknya melalui dialog konfirmasi browser. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman riwayat `/adoptions`.<br>3. Klik tombol `Hapus pengajuan`pada baris pengajuan.<br>4. Tangani dialog konfirmasi browser native menggunakan `$browser->acceptDialog()`. | 1. Data pengajuan terhapus dari database.<br>2. Halaman me-refresh di path `/adoptions`.<br>3. Muncul notifikasi: `Pengajuan adopsi berhasil dihapus.`<br>4. Baris pengajuan terkait tidak lagi muncul di tabel riwayat. |
| **7** | **Logout Akun Berhasil** | Memastikan sesi user terhapus dan akun keluar dari sistem melalui menu akun navbar. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman `/cats`.<br>3. Klik tombol menu profil akun pada navbar.<br>4. Klik tombol `Logout` pada menu dropdown yang terbuka. | 1. Pengguna keluar dari sesi terautentikasi.<br>2. Berpindah ke halaman beranda `/` (atau `/login`).<br>3. Muncul notifikasi: `Logout berhasil.`<br>4. Navbar kembali menampilkan tombol guest (`Login` dan `Register`). |
