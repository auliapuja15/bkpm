
<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../core/autoload.php';
require_once __DIR__ . '/../core/Router.php';

$router = new Router();
$router->dispatch();
