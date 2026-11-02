<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\AlatRepository;
use App\Repositories\LabRepository;

class AlatController extends Controller {
    private AlatRepository $alatRepo;
    private LabRepository $labRepo;

    public function __construct() {
        $this->alatRepo = new AlatRepository();
        $this->labRepo = new LabRepository();
    }

    public function index(): void {
        $keyword = $_GET['q'] ?? null;
        $labId = isset($_GET['lab_id']) && $_GET['lab_id'] !== '' ? (int)$_GET['lab_id'] : null;

        $items = $this->alatRepo->getAll($keyword, $labId);
        $labs = $this->labRepo->getAll();

        $this->render('alat/index', [
            'title' => 'Alat Laboratorium',
            'activeMenu' => 'alat',
            'items' => $items,
            'labs' => $labs,
            'keyword' => $keyword,
            'selectedLab' => $labId,
        ]);
    }

    public function create(): void {
        $labs = $this->labRepo->getAll();
        $this->render('alat/create', [
            'title' => 'Tambah Alat Laboratorium',
            'activeMenu' => 'alat',
            'labs' => $labs,
        ]);
    }

    public function store(): void {
        $kode_alat = trim($_POST['kode_alat'] ?? '');
        $nama_alat = trim($_POST['nama_alat'] ?? '');
        $id_lab = (int)($_POST['id_lab'] ?? 0);
        $kategori = trim($_POST['kategori'] ?? 'Umum');
        $jumlah = (int)($_POST['jumlah'] ?? 0);
        $kondisi = trim($_POST['kondisi'] ?? 'Baik');
        $status = trim($_POST['status'] ?? 'Tersedia');
        $deskripsi = trim($_POST['deskripsi'] ?? '');

        if ($kode_alat === '' || $nama_alat === '' || $id_lab === 0) {
            set_flash('error', 'Kode Alat, Nama Alat, dan Laboratorium wajib diisi.');
            redirect('/alat/create');
        }

        $this->alatRepo->create([
            'kode_alat' => $kode_alat,
            'nama_alat' => $nama_alat,
            'id_lab' => $id_lab,
            'kategori' => $kategori,
            'jumlah' => $jumlah,
            'kondisi' => $kondisi,
            'status' => $status,
            'deskripsi' => $deskripsi,
            'gambar' => null,
        ]);

        set_flash('success', "Alat \"{$nama_alat}\" berhasil ditambahkan.");
        redirect('/alat');
    }

    public function edit(string $id): void {
        $alat = $this->alatRepo->findById((int)$id);
        if (!$alat) {
            set_flash('error', 'Data alat tidak ditemukan.');
            redirect('/alat');
        }

        $labs = $this->labRepo->getAll();
        $this->render('alat/edit', [
            'title' => 'Ubah Data Alat Lab',
            'activeMenu' => 'alat',
            'alat' => $alat,
            'labs' => $labs,
        ]);
    }

    public function update(string $id): void {
        $item = $this->alatRepo->findById((int)$id);
        if (!$item) {
            set_flash('error', 'Data alat tidak ditemukan.');
            redirect('/alat');
        }

        $kode_alat = trim($_POST['kode_alat'] ?? '');
        $nama_alat = trim($_POST['nama_alat'] ?? '');
        $id_lab = (int)($_POST['id_lab'] ?? 0);
        $kategori = trim($_POST['kategori'] ?? 'Umum');
        $jumlah = (int)($_POST['jumlah'] ?? 0);
        $kondisi = trim($_POST['kondisi'] ?? 'Baik');
        $status = trim($_POST['status'] ?? 'Tersedia');
        $deskripsi = trim($_POST['deskripsi'] ?? '');

        if ($kode_alat === '' || $nama_alat === '' || $id_lab === 0) {
            set_flash('error', 'Kode Alat, Nama Alat, dan Laboratorium wajib diisi.');
            redirect('/alat/edit/' . $id);
        }

        $this->alatRepo->update((int)$id, [
            'kode_alat' => $kode_alat,
            'nama_alat' => $nama_alat,
            'id_lab' => $id_lab,
            'kategori' => $kategori,
            'jumlah' => $jumlah,
            'kondisi' => $kondisi,
            'status' => $status,
            'deskripsi' => $deskripsi,
            'gambar' => $item['gambar'] ?? null,
        ]);

        set_flash('success', "Perubahan data alat \"{$nama_alat}\" berhasil disimpan.");
        redirect('/alat');
    }

    public function delete(string $id): void {
        $item = $this->alatRepo->findById((int)$id);
        if ($item) {
            $this->alatRepo->delete((int)$id);
            set_flash('success', "Alat \"{$item['nama_alat']}\" berhasil dihapus.");
        } else {
            set_flash('error', 'Data alat tidak ditemukan.');
        }
        redirect('/alat');
    }

    public function detail(string $id): void {
        $alat = $this->alatRepo->findById((int)$id);
        if (!$alat) {
            set_flash('error', 'Data alat tidak ditemukan.');
            redirect('/alat');
        }

        $this->render('alat/detail', [
            'title' => 'Detail Alat: ' . $alat['nama_alat'],
            'activeMenu' => 'alat',
            'alat' => $alat,
        ]);
    }
}

