<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Laboratorium</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Kelola data ruangan, kapasitas, dan penanggung jawab laboratorium komputer & elektronika.</p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/lab/create') ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Lab Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Laboratorium Terpadu</div>
        <span style="font-size: 12px; color: var(--text-muted);">Total <?= count($labs) ?> laboratorium</span>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 140px;">Kode Lab</th>
                    <th>Nama Laboratorium</th>
                    <th>Lokasi Gedung / Ruang</th>
                    <th style="text-align: center; width: 100px;">Kapasitas</th>
                    <th>Kepala Lab / PIC</th>
                    <th style="text-align: right; width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($labs)): ?>
                    <tr>
                        <td colspan="6" class="empty-state">Belum ada data laboratorium.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($labs as $lab): ?>
                        <tr>
                            <td>
                                <span class="badge badge-sku"><?= e($lab['kode_lab']) ?></span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--text-main);"><?= e($lab['nama_lab']) ?></div>
                                <?php if (!empty($lab['deskripsi'])): ?>
                                    <small style="color: var(--text-muted); font-size: 11px;">
                                        <?= e(mb_strimwidth($lab['deskripsi'], 0, 60, '...')) ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td><?= e($lab['lokasi']) ?></td>
                            <td style="text-align: center; font-weight: 600;"><?= e((string)$lab['kapasitas']) ?> Kursi</td>
                            <td><span style="color: var(--primary);"><?= e($lab['kepala_lab']) ?></span></td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="<?= base_url('/lab/edit/' . $lab['id']) ?>" class="btn-icon" title="Edit Lab" aria-label="Edit Lab">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                <a href="<?= base_url('/lab/delete/' . $lab['id']) ?>" 
                                   class="btn-icon danger" 
                                   title="Hapus Lab" 
                                   aria-label="Hapus Lab"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus lab <?= e(addslashes($lab['nama_lab'])) ?>?');">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
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

