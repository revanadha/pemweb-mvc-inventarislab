<?php

namespace App\Repositories;

use App\Config\Database;
use App\Models\Laboratorium;
use PDO;

class LabRepository {
    private ?PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->initMockData();
    }

    private function initMockData(): void {
        if (!isset($_SESSION['mock_store']['laboratorium'])) {
            $_SESSION['mock_store']['laboratorium'] = [
                1 => [
                    'id' => 1,
                    'kode_lab' => 'LAB-KOM-01',
                    'nama_lab' => 'Lab Komputer Dasar',
                    'lokasi' => 'Gedung B Lt. 2',
                    'kapasitas' => 40,
                    'kepala_lab' => 'Dr. Hendra Wijaya, M.Kom',
                    'deskripsi' => 'Fasilitas praktikum pemrograman dasar, basis data, dan algoritma.'
                ],
                2 => [
                    'id' => 2,
                    'kode_lab' => 'LAB-NET-02',
                    'nama_lab' => 'Lab Jaringan & Siber',
                    'lokasi' => 'Gedung B Lt. 3',
                    'kapasitas' => 30,
                    'kepala_lab' => 'Ir. Maya Safitri, M.T',
                    'deskripsi' => 'Dilengkapi perangkat switch, router enterprise, server rack, dan firewall.'
                ],
                3 => [
                    'id' => 3,
                    'kode_lab' => 'LAB-RPL-03',
                    'nama_lab' => 'Lab Rekayasa Perangkat Lunak',
                    'lokasi' => 'Gedung C Lt. 1',
                    'kapasitas' => 35,
                    'kepala_lab' => 'Rian Hidayat, S.Kom, M.Cs',
                    'deskripsi' => 'Pengembangan sistem informasi, riset UI/UX, dan peranti lunak cerdas.'
                ],
                4 => [
                    'id' => 4,
                    'kode_lab' => 'LAB-IOT-04',
                    'nama_lab' => 'Lab Elektronika & IoT',
                    'lokasi' => 'Gedung A Lt. 2',
                    'kapasitas' => 25,
                    'kepala_lab' => 'Ahmad Fauzi, M.T',
                    'deskripsi' => 'Eksperimen mikrokontroler, instrumen elektronika, sensor, dan peranti IoT.'
                ]
            ];
        }
    }

    public function getAll(): array {
        if ($this->db) {
            try {
                $stmt = $this->db->query("SELECT * FROM laboratorium ORDER BY id ASC");
                return $stmt->fetchAll();
            } catch (\Exception $e) {
                // Fallback to mock session data
            }
        }
        return array_values($_SESSION['mock_store']['laboratorium']);
    }

    public function findById(int $id): ?array {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM laboratorium WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $res = $stmt->fetch();
                return $res ?: null;
            } catch (\Exception $e) {
                // Fallback
            }
        }
        return $_SESSION['mock_store']['laboratorium'][$id] ?? null;
    }

    public function create(array $data): int {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("
                    INSERT INTO laboratorium (kode_lab, nama_lab, lokasi, kapasitas, kepala_lab, deskripsi)
                    VALUES (:kode_lab, :nama_lab, :lokasi, :kapasitas, :kepala_lab, :deskripsi)
                ");
                $stmt->execute([
                    'kode_lab' => $data['kode_lab'],
                    'nama_lab' => $data['nama_lab'],
                    'lokasi' => $data['lokasi'],
                    'kapasitas' => (int)$data['kapasitas'],
                    'kepala_lab' => $data['kepala_lab'],
                    'deskripsi' => $data['deskripsi'] ?? null
                ]);
                return (int)$this->db->lastInsertId();
            } catch (\Exception $e) {
                // Fallback
            }
        }

        $items = $_SESSION['mock_store']['laboratorium'];
        $nextId = empty($items) ? 1 : (max(array_keys($items)) + 1);
        $data['id'] = $nextId;
        $data['kapasitas'] = (int)$data['kapasitas'];
        $_SESSION['mock_store']['laboratorium'][$nextId] = $data;
        return $nextId;
    }

    public function update(int $id, array $data): bool {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("
                    UPDATE laboratorium 
                    SET kode_lab = :kode_lab, nama_lab = :nama_lab, lokasi = :lokasi, 
                        kapasitas = :kapasitas, kepala_lab = :kepala_lab, deskripsi = :deskripsi
                    WHERE id = :id
                ");
                $data['id'] = $id;
                $data['kapasitas'] = (int)$data['kapasitas'];
                return $stmt->execute($data);
            } catch (\Exception $e) {
                // Fallback
            }
        }

        if (isset($_SESSION['mock_store']['laboratorium'][$id])) {
            $data['id'] = $id;
            $data['kapasitas'] = (int)$data['kapasitas'];
            $_SESSION['mock_store']['laboratorium'][$id] = array_merge(
                $_SESSION['mock_store']['laboratorium'][$id],
                $data
            );
            return true;
        }
        return false;
    }

    public function delete(int $id): bool {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("DELETE FROM laboratorium WHERE id = :id");
                return $stmt->execute(['id' => $id]);
            } catch (\Exception $e) {
                // Fallback
            }
        }

        if (isset($_SESSION['mock_store']['laboratorium'][$id])) {
            unset($_SESSION['mock_store']['laboratorium'][$id]);
            return true;
        }
        return false;
    }
}

