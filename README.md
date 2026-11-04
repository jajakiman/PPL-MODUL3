# Modul 3 PPL: Automated End-to-End Testing (Laravel Dusk)

Aplikasi **EISD Meowdopt** adalah platform sistem informasi shelter dan adopsi kucing kampus yang dikembangkan menggunakan **Laravel 12**. Repositori ini digunakan sebagai studi kasus praktikum **Modul 3 Praktikum Perangkat Lunak (PPL)** dengan fokus pengujian otomatis antarmuka web (*Browser / E2E Testing*) menggunakan **Laravel Dusk**.

### Test Case Scenario
[Reg](##daftar-skenario-test)
[INT](##test-case-scenario)
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

## Daftar Skenario Test

Gunakan tabel skenario berikut sebagai acuan utama dalam menyusun file pengujian Dusk (`tests/Browser/`):

> **Konvensi notasi:** nama field merujuk ke atribut `name` HTML (contoh `name="password_confirmation"`), tombol/link ditulis sesuai teks yang tampil, dan elemen non-teks memakai selector CSS / `aria-label`.

| No | Skenario | Tujuan | Langkah Pengujian | Ekspektasi Hasil |
|:---:|---|---|---|---|
| **1** | **Registrasi Akun Adopter Berhasil** | Memastikan calon adopter baru dapat mendaftar melalui form registrasi dan diarahkan ke halaman login. | 1. Buka halaman `/register`.<br>2. Isi form registrasi`name`, `email`, `password` & `password_confirmation`(Minimal 8 karakter).<br>&nbsp;&nbsp;• Centang `cat_lover` (pernyataan pecinta kucing).<br>3. Klik tombol `Register`. | 1. Berpindah ke path `/login`.<br>2. Muncul pesan sukses: `Registrasi berhasil.`<br>3. Input email otomatis terisi dengan email yang didaftarkan. |
| **2** | **Login Adopter Berhasil** | Memastikan adopter yang telah terdaftar dapat login melalui form login dan masuk ke katalog kucing. | 1. Buka halaman `/login`.<br>2. Isi input `email` valid dan `password` valid.<br>3. Klik tombol `Login`. | 1. Berpindah ke path `/cats`.<br>2. Muncul notifikasi: `Login berhasil.`<br>3. Halaman memuat heading `Katalog Kucing Adopsi`. |
| **3** | **Tambah Pengajuan Adopsi Berhasil (Create)** | Memastikan alur pengajuan adopsi kucing oleh adopter tersimpan ke database. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman katalog `/cats`, lalu klik link `Ajukan Adopsi` pada kartu kucing.<br>3. Isi form pengajuan secara lengkap.<br>4. Klik tombol `Kirim Pengajuan`. | 1. Data pengajuan berhasil tersimpan.<br>2. Berpindah ke path riwayat `/adoptions`.<br>3. Muncul notifikasi: `Pengajuan adopsi berhasil dikirim.`<br>4. Baris data pengajuan kucing tampil di tabel riwayat. |
| **4** | **Lihat Katalog & Detail Kucing (Read)** | Memastikan katalog kucing tampil lengkap beserta informasi spesifikasi pada halaman detail. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman katalog `/cats`.<br>3. Verifikasi ketersediaan kartu kucing di katalog.<br>4. Klik tautan `Detail` pada salah satu kartu kucing. | 1. Pada `/cats`: Tampil judul `Katalog Kucing Adopsi` dan daftar kartu kucing.<br>2. Pada `/cats/{id}`: Menampilkan detail ras, sifat, umur, dan status vaksinasi kucing terpilih. |
| **5** | **Update Pengajuan Adopsi (Gagal)** | Memastikan validasi sistem menolak pembaruan data pengajuan jika input wajib dikosongkan. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman riwayat pengajuan `/adoptions`.<br>3. Klik tombol pemicu menu aksi `button[aria-label='Aksi pengajuan']` pada baris pengajuan.<br>4. Klik tautan `Edit Pengajuan` untuk membuka form edit.<br>5. Kosongkan alamat tempat tinggal.<br>6. Klik tombol `Perbarui Pengajuan`. | 1. Sistem membuka halaman edit `/adoptions/{id}/edit`.<br>2. Data tidak terupdate di database.<br>3. Sistem tetap bertahan di halaman edit (`/adoptions/{id}/edit`).<br>4. Muncul pesan error validasi: `Alamat tempat tinggal wajib diisi.` |
| **6** | **Hapus Pengajuan Adopsi Berhasil (Delete)** | Memastikan adopter dapat membatalkan/menghapus pengajuan adopsi miliknya melalui dialog konfirmasi browser. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman riwayat `/adoptions`.<br>3. Klik tombol `Hapus pengajuan`pada baris pengajuan.<br>4. Tangani dialog konfirmasi browser native menggunakan `$browser->acceptDialog()`. | 1. Data pengajuan terhapus dari database.<br>2. Halaman me-refresh di path `/adoptions`.<br>3. Muncul notifikasi: `Pengajuan adopsi berhasil dihapus.`<br>4. Baris pengajuan terkait tidak lagi muncul di tabel riwayat. |
| **7** | **Logout Akun Berhasil** | Memastikan sesi user terhapus dan akun keluar dari sistem melalui menu akun navbar. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman `/cats`.<br>3. Klik tombol menu profil akun pada navbar.<br>4. Klik tombol `Logout` pada menu dropdown yang terbuka. | 1. Pengguna keluar dari sesi terautentikasi.<br>2. Berpindah ke halaman beranda `/` (atau `/login`).<br>3. Muncul notifikasi: `Logout berhasil.`<br>4. Navbar kembali menampilkan tombol guest (`Login` dan `Register`). |

---

## Test Case Scenario

> **Notation convention:** Field names refer to HTML `name` attributes (e.g. `name="password_confirmation"`), buttons/links match the exact text displayed on screen, and non-text elements use CSS selectors / `aria-label`.

| No | Scenario | Goal | Test Steps | Expected Result |
|:---:|---|---|---|---|
| **1** | **Successful Adopter Registration** | Verify that a new adopter can register and get redirected to the login page. | 1. Open `/register`.<br>2. Fill in form fields `name`, `email`, `password` & `password_confirmation` (min. 8 characters).<br>&nbsp;&nbsp;• Check `cat_lover` (cat lover statement).<br>3. Click the `Register` button. | 1. Redirect to `/login`.<br>2. Success message appears: `Registrasi berhasil.`<br>3. Email input is auto-filled with the registered email. |
| **2** | **Successful Adopter Login** | Verify that a registered adopter can log in and enter the cat catalog. | 1. Open `/login`.<br>2. Fill in valid `email` and `password`.<br>3. Click the `Login` button. | 1. Redirect to `/cats`.<br>2. Notification appears: `Login berhasil.`<br>3. Heading `Katalog Kucing Adopsi` is visible. |
| **3** | **Successful Adoption Request (Create)** | Verify that a cat adoption application submitted by an adopter is saved to the database. | 1. Log in with helper `$browser->loginAs($user)`.<br>2. Open `/cats`, then click `Ajukan Adopsi` on a cat card.<br>3. Fill out the application form completely.<br>4. Click the `Kirim Pengajuan` button. | 1. Application data is saved.<br>2. Redirect to `/adoptions`.<br>3. Notification appears: `Pengajuan adopsi berhasil dikirim.`<br>4. The new adoption row appears in the history table. |
| **4** | **View Catalog & Cat Details (Read)** | Verify that the cat catalog displays properly with full profile details on the detail page. | 1. Log in with helper `$browser->loginAs($user)`.<br>2. Open `/cats`.<br>3. Verify available cat cards in the catalog.<br>4. Click the `Detail` link on a cat card. | 1. On `/cats`: Displays heading `Katalog Kucing Adopsi` and cat cards.<br>2. On `/cats/{id}`: Displays breed, temperament, age, and vaccination status. |
| **5** | **Update Adoption Request (Validation Fail)** | Verify that the system rejects updates when required fields are empty. | 1. Log in with helper `$browser->loginAs($user)`.<br>2. Open `/adoptions`.<br>3. Click the action menu button `button[aria-label='Aksi pengajuan']` on an adoption row.<br>4. Click `Edit Pengajuan` to open the edit form.<br>5. Clear the address input.<br>6. Click `Perbarui Pengajuan`. | 1. Opens edit page `/adoptions/{id}/edit`.<br>2. Data is not updated in the database.<br>3. Page stays on `/adoptions/{id}/edit`.<br>4. Validation error appears: `Alamat tempat tinggal wajib diisi.` |
| **6** | **Successful Adoption Deletion (Delete)** | Verify that an adopter can cancel/delete their adoption request via native browser confirmation. | 1. Log in with helper `$browser->loginAs($user)`.<br>2. Open `/adoptions`.<br>3. Click `Hapus pengajuan` on an adoption row.<br>4. Handle the native confirmation dialog using `$browser->acceptDialog()`. | 1. Adoption is deleted from the database.<br>2. Page refreshes at `/adoptions`.<br>3. Notification appears: `Pengajuan adopsi berhasil dihapus.`<br>4. The deleted row is no longer shown in the table. |
| **7** | **Successful Account Logout** | Verify that user session is cleared and the account logs out via navbar menu. | 1. Log in with helper `$browser->loginAs($user)`.<br>2. Open `/cats`.<br>3. Click account menu button on the navbar.<br>4. Click `Logout` in the dropdown menu. | 1. User logs out.<br>2. Redirect to home `/` (or `/login`).<br>3. Notification appears: `Logout berhasil.`<br>4. Navbar shows guest buttons (`Login` and `Register`). |
