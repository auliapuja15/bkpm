<?php

session_start();

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/MahasiswaController.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Core/Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../routes/web.php';

use App\Controllers\MahasiswaController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/si-akademik6/public';

if (str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));

    if ($uri === '') {
        $uri = '/';
    }
}

$method = $_SERVER['REQUEST_METHOD'];

if (isset($routes[$method][$uri])) {

    $route = $routes[$method][$uri];

    $controllerClass = $route[0];
    $action = $route[1];
    $middlewares = $route[2] ?? [];

    // Jalankan middleware
    foreach ($middlewares as $middleware) {

        $middlewareInstance = new $middleware();

        $middlewareInstance->handle();
    }

    // Jalankan Controller
    $controller = new $controllerClass();

    $controller->$action();

} else {

    http_response_code(404);

    echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
}