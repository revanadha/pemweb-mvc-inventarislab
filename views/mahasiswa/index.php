<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Data Mahasiswa</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Kelola data mahasiswa peminjam fasilitas dan instrumen laboratorium terpadu.</p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/mahasiswa/create') ?>" class="btn btn-primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Mahasiswa
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Daftar Mahasiswa Terdaftar</div>
        <span style="font-size: 12px; color: var(--text-muted);">Total <?= count($mahasiswa) ?> mahasiswa</span>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 140px;">NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Program Studi</th>
                    <th>Email Akademik</th>
                    <th>No. Telepon / WhatsApp</th>
                    <th>Status</th>
                    <th style="text-align: right; width: 120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($mahasiswa)): ?>
                    <tr>
                        <td colspan="7" class="empty-state">Belum ada data mahasiswa.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($mahasiswa as $mhs): ?>
                        <tr>
                            <td>
                                <span class="badge badge-sku"><?= e($mhs['nim']) ?></span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--text-main);"><?= e($mhs['nama']) ?></div>
                            </td>
                            <td><span style="color: var(--text-muted);"><?= e($mhs['prodi']) ?></span></td>
                            <td><?= e($mhs['email'] ?? '-') ?></td>
                            <td><?= e($mhs['no_telp'] ?? '-') ?></td>
                            <td>
                                <?php if ($mhs['status'] === 'Aktif'): ?>
                                    <span class="badge badge-success">Aktif</span>
                                <?php else: ?>
                                    <span class="badge badge-danger"><?= e($mhs['status']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="<?= base_url('/mahasiswa/riwayat/' . $mhs['id']) ?>"
                                   class="btn btn-secondary btn-sm" title="Lihat Riwayat Peminjaman">
                                    Riwayat
                                </a>
                                <a href="<?= base_url('/mahasiswa/edit/' . $mhs['id']) ?>" class="btn-icon" title="Edit Mahasiswa" aria-label="Edit Mahasiswa">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                <a href="<?= base_url('/mahasiswa/delete/' . $mhs['id']) ?>"
                                   class="btn-icon danger"
                                   title="Hapus Mahasiswa"
                                   aria-label="Hapus Mahasiswa"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data mahasiswa <?= e(addslashes($mhs['nama'])) ?>?');">
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

