<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\AlatRepository;
use App\Repositories\MahasiswaRepository;
use App\Repositories\PeminjamanRepository;

class PeminjamanController extends Controller {
    private PeminjamanRepository $pinjamRepo;
    private MahasiswaRepository $mhsRepo;
    private AlatRepository $alatRepo;

    public function __construct() {
        $this->pinjamRepo = new PeminjamanRepository();
        $this->mhsRepo = new MahasiswaRepository();
        $this->alatRepo = new AlatRepository();
    }

    public function index(): void {
        $items = $this->pinjamRepo->getAll();
        $this->render('peminjaman/index', [
            'title' => 'Transaksi Peminjaman Alat Lab',
            'activeMenu' => 'peminjaman',
            'items' => $items,
        ]);
    }

    public function create(): void {
        $mahasiswa = $this->mhsRepo->getAll();
        $alat = $this->alatRepo->getAll();

        $this->render('peminjaman/form_tambah', [
            'title' => 'Buat Peminjaman Baru',
            'activeMenu' => 'peminjaman',
            'mahasiswa' => $mahasiswa,
            'alat' => $alat,
        ]);
    }

    public function store(): void {
        $id_mahasiswa = (int)($_POST['id_mahasiswa'] ?? 0);
        $id_alat = (int)($_POST['id_alat'] ?? 0);
        $tanggal_pinjam = trim($_POST['tanggal_pinjam'] ?? date('Y-m-d'));
        $jumlah = (int)($_POST['jumlah'] ?? 1);
        $catatan = trim($_POST['catatan'] ?? '');

        if ($id_mahasiswa === 0 || $id_alat === 0) {
            set_flash('error', 'Silakan pilih Mahasiswa dan Alat yang ingin dipinjam.');
            redirect('/peminjaman/create');
        }

        $this->pinjamRepo->create([
            'id_mahasiswa' => $id_mahasiswa,
            'id_alat' => $id_alat,
            'tanggal_pinjam' => $tanggal_pinjam,
            'tanggal_kembali' => null,
            'jumlah' => $jumlah,
            'status' => 'Dipinjam',
            'catatan' => $catatan,
        ]);

        set_flash('success', 'Transaksi peminjaman berhasil dicatat.');
        redirect('/peminjaman');
    }

    public function kembalikan(string $id): void {
        $this->pinjamRepo->updateStatus((int)$id, 'Kembali');
        set_flash('success', 'Status peminjaman berhasil diubah menjadi Selesai / Dikembalikan.');
        redirect('/peminjaman');
    }
}

