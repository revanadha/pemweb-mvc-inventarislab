<?php

// Dukungan PHP Built-in Server untuk file statis
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $filePath = __DIR__ . $path;
    if ($path !== '/' && is_file($filePath)) {
        return false;
    }
}

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once dirname(__DIR__) . '/src/helpers.php';
require_once dirname(__DIR__) . '/src/Core/Autoloader.php';

\App\Core\Autoloader::register();

use App\Core\Router;
use App\Controllers\DashboardController;
use App\Controllers\AlatController;
use App\Controllers\LabController;
use App\Controllers\MahasiswaController;
use App\Controllers\PeminjamanController;

$router = new Router();

// Route: Dashboard & Utility
$router->get('/', [DashboardController::class, 'index']);
$router->get('/reset-demo', function() {
    unset($_SESSION['mock_store']);
    set_flash('success', 'Data simulasi telah di-reset ke nilai awal.');
    redirect('/');
});

// Route: Modul Alat
$router->get('/alat', [AlatController::class, 'index']);
$router->get('/alat/create', [AlatController::class, 'create']);
$router->post('/alat/store', [AlatController::class, 'store']);
$router->get('/alat/edit/{id}', [AlatController::class, 'edit']);
$router->post('/alat/update/{id}', [AlatController::class, 'update']);
$router->get('/alat/delete/{id}', [AlatController::class, 'delete']);
$router->get('/alat/detail/{id}', [AlatController::class, 'detail']);

// Route: Modul Laboratorium
$router->get('/lab', [LabController::class, 'index']);
$router->get('/lab/create', [LabController::class, 'create']);
$router->post('/lab/store', [LabController::class, 'store']);
$router->get('/lab/edit/{id}', [LabController::class, 'edit']);
$router->post('/lab/update/{id}', [LabController::class, 'update']);
$router->get('/lab/delete/{id}', [LabController::class, 'delete']);

// Route: Modul Mahasiswa
$router->get('/mahasiswa',                 [MahasiswaController::class, 'index']);
$router->get('/mahasiswa/create',          [MahasiswaController::class, 'create']);
$router->post('/mahasiswa/store',          [MahasiswaController::class, 'store']);
$router->get('/mahasiswa/edit/{id}',       [MahasiswaController::class, 'edit']);
$router->post('/mahasiswa/update/{id}',    [MahasiswaController::class, 'update']);
$router->get('/mahasiswa/delete/{id}',     [MahasiswaController::class, 'delete']);
$router->get('/mahasiswa/riwayat/{id}',    [MahasiswaController::class, 'riwayat']);

// Route: Peminjaman
$router->get('/peminjaman',                      [PeminjamanController::class, 'index']);
$router->get('/peminjaman/create',               [PeminjamanController::class, 'create']);
$router->post('/peminjaman/store',               [PeminjamanController::class, 'store']);
$router->get('/peminjaman/kembalikan/{id}',      [PeminjamanController::class, 'kembalikan']);
// --- Kontribusi: Detail, Edit, Update, Delete ---
$router->get('/peminjaman/detail/{id}',          [PeminjamanController::class, 'detail']);
$router->get('/peminjaman/edit/{id}',            [PeminjamanController::class, 'edit']);
$router->post('/peminjaman/update/{id}',         [PeminjamanController::class, 'update']);
$router->get('/peminjaman/delete/{id}',          [PeminjamanController::class, 'delete']);

$router->dispatch();

