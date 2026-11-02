<?php

namespace App\Models;

class Mahasiswa {
    public ?int $id;
    public string $nim;
    public string $nama;
    public string $prodi;
    public string $email;
    public string $no_telp;
    public string $status;

    public function __construct(array $data = []) {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->nim = $data['nim'] ?? '';
        $this->nama = $data['nama'] ?? '';
        $this->prodi = $data['prodi'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->no_telp = $data['no_telp'] ?? '';
        $this->status = $data['status'] ?? 'Aktif';
    }

    public function toArray(): array {
        return [
            'id' => $this->id,
            'nim' => $this->nim,
            'nama' => $this->nama,
            'prodi' => $this->prodi,
            'email' => $this->email,
            'no_telp' => $this->no_telp,
            'status' => $this->status,
        ];
    }
}

