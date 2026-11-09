<?php

namespace App\Core;

/**
 * Base Controller.
 * Method yang dipakai semua controller (view, redirect, flash) ditulis SEKALI di sini,
 * lalu diwariskan lewat "extends Controller" (prinsip DRY).
 */
abstract class Controller
{
    /** Tampilkan View di dalam layout */
    protected function view(string $view, array $data = [], string $layout = 'layouts/main'): void
    {
        extract($data);
        $contentView = APP_PATH . '/Views/' . $view . '.php';

        require APP_PATH . '/Views/' . $layout . '.php';
    }

    /** Pindah ke halaman lain */
    protected function redirect(string $path): never
    {
        header('Location: ' . url($path));
        exit;
    }

    /** Simpan pesan sekali-tampil (alert) */
    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    /** Kembali ke form dengan input lama + pesan error */
    protected function backWithError(string $path, string $message): never
    {
        $_SESSION['old'] = $_POST;
        $this->flash('danger', $message);
        $this->redirect($path);
    }
}
