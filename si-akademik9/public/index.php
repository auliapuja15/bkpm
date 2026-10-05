<?php

session_start();

require_once __DIR__ . '/../routes/web.php';

require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Models/Mahasiswa.php';
require_once __DIR__ . '/../app/Models/MahasiswaRepository.php';

require_once __DIR__ . '/../app/Controllers/MahasiswaController.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';

require_once __DIR__ . '/../app/Core/Middleware/AuthMiddleware.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];


// Base path project
$base = '/bkpm/si-akademik9/public';


// Hilangkan base path
if (str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base));
}


// Jika kosong
if ($uri === '') {
    $uri = '/';
}


/*
|--------------------------------------------------------------------------
| Cari Route
|--------------------------------------------------------------------------
*/

$route = $routes[$method][$uri] ?? null;


/*
|--------------------------------------------------------------------------
| Route Tidak Ditemukan
|--------------------------------------------------------------------------
*/

if ($route === null) {

    http_response_code(404);

    echo '<h1>404 - Halaman Tidak Ditemukan</h1>';

    exit;
}


/*
|--------------------------------------------------------------------------
| Middleware
|--------------------------------------------------------------------------
*/

if (isset($route['middleware'])) {

    foreach ($route['middleware'] as $middlewareName) {

        if ($middlewareName === 'AuthMiddleware') {

            $middleware = new AuthMiddleware();

            $middleware->handle();
        }
    }
}


/*
|--------------------------------------------------------------------------
| Controller
|--------------------------------------------------------------------------
*/

$controllerName = $route['controller'];
$action = $route['action'];


if ($controllerName === 'MahasiswaController') {

    $controller = new MahasiswaController(
        new MahasiswaRepository(
            Database::getInstance()
        )
    );

} elseif ($controllerName === 'AuthController') {

    $controller = new AuthController();

} elseif ($controllerName === 'HomeController') {

    $controller = new HomeController();

} else {

    http_response_code(404);

    echo '<h1>Controller Tidak Ditemukan</h1>';

    exit;
}


/*
|--------------------------------------------------------------------------
| Jalankan Action
|--------------------------------------------------------------------------
*/

if (!method_exists($controller, $action)) {

    http_response_code(500);

    echo "Method {$action} tidak ditemukan pada {$controllerName}.";

    exit;
}


$controller->$action();