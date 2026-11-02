# Dokumentasi Codebase & Panduan UI/UX: EISD Meowdopt

Dokumen ini menjadi referensi teknis untuk modifikasi tampilan (UI/UX), penambahan aset (gambar/ikon), dan pengembangan fitur pada aplikasi **EISD Meowdopt** (Laravel 12) agar tetap kompatibel dengan skenario pengujian otomatis **Laravel Dusk**.

---

## 1. Struktur File Utama

Aplikasi ini menggunakan arsitektur **Zero-Build Frontend** (tanpa Node.js, tanpa npm, tanpa Vite/Tailwind compiler). Seluruh CSS dan JavaScript dimuat langsung dari folder `public/`.

```text
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php        # Login, Register, Logout
│   │   ├── CatController.php         # Dashboard katalog & CRUD kucing (Staff)
│   │   └── AdoptionController.php    # Pengajuan, edit, & konfirmasi adopsi (Adopter)
│   ├── Models/
│   │   ├── User.php                  # Role: 'adopter' (default) | 'staff'
│   │   ├── Cat.php                   # Konstanta BREEDS, TEMPERS, & scopeAvailable()
│   │   └── Adoption.php              # Konstanta HOUSING, EXPERIENCE, PENDING, DONE
│   └── Providers/
│       └── AppServiceProvider.php    # Definisi Gate 'staff' & 'adopter'
├── database/
│   ├── migrations/                   # Tabel users (+role), cats, adoptions
│   └── seeders/DatabaseSeeder.php    # Akun Staff, Adopter, & 3 kucing awal
├── public/
│   ├── css/app.css                   # Seluruh styling aplikasi (single stylesheet)
│   └── js/app.js                     # Menu dropdown, modal <dialog>, confirm, animasi
├── resources/views/
│   ├── layouts/app.blade.php         # Kerangka HTML utama, topbar, flash message
│   ├── welcome.blade.php             # Landing page publik (tema Daylight)
│   ├── auth/                         # login.blade.php & register.blade.php (tema Dusk)
│   ├── cats/                         # index (Dashboard), show, create, edit, _form
│   └── adoptions/                    # index, create, edit, _form
└── routes/web.php                    # Seluruh routing & proteksi middleware Gate
```

---

## 2. Arsitektur Backend & Hak Akses Aktor

### A. Aktor & Otorisasi (`AppServiceProvider.php`)
Sistem membedakan dua peran melalui kolom `users.role` dan Laravel Gate:
1. **Adopter (`role = 'adopter'`, Gate `can:adopter`):**
   - Peran default saat registrasi akun baru (`role` tidak dimasukkan ke `$fillable` pada `User.php` untuk mencegah manipulasi role saat register).
   - Melihat katalog bersih di `/cats`, membuka detail kucing `/cats/{cat}`, mengajukan adopsi di `/adoptions/create`, mengedit pengajuan, dan mengonfirmasi adopsi melalui modal.
2. **Staff Shelter (`role = 'staff'`, Gate `can:staff`):**
   - Mengelola inventaris kucing (`/cats/create`, `/cats/{cat}/edit`, `DELETE /cats/{cat}`).
   - Memantau seluruh daftar pengajuan masuk dari adopter di `/adoptions`.

### B. Alur Status Kucing & Adopsi
- **`Cat::scopeAvailable()` (`app/Models/Cat.php`):**
  Menyaring kucing yang belum memiliki pengajuan berstatus `Diadopsi` (`Adoption::DONE`).
- Saat adopter menekan tombol **Ya, Saya Siap** pada modal konfirmasi (`POST /adoptions/{adoption}/confirm`):
  1. `AdoptionController@confirm` memeriksa apakah pengajuan milik user tersebut dan kucing masih tersedia.
  2. Status pengajuan diubah dari `'Diajukan'` menjadi `'Diadopsi'`.
  3. Kucing tersebut otomatis tidak lagi muncul di katalog `/cats` maupun statistik landing page `/`.

### C. Konstanta Validasi Model
Jika ingin menambah pilihan dropdown atau radio di form, ubah konstanta pada model terkait (otomatis terpakai di migrasi, validasi controller, dan opsi Blade):
- **`App\Models\Cat`:**
  - `BREEDS = ['Kampung', 'Persia', 'Anggora', 'Oren Barbar']`
  - `TEMPERS = ['Manja', 'Mager', 'Galak']`
- **`App\Models\Adoption`:**
  - `HOUSING = ['Rumah Sendiri', 'Kos Ramah Hewan', 'Apartemen']`
  - `EXPERIENCE = ['Pemula', 'Pernah Pelihara', 'Punya Kucing Lain']`

---

## 3. Arsitektur Frontend & Sistem Tema (`public/css/app.css`)

Tampilan dibagi menjadi 3 tema melalui atribut `class` pada `<body>` di `resources/views/layouts/app.blade.php`:

| Halaman | Class `<body>` | Karakteristik Visual |
|---|---|---|
| **Landing Page (`/`)** | *(kosong)* | Latar belakang `.floral-bg` (animasi *bloom field* radial gradient) dengan tata letak editorial Daylight. |
| **Auth (`/login`, `/register`)** | `theme-dusk` | Tema sunset gelap, input transparan gelap, tombol utama putih bersih. |
| **Dashboard & App (Login)** | `theme-board` | Gaya Boostboard: latar abu hangat (`#ebe7e0`), kartu putih (`#fffdf8`) dengan sudut `22px`, dan navigasi kapsul hitam. |

### Daftar CSS Custom Properties (Design Tokens)
Ubah variabel di blok `:root` dan `.theme-board` pada `public/css/app.css` untuk mengganti skema warna secara global:
- `--surface: #fffdf8` (Warna latar kartu & permukaan utama)
- `--sunk: #efe8db` (Warna latar sekunder, header tabel, & kotak legenda)
- `--board-bg: #ebe7e0` (Warna latar halaman setelah login)
- `--board-ink: #141210` (Warna teks & tombol pill hitam pada dashboard)
- `--accent: #a8520a` & `--accent-hover: #8a4207` (Warna aksen utama)
- `--sun: #e0ad3a`, `--flame: #c2410c`, `--hatch: #6d4fc0` (Warna visualisasi grafik bar & lingkaran status)
- `--ok: #2f6b3a` & `--danger: #a3261b` (Warna badge sukses & pesan error)

---

## 4. Interaktivitas JavaScript (`public/js/app.js`)

Seluruh interaksi UI berjalan tanpa library eksternal:

1. **Menu Dropdown (`[data-menu-toggle]`):**
   - Tombol pemicu wajib memiliki atribut `data-menu-toggle`, `aria-expanded="false"`, dan `aria-controls="id-menu"`.
   - Elemen menu target menggunakan atribut `hidden`. Klik di luar menu atau tombol `Escape` otomatis menutup menu.
2. **Modal Konfirmasi Adopsi (`<dialog id="modal-confirm">`):**
   - Dipicu oleh tombol dengan atribut `data-confirm-url="..."` dan `data-confirm-cat="NamaKucing"`.
   - Script otomatis mengisi atribut `action` pada `<form>` di dalam modal, menyisipkan nama kucing ke seluruh elemen `[data-cat-name]`, lalu memanggil `modal.showModal()`.
   - Tombol dengan atribut `data-modal-close` atau klik pada area backdrop menutup modal.
3. **Konfirmasi Native Browser (`form[data-confirm]`):**
   - Digunakan pada form hapus kucing milik Staff (`data-confirm="Hapus ... dari katalog?"`). Saat form disubmit, script memanggil `window.confirm()` bawaan browser.

---

## 5. Kontrak Pengujian Dusk (JANGAN DIUBAH)

Agar seluruh 7 skenario pengujian otomatis Laravel Dusk tetap berjalan **PASS (Green)**, bagian berikut **tidak boleh dihapus atau diubah namanya** saat memodifikasi UI:

### A. URL & Route
- `/`, `/register`, `/login`, `/logout`, `/cats`, `/cats/{cat}`, `/adoptions`, `/adoptions/create`, `/adoptions/{adoption}/edit`, `/adoptions/{adoption}/confirm`.

### B. Selector & Atribut Elemen
| Komponen | Selector / Atribut Wajib | Lokasi File Blade |
|---|---|---|
| Tombol Menu Akun Navbar | `.user-icon-btn` | `resources/views/layouts/app.blade.php` |
| Link Navigasi & Aksi | Teks link: `Register`, `Detail`, `Ajukan Adopsi`, `Edit Pengajuan` | `welcome`, `cats/index`, `cats/show`, `adoptions/index` |
| Tombol Menu Titik Tiga Pengajuan | `button[aria-label='Aksi pengajuan']` | `resources/views/adoptions/index.blade.php` |
| Kontainer Dropdown Aksi | `.aksi-menu` | `cats/index.blade.php` & `adoptions/index.blade.php` |
| Tombol Buka Modal Konfirmasi | `button[aria-label='Konfirmasi adopsi']` | `resources/views/adoptions/index.blade.php` |
| Elemen Modal Konfirmasi | `#modal-confirm` | `resources/views/adoptions/index.blade.php` |
| Tombol Submit di Dalam Modal | Teks tombol: `Ya, Saya Siap` | `resources/views/adoptions/index.blade.php` |
| Tombol Hapus Kucing (Staff) | `button[aria-label='Hapus kucing']` pada `<form data-confirm="...">` | `resources/views/cats/index.blade.php` |

### C. Atribut `name` pada Input Form
- **Form Register (`auth/register.blade.php`):** `name`, `email`, `password`, `password_confirmation`, `cat_lover` (checkbox), tombol submit `Register`.
- **Form Login (`auth/login.blade.php`):** `email`, `password`, tombol submit `Login`.
- **Form Pengajuan Adopsi (`adoptions/_form.blade.php`):** `address` (text), `housing_type` (select), `experience` (radio), `indoor` (checkbox), `cost_commitment` (checkbox), tombol submit `Kirim Pengajuan` (create) dan `Perbarui Pengajuan` (edit).

### D. Teks Heading & Flash Message Wajib
- Heading katalog: `Katalog Kucing Adopsi`
- Heading modal: `Konfirmasi Adopsi <Nama Kucing>`
- Notifikasi flash (`session('status')`):
  - `Registrasi berhasil.`
  - `Login berhasil.`
  - `Pengajuan adopsi berhasil dikirim.`
  - `Data pengajuan berhasil diperbarui.`
  - `Selamat! Adopsi resmi selesai.`
  - `Kucing berhasil dihapus.`
  - `Logout berhasil.`

> **Tips Aman Modifikasi UI:** Kamu bebas mengubah warna, font, ukuran, tata letak grid/flexbox, menambahkan gambar/ilustrasi, atau menambah class CSS baru selama atribut `name`, `id`, `aria-label`, dan teks di atas tetap utuh.

---

## 6. Panduan Menambahkan Aset Baru (Gambar, Foto Kucing, Ikon)

1. **Tempat Penyimpanan:**
   Taruh seluruh file statis baru (PNG, JPG, WebP, SVG, atau font lokal) di dalam folder `public/`, misalnya:
   - `public/images/` untuk ilustrasi atau foto kucing.
   - `public/icons/` untuk file ikon.
2. **Cara Memanggil di Blade:**
   Gunakan helper `asset()` agar path selalu akurat di semua halaman:
   ```blade
   <img src="{{ asset('images/hero-cat.webp') }}" alt="Kucing shelter kampus" loading="lazy">
   ```
3. ** Cara Memanggil di CSS (`public/css/app.css`):**
   Gunakan path relatif terhadap posisi `public/css/app.css`:
   ```css
   .hero-illustration {
       background-image: url('../images/pattern.svg');
   }
   ```
4. **Standar Ikon:**
   Disarankan menggunakan **Inline SVG** dengan `fill="currentColor"` atau `stroke="currentColor"` supaya warna ikon otomatis mengikuti warna teks tombol/badge tanpa perlu membuat banyak file gambar.

---

## 7. Akun Seeder & Perintah Menjalankan Proyek

### A. Persiapan Awal
```bash
# 1. Jalankan migrasi dan isi data awal (seeder)
php artisan migrate:fresh --seed

# 2. Jalankan server lokal
php artisan serve
```

### B. Akun Login Bawaan (`DatabaseSeeder.php`)
| Role | Email | Password | Kegunaan Review UI |
|---|---|---|---|
| **Staff Shelter** | `staff@meowdopt.test` | `password` | Cek tampilan Panel Staff, form tambah/edit kucing, dialog hapus, & tabel pengajuan masuk. |
| **Adopter** | `adopter@meowdopt.test` | `password` | Cek tampilan Dashboard Adopter, detail kucing, form ajukan adopsi, & modal konfirmasi adopsi. |
