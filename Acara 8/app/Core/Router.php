<?php

namespace App\Core;

use App\Core\Middleware\AuthMiddleware;

/**
 * Router sederhana: mencocokkan METHOD + URL ke Controller@method,
 * mendukung parameter {id} dan middleware per-route.
 */
class Router
{
    /** @var array<int, array<string, mixed>> */
    private array $routes = [];

    /** Nama middleware => class */
    private array $middlewareMap = [
        'auth' => AuthMiddleware::class,
    ];

    /** @var callable Pembuat object controller */
    private $factory;

    public function __construct(?callable $factory = null)
    {
        $this->factory = $factory ?? static fn (string $class) => new $class();
    }

    public function get(string $path, array $handler, array $middleware = []): void
    {
        $this->add('GET', $path, $handler, $middleware);
    }

    public function post(string $path, array $handler, array $middleware = []): void
    {
        $this->add('POST', $path, $handler, $middleware);
    }

    private function add(string $method, string $path, array $handler, array $middleware): void
    {
        $pattern = '#^' . str_replace('\{id\}', '([0-9]+)', preg_quote($path, '#')) . '$#';

        $this->routes[] = [
            'method' => $method,
            'pattern' => $pattern,
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $pathExistsForOtherMethod = false;

        foreach ($this->routes as $route) {
            if (!preg_match($route['pattern'], $uri, $matches)) {
                continue;
            }

            if ($route['method'] !== $method) {
                $pathExistsForOtherMethod = true;
                continue;
            }

            array_shift($matches);
            $params = array_map('intval', $matches);

            // Jalankan middleware lebih dulu (cek login, dll.)
            foreach ($route['middleware'] as $name) {
                $class = $this->middlewareMap[$name];
                (new $class())->handle();
            }

            [$controllerClass, $action] = $route['handler'];
            $controller = ($this->factory)($controllerClass);

            if (!method_exists($controller, $action)) {
                $this->error(501, 'Method belum tersedia', "Method {$action} belum dibuat di {$controllerClass}.");
                return;
            }

            $controller->$action(...$params);
            return;
        }

        if ($pathExistsForOtherMethod) {
            $this->error(405, 'Method tidak diizinkan', 'Halaman ini tidak bisa diakses dengan method ' . $method . '.');
            return;
        }

        $this->error(404, 'Halaman tidak ditemukan', 'URL yang kamu buka tidak terdaftar di routes/web.php.');
    }

    private function error(int $code, string $title, string $message): void
    {
        http_response_code($code);
        view('errors/error', compact('code', 'title', 'message'));
    }
}
