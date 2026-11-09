<?php
/**
 * Fungsi bantu (helper) yang dipakai di seluruh aplikasi.
 * Semua URL dibuat dinamis dari lokasi public/index.php, jadi aplikasi
 * bisa ditaruh di folder mana pun (si-akademik/Acara 6/public, dst.)
 */

/** Path dasar aplikasi, mis. "/si-akademik/Acara 6/public" */
function base_path(): string
{
    static $base = null;

    if ($base === null) {
        $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $base = ($dir === '/' || $dir === '.') ? '' : rtrim($dir, '/');
    }

    return $base;
}

/** Membuat URL aman (spasi di nama folder otomatis di-encode) */
function url(string $path = ''): string
{
    $query = '';
    $pos = strpos($path, '?');

    if ($pos !== false) {
        $query = substr($path, $pos);
        $path = substr($path, 0, $pos);
    }

    $base = implode('/', array_map('rawurlencode', explode('/', base_path())));

    return $base . '/' . ltrim($path, '/') . $query;
}

/** Alias htmlspecialchars agar View lebih ringkas */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Baca konfigurasi dari folder config/, mis. config('app.name') */
function config(string $key, $default = null)
{
    static $cache = [];

    [$file, $item] = array_pad(explode('.', $key, 2), 2, null);

    if (!isset($cache[$file])) {
        $path = dirname(__DIR__) . '/config/' . $file . '.php';
        $cache[$file] = is_file($path) ? require $path : [];
    }

    if ($item === null) {
        return $cache[$file];
    }

    return $cache[$file][$item] ?? $default;
}

/** Simpan flash message untuk ditampilkan sekali di halaman berikutnya */
function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

/** Ambil lalu hapus flash message */
function pull_flash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);

    return $flash;
}

/** Pindah halaman (Redirect) */
function redirect(string $path): void
{
    header('Location: ' . url($path));
    exit;
}

/** Tampilkan View di dalam layout */
function view(string $view, array $data = [], string $layout = 'layouts/main'): void
{
    extract($data);
    $contentView = APP_PATH . '/Views/' . $view . '.php';
    require APP_PATH . '/Views/' . $layout . '.php';
}

/** Path URL saat ini (tanpa folder project), untuk menandai menu aktif */
function current_path(): string
{
    return $GLOBALS['current_uri'] ?? '/';
}

/** Nilai input lama (dipakai agar form tidak kosong setelah gagal validasi) */
function old(string $key, $default = '')
{
    return $_SESSION['old'][$key] ?? $default;
}

/** Simpan input form lalu kembali ke halaman form dengan pesan error */
function back_with_error(string $path, string $message): void
{
    $_SESSION['old'] = $_POST;
    flash('danger', $message);
    redirect($path);
}
