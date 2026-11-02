<?php

namespace App\Models;

class Laboratorium {
    public ?int $id;
    public string $kode_lab;
    public string $nama_lab;
    public string $lokasi;
    public int $kapasitas;
    public string $kepala_lab;
    public ?string $deskripsi;

    public function __construct(array $data = []) {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->kode_lab = $data['kode_lab'] ?? '';
        $this->nama_lab = $data['nama_lab'] ?? '';
        $this->lokasi = $data['lokasi'] ?? '';
        $this->kapasitas = isset($data['kapasitas']) ? (int)$data['kapasitas'] : 0;
        $this->kepala_lab = $data['kepala_lab'] ?? '';
        $this->deskripsi = $data['deskripsi'] ?? null;
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'kode_lab' => $this->kode_lab,
            'nama_lab' => $this->nama_lab,
            'lokasi' => $this->lokasi,
            'kapasitas' => $this->kapasitas,
            'kepala_lab' => $this->kepala_lab,
            'deskripsi' => $this->deskripsi,
        ];
    }
}

