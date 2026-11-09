<?php

// Front controller: semua request masuk lewat file ini (lihat .htaccess)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_PATH', dirname(__DIR__) . '/app');

require APP_PATH . '/helpers.php';

date_default_timezone_set(config('app.timezone', 'Asia/Jakarta'));

// Autoload sederhana: App\Controllers\X => app/Controllers/X.php
spl_autoload_register(function (string $class): void {
    if (strncmp($class, 'App\\', 4) !== 0) {
        return;
    }

    $file = APP_PATH . '/' . str_replace('\\', '/', substr($class, 4)) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

use App\Core\Router;

// Jika class Container ada (Acara 9 ke atas), controller dibuat lewat
// Dependency Injection otomatis. Jika tidak, cukup "new Controller()".
if (class_exists('App\\Core\\Container')) {
    $container = new App\Core\Container();
    $router = new Router(fn (string $class) => $container->make($class));
} else {
    $router = new Router();
}

require dirname(__DIR__) . '/routes/web.php';

// Ambil URI yang diminta, buang folder project di depannya
$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/');
$base = base_path();

if ($base !== '' && strpos($uri, $base) === 0) {
    $uri = substr($uri, strlen($base));
}

$uri = '/' . trim($uri, '/');
$GLOBALS['current_uri'] = $uri;

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $uri);
} catch (PDOException $e) {
    // Catat ke storage/logs, tampilkan pesan ramah ke pengguna
    $logDir = dirname(__DIR__) . '/storage/logs';
    if (is_dir($logDir)) {
        @file_put_contents(
            $logDir . '/app.log',
            '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . PHP_EOL,
            FILE_APPEND
        );
    }

    http_response_code(500);
    view('errors/error', [
        'code' => 500,
        'title' => 'Database bermasalah',
        'message' => 'Aplikasi tidak bisa mengakses database. Pastikan MySQL di XAMPP sudah Start dan database si_akademik sudah di-import.',
    ]);
}
