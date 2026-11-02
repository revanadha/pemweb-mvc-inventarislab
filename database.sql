-- =========================================================
--  DATABASE: Sistem Inventaris & Peminjaman Alat Laboratorium
--  Mata Kuliah : Pemrograman Web
--  Universitas  : Universitas Muhammadiyah Malang
-- =========================================================

-- Buat database jika belum ada, lalu gunakan
CREATE DATABASE IF NOT EXISTS `inventaris_lab`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `inventaris_lab`;

-- =========================================================
--  TABEL 1: laboratorium
-- =========================================================
CREATE TABLE IF NOT EXISTS `laboratorium` (
  `id`          INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `kode_lab`    VARCHAR(20)     NOT NULL UNIQUE,
  `nama_lab`    VARCHAR(100)    NOT NULL,
  `lokasi`      VARCHAR(150)    NOT NULL,
  `kapasitas`   INT             NOT NULL DEFAULT 0,
  `kepala_lab`  VARCHAR(100)    NULL,
  `deskripsi`   TEXT            NULL,
  `created_at`  TIMESTAMP       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
--  TABEL 2: mahasiswa
-- =========================================================
CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `id`         INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `nim`        VARCHAR(20)   NOT NULL UNIQUE,
  `nama`       VARCHAR(100)  NOT NULL,
  `prodi`      VARCHAR(100)  NOT NULL,
  `email`      VARCHAR(100)  NULL,
  `no_telp`    VARCHAR(20)   NULL,
  `status`     ENUM('Aktif','Non-Aktif') NOT NULL DEFAULT 'Aktif',
  `created_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
--  TABEL 3: alat
-- =========================================================
CREATE TABLE IF NOT EXISTS `alat` (
  `id`         INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `kode_alat`  VARCHAR(30)   NOT NULL UNIQUE,
  `nama_alat`  VARCHAR(150)  NOT NULL,
  `id_lab`     INT UNSIGNED  NULL,
  `kategori`   VARCHAR(100)  NOT NULL,
  `jumlah`     INT           NOT NULL DEFAULT 0,
  `kondisi`    ENUM('Baik','Rusak Ringan','Perbaikan','Rusak Berat') NOT NULL DEFAULT 'Baik',
  `status`     ENUM('Tersedia','Dipinjam','Dalam Perbaikan') NOT NULL DEFAULT 'Tersedia',
  `deskripsi`  TEXT          NULL,
  `gambar`     VARCHAR(255)  NULL,
  `created_at` TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_alat_lab` FOREIGN KEY (`id_lab`)
    REFERENCES `laboratorium`(`id`)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
--  TABEL 4: peminjaman
-- =========================================================
CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id`              INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `kode_transaksi`  VARCHAR(30)   NOT NULL UNIQUE,
  `id_mahasiswa`    INT UNSIGNED  NULL,
  `id_alat`         INT UNSIGNED  NULL,
  `tanggal_pinjam`  DATE          NOT NULL,
  `tanggal_kembali` DATE          NULL,
  `jumlah`          INT           NOT NULL DEFAULT 1,
  `status`          ENUM('Dipinjam','Kembali','Terlambat') NOT NULL DEFAULT 'Dipinjam',
  `catatan`         TEXT          NULL,
  `created_at`      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_pinjam_mahasiswa` FOREIGN KEY (`id_mahasiswa`)
    REFERENCES `mahasiswa`(`id`)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT `fk_pinjam_alat` FOREIGN KEY (`id_alat`)
    REFERENCES `alat`(`id`)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =========================================================
--  DATA SAMPLE: laboratorium
-- =========================================================
INSERT INTO `laboratorium` (`id`, `kode_lab`, `nama_lab`, `lokasi`, `kapasitas`, `kepala_lab`, `deskripsi`) VALUES
(1, 'LAB-KOM-01', 'Lab Komputer Dasar',          'Gedung B Lt. 2', 40, 'Dr. Hendra Wijaya, M.Kom',   'Fasilitas praktikum pemrograman dasar, basis data, dan algoritma.'),
(2, 'LAB-NET-02', 'Lab Jaringan & Siber',         'Gedung B Lt. 3', 30, 'Ir. Maya Safitri, M.T',      'Dilengkapi perangkat switch, router enterprise, server rack, dan firewall.'),
(3, 'LAB-RPL-03', 'Lab Rekayasa Perangkat Lunak', 'Gedung C Lt. 1', 35, 'Rian Hidayat, S.Kom, M.Cs', 'Pengembangan sistem informasi, riset UI/UX, dan peranti lunak cerdas.'),
(4, 'LAB-IOT-04', 'Lab Elektronika & IoT',        'Gedung A Lt. 2', 25, 'Ahmad Fauzi, M.T',           'Eksperimen mikrokontroler, instrumen elektronika, sensor, dan peranti IoT.');

-- =========================================================
--  DATA SAMPLE: mahasiswa
-- =========================================================
INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `prodi`, `email`, `no_telp`, `status`) VALUES
(1, '2400018001', 'Muhammad Rizky Pratama', 'Informatika',      'rizky.pratama@student.ac.id',    '081234567890', 'Aktif'),
(2, '2400018025', 'Siti Aisyah Nurhaliza',  'Sistem Informasi', 'aisyah.nurhaliza@student.ac.id', '081298765432', 'Aktif'),
(3, '2400018042', 'Fajar Nugraha',          'Informatika',      'fajar.nugraha@student.ac.id',    '081377889900', 'Aktif'),
(4, '2400018060', 'Amanda Putri Lestari',   'Teknik Elektro',   'amanda.putri@student.ac.id',     '081566778899', 'Aktif');

-- =========================================================
--  DATA SAMPLE: alat
-- =========================================================
INSERT INTO `alat` (`id`, `kode_alat`, `nama_alat`, `id_lab`, `kategori`, `jumlah`, `kondisi`, `status`, `deskripsi`, `gambar`) VALUES
(1, 'AL-ROUT-01', 'Cisco Router 2901 Integrated Services',      2, 'Networking',      12, 'Baik',      'Tersedia',        'Router modular enterprise untuk praktikum routing static, OSPF, dan VLAN.',        'cisco-router.png'),
(2, 'AL-OSC-02',  'Digital Oscilloscope 100MHz 2-Channel',      4, 'Elektronika',      8, 'Baik',      'Tersedia',        'Alat ukur sinyal tegangan digital untuk praktikum elektronika analog dan digital.', 'oscilloscope.png'),
(3, 'AL-VR-03',   'Oculus Quest 2 VR Headset 256GB',            3, 'Multimedia',       5, 'Baik',      'Tersedia',        'Perangkat VR untuk praktikum pengembangan game dan immersive software.',           'vr-headset.png'),
(4, 'AL-SERV-04', 'Server Rack Dell PowerEdge R740',            2, 'Server',           2, 'Baik',      'Tersedia',        'Server rak 2U untuk praktikum virtualisasi dan cloud computing.',                  'dell-server.png'),
(5, 'AL-IOT-05',  'Raspberry Pi 4 Model B 8GB Starter Kit',     4, 'IoT dan Embedded',20, 'Baik',      'Tersedia',        'Single-board computer untuk praktikum IoT, embedded Linux, dan sensor gateway.',  'raspberry-pi.png'),
(6, 'AL-PC-06',   'Workstation PC Intel Core i7 32GB RTX 3060', 1, 'Komputer',        35, 'Baik',      'Tersedia',        'Unit komputer grafis tinggi untuk machine learning dan rendering grafis.',          'workstation.png'),
(7, 'AL-SOLD-07', 'Soldering Station Digital ESD Safe',         4, 'Alat Praktikum',  15, 'Perbaikan', 'Dalam Perbaikan', 'Stasiun solder temperatur teratur untuk perakitan sirkuit PCB elektronika.',      'solder-station.png');

-- =========================================================
--  DATA SAMPLE: peminjaman
-- =========================================================
INSERT INTO `peminjaman` (`id`, `kode_transaksi`, `id_mahasiswa`, `id_alat`, `tanggal_pinjam`, `tanggal_kembali`, `jumlah`, `status`, `catatan`) VALUES
(1, 'TRX-202611-001', 1, 1, '2026-11-01', '2026-11-05', 2, 'Dipinjam', 'Praktikum jaringan komputer mandiri.'),
(2, 'TRX-202611-002', 2, 3, '2026-11-02', '2026-11-04', 1, 'Dipinjam', 'Tugas akhir simulasi interaktif VR.'),
(3, 'TRX-202610-025', 3, 2, '2026-10-25', '2026-10-28', 1, 'Kembali',  'Alat dikembalikan dalam kondisi baik.');