<?php

use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\MahasiswaController;

$routes = [

    'GET' => [

        '/' => [
            HomeController::class,
            'index'
        ],

        '/login' => [
            AuthController::class,
            'login'
        ],

        '/logout' => [
            AuthController::class,
            'logout'
        ],

        '/dashboard' => [
            HomeController::class,
            'index'
        ],

        '/mahasiswa' => [
            MahasiswaController::class,
            'index'
        ],

        '/mahasiswa/create' => [
            MahasiswaController::class,
            'create'
        ],

        '/mahasiswa/edit' => [
            MahasiswaController::class,
            'edit'
        ],

    ],

    'POST' => [

        '/login/process' => [
            AuthController::class,
            'processLogin'
        ],

    ],

];

return $routes;