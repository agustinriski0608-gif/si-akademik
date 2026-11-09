<?php

require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/MahasiswaController.php';
require_once __DIR__ . '/../routes/web.php';

$method = $_SERVER['REQUEST_METHOD'];

$uri = rawurldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

$basePath = '/si-akademik/Acara 5/public';

if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

$uri = '/' . trim($uri, '/');

if ($uri === '//') {
    $uri = '/';
}

if (isset($routes[$method][$uri])) {
    [$controllerName, $action] = $routes[$method][$uri];

    $controller = new $controllerName();
    $controller->$action();
    exit;
}

if ($method === 'GET' && preg_match('#^/mahasiswa/([0-9]+)$#', $uri, $matches)) {
    $controller = new MahasiswaController();
    $controller->show((int) $matches[1]);
    exit;
}

http_response_code(404);
echo '<h1>404 - Halaman Tidak Ditemukan</h1>';
