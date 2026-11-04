# EISD Meowdopt — Modul 3 PPL: Automated End-to-End Testing (Laravel Dusk)

Aplikasi **EISD Meowdopt** adalah platform sistem informasi shelter dan adopsi kucing kampus yang dikembangkan menggunakan **Laravel 12**. Repositori ini digunakan sebagai studi kasus praktikum **Modul 3 Praktikum Perangkat Lunak (PPL)** dengan fokus pengujian otomatis antarmuka web (*Browser / E2E Testing*) menggunakan **Laravel Dusk**.

---

## 1. Setup

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
1. Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   # Pada Windows PowerShell:
   copy .env.example .env
   ```
2. Generate Application Key:
   ```bash
   php artisan key:generate
   ```
3. Pastikan service **MySQL (XAMPP / MariaDB)** sudah aktif di port `3306`. Buat database baru bernama `eisd_meowdopt`, atau biarkan terminal Laravel membuatnya secara otomatis saat proses migrasi.
4. Jalankan migrasi tabel sekaligus pengisian data awal (seeder):
   ```bash
   php artisan migrate --seed
   # Catatan: Bila ingin mereset ulang seluruh tabel & data dari awal kapan saja:
   # php artisan migrate:fresh --seed
   ```

### C. Running APP
```bash
# Jalankan server lokal aplikasi di terminal 1:
php artisan serve

# Jalankan seluruh skenario pengujian Laravel Dusk di terminal 2:
php artisan dusk
```

---

## 2. Akun Bawaan Seeder (`DatabaseSeeder.php`)

Gunakan akun berikut jika ingin melakukan pengecekan manual via browser:

| Role | Email | Password | Kegunaan |
|---|---|---|---|
| **Adopter** | `adopter@meowdopt.test` | `password` | Akun calon pengadopsi kucing (Katalog, Pengajuan Adopsi, Riwayat). |
| **Staff Shelter** | `staff@meowdopt.test` | `password` | Akun pengelola shelter (Inventaris kucing, Daftar pengajuan masuk). |

---

## 3. Daftar Skenario Pengujian Laravel Dusk

Gunakan tabel skenario berikut sebagai acuan utama dalam menyusun file pengujian Dusk (`tests/Browser/`):

| No | Skenario | Tujuan | Langkah Pengujian | Ekspektasi Hasil |
|:---:|---|---|---|---|
| **1** | **Registrasi Akun Adopter Berhasil** | Memastikan calon adopter baru dapat mendaftar melalui form registrasi dan diarahkan ke halaman login. | 1. Buka halaman `/register`.<br>2. Isi form registrasi:<br>&nbsp;&nbsp;• `name`: Nama lengkap adopter baru.<br>&nbsp;&nbsp;• `email`: Email unik baru.<br>&nbsp;&nbsp;• `password` & `password_confirmation`: Minimal 8 karakter.<br>&nbsp;&nbsp;• Centang `cat_lover` (pernyataan pecinta kucing).<br>3. Klik tombol `Register`. | 1. Berpindah ke path `/login`.<br>2. Muncul pesan sukses: `Registrasi berhasil.`<br>3. Input email otomatis terisi dengan email yang didaftarkan. |
| **2** | **Login Adopter Berhasil** | Memastikan adopter yang telah terdaftar dapat login melalui form login dan masuk ke katalog kucing. | 1. Buka halaman `/login`.<br>2. Isi input `email` valid dan `password` valid.<br>3. Klik tombol `Login`. | 1. Berpindah ke path `/cats`.<br>2. Muncul notifikasi: `Login berhasil.`<br>3. Halaman memuat heading `Katalog Kucing Adopsi`. |
| **3** | **Tambah Pengajuan Adopsi Berhasil (Create)** | Memastikan alur pengajuan adopsi kucing oleh adopter tersimpan ke database. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman katalog `/cats`, lalu klik tautan `Ajukan Adopsi` pada kartu kucing (atau akses `/adoptions/create?cat={id}`).<br>3. Isi form pengajuan secara lengkap:<br>&nbsp;&nbsp;• `address`: Alamat domisili.<br>&nbsp;&nbsp;• `housing_type`: Pilih salah satu tipe hunian (dropdown).<br>&nbsp;&nbsp;• `experience`: Pilih pengalaman memelihara (radio button).<br>&nbsp;&nbsp;• `indoor`: Centang kesiapan merawat dalam ruangan.<br>&nbsp;&nbsp;• `cost_commitment`: Centang komitmen biaya pakan/vaksin.<br>4. Klik tombol `Kirim Pengajuan`. | 1. Data pengajuan berhasil tersimpan.<br>2. Berpindah ke path riwayat `/adoptions`.<br>3. Muncul notifikasi: `Pengajuan adopsi berhasil dikirim.`<br>4. Baris data pengajuan kucing tampil di tabel riwayat. |
| **4** | **Lihat Katalog & Detail Kucing (Read)** | Memastikan katalog kucing tampil lengkap beserta informasi spesifikasi pada halaman detail. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman katalog `/cats`.<br>3. Verifikasi ketersediaan kartu kucing di katalog.<br>4. Klik tautan `Detail` pada salah satu kartu kucing. | 1. Pada `/cats`: Tampil judul `Katalog Kucing Adopsi` dan daftar kartu kucing.<br>2. Pada `/cats/{id}`: Menampilkan detail ras, sifat, umur, dan status vaksinasi kucing terpilih. |
| **5** | **Update Pengajuan Adopsi Gagal (Test Negatif)** | Memastikan validasi sistem menolak pembaruan data pengajuan jika input wajib dikosongkan. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman riwayat pengajuan `/adoptions`.<br>3. Klik tombol pemicu menu aksi `button[aria-label='Aksi pengajuan']` pada baris pengajuan.<br>4. Klik tautan `Edit Pengajuan` (`clickLink('Edit Pengajuan')`) untuk membuka form edit.<br>5. Kosongkan nilai pada input alamat tempat tinggal (`name="address"`).<br>6. Klik tombol `Perbarui Pengajuan`. | 1. Sistem membuka halaman edit `/adoptions/{id}/edit`.<br>2. Data tidak terupdate di database.<br>3. Sistem tetap bertahan di halaman edit (`/adoptions/{id}/edit`).<br>4. Muncul pesan error validasi: `Alamat tempat tinggal wajib diisi.` |
| **6** | **Hapus Pengajuan Adopsi Berhasil (Delete)** | Memastikan adopter dapat membatalkan/menghapus pengajuan adopsi miliknya melalui dialog konfirmasi browser. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman riwayat `/adoptions`.<br>3. Klik tombol pemicu menu aksi `button[aria-label='Aksi pengajuan']`.<br>4. Klik tombol `Hapus pengajuan` (`button[aria-label='Hapus pengajuan']`).<br>5. Tangani dialog konfirmasi browser native menggunakan `$browser->acceptDialog()`. | 1. Data pengajuan terhapus dari database.<br>2. Halaman me-refresh di path `/adoptions`.<br>3. Muncul notifikasi: `Pengajuan adopsi berhasil dihapus.`<br>4. Baris pengajuan terkait tidak lagi muncul di tabel riwayat. |
| **7** | **Logout Akun Berhasil** | Memastikan sesi user terhapus dan akun keluar dari sistem melalui menu akun navbar. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman `/cats`.<br>3. Klik tombol menu profil akun pada navbar (`button.user-icon-btn` atau `aria-label="Menu akun"`).<br>4. Klik tombol `Logout` pada menu dropdown yang terbuka. | 1. Pengguna keluar dari sesi terautentikasi.<br>2. Berpindah ke halaman beranda `/` (atau `/login`).<br>3. Muncul notifikasi: `Logout berhasil.`<br>4. Navbar kembali menampilkan tombol guest (`Login` dan `Register`). |
