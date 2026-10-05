<?php

require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/MahasiswaController.php';
require_once __DIR__ . '/../routes/web.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/si-akademik5/public';

if (str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath)) ?: '/';
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && str_starts_with($uri, '/mahasiswa/')) {

    $parts = explode('/', trim($uri, '/'));

    if (count($parts) === 2 && is_numeric($parts[1])) {

        $id = $parts[1];

        $controller = new \App\Controllers\MahasiswaController();

        $controller->show($id);

        exit;
    }
}

if (isset($routes[$method][$uri])) {

    [$controllerName, $action] = $routes[$method][$uri];

    $controllerClass = "App\\Controllers\\{$controllerName}";

    $controller = new $controllerClass();

    $controller->$action();

} else {

    http_response_code(404);

    echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
}