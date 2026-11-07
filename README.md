# Modul 3 PPL: Automated Testing

### Konfigurasi Environment & Database
1. Salin file `.env.example` menjadi `.env`
2. Generate Application Key
3. Pastikan service **MySQL** sudah aktif. Buat database baru bernama `eisd_meowdopt`, atau biarkan terminal Laravel membuatnya secara otomatis saat proses migrasi.
4. Jalankan migrasi tabel sekaligus pengisian data awal (seeder)
5. Jalankan website di server lokal

## Daftar Skenario Test

Gunakan tabel skenario berikut sebagai acuan utama dalam menyusun file pengujian Dusk (`tests/Browser/`):

> **Konvensi notasi:** nama field merujuk ke atribut `name` HTML (contoh `name="password_confirmation"`), tombol/link ditulis sesuai teks yang tampil, dan elemen non-teks memakai selector CSS / `aria-label`.

| No | Skenario | Tujuan | Langkah Pengujian | Ekspektasi Hasil |
|:---:|---|---|---|---|
| **1** | **Registrasi Akun Adopter Berhasil** | Memastikan calon adopter baru dapat mendaftar melalui form registrasi dan diarahkan ke halaman login. | 1. Buka halaman `/register`.<br>2. Isi form registrasi`name`, `email`, `password` & `password_confirmation`(Minimal 8 karakter).<br>&nbsp;&nbsp;• Centang `cat_lover` (pernyataan pecinta kucing).<br>3. Klik tombol `Register`. | 1. Berpindah ke path `/login`.<br>2. Muncul pesan sukses: `Registrasi berhasil.` |
| **2** | **Login Adopter Berhasil** | Memastikan adopter yang telah terdaftar dapat login melalui form login dan masuk ke katalog kucing. | 1. Buka halaman `/login`.<br>2. Isi input `email` valid dan `password` valid.<br>3. Klik tombol `Login`. | 1. Berpindah ke path `/cats`.<br>2. Muncul notifikasi: `Login berhasil.`<br>3. Halaman memuat heading `Katalog Kucing Adopsi`. |
| **3** | **Tambah Pengajuan Adopsi Berhasil (Create)** | Memastikan alur pengajuan adopsi kucing oleh adopter tersimpan ke database. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Pilih satu kucing bebas (lihat tabel **Data Kucing** di bawah), buka halaman detailnya `/cats/{id}`, lalu klik link `Ajukan Adopsi`.<br>3. Isi form pengajuan secara lengkap:<br>&nbsp;&nbsp;• Isi `address`.<br>&nbsp;&nbsp;• Pilih `housing_type`.<br>&nbsp;&nbsp;• Pilih radio `experience`.<br>&nbsp;&nbsp;• Centang `indoor` dan `cost_commitment`.<br>4. Klik tombol `Kirim Pengajuan`. | 1. Form pengajuan menampilkan judul `Ajukan Adopsi {nama kucing}`.<br>2. Berpindah ke path riwayat `/adoptions`.<br>3. Muncul notifikasi: `Pengajuan adopsi berhasil dikirim.`<br>4. Nama kucing yang diajukan tampil di tabel riwayat. |
| **4** | **Lihat Katalog & Detail Kucing (Read)** | Memastikan katalog kucing tampil lengkap beserta informasi spesifikasi pada halaman detail. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman katalog `/cats`.<br>3. Verifikasi heading `Katalog Kucing Adopsi`.<br>4. Pilih satu kucing bebas (lihat tabel **Data Kucing**), lalu buka halaman detailnya `/cats/{id}`. | 1. Pada `/cats`: Tampil judul `Katalog Kucing Adopsi` dan daftar kartu kucing.<br>2. Berpindah ke path `/cats/{id}` kucing terpilih.<br>3. Halaman detail menampilkan nama, ras, sifat, umur, dan status vaksinasi sesuai tabel **Data Kucing**.<br><br>**Catatan:** Praktikan bebas membuka halaman detail kucing mana saja (`/cats/{id}`), lalu sesuaikan teks pengecekan dengan data kucing yang dipilih. |
| **5** | **Update Pengajuan Adopsi (Gagal)** | Memastikan validasi sistem menolak pembaruan pengajuan jika field alamat dikosongkan. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman riwayat pengajuan `/adoptions` dan pastikan pengajuan kucing dari Skenario 3 tampil di tabel.<br>3. Klik tombol pemicu menu aksi `button[aria-label='Aksi pengajuan']` pada baris pengajuan.<br>4. Tunggu menu `.aksi-menu` muncul, lalu klik tautan `Edit Pengajuan`.<br>5. Kosongkan field `address`.<br>6. Klik tombol `Perbarui Pengajuan`. | 1. Sistem tetap bertahan di halaman edit `/adoptions/{id}/edit` (data tidak terupdate).<br>2. Muncul pesan error validasi: `Alamat tempat tinggal wajib diisi.` |
| **6** | **Hapus Pengajuan Adopsi Berhasil (Delete)** | Memastikan adopter dapat membatalkan/menghapus pengajuan adopsi miliknya melalui dialog konfirmasi browser. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman riwayat `/adoptions`.<br>3. Klik tombol ikon hapus `button[aria-label='Hapus pengajuan']` pada baris pengajuan.<br>4. Tunggu dialog konfirmasi browser native muncul (`waitForDialog()`), lalu setujui dengan `acceptDialog()`. | 1. Halaman me-refresh di path `/adoptions`.<br>2. Muncul notifikasi: `Pengajuan adopsi berhasil dihapus.`<br>3. Nama kucing yang dihapus tidak lagi muncul di tabel riwayat. |
| **7** | **Logout Akun Berhasil** | Memastikan sesi user terhapus dan akun keluar dari sistem melalui menu akun navbar. | 1. Login menggunakan helper `$browser->loginAs($user)`.<br>2. Buka halaman `/cats`.<br>3. Klik tombol menu akun `button[aria-label='Menu akun']` pada navbar.<br>4. Tunggu dropdown `#user-dropdown` muncul, lalu klik tombol `Logout`. | 1. Berpindah ke halaman beranda `/`.<br>2. Muncul notifikasi: `Logout berhasil.`<br>3. Navbar kembali menampilkan tombol guest (`Login` dan `Register`). |

### Data Kucing

Data awal kucing hasil `php artisan migrate:fresh --seed`:

| id | Nama | Ras | Sifat | Umur | Vaksin |
|:---:|---|---|---|---|---|
| 1 | Belang | Kampung | Manja | 8 bulan | Sudah Vaksin |
| 2 | Chocho | Kampung | Mager | 12 bulan | Sudah Vaksin |
| 3 | Wolfy | Persia | Galak | 9 bulan | Sudah Vaksin |
| 4 | Ciko | Anggora | Manja | 7 bulan | Sudah Vaksin |
| 5 | Kimi | Persia | Mager | 10 bulan | Sudah Vaksin |
| 6 | Lui | Oren Barbar | Galak | 6 bulan | Belum Vaksin |

> **Catatan:** kucing yang sudah diajukan pada Skenario 3 langsung hilang dari katalog `/cats` dan tidak bisa diajukan lagi. Pada Skenario 4, pastikan yang dibuka adalah kucing yang masih tampil di katalog. Pada Skenario 6, nama kucing yang dicek dengan `assertDontSee` harus sama dengan kucing yang diajukan di Skenario 3.

---

## Test Case Scenario

> **Notation convention:** Field names refer to HTML `name` attributes (e.g. `name="password_confirmation"`), buttons/links match the exact text displayed on screen, and non-text elements use CSS selectors / `aria-label`.

| No | Scenario | Goal | Test Steps | Expected Result |
|:---:|---|---|---|---|
| **1** | **Successful Adopter Registration** | Verify that a new adopter can register and get redirected to the login page. | 1. Open `/register`.<br>2. Fill in form fields `name`, `email`, `password` & `password_confirmation` (min. 8 characters).<br>&nbsp;&nbsp;• Check `cat_lover` (cat lover statement).<br>3. Click the `Register` button. | 1. Redirect to `/login`.<br>2. Success message appears: `Registrasi berhasil.` |
| **2** | **Successful Adopter Login** | Verify that a registered adopter can log in and enter the cat catalog. | 1. Open `/login`.<br>2. Fill in valid `email` and `password`.<br>3. Click the `Login` button. | 1. Redirect to `/cats`.<br>2. Notification appears: `Login berhasil.`<br>3. Heading `Katalog Kucing Adopsi` is visible. |
| **3** | **Successful Adoption Request (Create)** | Verify that a cat adoption application submitted by an adopter is saved to the database. | 1. Log in with helper `$browser->loginAs($user)`.<br>2. Choose any cat (see the **Cat Data** table below), open its detail page `/cats/{id}`, then click the `Ajukan Adopsi` link.<br>3. Fill out the application form completely:<br>&nbsp;&nbsp;• Fill in `address`.<br>&nbsp;&nbsp;• Select `housing_type`.<br>&nbsp;&nbsp;• Choose radio `experience`.<br>&nbsp;&nbsp;• Check `indoor` and `cost_commitment`.<br>4. Click the `Kirim Pengajuan` button. | 1. The form shows the heading `Ajukan Adopsi {cat name}`.<br>2. Redirect to `/adoptions`.<br>3. Notification appears: `Pengajuan adopsi berhasil dikirim.`<br>4. The requested cat name appears in the history table. |
| **4** | **View Catalog & Cat Details (Read)** | Verify that the cat catalog displays properly with full profile details on the detail page. | 1. Log in with helper `$browser->loginAs($user)`.<br>2. Open `/cats`.<br>3. Verify heading `Katalog Kucing Adopsi`.<br>4. Choose any cat (see the **Cat Data** table below), then open its detail page `/cats/{id}`. | 1. On `/cats`: Displays heading `Katalog Kucing Adopsi` and cat cards.<br>2. Redirect to `/cats/{id}` of the selected cat.<br>3. The detail page shows name, breed, temperament, age, and vaccination status matching the **Cat Data** table.<br><br>**Note:** You are free to open any cat's detail page (`/cats/{id}`), then match the assertions with the selected cat's data. |
| **5** | **Update Adoption Request (Validation Fail)** | Verify that the system rejects the update when the address field is empty. | 1. Log in with helper `$browser->loginAs($user)`.<br>2. Open `/adoptions` and verify the cat from Scenario 3 appears in the table.<br>3. Click the action menu button `button[aria-label='Aksi pengajuan']` on an adoption row.<br>4. Wait for `.aksi-menu` to appear, then click `Edit Pengajuan`.<br>5. Clear the `address` field.<br>6. Click `Perbarui Pengajuan`. | 1. Page stays on `/adoptions/{id}/edit` (data is not updated).<br>2. Validation error appears: `Alamat tempat tinggal wajib diisi.` |
| **6** | **Successful Adoption Deletion (Delete)** | Verify that an adopter can cancel/delete their adoption request via native browser confirmation. | 1. Log in with helper `$browser->loginAs($user)`.<br>2. Open `/adoptions`.<br>3. Click the delete icon button `button[aria-label='Hapus pengajuan']` on an adoption row.<br>4. Wait for the native confirmation dialog (`waitForDialog()`), then accept it with `acceptDialog()`. | 1. Page refreshes at `/adoptions`.<br>2. Notification appears: `Pengajuan adopsi berhasil dihapus.`<br>3. The deleted cat name is no longer shown in the table. |
| **7** | **Successful Account Logout** | Verify that user session is cleared and the account logs out via navbar menu. | 1. Log in with helper `$browser->loginAs($user)`.<br>2. Open `/cats`.<br>3. Click the account menu button `button[aria-label='Menu akun']` on the navbar.<br>4. Wait for `#user-dropdown` to appear, then click `Logout`. | 1. Redirect to home `/`.<br>2. Notification appears: `Logout berhasil.`<br>3. Navbar shows guest buttons (`Login` and `Register`). |

### Cat Data

Initial cat data from `php artisan migrate:fresh --seed`:

| id | Name | Breed | Temperament | Age | Vaccine |
|:---:|---|---|---|---|---|
| 1 | Belang | Kampung | Manja | 8 bulan | Sudah Vaksin |
| 2 | Chocho | Kampung | Mager | 12 bulan | Sudah Vaksin |
| 3 | Wolfy | Persia | Galak | 9 bulan | Sudah Vaksin |
| 4 | Ciko | Anggora | Manja | 7 bulan | Sudah Vaksin |
| 5 | Kimi | Persia | Mager | 10 bulan | Sudah Vaksin |
| 6 | Lui | Oren Barbar | Galak | 6 bulan | Belum Vaksin |

> **Note:** a cat requested in Scenario 3 immediately disappears from the `/cats` catalog and cannot be requested again. In Scenario 4, make sure to open a cat that is still shown in the catalog. In Scenario 6, the cat name checked with `assertDontSee` must match the cat requested in Scenario 3.
