# Sistem Inventaris & Peminjaman Alat Laboratorium Terpadu

Proyek aplikasi web berbasis arsitektur **PHP-MVC** (tanpa framework) dengan database **MySQL** menggunakan **PDO Prepared Statement**. Proyek ini disusun untuk memenuhi tugas kelompok mata kuliah Pemrograman Web di Program Studi Informatika, Universitas Muhammadiyah Malang.

---

## Informasi Dosen Pengampu
* **Dosen:** Bella Dwi Mardiana, M.Kom
* **Mata Kuliah:** Pemrograman Web (Pertemuan 7 - Arsitektur PHP-MVC)
* **Program Studi:** Informatika - Fakultas Teknik, Universitas Muhammadiyah Malang

---

## Tim Pengembang (Kelompok)

| No. | Nama Mahasiswa | NIM | Peran / Fokus Pengerjaan |
| :---: | :--- | :---: | :--- |
| 1. | **[Bayu Adi Nugroho]** | `[202410370110193]` | Backend Core, Routing, PDO Config, Modul Transaksi & Logika PRG |
| 2. | **[Revansa Adha Dwi Yuliarto]** | `[202410370110218]` | UI/Layouting, Modul Master Data (Laboratorium, Alat, Mahasiswa) |

---

## Arsitektur & Teknologi

* **Bahasa Pemrograman:** PHP (>= 8.0)
* **Arsitektur:** Native MVC (*Model - View - Controller*)
* **Database:** MySQL via PDO Driver (*Prepared Statement*)
* **Dependensi:** Composer (PSR-4 Autoloading)
* **Web Server:** Apache dengan modul `mod_rewrite` aktif (.htaccess)

---

## Struktur Folder Proyek

```text
pemweb-mvc-lab/
├── composer.json           # Definisi autoload PSR-4
├── database.sql            # Skema DDL tabel database
├── public/                 # Satu-satunya akses web (Single Entry Point)
│   ├── .htaccess           # URL Rewrite ke index.php
│   └── index.php           # Front Controller
├── src/
│   ├── config/
│   │   └── koneksi.php     # Instance koneksi PDO
│   ├── Core/
│   │   └── Router.php      # Dispatcher rute GET/POST & handling 404
│   ├── Controllers/        # Controller alur request & validasi input
│   ├── Models/             # Entity class data
│   └── Repositories/       # Query data dengan Prepared Statements
└── views/
    ├── layout/             # Master layout (header.php, footer.php)
    ├── alat/               # Tampilan master inventaris alat
    └── peminjaman/         # Tampilan transaksi & form peminjaman
```

---

## Skema Database (Minimal 2 Tabel)

Sistem ini menggunakan 4 tabel yang saling berelasi:
1. `laboratorium`: Data master ruangan laboratorium.
2. `mahasiswa`: Data master identitas peminjam.
3. `alat`: Data inventaris alat lab, kondisi, dan jumlah ketersediaan stok.
4. `peminjaman`: Data transaksi peminjaman alat dengan pelacakan status (`dipinjam` / `kembali`).

---

## Fitur Utama & Kepatuhan Teknis

1. **Front Controller & Routing Bersih:**
   * Seluruh lalu lintas request diarahkan melalui `public/index.php`.
   * Endpoint URL bersih tanpa ekstensi file PHP (contoh: `/alat`, `/peminjaman`, `/peminjaman/tambah`).
2. **Pemisahan Peran MVC Ketat:**
   * View tidak menjalankan query SQL dan hanya mencetak variabel yang siap tampil via `htmlspecialchars()`.
   * Controller tipis, bertugas memvalidasi request dan memilih View.
   * Model/Repository murni mengelola data menggunakan PDO Prepared Statement untuk mencegah SQL Injection.
3. **Pola PRG (*Post/Redirect/Get*):**
   * Submit form menggunakan method HTTP `POST`, divalidasi di controller, lalu dialihkan via `header('Location: ...')` untuk mencegah duplikasi data saat browser di-refresh.
4. **CRUD Lengkap:**
   * Create, Read, Update, dan Delete terdistribusi pada modul inventaris alat dan pencatatan transaksi peminjaman.

---

## Panduan Instalasi & Menjalankan Aplikasi

### 1. Kloning Repositori
```bash
git clone https://github.com/revanadha/pemweb-mvc-inventarislab.git
cd pemweb-mvc-inventarislab
```

### 2. Generate Autoload Composer
Pastikan Composer telah terpasang di komputer lokal, lalu jalankan:
```bash
composer dump-autoload
```

### 3. Konfigurasi Database
1. Buka MySQL / phpMyAdmin.
2. Buat database baru, contoh: `pemweb_lab`.
3. Impor berkas `database.sql` yang tersedia di direktori utama repositori ini.
4. Sesuaikan kredensial username/password database pada berkas `src/config/koneksi.php`.

### 4. Menjalankan Server
Arahkan dokumen root server lokal ke folder `public/`:

* **Menggunakan Built-in PHP Server (Terminal):**
  ```bash
  php -S localhost:8000 -t public
  ```
  Akses di browser: `http://localhost:8000/alat`

* **Menggunakan Laragon / XAMPP:**
  * Letakkan folder di direktori server web (`htdocs` atau `www`).
  * Buat Virtual Host atau arahkan browser ke folder `public/` aplikasi.

---

## Standar Kolaborasi Git

Proyek ini dikembangkan secara kolaboratif menggunakan alur kerja Git standar:
* **Larangan Push Langsung ke `main`:** Semua perubahan dikerjakan di branch fitur masing-masing (misal: `feature/master-alat`, `feature/transaksi-peminjaman`).
* **Pull Request & Code Review:** Penggabungan kode ke branch utama (`main`) wajib melalui proses *Pull Request* dan disetujui (*Approve*) oleh rekan tim setelah *code review*.
