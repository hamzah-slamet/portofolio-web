# Web Portfolio Dinamis

Aplikasi portfolio berbasis **Laravel 12** dengan dashboard admin. Seluruh isi halaman depan (hero, about, skills, pengalaman, pendidikan, sertifikat, projek, kontak, menu navbar, dan CV) **dikelola lewat dashboard** — tidak ada konten yang hardcoded.

---

## Persyaratan

| Kebutuhan | Versi |
|-----------|-------|
| PHP       | ≥ 8.2 (dites di 8.4) |
| Composer  | ≥ 2.x |
| MySQL / MariaDB | (mis. via Laragon/XAMPP) |
| Node.js & NPM   | ≥ 16 (untuk build aset frontend) |

> Ekstensi PHP yang dibutuhkan: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd`.

---

## Langkah Instalasi & Menjalankan

### 1. Install dependency PHP

```bash
composer install
```

### 2. Siapkan file environment

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Buat database & atur koneksi

Buat database kosong (mis. lewat phpMyAdmin/Laragon) bernama `web_portfolio`, lalu edit `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_portfolio
DB_USERNAME=root
DB_PASSWORD=
```

> Ingin tanpa MySQL? Set `DB_CONNECTION=sqlite`, lalu buat file `database/database.sqlite`.

### 4. Migrasi + data awal (seeder)

```bash
php artisan migrate:fresh --seed
```

Perintah ini membuat semua tabel dan mengisi data default: **1 user**, konfigurasi portfolio, dan **8 menu navbar**.

### 5. Buat symlink storage (untuk foto profil & gambar sertifikat)

```bash
php artisan storage:link
```

### 6. Build aset frontend

```bash
npm install
npm run dev      # mode pengembangan (biarkan berjalan)
# atau
npm run build    # untuk produksi
```

### 7. Jalankan server

```bash
php artisan serve
```

Buka **<http://127.0.0.1:8000>**

---

## Struktur Halaman

### Halaman Depan (publik) — `/`

Menampilkan section sesuai **menu aktif**: Hero, About, Skills, Experience, Education, Certificate, Projects, Contact.

### Dashboard Admin

| Menu | Fungsi |
|------|--------|
| **Dashboard** | Ringkasan statistik |
| **Projek** | CRUD project (judul, deskripsi, tech stack, link, featured) |
| **Keahlian** | CRUD skill (nama, kategori, level %) |
| **Pengalaman** | CRUD pengalaman kerja |
| **Pendidikan** | CRUD riwayat pendidikan |
| **Sertifikat** | CRUD sertifikat (judul, penerbit, tahun, gambar, link) |
| **Daftar Riwayat Hidup (CV)** | Preview & unduh PDF — datanya otomatis dari menu di atas |
| **Pengaturan Portfolio** | Teks Hero, statistik, kontak, judul About |
| **Menu Navbar** | Kelola menu + **mengatur section mana yang tampil** di halaman depan |
| **Profil Saya** | Data diri + foto + "Tentang Saya" (tampil di section About) |

### Konsep penting

- **Visibilitas section** halaman depan dikendalikan dari **Menu Navbar**: section tampil bila ada menu **aktif** menuju anchor-nya (`#hero`, `#about`, `#skills`, `#experience`, `#education`, `#certificate`, `#projects`, `#contact`).
- **Deskripsi About** diambil dari **Profil → Tentang Saya**.
- **CV** menarik data dari Profil, Skills, Pengalaman, Pendidikan, dan Projek.
- Agar halaman depan tampil (bukan 404), pastikan **Status Publikasi** aktif di *Pengaturan Portfolio*.

---

## Perintah yang Sering Dipakai

```bash
php artisan migrate:fresh --seed   # reset ulang database + data awal
php artisan db:seed                # jalankan seeder saja
php artisan optimize:clear         # bersihkan cache (view, route, config)
php artisan storage:link           # ulang symlink storage bila gambar tak muncul
```

---

## Troubleshooting

| Masalah | Solusi |
|---------|--------|
| `require vendor/autoload.php ... No such file` | Jalankan `composer install` |
| Halaman depan **404** | Aktifkan *Status Publikasi* di Pengaturan Portfolio |
| `Table 'projects' already exists` saat migrate | Jalankan `php artisan migrate:fresh --seed` |
| Foto/gambar tidak muncul | Jalankan `php artisan storage:link` |
| CSS/JS admin tidak berubah | Hard refresh browser (**Ctrl + F5**) atau jalankan `npm run dev` |
| `SQLSTATE ... Access denied` | Cek `DB_USERNAME`/`DB_PASSWORD` di `.env` |

---

## Teknologi

- **Laravel 12** · **Laravel Breeze** (autentikasi)
- **Bootstrap 5** + **Bootstrap Icons** (UI seragam)
- **barryvdh/laravel-dompdf** (unduh CV PDF)
- **Vite** (build aset)
