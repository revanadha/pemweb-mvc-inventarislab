<?php

namespace App\Repositories;

use App\Config\Database;
use App\Models\Mahasiswa;
use PDO;

class MahasiswaRepository {
    private ?PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->initMockData();
    }

    private function initMockData(): void {
        if (!isset($_SESSION['mock_store']['mahasiswa'])) {
            $_SESSION['mock_store']['mahasiswa'] = [
                1 => [
                    'id' => 1,
                    'nim' => '2400018001',
                    'nama' => 'Muhammad Rizky Pratama',
                    'prodi' => 'Informatika',
                    'email' => 'rizky.pratama@student.ac.id',
                    'no_telp' => '081234567890',
                    'status' => 'Aktif'
                ],
                2 => [
                    'id' => 2,
                    'nim' => '2400018025',
                    'nama' => 'Siti Aisyah Nurhaliza',
                    'prodi' => 'Sistem Informasi',
                    'email' => 'aisyah.nurhaliza@student.ac.id',
                    'no_telp' => '081298765432',
                    'status' => 'Aktif'
                ],
                3 => [
                    'id' => 3,
                    'nim' => '2400018042',
                    'nama' => 'Fajar Nugraha',
                    'prodi' => 'Informatika',
                    'email' => 'fajar.nugraha@student.ac.id',
                    'no_telp' => '081377889900',
                    'status' => 'Aktif'
                ],
                4 => [
                    'id' => 4,
                    'nim' => '2400018060',
                    'nama' => 'Amanda Putri Lestari',
                    'prodi' => 'Teknik Elektro',
                    'email' => 'amanda.putri@student.ac.id',
                    'no_telp' => '081566778899',
                    'status' => 'Aktif'
                ]
            ];
        }
    }

    public function getAll(): array {
        if ($this->db) {
            try {
                $stmt = $this->db->query("SELECT * FROM mahasiswa ORDER BY nim ASC");
                return $stmt->fetchAll();
            } catch (\Exception $e) {
                // Fallback
            }
        }
        return array_values($_SESSION['mock_store']['mahasiswa']);
    }

    public function findById(int $id): ?array {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM mahasiswa WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $res = $stmt->fetch();
                return $res ?: null;
            } catch (\Exception $e) {
                // Fallback
            }
        }
        return $_SESSION['mock_store']['mahasiswa'][$id] ?? null;
    }

    public function findByNim(string $nim): ?array {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("SELECT * FROM mahasiswa WHERE nim = :nim");
                $stmt->execute(['nim' => $nim]);
                $res = $stmt->fetch();
                return $res ?: null;
            } catch (\Exception $e) {
                // Fallback
            }
        }
        foreach ($_SESSION['mock_store']['mahasiswa'] as $mhs) {
            if ($mhs['nim'] === $nim) {
                return $mhs;
            }
        }
        return null;
    }

    public function create(array $data): int {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("
                    INSERT INTO mahasiswa (nim, nama, prodi, email, no_telp, status)
                    VALUES (:nim, :nama, :prodi, :email, :no_telp, :status)
                ");
                $stmt->execute([
                    'nim' => $data['nim'],
                    'nama' => $data['nama'],
                    'prodi' => $data['prodi'],
                    'email' => $data['email'],
                    'no_telp' => $data['no_telp'],
                    'status' => $data['status'] ?? 'Aktif'
                ]);
                return (int)$this->db->lastInsertId();
            } catch (\Exception $e) {
                // Fallback
            }
        }

        $items = $_SESSION['mock_store']['mahasiswa'];
        $nextId = empty($items) ? 1 : (max(array_keys($items)) + 1);
        $data['id'] = $nextId;
        $data['status'] = $data['status'] ?? 'Aktif';
        $_SESSION['mock_store']['mahasiswa'][$nextId] = $data;
        return $nextId;
    }

    public function update(int $id, array $data): bool {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("
                    UPDATE mahasiswa 
                    SET nim = :nim, nama = :nama, prodi = :prodi, 
                        email = :email, no_telp = :no_telp, status = :status
                    WHERE id = :id
                ");
                $data['id'] = $id;
                return $stmt->execute($data);
            } catch (\Exception $e) {
                // Fallback
            }
        }

        if (isset($_SESSION['mock_store']['mahasiswa'][$id])) {
            $data['id'] = $id;
            $_SESSION['mock_store']['mahasiswa'][$id] = array_merge(
                $_SESSION['mock_store']['mahasiswa'][$id],
                $data
            );
            return true;
        }
        return false;
    }

    public function delete(int $id): bool {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("DELETE FROM mahasiswa WHERE id = :id");
                return $stmt->execute(['id' => $id]);
            } catch (\Exception $e) {
                // Fallback
            }
        }

        if (isset($_SESSION['mock_store']['mahasiswa'][$id])) {
            unset($_SESSION['mock_store']['mahasiswa'][$id]);
            return true;
        }
        return false;
    }
}

