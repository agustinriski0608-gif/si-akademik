<?php

require_once __DIR__ . '/../app/Models/Mahasiswa.php';

use App\Models\Mahasiswa;

$mahasiswa = [
    new Mahasiswa('2401001', 'Mingyu', 'Teknik Informatika'),
    new Mahasiswa('2401002', 'Wonwoo', 'Manajemen Informatika'),
    new Mahasiswa('2401003', 'Seungmin', 'Teknik Komputer'),
];

$contentView = __DIR__ . '/../app/Views/mahasiswa/index.php';

require __DIR__ . '/../app/Views/layouts/main.php';
