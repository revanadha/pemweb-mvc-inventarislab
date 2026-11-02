<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard Inventaris Lab</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Selamat datang di Sistem Manajemen & Peminjaman Alat Laboratorium Terpadu.</p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/alat/create') ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Alat Baru
        </a>
        <a href="<?= base_url('/peminjaman/create') ?>" class="btn btn-secondary">
            Catat Peminjaman
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value"><?= e((string)$stats['total_alat']) ?></div>
            <div class="stat-label">Total Unit Alat</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 21h18"></path>
                <path d="M5 21V7l8-4v18"></path>
                <path d="M19 21V11l-6-3"></path>
            </svg>
        </div>
        <div>
            <div class="stat-value"><?= e((string)$stats['total_lab']) ?></div>
            <div class="stat-label">Laboratorium Aktif</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
            </svg>
        </div>
        <div>
            <div class="stat-value"><?= e((string)$stats['total_mhs']) ?></div>
            <div class="stat-label">Mahasiswa Terdaftar</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
        </div>
        <div>
            <div class="stat-value" style="color: var(--primary);"><?= e((string)$stats['pinjam_aktif']) ?></div>
            <div class="stat-label">Peminjaman Berjalan</div>
        </div>
    </div>
</div>

<!-- Recent Alat Table -->
<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <div class="card-title">Inventaris Alat Terbaru</div>
        <a href="<?= base_url('/alat') ?>" class="btn btn-secondary btn-sm">Lihat Semua Alat &rarr;</a>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 140px;">Kode Alat</th>
                    <th>Nama Perangkat / Spesifikasi</th>
                    <th>Kategori</th>
                    <th>Laboratorium</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th>Status</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentAlat)): ?>
                    <tr>
                        <td colspan="7" class="empty-state">Belum ada inventaris alat yang tersimpan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recentAlat as $item): ?>
                        <tr>
                            <td>
                                <span class="badge badge-sku"><?= e($item['kode_alat']) ?></span>
                            </td>
                            <td>
                                <a href="<?= base_url('/alat/detail/' . $item['id']) ?>" style="font-weight: 600;">
                                    <?= e($item['nama_alat']) ?>
                                </a>
                            </td>
                            <td><span style="color: var(--text-muted);"><?= e($item['kategori']) ?></span></td>
                            <td><?= e($item['nama_lab'] ?? '-') ?></td>
                            <td style="text-align: center; font-weight: 600;"><?= e((string)$item['jumlah']) ?></td>
                            <td>
                                <?php if ($item['status'] === 'Tersedia'): ?>
                                    <span class="badge badge-success">Tersedia</span>
                                <?php elseif ($item['status'] === 'Dipinjam'): ?>
                                    <span class="badge badge-warning">Dipinjam</span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><?= e($item['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right;">
                                <a href="<?= base_url('/alat/edit/' . $item['id']) ?>" class="btn-icon" title="Edit Alat">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layout/footer.php';
?>

