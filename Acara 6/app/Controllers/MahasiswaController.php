<?php

namespace App\Controllers;

use App\Models\Mahasiswa;

class MahasiswaController
{
    public function index(): void
    {
        // Data sementara (belum database) memakai class Mahasiswa dari Acara 4
        $mahasiswa = [
            new Mahasiswa('2401001', 'Mingyu', 'Teknik Informatika'),
            new Mahasiswa('2401002', 'Wonwoo', 'Manajemen Informatika'),
            new Mahasiswa('2401003', 'Seungmin', 'Teknik Komputer'),
        ];

        view('mahasiswa/index', compact('mahasiswa'));
    }
}
