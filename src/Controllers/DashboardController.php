<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\AlatRepository;
use App\Repositories\LabRepository;
use App\Repositories\MahasiswaRepository;
use App\Repositories\PeminjamanRepository;

class DashboardController extends Controller {
    public function index(): void {
        $alatRepo = new AlatRepository();
        $labRepo = new LabRepository();
        $mhsRepo = new MahasiswaRepository();
        $pinjamRepo = new PeminjamanRepository();

        $stats = [
            'total_alat' => count($alatRepo->getAll()),
            'total_lab' => count($labRepo->getAll()),
            'total_mhs' => count($mhsRepo->getAll()),
            'pinjam_aktif' => $pinjamRepo->countActive(),
        ];

        $recentAlat = array_slice($alatRepo->getAll(), 0, 5);
        $recentPinjam = array_slice($pinjamRepo->getAll(), 0, 5);

        $this->render('dashboard/index', [
            'title' => 'Dashboard Inventaris Lab',
            'activeMenu' => 'dashboard',
            'stats' => $stats,
            'recentAlat' => $recentAlat,
            'recentPinjam' => $recentPinjam,
        ]);
    }
}

