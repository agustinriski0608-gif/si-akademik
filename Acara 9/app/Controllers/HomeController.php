<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\ProdiModel;
use App\Repositories\MahasiswaRepository;

class HomeController
{
    public function __construct(
        private MahasiswaRepository $mahasiswaRepo,
        private ProdiModel $prodiModel,
        private MataKuliahModel $mataKuliahModel
    ) {
    }

    public function index(): void
    {
        redirect('/dashboard');
    }

    public function dashboard(): void
    {
        $totalMahasiswa = $this->mahasiswaRepo->count();
        $totalProdi = $this->prodiModel->count();
        $totalMatakuliah = $this->mataKuliahModel->count();

        view('home/dashboard', compact('totalMahasiswa', 'totalProdi', 'totalMatakuliah'));
    }
}
