<?php
/** @var string $title */
/** @var string $activeMenu */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Sistem Inventaris Lab Terpadu') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('/css/style.css') ?>">
</head>
<body>
<div class="app-container">
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div>
            <div class="brand-section">
                <a href="<?= base_url('/') ?>" class="brand-logo">
                    <div class="brand-icon">N</div>
                    <span>INVENTORY <small style="color: var(--primary); font-size: 11px; font-weight: 600;">LAB</small></span>
                </a>
                <button type="button" class="sidebar-collapse-btn" title="Toggle Sidebar" aria-label="Toggle Sidebar">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-label">Menu Utama</div>
                
                <a href="<?= base_url('/') ?>" class="nav-link <?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="<?= base_url('/alat') ?>" class="nav-link <?= ($activeMenu ?? '') === 'alat' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                    <span>Alat</span>
                </a>

                <a href="<?= base_url('/lab') ?>" class="nav-link <?= ($activeMenu ?? '') === 'lab' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 21h18"></path>
                        <path d="M5 21V7l8-4v18"></path>
                        <path d="M19 21V11l-6-3"></path>
                        <line x1="9" y1="9" x2="9" y2="9.01"></line>
                        <line x1="9" y1="13" x2="9" y2="13.01"></line>
                        <line x1="9" y1="17" x2="9" y2="17.01"></line>
                    </svg>
                    <span>Laboratorium</span>
                </a>

                <a href="<?= base_url('/mahasiswa') ?>" class="nav-link <?= ($activeMenu ?? '') === 'mahasiswa' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Mahasiswa</span>
                </a>

                <div class="nav-label" style="margin-top: 12px;">Sirkulasi Lab</div>

                <a href="<?= base_url('/peminjaman') ?>" class="nav-link <?= ($activeMenu ?? '') === 'peminjaman' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <span>Peminjaman Alat</span>
                </a>
            </nav>
        </div>

        <div class="sidebar-footer">
            <a href="<?= base_url('/reset-demo') ?>" class="nav-link" onclick="return confirm('Kembalikan data simulasi ke awal?');">
                <svg viewBox="0 0 24 24">
                    <polyline points="1 4 1 10 7 10"></polyline>
                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                </svg>
                <span>Reset Data Demo</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <header class="top-bar">
            <form action="<?= base_url('/alat') ?>" method="GET" class="search-box">
                <svg class="search-icon" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" class="search-input" placeholder="Cari alat, kode SKU, atau kategori..." value="<?= e($_GET['q'] ?? '') ?>">
            </form>

            <div class="top-actions">
                <a href="<?= base_url('/peminjaman') ?>" class="notification-btn" title="Peminjaman Aktif" aria-label="Peminjaman Aktif">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="badge-counter"><?= (new \App\Repositories\PeminjamanRepository())->countActive() ?></span>
                </a>

                <div class="user-avatar" title="Admin Laboratorium">
                    AD
                </div>
            </div>
        </header>

        <!-- Body Content Container -->
        <div class="page-body">
            <!-- Flash Alert Message -->
            <?php if ($msg = get_flash('success')): ?>
                <div class="alert alert-success">
                    <span><?= e($msg) ?></span>
                    <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:inherit;cursor:pointer;font-weight:700;">&times;</button>
                </div>
            <?php endif; ?>

            <?php if ($msg = get_flash('error')): ?>
                <div class="alert alert-error">
                    <span><?= e($msg) ?></span>
                    <button type="button" onclick="this.parentElement.remove()" style="background:none;border:none;color:inherit;cursor:pointer;font-weight:700;">&times;</button>
                </div>
            <?php endif; ?>

