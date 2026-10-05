<?php

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/Mahasiswa.php';

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/MahasiswaController.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';

require_once __DIR__ . '/../app/Core/Middleware/AuthMiddleware.php';

$routes = require_once __DIR__ . '/../routes/web.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/si-akademik7/public';

if (str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

if ($uri === '') {
    $uri = '/';
}

$method = $_SERVER['REQUEST_METHOD'];

if (isset($routes[$method][$uri])) {

    $route = $routes[$method][$uri];

    $controllerClass = $route[0];
    $action = $route[1];

    $controller = new $controllerClass();

    $controller->$action();

} else {

    http_response_code(404);

    echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
}