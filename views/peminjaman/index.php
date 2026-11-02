<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Sirkulasi & Peminjaman Alat</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Pencatatan peminjaman dan pengembalian instrumen laboratorium terpadu.</p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/peminjaman/create') ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Catat Peminjaman Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Transaksi Peminjaman</div>
        <span style="font-size: 12px; color: var(--text-muted);">Total <?= count($items) ?> catatan transaksi</span>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 140px;">No. Transaksi</th>
                    <th>Mahasiswa Peminjam</th>
                    <th>Perangkat / Alat</th>
                    <th style="text-align: center; width: 60px;">Qty</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th style="text-align: right; width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($items)): ?>
                    <tr>
                        <td colspan="8" class="empty-state">Belum ada transaksi peminjaman tercatat.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <span class="badge badge-sku"><?= e($item['kode_transaksi']) ?></span>
                            </td>
                            <td>
                                <div style="font-weight: 600;"><?= e($item['nama_mahasiswa'] ?? '-') ?></div>
                                <small style="color: var(--text-muted); font-size: 11px;">NIM: <?= e($item['nim'] ?? '-') ?></small>
                            </td>
                            <td>
                                <div style="font-weight: 500;"><?= e($item['nama_alat'] ?? '-') ?></div>
                                <small style="color: var(--text-muted); font-size: 11px;"><?= e($item['kode_alat'] ?? '-') ?></small>
                            </td>
                            <td style="text-align: center; font-weight: 600;"><?= e((string)$item['jumlah']) ?></td>
                            <td><?= e($item['tanggal_pinjam']) ?></td>
                            <td>
                                <?= !empty($item['tanggal_kembali']) ? e($item['tanggal_kembali']) : '<span style="color: var(--text-muted);">-</span>' ?>
                            </td>
                            <td>
                                <?php if ($item['status'] === 'Dipinjam'): ?>
                                    <span class="badge badge-warning">Dipinjam</span>
                                <?php elseif ($item['status'] === 'Kembali'): ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php else: ?>
                                    <span class="badge badge-muted"><?= e($item['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <?php if ($item['status'] === 'Dipinjam'): ?>
                                    <a href="<?= base_url('/peminjaman/kembalikan/' . $item['id']) ?>" 
                                       class="btn btn-secondary btn-sm"
                                       onclick="return confirm('Konfirmasi pengembalian alat ini?');">
                                        Kembalikan
                                    </a>
                                <?php else: ?>
                                    <span style="color: var(--text-muted); font-size: 12px;">Selesai</span>
                                <?php endif; ?>
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

