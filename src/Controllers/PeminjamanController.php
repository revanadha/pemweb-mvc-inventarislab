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
        $this->mhsRepo    = new MahasiswaRepository();
        $this->alatRepo   = new AlatRepository();
    }

    public function index(): void {
        $status  = $_GET['status'] ?? null;
        $keyword = !empty($_GET['q']) ? trim($_GET['q']) : null;

        $items = $this->pinjamRepo->getAll($status ?: null, $keyword);

        $this->render('peminjaman/index', [
            'title'          => 'Transaksi Peminjaman Alat Lab',
            'activeMenu'     => 'peminjaman',
            'items'          => $items,
            'filterStatus'   => $status,
            'filterKeyword'  => $keyword,
        ]);
    }

    public function create(): void {
        $mahasiswa = $this->mhsRepo->getAll();
        $alat      = $this->alatRepo->getAll();

        $this->render('peminjaman/form_tambah', [
            'title'      => 'Buat Peminjaman Baru',
            'activeMenu' => 'peminjaman',
            'mahasiswa'  => $mahasiswa,
            'alat'       => $alat,
        ]);
    }

    public function store(): void {
        $id_mahasiswa   = (int)($_POST['id_mahasiswa'] ?? 0);
        $id_alat        = (int)($_POST['id_alat'] ?? 0);
        $tanggal_pinjam = trim($_POST['tanggal_pinjam'] ?? date('Y-m-d'));
        $jumlah         = (int)($_POST['jumlah'] ?? 1);
        $catatan        = trim($_POST['catatan'] ?? '');

        if ($id_mahasiswa === 0 || $id_alat === 0) {
            set_flash('error', 'Silakan pilih Mahasiswa dan Alat yang ingin dipinjam.');
            redirect('/peminjaman/create');
        }

        // ⚠️ VALIDASI STOK & STATUS ALAT
        $alatData = $this->alatRepo->findById($id_alat);
        if (!$alatData) {
            set_flash('error', 'Alat tidak ditemukan di sistem.');
            redirect('/peminjaman/create');
        }
        if ($alatData['status'] === 'Dalam Perbaikan') {
            set_flash('error', "Alat \"{$alatData['nama_alat']}\" sedang dalam perbaikan dan tidak dapat dipinjam.");
            redirect('/peminjaman/create');
        }
        if ((int)$alatData['jumlah'] <= 0) {
            set_flash('error', "Stok alat \"{$alatData['nama_alat']}\" habis (stok: 0). Tidak dapat dipinjam.");
            redirect('/peminjaman/create');
        }
        if ($jumlah > (int)$alatData['jumlah']) {
            set_flash('error', "Jumlah yang diminta ({$jumlah}) melebihi stok tersedia ({$alatData['jumlah']}).");
            redirect('/peminjaman/create');
        }

        $this->pinjamRepo->create([
            'id_mahasiswa'    => $id_mahasiswa,
            'id_alat'         => $id_alat,
            'tanggal_pinjam'  => $tanggal_pinjam,
            'tanggal_kembali' => null,
            'jumlah'          => $jumlah,
            'status'          => 'Dipinjam',
            'catatan'         => $catatan,
        ]);

        set_flash('success', 'Transaksi peminjaman berhasil dicatat.');
        redirect('/peminjaman');
    }

    public function kembalikan(string $id): void {
        $this->pinjamRepo->updateStatus((int)$id, 'Kembali');
        set_flash('success', 'Status peminjaman berhasil diubah menjadi Selesai / Dikembalikan.');
        redirect('/peminjaman');
    }

    // -------------------------------------------------------
    // KONTRIBUSI: Detail, Edit, Update, Delete
    // -------------------------------------------------------

    public function detail(string $id): void {
        $item = $this->pinjamRepo->findById((int)$id);

        if (!$item) {
            set_flash('error', 'Data peminjaman tidak ditemukan.');
            redirect('/peminjaman');
        }

        $this->render('peminjaman/detail', [
            'title'      => 'Detail Transaksi #' . $item['kode_transaksi'],
            'activeMenu' => 'peminjaman',
            'item'       => $item,
        ]);
    }

    public function edit(string $id): void {
        $item = $this->pinjamRepo->findById((int)$id);

        if (!$item) {
            set_flash('error', 'Data peminjaman tidak ditemukan.');
            redirect('/peminjaman');
        }

        if ($item['status'] === 'Kembali') {
            set_flash('error', 'Transaksi yang sudah selesai tidak dapat diedit.');
            redirect('/peminjaman');
        }

        $mahasiswa = $this->mhsRepo->getAll();
        $alat      = $this->alatRepo->getAll();

        $this->render('peminjaman/form_edit', [
            'title'      => 'Edit Peminjaman #' . $item['kode_transaksi'],
            'activeMenu' => 'peminjaman',
            'item'       => $item,
            'mahasiswa'  => $mahasiswa,
            'alat'       => $alat,
        ]);
    }

    public function update(string $id): void {
        $id_mahasiswa   = (int)($_POST['id_mahasiswa'] ?? 0);
        $id_alat        = (int)($_POST['id_alat'] ?? 0);
        $tanggal_pinjam = trim($_POST['tanggal_pinjam'] ?? '');
        $jumlah         = (int)($_POST['jumlah'] ?? 1);
        $catatan        = trim($_POST['catatan'] ?? '');

        if ($id_mahasiswa === 0 || $id_alat === 0 || empty($tanggal_pinjam)) {
            set_flash('error', 'Data tidak lengkap. Pastikan semua field wajib diisi.');
            redirect('/peminjaman/edit/' . $id);
        }

        $this->pinjamRepo->update((int)$id, [
            'id_mahasiswa'   => $id_mahasiswa,
            'id_alat'        => $id_alat,
            'tanggal_pinjam' => $tanggal_pinjam,
            'jumlah'         => $jumlah,
            'catatan'        => $catatan,
        ]);

        set_flash('success', 'Data peminjaman berhasil diperbarui.');
        redirect('/peminjaman');
    }

    public function delete(string $id): void {
        $item = $this->pinjamRepo->findById((int)$id);

        if (!$item) {
            set_flash('error', 'Data peminjaman tidak ditemukan.');
            redirect('/peminjaman');
        }

        $this->pinjamRepo->delete((int)$id);
        set_flash('success', 'Transaksi peminjaman berhasil dihapus.');
        redirect('/peminjaman');
    }
}


