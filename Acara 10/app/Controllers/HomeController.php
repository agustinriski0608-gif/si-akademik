<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\MataKuliahRepository;
use App\Repositories\ProdiRepository;
use App\Repositories\MahasiswaRepository;

class HomeController extends Controller
{
    public function __construct(
        private MahasiswaRepository $mahasiswaRepo,
        private ProdiRepository $prodiRepo,
        private MataKuliahRepository $mataKuliahRepo
    ) {
    }

    public function index(): void
    {
        $this->redirect('/dashboard');
    }

    public function dashboard(): void
    {
        $totalMahasiswa = $this->mahasiswaRepo->count();
        $totalProdi = $this->prodiRepo->count();
        $totalMatakuliah = $this->mataKuliahRepo->count();

        $this->view('home/dashboard', compact('totalMahasiswa', 'totalProdi', 'totalMatakuliah'));
    }
}
