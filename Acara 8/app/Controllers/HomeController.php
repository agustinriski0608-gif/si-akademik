<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\MataKuliahModel;
use App\Models\ProdiModel;

class HomeController
{
    public function index(): void
    {
        redirect('/dashboard');
    }

    public function dashboard(): void
    {
        $totalMahasiswa = (new MahasiswaModel())->count();
        $totalProdi = (new ProdiModel())->count();
        $totalMatakuliah = (new MataKuliahModel())->count();

        view('home/dashboard', compact('totalMahasiswa', 'totalProdi', 'totalMatakuliah'));
    }
}
