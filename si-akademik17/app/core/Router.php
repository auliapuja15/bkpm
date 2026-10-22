
<?php

require_once __DIR__ . '/../controllers/MahasiswaController.php';
require_once __DIR__ . '/../controllers/BukuController.php';

class Router
{
    public function dispatch(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Menemukan bagian URL setelah /public/
        $position = strpos($uri, '/public/');

        if ($position !== false) {
            $path = substr($uri, $position + strlen('/public/'));
        } else {
            http_response_code(404);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['message' => 'Endpoint tidak ditemukan']);
            return;
        }

        $path = trim($path, '/');
        $method = $_SERVER['REQUEST_METHOD'];

        header('Content-Type: application/json; charset=utf-8');

        $routes = [
            'mahasiswa' => MahasiswaController::class,
            'buku' => BukuController::class,
        ];

        if (!isset($routes[$path])) {
            http_response_code(404);
            echo json_encode(['message' => 'Endpoint tidak ditemukan']);
            return;
        }

        $controllerClass = $routes[$path];
        $controller = new $controllerClass();

        switch ($method) {
            case 'GET':
                $controller->index();
                break;

            case 'POST':
                $controller->store();
                break;

            case 'PUT':
                $controller->update();
                break;

            case 'DELETE':
                $controller->destroy();
                break;

            default:
                header('Allow: GET, POST, PUT, DELETE');
                http_response_code(405);
                echo json_encode(['message' => 'Metode HTTP tidak diizinkan']);
        }
    }
}
