<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Pencatatan Peminjaman Alat</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Pilih mahasiswa dan inventaris alat yang akan dipinjam untuk kegiatan akademik atau praktikum.</p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/peminjaman') ?>" class="btn btn-secondary">
            &larr; Kembali
        </a>
    </div>
</div>

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Formulir Peminjaman</div>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/peminjaman/store') ?>" method="POST">
            <div class="form-group">
                <label for="id_mahasiswa" class="form-label">Mahasiswa Peminjam <span style="color: var(--danger);">*</span></label>
                <select id="id_mahasiswa" name="id_mahasiswa" class="form-select" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    <?php foreach ($mahasiswa as $mhs): ?>
                        <option value="<?= e((string)$mhs['id']) ?>">
                            <?= e($mhs['nim']) ?> - <?= e($mhs['nama']) ?> (<?= e($mhs['prodi']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_alat" class="form-label">Alat / Perangkat yang Dipinjam <span style="color: var(--danger);">*</span></label>
                <select id="id_alat" name="id_alat" class="form-select" required>
                    <option value="">-- Pilih Alat --</option>
                    <?php foreach ($alat as $item): ?>
                        <option value="<?= e((string)$item['id']) ?>">
                            [<?= e($item['kode_alat']) ?>] <?= e($item['nama_alat']) ?> (Stok: <?= e((string)$item['jumlah']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="tanggal_pinjam" class="form-label">Tanggal Peminjaman <span style="color: var(--danger);">*</span></label>
                    <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="form-group">
                    <label for="jumlah" class="form-label">Jumlah Unit <span style="color: var(--danger);">*</span></label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control" min="1" value="1" required>
                </div>
            </div>

            <div class="form-group">
                <label for="catatan" class="form-label">Keperluan / Catatan</label>
                <textarea id="catatan" name="catatan" class="form-control" rows="3" placeholder="Contoh: Praktikum Pemrograman Web / Tugas Akhir"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border);">
                <a href="<?= base_url('/peminjaman') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layout/footer.php';
?>

