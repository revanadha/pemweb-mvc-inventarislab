<?php

namespace App\Repositories;

use App\Config\Database;
use App\Models\Alat;
use PDO;

class AlatRepository {
    private ?PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->initMockData();
    }

    private function initMockData(): void {
        if (!isset($_SESSION['mock_store']['alat'])) {
            $_SESSION['mock_store']['alat'] = [
                1 => [
                    'id' => 1,
                    'kode_alat' => 'AL-ROUT-01',
                    'nama_alat' => 'Cisco Router 2901 Integrated Services',
                    'id_lab' => 2,
                    'kategori' => 'Networking',
                    'jumlah' => 12,
                    'kondisi' => 'Baik',
                    'status' => 'Tersedia',
                    'deskripsi' => 'Router modular enterprise untuk praktikum konfigurasi routing static, OSPF, dan VLAN.',
                    'gambar' => 'cisco-router.png'
                ],
                2 => [
                    'id' => 2,
                    'kode_alat' => 'AL-OSC-02',
                    'nama_alat' => 'Digital Oscilloscope 100MHz 2-Channel',
                    'id_lab' => 4,
                    'kategori' => 'Elektronika',
                    'jumlah' => 8,
                    'kondisi' => 'Baik',
                    'status' => 'Tersedia',
                    'deskripsi' => 'Alat ukur sinyal tegangan digital dengan layar warna untuk praktikum elektronika analog & digital.',
                    'gambar' => 'oscilloscope.png'
                ],
                3 => [
                    'id' => 3,
                    'kode_alat' => 'AL-VR-03',
                    'nama_alat' => 'Oculus Quest 2 VR Headset 256GB',
                    'id_lab' => 3,
                    'kategori' => 'Multimedia',
                    'jumlah' => 5,
                    'kondisi' => 'Baik',
                    'status' => 'Tersedia',
                    'deskripsi' => 'Perangkat virtual reality untuk praktikum pengembangan game dan immersive software.',
                    'gambar' => 'vr-headset.png'
                ],
                4 => [
                    'id' => 4,
                    'kode_alat' => 'AL-SERV-04',
                    'nama_alat' => 'Server Rack Dell PowerEdge R740',
                    'id_lab' => 2,
                    'kategori' => 'Server',
                    'jumlah' => 2,
                    'kondisi' => 'Baik',
                    'status' => 'Tersedia',
                    'deskripsi' => 'Server rak 2U untuk praktikum virtualisasi, sistem operasi jaringan, dan cloud computing.',
                    'gambar' => 'dell-server.png'
                ],
                5 => [
                    'id' => 5,
                    'kode_alat' => 'AL-IOT-05',
                    'nama_alat' => 'Raspberry Pi 4 Model B 8GB Starter Kit',
                    'id_lab' => 4,
                    'kategori' => 'IoT & Embedded',
                    'jumlah' => 20,
                    'kondisi' => 'Baik',
                    'status' => 'Tersedia',
                    'deskripsi' => 'Single-board computer untuk praktikum automasi IoT, embedded Linux, dan sensor gateway.',
                    'gambar' => 'raspberry-pi.png'
                ],
                6 => [
                    'id' => 6,
                    'kode_alat' => 'AL-PC-06',
                    'nama_alat' => 'Workstation PC Intel Core i7 32GB RTX 3060',
                    'id_lab' => 1,
                    'kategori' => 'Komputer',
                    'jumlah' => 35,
                    'kondisi' => 'Baik',
                    'status' => 'Tersedia',
                    'deskripsi' => 'Unit komputer grafis tinggi untuk komputasi berat, machine learning, dan rendering grafis.',
                    'gambar' => 'workstation.png'
                ],
                7 => [
                    'id' => 7,
                    'kode_alat' => 'AL-SOLD-07',
                    'nama_alat' => 'Soldering Station Digital ESD Safe',
                    'id_lab' => 4,
                    'kategori' => 'Alat Praktikum',
                    'jumlah' => 15,
                    'kondisi' => 'Perbaikan',
                    'status' => 'Dalam Perbaikan',
                    'deskripsi' => 'Stasiun solder temperatur teratur untuk perakitan sirkuit PCB komponen elektronika.',
                    'gambar' => 'solder-station.png'
                ]
            ];
        }
    }

    public function getAll(?string $keyword = null, ?int $labId = null): array {
        if ($this->db) {
            try {
                $sql = "
                    SELECT a.*, l.nama_lab, l.lokasi as lokasi_lab 
                    FROM alat a 
                    LEFT JOIN laboratorium l ON a.id_lab = l.id
                    WHERE 1=1
                ";
                $params = [];
                if (!empty($keyword)) {
                    $sql .= " AND (a.nama_alat LIKE :keyword OR a.kode_alat LIKE :keyword OR a.kategori LIKE :keyword)";
                    $params['keyword'] = '%' . $keyword . '%';
                }
                if ($labId) {
                    $sql .= " AND a.id_lab = :labId";
                    $params['labId'] = $labId;
                }
                $sql .= " ORDER BY a.id DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);
                return $stmt->fetchAll();
            } catch (\Exception $e) {
                // Fallback
            }
        }

        $items = $_SESSION['mock_store']['alat'];
        $labRepo = new LabRepository();
        $labs = [];
        foreach ($labRepo->getAll() as $lab) {
            $labs[$lab['id']] = $lab;
        }

        $results = [];
        foreach ($items as $item) {
            $item['nama_lab'] = $labs[$item['id_lab']]['nama_lab'] ?? 'Lab Umum';
            $item['lokasi_lab'] = $labs[$item['id_lab']]['lokasi'] ?? '-';

            if ($labId && (int)$item['id_lab'] !== $labId) {
                continue;
            }

            if (!empty($keyword)) {
                $kw = strtolower($keyword);
                $match = str_contains(strtolower($item['nama_alat']), $kw)
                    || str_contains(strtolower($item['kode_alat']), $kw)
                    || str_contains(strtolower($item['kategori']), $kw);
                if (!$match) {
                    continue;
                }
            }

            $results[] = $item;
        }

        usort($results, fn($a, $b) => $b['id'] <=> $a['id']);
        return $results;
    }

    public function findById(int $id): ?array {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("
                    SELECT a.*, l.nama_lab, l.lokasi as lokasi_lab 
                    FROM alat a 
                    LEFT JOIN laboratorium l ON a.id_lab = l.id 
                    WHERE a.id = :id
                ");
                $stmt->execute(['id' => $id]);
                $res = $stmt->fetch();
                return $res ?: null;
            } catch (\Exception $e) {
                // Fallback
            }
        }

        if (isset($_SESSION['mock_store']['alat'][$id])) {
            $item = $_SESSION['mock_store']['alat'][$id];
            $labRepo = new LabRepository();
            $lab = $labRepo->findById((int)$item['id_lab']);
            $item['nama_lab'] = $lab['nama_lab'] ?? 'Lab Umum';
            $item['lokasi_lab'] = $lab['lokasi'] ?? '-';
            return $item;
        }
        return null;
    }

    public function create(array $data): int {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("
                    INSERT INTO alat (kode_alat, nama_alat, id_lab, kategori, jumlah, kondisi, status, deskripsi, gambar)
                    VALUES (:kode_alat, :nama_alat, :id_lab, :kategori, :jumlah, :kondisi, :status, :deskripsi, :gambar)
                ");
                $stmt->execute([
                    'kode_alat' => $data['kode_alat'],
                    'nama_alat' => $data['nama_alat'],
                    'id_lab' => (int)$data['id_lab'],
                    'kategori' => $data['kategori'],
                    'jumlah' => (int)$data['jumlah'],
                    'kondisi' => $data['kondisi'] ?? 'Baik',
                    'status' => $data['status'] ?? 'Tersedia',
                    'deskripsi' => $data['deskripsi'] ?? null,
                    'gambar' => $data['gambar'] ?? null,
                ]);
                return (int)$this->db->lastInsertId();
            } catch (\Exception $e) {
                // Fallback
            }
        }

        $items = $_SESSION['mock_store']['alat'];
        $nextId = empty($items) ? 1 : (max(array_keys($items)) + 1);
        $data['id'] = $nextId;
        $data['id_lab'] = (int)$data['id_lab'];
        $data['jumlah'] = (int)$data['jumlah'];
        $data['kondisi'] = $data['kondisi'] ?? 'Baik';
        $data['status'] = $data['status'] ?? 'Tersedia';
        $_SESSION['mock_store']['alat'][$nextId] = $data;
        return $nextId;
    }

    public function update(int $id, array $data): bool {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("
                    UPDATE alat 
                    SET kode_alat = :kode_alat, nama_alat = :nama_alat, id_lab = :id_lab, 
                        kategori = :kategori, jumlah = :jumlah, kondisi = :kondisi, 
                        status = :status, deskripsi = :deskripsi, gambar = :gambar
                    WHERE id = :id
                ");
                $data['id'] = $id;
                $data['id_lab'] = (int)$data['id_lab'];
                $data['jumlah'] = (int)$data['jumlah'];
                return $stmt->execute($data);
            } catch (\Exception $e) {
                // Fallback
            }
        }

        if (isset($_SESSION['mock_store']['alat'][$id])) {
            $data['id'] = $id;
            $data['id_lab'] = (int)$data['id_lab'];
            $data['jumlah'] = (int)$data['jumlah'];
            $_SESSION['mock_store']['alat'][$id] = array_merge(
                $_SESSION['mock_store']['alat'][$id],
                $data
            );
            return true;
        }
        return false;
    }

    public function delete(int $id): bool {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("DELETE FROM alat WHERE id = :id");
                return $stmt->execute(['id' => $id]);
            } catch (\Exception $e) {
                // Fallback
            }
        }

        if (isset($_SESSION['mock_store']['alat'][$id])) {
            unset($_SESSION['mock_store']['alat'][$id]);
            return true;
        }
        return false;
    }

    public function countTotal(): int {
        return count($this->getAll());
    }

    public function countByStatus(string $status): int {
        $count = 0;
        foreach ($this->getAll() as $item) {
            if (strcasecmp($item['status'], $status) === 0) {
                $count++;
            }
        }
        return $count;
    }
}

