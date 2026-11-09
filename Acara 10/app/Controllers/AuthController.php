<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{
    /** Tampilkan form login */
    public function loginForm(): void
    {
        // Jika sudah login, tidak perlu melihat form login lagi
        if (!empty($_SESSION['logged_in'])) {
            $this->redirect('/dashboard');
        }

        require APP_PATH . '/Views/auth/login.php';
    }

    /** Proses login (username/password masih hardcode, nanti diganti database) */
    public function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === 'admin' && $password === 'admin123') {
            session_regenerate_id(true);

            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = 1;
            $_SESSION['user_name'] = 'Admin';

            $this->flash('success', 'Selamat datang, Admin');
            $this->redirect('/dashboard');
        }

        $this->flash('danger', 'Username atau password salah.');
        $this->redirect('/login');
    }

    /** Hapus session lalu kembali ke halaman login */
    public function logout(): void
    {
        // Kosongkan data session lalu hancurkan session lama
        $_SESSION = [];
        session_destroy();

        // Buat session baru (ID baru) khusus untuk menyimpan flash message.
        // Tanpa ID baru, browser tidak menerima cookie baru dan pesan hilang.
        session_id(bin2hex(random_bytes(16)));
        session_start();
        $this->flash('info', 'Anda telah logout');
        $this->redirect('/login');
    }
}
