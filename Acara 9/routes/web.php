<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\MahasiswaController;
use App\Controllers\MataKuliahController;
use App\Controllers\ProdiController;

/** @var App\Core\Router $router */

// ---------- Halaman publik ----------
$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);

// ---------- Wajib login (AuthMiddleware) ----------
$router->get('/logout', [AuthController::class, 'logout'], ['auth']);
$router->get('/dashboard', [HomeController::class, 'dashboard'], ['auth']);

// Mahasiswa
$router->get('/mahasiswa', [MahasiswaController::class, 'index'], ['auth']);
$router->get('/mahasiswa/create', [MahasiswaController::class, 'create'], ['auth']);
$router->post('/mahasiswa', [MahasiswaController::class, 'store'], ['auth']);
$router->get('/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'], ['auth']);
$router->post('/mahasiswa/{id}', [MahasiswaController::class, 'update'], ['auth']);
$router->post('/mahasiswa/{id}/delete', [MahasiswaController::class, 'destroy'], ['auth']);

// Program Studi
$router->get('/prodi', [ProdiController::class, 'index'], ['auth']);
$router->get('/prodi/create', [ProdiController::class, 'create'], ['auth']);
$router->post('/prodi', [ProdiController::class, 'store'], ['auth']);
$router->get('/prodi/{id}/edit', [ProdiController::class, 'edit'], ['auth']);
$router->post('/prodi/{id}', [ProdiController::class, 'update'], ['auth']);
$router->post('/prodi/{id}/delete', [ProdiController::class, 'destroy'], ['auth']);

// Mata Kuliah
$router->get('/matakuliah', [MataKuliahController::class, 'index'], ['auth']);
$router->get('/matakuliah/create', [MataKuliahController::class, 'create'], ['auth']);
$router->post('/matakuliah', [MataKuliahController::class, 'store'], ['auth']);
$router->get('/matakuliah/{id}/edit', [MataKuliahController::class, 'edit'], ['auth']);
$router->post('/matakuliah/{id}', [MataKuliahController::class, 'update'], ['auth']);
$router->post('/matakuliah/{id}/delete', [MataKuliahController::class, 'destroy'], ['auth']);
