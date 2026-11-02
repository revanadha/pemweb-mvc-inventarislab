<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Detail Transaksi Peminjaman</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">
            Informasi lengkap transaksi peminjaman alat laboratorium.
        </p>
    </div>
    <div class="toolbar-group">
        <?php if ($item['status'] === 'Dipinjam'): ?>
            <a href="<?= base_url('/peminjaman/edit/' . $item['id']) ?>" class="btn btn-secondary">
                ✏️ Edit
            </a>
        <?php endif; ?>
        <a href="<?= base_url('/peminjaman') ?>" class="btn btn-secondary">← Kembali</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; max-width: 900px;">

    <div class="card">
        <div class="card-header">
            <div class="card-title">Informasi Transaksi</div>
        </div>
        <div class="card-body" style="display: flex; flex-direction: column; gap: 14px;">
            <div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Kode Transaksi</div>
                <span class="badge badge-sku"><?= e($item['kode_transaksi']) ?></span>
            </div>
            <div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Status</div>
                <?php if ($item['status'] === 'Dipinjam'): ?>
                    <span class="badge badge-warning">Dipinjam</span>
                <?php elseif ($item['status'] === 'Kembali'): ?>
                    <span class="badge badge-success">Selesai / Dikembalikan</span>
                <?php else: ?>
                    <span class="badge badge-muted"><?= e($item['status']) ?></span>
                <?php endif; ?>
            </div>
            <div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Tanggal Pinjam</div>
                <div style="font-weight: 600;"><?= e($item['tanggal_pinjam']) ?></div>
            </div>
            <div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Tanggal Kembali</div>
                <div style="font-weight: 600;">
                    <?= !empty($item['tanggal_kembali']) ? e($item['tanggal_kembali']) : '<span style="color:var(--text-muted)">Belum dikembalikan</span>' ?>
                </div>
            </div>
            <div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Jumlah Unit</div>
                <div style="font-weight: 600; font-size: 20px; color: var(--primary);"><?= e((string)$item['jumlah']) ?></div>
            </div>
            <div>
                <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Keperluan / Catatan</div>
                <div style="color: var(--text-secondary);"><?= !empty($item['catatan']) ? e($item['catatan']) : '<em style="color:var(--text-muted)">-</em>' ?></div>
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Mahasiswa Peminjam</div>
            </div>
            <div class="card-body" style="display: flex; flex-direction: column; gap: 10px;">
                <div>
                    <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Nama</div>
                    <div style="font-weight: 600;"><?= e($item['nama_mahasiswa'] ?? '-') ?></div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">NIM</div>
                    <span class="badge badge-sku"><?= e($item['nim'] ?? '-') ?></span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">Alat yang Dipinjam</div>
            </div>
            <div class="card-body" style="display: flex; flex-direction: column; gap: 10px;">
                <div>
                    <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Nama Alat</div>
                    <div style="font-weight: 600;"><?= e($item['nama_alat'] ?? '-') ?></div>
                </div>
                <div>
                    <div style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 4px;">Kode Alat</div>
                    <span class="badge badge-sku"><?= e($item['kode_alat'] ?? '-') ?></span>
                </div>
            </div>
        </div>

        <?php if ($item['status'] === 'Dipinjam'): ?>
        <div class="card" style="border-color: var(--danger); background: rgba(255,59,48,.05);">
            <div class="card-header">
                <div class="card-title" style="color: var(--danger);">Zona Berbahaya</div>
            </div>
            <div class="card-body" style="display: flex; flex-direction: column; gap: 10px;">
                <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
                    Hapus transaksi ini secara permanen dari sistem.
                </p>
                <a href="<?= base_url('/peminjaman/delete/' . $item['id']) ?>"
                   class="btn btn-secondary"
                   style="background: rgba(255,59,48,.15); color: var(--danger); border-color: var(--danger);"
                   onclick="return confirm('Yakin ingin menghapus transaksi ini? Tindakan tidak dapat dibatalkan.');">
                    🗑️ Hapus Transaksi Ini
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layout/footer.php';
?>
