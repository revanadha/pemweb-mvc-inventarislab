<?php

namespace App\Repositories;

use App\Config\Database;
use App\Models\Peminjaman;
use PDO;

class PeminjamanRepository {
    private ?PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->initMockData();
    }

    private function initMockData(): void {
        if (!isset($_SESSION['mock_store']['peminjaman'])) {
            $_SESSION['mock_store']['peminjaman'] = [
                1 => [
                    'id' => 1,
                    'kode_transaksi' => 'TRX-202611-001',
                    'id_mahasiswa' => 1,
                    'id_alat' => 1,
                    'tanggal_pinjam' => '2026-11-01',
                    'tanggal_kembali' => '2026-11-05',
                    'jumlah' => 2,
                    'status' => 'Dipinjam',
                    'catatan' => 'Praktikum jaringan komputer mandiri.'
                ],
                2 => [
                    'id' => 2,
                    'kode_transaksi' => 'TRX-202611-002',
                    'id_mahasiswa' => 2,
                    'id_alat' => 3,
                    'tanggal_pinjam' => '2026-11-02',
                    'tanggal_kembali' => '2026-11-04',
                    'jumlah' => 1,
                    'status' => 'Dipinjam',
                    'catatan' => 'Tugas akhir simulasi interaktif VR.'
                ],
                3 => [
                    'id' => 3,
                    'kode_transaksi' => 'TRX-202610-025',
                    'id_mahasiswa' => 3,
                    'id_alat' => 2,
                    'tanggal_pinjam' => '2026-10-25',
                    'tanggal_kembali' => '2026-10-28',
                    'jumlah' => 1,
                    'status' => 'Kembali',
                    'catatan' => 'Alat dikembalikan dalam kondisi baik.'
                ]
            ];
        }
    }

    public function getAll(?string $status = null, ?string $keyword = null): array {
        if ($this->db) {
            try {
                $sql = "
                    SELECT p.*, m.nama as nama_mahasiswa, m.nim, a.nama_alat, a.kode_alat
                    FROM peminjaman p
                    LEFT JOIN mahasiswa m ON p.id_mahasiswa = m.id
                    LEFT JOIN alat a ON p.id_alat = a.id
                    WHERE 1=1
                ";
                $params = [];
                if ($status) {
                    $sql .= " AND p.status = :status";
                    $params['status'] = $status;
                }
                if ($keyword) {
                    $sql .= " AND (m.nama LIKE :kw OR m.nim LIKE :kw OR a.nama_alat LIKE :kw OR p.kode_transaksi LIKE :kw)";
                    $params['kw'] = '%' . $keyword . '%';
                }
                $sql .= " ORDER BY p.id DESC";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);
                return $stmt->fetchAll();
            } catch (\Exception $e) {
                // Fallback
            }
        }

        $mhsRepo  = new MahasiswaRepository();
        $alatRepo = new AlatRepository();

        $results = [];
        foreach ($_SESSION['mock_store']['peminjaman'] as $p) {
            $m = $mhsRepo->findById((int)$p['id_mahasiswa']);
            $a = $alatRepo->findById((int)$p['id_alat']);
            $p['nama_mahasiswa'] = $m['nama'] ?? 'Mahasiswa #' . $p['id_mahasiswa'];
            $p['nim']            = $m['nim']  ?? '-';
            $p['nama_alat']      = $a['nama_alat']  ?? 'Alat #' . $p['id_alat'];
            $p['kode_alat']      = $a['kode_alat']  ?? '-';

            // Filter status
            if ($status && strcasecmp($p['status'], $status) !== 0) continue;

            // Filter keyword
            if ($keyword) {
                $kw = strtolower($keyword);
                $match = str_contains(strtolower($p['nama_mahasiswa']), $kw)
                      || str_contains(strtolower($p['nim']), $kw)
                      || str_contains(strtolower($p['nama_alat']), $kw)
                      || str_contains(strtolower($p['kode_transaksi']), $kw);
                if (!$match) continue;
            }

            $results[] = $p;
        }

        usort($results, fn($a, $b) => $b['id'] <=> $a['id']);
        return $results;
    }

    public function findById(int $id): ?array {
        foreach ($this->getAll() as $item) {
            if ((int)$item['id'] === $id) {
                return $item;
            }
        }
        return null;
    }

    public function create(array $data): int {
        $items = $_SESSION['mock_store']['peminjaman'];
        $nextId = empty($items) ? 1 : (max(array_keys($items)) + 1);
        $data['id'] = $nextId;
        $data['kode_transaksi'] = 'TRX-' . date('Ymd') . '-' . sprintf('%03d', $nextId);
        $data['id_mahasiswa'] = (int)$data['id_mahasiswa'];
        $data['id_alat'] = (int)$data['id_alat'];
        $data['jumlah'] = (int)($data['jumlah'] ?? 1);
        $data['status'] = $data['status'] ?? 'Dipinjam';
        $_SESSION['mock_store']['peminjaman'][$nextId] = $data;
        return $nextId;
    }

    public function updateStatus(int $id, string $status): bool {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("UPDATE peminjaman SET status = :status WHERE id = :id");
                return $stmt->execute(['status' => $status, 'id' => $id]);
            } catch (\Exception $e) {
                // Fallback
            }
        }
        if (isset($_SESSION['mock_store']['peminjaman'][$id])) {
            $_SESSION['mock_store']['peminjaman'][$id]['status'] = $status;
            if ($status === 'Kembali') {
                $_SESSION['mock_store']['peminjaman'][$id]['tanggal_kembali'] = date('Y-m-d');
            }
            return true;
        }
        return false;
    }

    public function update(int $id, array $data): bool {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("
                    UPDATE peminjaman
                    SET id_mahasiswa   = :id_mahasiswa,
                        id_alat        = :id_alat,
                        tanggal_pinjam = :tanggal_pinjam,
                        jumlah         = :jumlah,
                        catatan        = :catatan
                    WHERE id = :id
                ");
                return $stmt->execute([
                    'id_mahasiswa'   => (int)$data['id_mahasiswa'],
                    'id_alat'        => (int)$data['id_alat'],
                    'tanggal_pinjam' => $data['tanggal_pinjam'],
                    'jumlah'         => (int)$data['jumlah'],
                    'catatan'        => $data['catatan'] ?? null,
                    'id'             => $id,
                ]);
            } catch (\Exception $e) {
                // Fallback
            }
        }

        if (isset($_SESSION['mock_store']['peminjaman'][$id])) {
            $_SESSION['mock_store']['peminjaman'][$id] = array_merge(
                $_SESSION['mock_store']['peminjaman'][$id],
                [
                    'id_mahasiswa'   => (int)$data['id_mahasiswa'],
                    'id_alat'        => (int)$data['id_alat'],
                    'tanggal_pinjam' => $data['tanggal_pinjam'],
                    'jumlah'         => (int)$data['jumlah'],
                    'catatan'        => $data['catatan'] ?? null,
                ]
            );
            return true;
        }
        return false;
    }

    public function delete(int $id): bool {
        if ($this->db) {
            try {
                $stmt = $this->db->prepare("DELETE FROM peminjaman WHERE id = :id");
                return $stmt->execute(['id' => $id]);
            } catch (\Exception $e) {
                // Fallback
            }
        }

        if (isset($_SESSION['mock_store']['peminjaman'][$id])) {
            unset($_SESSION['mock_store']['peminjaman'][$id]);
            return true;
        }
        return false;
    }

    public function countActive(): int {
        $count = 0;
        foreach ($_SESSION['mock_store']['peminjaman'] as $p) {
            if ($p['status'] === 'Dipinjam') {
                $count++;
            }
        }
        return $count;
    }
}

