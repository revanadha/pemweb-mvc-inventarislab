<?php

namespace App\Models;

class Peminjaman {
    public ?int $id;
    public string $kode_transaksi;
    public int $id_mahasiswa;
    public int $id_alat;
    public string $tanggal_pinjam;
    public ?string $tanggal_kembali;
    public int $jumlah;
    public string $status;
    public ?string $catatan;

    public function __construct(array $data = []) {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->kode_transaksi = $data['kode_transaksi'] ?? '';
        $this->id_mahasiswa = isset($data['id_mahasiswa']) ? (int)$data['id_mahasiswa'] : 0;
        $this->id_alat = isset($data['id_alat']) ? (int)$data['id_alat'] : 0;
        $this->tanggal_pinjam = $data['tanggal_pinjam'] ?? date('Y-m-d');
        $this->tanggal_kembali = $data['tanggal_kembali'] ?? null;
        $this->jumlah = isset($data['jumlah']) ? (int)$data['jumlah'] : 1;
        $this->status = $data['status'] ?? 'Dipinjam';
        $this->catatan = $data['catatan'] ?? null;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'kode_transaksi' => $this->kode_transaksi,
            'id_mahasiswa' => $this->id_mahasiswa,
            'id_alat' => $this->id_alat,
            'tanggal_pinjam' => $this->tanggal_pinjam,
            'tanggal_kembali' => $this->tanggal_kembali,
            'jumlah' => $this->jumlah,
            'status' => $this->status,
            'catatan' => $this->catatan,
        ];
    }
}

