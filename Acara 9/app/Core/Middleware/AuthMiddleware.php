<?php

namespace App\Core\Middleware;

/**
 * Satpam di pintu masuk: cek session sebelum Controller dijalankan.
 */
class AuthMiddleware
{
    public function handle(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            flash('warning', 'Silakan login terlebih dahulu.');
            redirect('/login');
        }
    }
}
