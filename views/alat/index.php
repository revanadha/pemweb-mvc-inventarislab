<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Alat Laboratorium</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Kelola seluruh inventaris perangkat dan instrumen laboratorium terpadu.</p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/alat/create') ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Alat Baru
        </a>
    </div>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
    <form action="<?= base_url('/alat') ?>" method="GET" class="filter-form">
        <div style="flex: 1; min-width: 200px;">
            <input type="text" name="q" class="form-control" placeholder="Cari nama alat, SKU, atau kategori..." value="<?= e($keyword ?? '') ?>">
        </div>
        <div style="width: 220px;">
            <select name="lab_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Semua Laboratorium --</option>
                <?php foreach ($labs as $lab): ?>
                    <option value="<?= e((string)$lab['id']) ?>" <?= ($selectedLab ?? null) == $lab['id'] ? 'selected' : '' ?>>
                        <?= e($lab['nama_lab']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        <?php if (!empty($keyword) || !empty($selectedLab)): ?>
            <a href="<?= base_url('/alat') ?>" class="btn btn-secondary btn-sm" style="color: var(--text-muted);">Reset</a>
        <?php endif; ?>
    </form>
</div>

<!-- Table Card -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Inventaris Alat</div>
        <span style="font-size: 12px; color: var(--text-muted);">Menampilkan <?= count($items) ?> unit perangkat</span>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 40px; text-align: center;">
                        <input type="checkbox" id="selectAll" aria-label="Pilih Semua">
                    </th>
                    <th style="width: 130px;">Kode Alat</th>
                    <th>Nama Alat & Spesifikasi</th>
                    <th>Kategori</th>
                    <th style="text-align: center; width: 70px;">Jumlah</th>
                    <th>Lokasi Lab</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th style="text-align: right; width: 130px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($items)): ?>
                    <tr>
                        <td colspan="9" class="empty-state">
                            <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <p>Tidak ada data alat yang sesuai dengan filter.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($items as $alat): ?>
                        <tr>
                            <td style="text-align: center;">
                                <input type="checkbox" class="row-checkbox" aria-label="Pilih alat <?= e($alat['nama_alat']) ?>">
                            </td>
                            <td>
                                <span class="badge badge-sku"><?= e($alat['kode_alat']) ?></span>
                            </td>
                            <td>
                                <div>
                                    <a href="<?= base_url('/alat/detail/' . $alat['id']) ?>" style="font-weight: 600; display: block;">
                                        <?= e($alat['nama_alat']) ?>
                                    </a>
                                    <?php if (!empty($alat['deskripsi'])): ?>
                                        <small style="color: var(--text-muted); font-size: 11px;">
                                            <?= e(mb_strimwidth($alat['deskripsi'], 0, 50, '...')) ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--text-muted);"><?= e($alat['kategori']) ?></span>
                            </td>
                            <td style="text-align: center; font-weight: 600;">
                                <?= e((string)$alat['jumlah']) ?>
                            </td>
                            <td>
                                <div style="font-size: 13px; font-weight: 500;"><?= e($alat['nama_lab'] ?? '-') ?></div>
                                <small style="color: var(--text-muted); font-size: 11px;"><?= e($alat['lokasi_lab'] ?? '') ?></small>
                            </td>
                            <td>
                                <?php if ($alat['kondisi'] === 'Baik'): ?>
                                    <span class="badge badge-success">Baik</span>
                                <?php elseif ($alat['kondisi'] === 'Perbaikan'): ?>
                                    <span class="badge badge-warning">Perbaikan</span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><?= e($alat['kondisi']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($alat['status'] === 'Tersedia'): ?>
                                    <span class="badge badge-success">Tersedia</span>
                                <?php elseif ($alat['status'] === 'Dipinjam'): ?>
                                    <span class="badge badge-warning">Dipinjam</span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><?= e($alat['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="<?= base_url('/alat/detail/' . $alat['id']) ?>" class="btn-icon" title="Detail Alat" aria-label="Detail Alat">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                <a href="<?= base_url('/alat/edit/' . $alat['id']) ?>" class="btn-icon" title="Edit Alat" aria-label="Edit Alat">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                <a href="<?= base_url('/alat/delete/' . $alat['id']) ?>" 
                                   class="btn-icon danger" 
                                   title="Hapus Alat" 
                                   aria-label="Hapus Alat"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus alat <?= e(addslashes($alat['nama_alat'])) ?>?');">
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

<script>
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = selectAll.checked);
        });
    }
</script>

<?php
require_once dirname(__DIR__) . '/layout/footer.php';
?>

