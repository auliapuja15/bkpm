<?php

// Mulai session hanya jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database
require_once __DIR__ . '/../config/database.php';

// Models
require_once __DIR__ . '/../app/Models/Mahasiswa.php';

// Controllers
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/MahasiswaController.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';

// Middleware
require_once __DIR__ . '/../app/Core/Middleware/AuthMiddleware.php';

// Routes
$routes = require_once __DIR__ . '/../routes/web.php';

// Ambil URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Base path project
$basePath = '/si-akademik8/public';

if (str_starts_with($uri, $basePath)) {
    $uri = substr($uri, strlen($basePath));
}

// Jika URL kosong
if ($uri === '') {
    $uri = '/';
}

// Method request
$method = $_SERVER['REQUEST_METHOD'];

// Cek route
if (isset($routes[$method][$uri])) {

    $route = $routes[$method][$uri];

    $controllerClass = $route[0];
    $action = $route[1];

    // Route yang membutuhkan login
    $protectedRoutes = [
        '/dashboard',
        '/mahasiswa',
        '/mahasiswa/create',
        '/mahasiswa/edit',
        '/mahasiswa/store',
        '/mahasiswa/update',
        '/mahasiswa/delete'
    ];

    // Jalankan middleware untuk route protected
    if (in_array($uri, $protectedRoutes)) {

        $middleware = new \App\Core\Middleware\AuthMiddleware();

        $middleware->handle();
    }

    // Tambahkan namespace Controller
    $controllerClass = 'App\\Controllers\\' . $controllerClass;

    // Buat object controller
    $controller = new $controllerClass();

    // Jalankan method controller
    $controller->$action();

} else {

    http_response_code(404);

    echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
}