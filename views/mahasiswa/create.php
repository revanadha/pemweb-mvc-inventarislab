<?php
require_once dirname(__DIR__) . '/layout/header.php';
?>

<div class="page-header">
    <div>
        <h1 class="page-title">Tambah Mahasiswa</h1>
        <p style="color: var(--text-muted); font-size: 13px; margin-top: 4px;">Pendaftaran mahasiswa peminjam alat laboratorium.</p>
    </div>
    <div class="toolbar-group">
        <a href="<?= base_url('/mahasiswa') ?>" class="btn btn-secondary">
            &larr; Kembali
        </a>
    </div>
</div>

<div class="card" style="max-width: 700px; margin: 0 auto;">
    <div class="card-header">
        <div class="card-title">Formulir Mahasiswa</div>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/mahasiswa/store') ?>" method="POST">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 16px;">
                <div class="form-group">
                    <label for="nim" class="form-label">NIM Mahasiswa <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="nim" name="nim" class="form-control" placeholder="2400018099" required>
                </div>
                <div class="form-group">
                    <label for="nama" class="form-label">Nama Lengkap <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama mahasiswa lengkap..." required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="prodi" class="form-label">Program Studi <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="prodi" name="prodi" class="form-control" placeholder="Informatika / Sistem Informasi..." required>
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status Akademik</label>
                    <select id="status" name="status" class="form-select">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                <div class="form-group">
                    <label for="email" class="form-label">Email Akademik</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="nama@student.ac.id">
                </div>
                <div class="form-group">
                    <label for="no_telp" class="form-label">No. Telepon / WhatsApp</label>
                    <input type="text" id="no_telp" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--border);">
                <a href="<?= base_url('/mahasiswa') ?>" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Mahasiswa</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once dirname(__DIR__) . '/layout/footer.php';
?>

