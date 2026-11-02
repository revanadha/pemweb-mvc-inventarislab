<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Laboratorium</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Tambahkan unit laboratorium baru ke dalam sistem.</p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/lab') ?>" class="btn btn-secondary">
            &larr; Kembali
        </a>
    </div>
</div>

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Formulir Laboratorium</div>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/lab/store') ?>" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px;">
                <div class="form-group">
                    <label for="kode_lab" class="form-label">Kode Lab <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="kode_lab" name="kode_lab" class="form-control" placeholder="LAB-KOM-05" required>
                </div>
                <div class="form-group">
                    <label for="nama_lab" class="form-label">Nama Laboratorium <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="nama_lab" name="nama_lab" class="form-control" placeholder="Lab Komputasi Awan" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="lokasi" class="form-label">Lokasi Gedung / Lantai <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Gedung D Lt. 3" required>
                </div>
                <div class="form-group">
                    <label for="kapasitas" class="form-label">Kapasitas (Kursi)</label>
                    <input type="number" id="kapasitas" name="kapasitas" class="form-control" min="0" value="30">
                </div>
            </div>

            <div class="form-group">
                <label for="kepala_lab" class="form-label">Kepala Laboratorium / PIC</label>
                <input type="text" id="kepala_lab" name="kepala_lab" class="form-control" placeholder="Nama Dosen atau Pranata Lab...">
            </div>

            <div class="form-group">
                <label for="deskripsi" class="form-label">Deskripsi & Peruntukan</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" rows="3" placeholder="Informasi fokus riset, peralatan khusus, atau matakuliah praktikum..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border);">
                <a href="<?= base_url('/lab') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Laboratorium</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layout/footer.php';
?>

