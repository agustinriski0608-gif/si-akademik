<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\MahasiswaController;

/** @var App\Core\Router $router */

// Halaman publik
$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [AuthController::class, 'loginForm']);
$router->post('/login', [AuthController::class, 'login']);

// Halaman yang dilindungi AuthMiddleware (wajib login)
$router->get('/logout', [AuthController::class, 'logout'], ['auth']);
$router->get('/dashboard', [HomeController::class, 'dashboard'], ['auth']);
$router->get('/mahasiswa', [MahasiswaController::class, 'index'], ['auth']);
