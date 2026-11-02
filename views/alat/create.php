<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Alat Laboratorium</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Masukkan rincian spesifikasi perangkat atau instrumen laboratorium baru.</p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/alat') ?>" class="btn btn-secondary">
            &larr; Kembali ke Daftar Alat
        </a>
    </div>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Formulir Tambah Perangkat</div>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/alat/store') ?>" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="kode_alat" class="form-label">Kode Alat / SKU <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="kode_alat" name="kode_alat" class="form-control" placeholder="Contoh: AL-ROUT-08" required>
                </div>
                <div class="form-group">
                    <label for="id_lab" class="form-label">Laboratorium Penempatan <span style="color: var(--danger);">*</span></label>
                    <select id="id_lab" name="id_lab" class="form-select" required>
                        <option value="">-- Pilih Laboratorium --</option>
                        <?php foreach ($labs as $lab): ?>
                            <option value="<?= e((string)$lab['id']) ?>">
                                <?= e($lab['nama_lab']) ?> (<?= e($lab['lokasi']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="nama_alat" class="form-label">Nama Perangkat / Instrumen <span style="color: var(--danger);">*</span></label>
                <input type="text" id="nama_alat" name="nama_alat" class="form-control" placeholder="Contoh: Cisco Catalyst 3850 24-Port Switch" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" id="kategori" name="kategori" class="form-control" placeholder="Networking, IoT, PC..." value="Umum">
                </div>
                <div class="form-group">
                    <label for="jumlah" class="form-label">Jumlah Unit <span style="color: var(--danger);">*</span></label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control" min="0" value="1" required>
                </div>
                <div class="form-group">
                    <label for="kondisi" class="form-label">Kondisi</label>
                    <select id="kondisi" name="kondisi" class="form-select">
                        <option value="Baik">Baik</option>
                        <option value="Perbaikan">Perlu Perbaikan</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Status Awal</label>
                <select id="status" name="status" class="form-select">
                    <option value="Tersedia">Tersedia</option>
                    <option value="Dipinjam">Dipinjam</option>
                    <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">Spesifikasi & Keterangan Tambahan</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="4" placeholder="Tuliskan nomor seri, kelengkapan kabel, atau instruksi pemakaian khusus..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border);">
                <a href="<?= base_url('/alat') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Alat</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layout/footer.php';
?>

