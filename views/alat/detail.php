<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">
            <span class="badge badge-sku" style="font-size: 14px;"><?= e($alat['kode_alat']) ?></span>
            <?= e($alat['nama_alat']) ?>
        </h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Informasi mendalam spesifikasi dan ketersediaan perangkat laboratorium.</p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/alat') ?>" class="btn btn-secondary">
            &larr; Kembali
        </a>
        <a href="<?= base_url('/alat/edit/' . $alat['id']) ?>" class="btn btn-primary">
            Ubah Data
        </a>
    </div>
</div>

<div class="card" style="max-width: 900px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Rincian Perangkat</div>
        <div>
            <?php if ($alat['status'] === 'Tersedia'): ?>
                <span class="badge badge-success">Tersedia</span>
            <?php elseif ($alat['status'] === 'Dipinjam'): ?>
                <span class="badge badge-warning">Dipinjam</span>
            <?php else: ?>
                <span class="badge badge-danger"><?= e($alat['status']) ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body">
        <div class="detail-grid" style="margin-bottom: 24px;">
            <div class="detail-item">
                <div class="detail-label">Kode Alat / SKU</div>
                <div class="detail-val" style="font-family: var(--font-mono); color: var(--primary);">
                    <?= e($alat['kode_alat']) ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Kategori</div>
                <div class="detail-val"><?= e($alat['kategori']) ?></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Jumlah Fisik Tersedia</div>
                <div class="detail-val"><?= e((string)$alat['jumlah']) ?> Unit</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Kondisi Alat</div>
                <div class="detail-val">
                    <?php if ($alat['kondisi'] === 'Baik'): ?>
                        <span style="color: var(--primary);">Baik / Prima</span>
                    <?php elseif ($alat['kondisi'] === 'Perbaikan'): ?>
                        <span style="color: var(--warning);">Perlu Perbaikan</span>
                    <?php else: ?>
                        <span style="color: var(--danger);"><?= e($alat['kondisi']) ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Laboratorium Penempatan</div>
                <div class="detail-val"><?= e($alat['nama_lab'] ?? '-') ?></div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Lokasi Ruang</div>
                <div class="detail-val"><?= e($alat['lokasi_lab'] ?? '-') ?></div>
            </div>
        </div>

        <div style="background: var(--surface-sidebar); border: 1px solid var(--border); border-radius: var(--radius-btn); padding: 18px 20px;">
            <div style="font-size: 12px; font-weight: 600; text-transform: uppercase; color: var(--text-muted); margin-bottom: 8px;">
                Deskripsi & Catatan Teknis
            </div>
            <p style="color: var(--text-main); font-size: 13px; line-height: 1.6; white-space: pre-line;">
                <?= !empty($alat['deskripsi']) ? e($alat['deskripsi']) : '<em>Tidak ada catatan khusus untuk perangkat ini.</em>' ?>
            </p>
        </div>

        <div style="margin-top: 24px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); padding-top: 16px;">
            <a href="<?= base_url('/alat/delete/' . $alat['id']) ?>" 
               class="btn btn-danger btn-sm"
               onclick="return confirm('Apakah Anda yakin ingin menghapus alat ini dari inventaris?');">
                Hapus Perangkat
            </a>

            <div style="display: flex; gap: 8px;">
                <a href="<?= base_url('/alat/edit/' . $alat['id']) ?>" class="btn btn-secondary btn-sm">
                    Edit Data
                </a>
                <a href="<?= base_url('/peminjaman/create') ?>" class="btn btn-primary btn-sm">
                    Pinjamkan Alat
                </a>
            </div>
        </div>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layout/footer.php';
?>

