<?php

namespace App\Models;

class Alat {
    public ?int $id;
    public string $kode_alat;
    public string $nama_alat;
    public int $id_lab;
    public string $kategori;
    public int $jumlah;
    public string $kondisi;
    public string $status;
    public ?string $deskripsi;
    public ?string $gambar;

    public function __construct(array $data = []) {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->kode_alat = $data['kode_alat'] ?? '';
        $this->nama_alat = $data['nama_alat'] ?? '';
        $this->id_lab = isset($data['id_lab']) ? (int)$data['id_lab'] : 1;
        $this->kategori = $data['kategori'] ?? 'Umum';
        $this->jumlah = isset($data['jumlah']) ? (int)$data['jumlah'] : 0;
        $this->kondisi = $data['kondisi'] ?? 'Baik';
        $this->status = $data['status'] ?? 'Tersedia';
        $this->deskripsi = $data['deskripsi'] ?? null;
        $this->gambar = $data['gambar'] ?? null;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'kode_alat' => $this->kode_alat,
            'nama_alat' => $this->nama_alat,
            'id_lab' => $this->id_lab,
            'kategori' => $this->kategori,
            'jumlah' => $this->jumlah,
            'kondisi' => $this->kondisi,
            'status' => $this->status,
            'deskripsi' => $this->deskripsi,
            'gambar' => $this->gambar,
        ];
    }
}

