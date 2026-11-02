<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Riwayat Peminjaman</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">
            Seluruh riwayat transaksi peminjaman alat oleh mahasiswa ini.
        </p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/mahasiswa') ?>" class="btn btn-secondary">← Kembali</a>
    </div>
</div>

<!-- Profil Mahasiswa -->
<div class="card" style="margin-bottom: 24px;">
    <div class="card-body" style="display: flex; align-items: center; gap: 20px; padding: 20px;">
        <div style="width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), #00b377);
                    display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 700; color: #111; flex-shrink: 0;">
            <?= strtoupper(substr($mhs['nama'], 0, 1)) ?>
        </div>
        <div style="flex: 1;">
            <div style="font-size: 18px; font-weight: 700; color: var(--text-main);"><?= e($mhs['nama']) ?></div>
            <div style="font-size: 13px; color: var(--text-muted); margin-top: 2px;">
                <span class="badge badge-sku"><?= e($mhs['nim']) ?></span>
                &nbsp;<?= e($mhs['prodi']) ?>
            </div>
        </div>
        <div style="display: flex; gap: 32px; text-align: center;">
            <div>
                <div style="font-size: 28px; font-weight: 800; color: var(--text-main);"><?= $totalPinjam ?></div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px;">Total Transaksi</div>
            </div>
            <div>
                <div style="font-size: 28px; font-weight: 800; color: var(--warning);"><?= $masihDipinjam ?></div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px;">Masih Dipinjam</div>
            </div>
            <div>
                <div style="font-size: 28px; font-weight: 800; color: var(--success);"><?= $sudahKembali ?></div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px;">Sudah Kembali</div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Riwayat -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Riwayat Transaksi Peminjaman</div>
        <span style="font-size: 12px; color: var(--text-muted);"><?= $totalPinjam ?> transaksi ditemukan</span>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 150px;">Kode Transaksi</th>
                    <th>Alat yang Dipinjam</th>
                    <th style="text-align: center; width: 60px;">Qty</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th style="text-align: right; width: 80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="7" class="empty-state">
                            Mahasiswa ini belum pernah meminjam alat laboratorium.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($riwayat as $item): ?>
                        <tr>
                            <td>
                                <span class="badge badge-sku"><?= e($item['kode_transaksi']) ?></span>
                            </td>
                            <td>
                                <div style="font-weight: 600;"><?= e($item['nama_alat'] ?? '-') ?></div>
                                <small style="color: var(--text-muted); font-size: 11px;"><?= e($item['kode_alat'] ?? '-') ?></small>
                            </td>
                            <td style="text-align: center; font-weight: 700;"><?= e((string)$item['jumlah']) ?></td>
                            <td><?= e($item['tanggal_pinjam']) ?></td>
                            <td>
                                <?php if (!empty($item['tanggal_kembali']) && $item['status'] === 'Kembali'): ?>
                                    <?= e($item['tanggal_kembali']) ?>
                                <?php else: ?>
                                    <span style="color: var(--text-muted);">-</span>
                                <?php endif; ?>
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
                            <td style="text-align: right;">
                                <a href="<?= base_url('/peminjaman/detail/' . $item['id']) ?>"
                                   class="btn btn-secondary btn-sm">Detail</a>
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