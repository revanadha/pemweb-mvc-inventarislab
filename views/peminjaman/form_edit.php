<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Edit Transaksi Peminjaman</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">
            Perbarui data peminjaman alat laboratorium.
        </p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/peminjaman') ?>" class="btn btn-secondary">← Kembali</a>
    </div>
</div>

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Edit Formulir</div>
        <span class="badge badge-sku"><?= e($item['kode_transaksi']) ?></span>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/peminjaman/update/' . $item['id']) ?>" method="POST">

            <div class="form-group">
                <label for="id_mahasiswa" class="form-label">Mahasiswa Peminjam <span style="color: var(--danger);">*</span></label>
                <select id="id_mahasiswa" name="id_mahasiswa" class="form-select" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    <?php foreach ($mahasiswa as $mhs): ?>
                        <option value="<?= e((string)$mhs['id']) ?>"
                            <?= (int)$mhs['id'] === (int)$item['id_mahasiswa'] ? 'selected' : '' ?>>
                            <?= e($mhs['nim']) ?> - <?= e($mhs['nama']) ?> (<?= e($mhs['prodi']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_alat" class="form-label">Alat / Perangkat yang Dipinjam <span style="color: var(--danger);">*</span></label>
                <select id="id_alat" name="id_alat" class="form-select" required>
                    <option value="">-- Pilih Alat --</option>
                    <?php foreach ($alat as $a): ?>
                        <option value="<?= e((string)$a['id']) ?>"
                            <?= (int)$a['id'] === (int)$item['id_alat'] ? 'selected' : '' ?>>
                            [<?= e($a['kode_alat']) ?>] <?= e($a['nama_alat']) ?> (Stok: <?= e((string)$a['jumlah']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Peminjaman <span style="color: var(--danger);">*</span></label>
                    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control"
                           value="<?= e($item['tanggal_pinjam']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="jumlah" class="form-label">Jumlah Unit <span style="color: var(--danger);">*</span></label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control"
                           min="1" value="<?= e((string)$item['jumlah']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="catatan" class="form-label">Keperluan / Catatan</label>
                <textarea id="catatan" name="catatan" class="form-control" rows="3"
                          placeholder="Contoh: Praktikum Pemrograman Web / Tugas Akhir"><?= e($item['catatan'] ?? '') ?></textarea>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border);">
                <a href="<?= base_url('/peminjaman/delete/' . $item['id']) ?>"
                   style="color: var(--danger); font-size: 13px; text-decoration: none;"
                   onclick="return confirm('Yakin ingin menghapus transaksi ini? Tindakan tidak dapat dibatalkan.');">
                    🗑️ Hapus Transaksi
                </a>
                <div style="display: flex; gap: 12px;">
                    <a href="<?= base_url('/peminjaman') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layout/footer.php';
?>
