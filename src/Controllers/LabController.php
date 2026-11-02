<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\LabRepository;

class LabController extends Controller {
    private LabRepository $labRepo;

    public function __construct() {
        $this->labRepo = new LabRepository();
    }

    public function index(): void {
        $labs = $this->labRepo->getAll();
        $this->render('lab/index', [
            'title' => 'Laboratorium',
            'activeMenu' => 'lab',
            'labs' => $labs,
        ]);
    }

    public function create(): void {
        $this->render('lab/create', [
            'title' => 'Tambah Laboratorium',
            'activeMenu' => 'lab',
        ]);
    }

    public function store(): void {
        $kode_lab = trim($_POST['kode_lab'] ?? '');
        $nama_lab = trim($_POST['nama_lab'] ?? '');
        $lokasi = trim($_POST['lokasi'] ?? '');
        $kapasitas = (int)($_POST['kapasitas'] ?? 0);
        $kepala_lab = trim($_POST['kepala_lab'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');

        if ($kode_lab === '' || $nama_lab === '' || $lokasi === '') {
            set_flash('error', 'Kode Lab, Nama Lab, dan Lokasi wajib diisi.');
            redirect('/lab/create');
        }

        $this->labRepo->create([
            'kode_lab' => $kode_lab,
            'nama_lab' => $nama_lab,
            'lokasi' => $lokasi,
            'kapasitas' => $kapasitas,
            'kepala_lab' => $kepala_lab,
            'deskripsi' => $deskripsi,
        ]);

        set_flash('success', "Laboratorium \"{$nama_lab}\" berhasil ditambahkan.");
        redirect('/lab');
    }

    public function edit(string $id): void {
        $lab = $this->labRepo->findById((int)$id);
        if (!$lab) {
            set_flash('error', 'Data laboratorium tidak ditemukan.');
            redirect('/lab');
        }

        $this->render('lab/edit', [
            'title' => 'Ubah Data Laboratorium',
            'activeMenu' => 'lab',
            'lab' => $lab,
        ]);
    }

    public function update(string $id): void {
        $lab = $this->labRepo->findById((int)$id);
        if (!$lab) {
            set_flash('error', 'Data laboratorium tidak ditemukan.');
            redirect('/lab');
        }

        $kode_lab = trim($_POST['kode_lab'] ?? '');
        $nama_lab = trim($_POST['nama_lab'] ?? '');
        $lokasi = trim($_POST['lokasi'] ?? '');
        $kapasitas = (int)($_POST['kapasitas'] ?? 0);
        $kepala_lab = trim($_POST['kepala_lab'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');

        if ($kode_lab === '' || $nama_lab === '' || $lokasi === '') {
            set_flash('error', 'Kode Lab, Nama Lab, dan Lokasi wajib diisi.');
            redirect('/lab/edit/' . $id);
        }

        $this->labRepo->update((int)$id, [
            'kode_lab' => $kode_lab,
            'nama_lab' => $nama_lab,
            'lokasi' => $lokasi,
            'kapasitas' => $kapasitas,
            'kepala_lab' => $kepala_lab,
            'deskripsi' => $deskripsi,
        ]);

        set_flash('success', "Perubahan data laboratorium \"{$nama_lab}\" berhasil disimpan.");
        redirect('/lab');
    }

    public function delete(string $id): void {
        $lab = $this->labRepo->findById((int)$id);
        if ($lab) {
            $this->labRepo->delete((int)$id);
            set_flash('success', "Laboratorium \"{$lab['nama_lab']}\" berhasil dihapus.");
        } else {
            set_flash('error', 'Data laboratorium tidak ditemukan.');
        }
        redirect('/lab');
    }
}

