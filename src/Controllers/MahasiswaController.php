<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\MahasiswaRepository;
use App\Repositories\PeminjamanRepository;

class MahasiswaController extends Controller {
    private MahasiswaRepository $mhsRepo;
    private PeminjamanRepository $pinjamRepo;

    public function __construct() {
        $this->mhsRepo    = new MahasiswaRepository();
        $this->pinjamRepo = new PeminjamanRepository();
    }

    public function index(): void {
        $mahasiswa = $this->mhsRepo->getAll();
        $this->render('mahasiswa/index', [
            'title' => 'Data Mahasiswa',
            'activeMenu' => 'mahasiswa',
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function create(): void {
        $this->render('mahasiswa/create', [
            'title' => 'Tambah Mahasiswa',
            'activeMenu' => 'mahasiswa',
        ]);
    }

    public function store(): void {
        $nim = trim($_POST['nim'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $prodi = trim($_POST['prodi'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $no_telp = trim($_POST['no_telp'] ?? '');
        $status = trim($_POST['status'] ?? 'Aktif');

        if ($nim === '' || $nama === '' || $prodi === '') {
            set_flash('error', 'NIM, Nama Mahasiswa, dan Program Studi wajib diisi.');
            redirect('/mahasiswa/create');
        }

        $existing = $this->mhsRepo->findByNim($nim);
        if ($existing) {
            set_flash('error', "Mahasiswa dengan NIM \"{$nim}\" sudah terdaftar.");
            redirect('/mahasiswa/create');
        }

        $this->mhsRepo->create([
            'nim' => $nim,
            'nama' => $nama,
            'prodi' => $prodi,
            'email' => $email,
            'no_telp' => $no_telp,
            'status' => $status,
        ]);

        set_flash('success', "Mahasiswa \"{$nama}\" berhasil ditambahkan.");
        redirect('/mahasiswa');
    }

    public function edit(string $id): void {
        $mhs = $this->mhsRepo->findById((int)$id);
        if (!$mhs) {
            set_flash('error', 'Data mahasiswa tidak ditemukan.');
            redirect('/mahasiswa');
        }

        $this->render('mahasiswa/edit', [
            'title' => 'Ubah Data Mahasiswa',
            'activeMenu' => 'mahasiswa',
            'mhs' => $mhs,
        ]);
    }

    public function update(string $id): void {
        $mhs = $this->mhsRepo->findById((int)$id);
        if (!$mhs) {
            set_flash('error', 'Data mahasiswa tidak ditemukan.');
            redirect('/mahasiswa');
        }

        $nim = trim($_POST['nim'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $prodi = trim($_POST['prodi'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $no_telp = trim($_POST['no_telp'] ?? '');
        $status = trim($_POST['status'] ?? 'Aktif');

        if ($nim === '' || $nama === '' || $prodi === '') {
            set_flash('error', 'NIM, Nama Mahasiswa, dan Program Studi wajib diisi.');
            redirect('/mahasiswa/edit/' . $id);
        }

        $this->mhsRepo->update((int)$id, [
            'nim' => $nim,
            'nama' => $nama,
            'prodi' => $prodi,
            'email' => $email,
            'no_telp' => $no_telp,
            'status' => $status,
        ]);

        set_flash('success', "Perubahan data mahasiswa \"{$nama}\" berhasil disimpan.");
        redirect('/mahasiswa');
    }

    public function delete(string $id): void {
        $mhs = $this->mhsRepo->findById((int)$id);
        if ($mhs) {
            $this->mhsRepo->delete((int)$id);
            set_flash('success', "Mahasiswa \"{$mhs['nama']}\" berhasil dihapus.");
        } else {
            set_flash('error', 'Data mahasiswa tidak ditemukan.');
        }
        redirect('/mahasiswa');
    }

    // -------------------------------------------------------
    // KONTRIBUSI: Riwayat Peminjaman per Mahasiswa
    // -------------------------------------------------------
    public function riwayat(string $id): void {
        $mhs = $this->mhsRepo->findById((int)$id);
        if (!$mhs) {
            set_flash('error', 'Data mahasiswa tidak ditemukan.');
            redirect('/mahasiswa');
        }

        // Ambil semua peminjaman, filter berdasarkan id_mahasiswa
        $semuaPinjam = $this->pinjamRepo->getAll();
        $riwayat = array_values(array_filter(
            $semuaPinjam,
            fn($p) => (int)$p['id_mahasiswa'] === (int)$id
        ));

        $totalPinjam  = count($riwayat);
        $masihDipinjam = count(array_filter($riwayat, fn($p) => $p['status'] === 'Dipinjam'));
        $sudahKembali  = count(array_filter($riwayat, fn($p) => $p['status'] === 'Kembali'));

        $this->render('mahasiswa/riwayat', [
            'title'         => 'Riwayat Peminjaman — ' . $mhs['nama'],
            'activeMenu'    => 'mahasiswa',
            'mhs'           => $mhs,
            'riwayat'       => $riwayat,
            'totalPinjam'   => $totalPinjam,
            'masihDipinjam' => $masihDipinjam,
            'sudahKembali'  => $sudahKembali,
        ]);
    }
}

