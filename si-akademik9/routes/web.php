<?php

$routes = [

    'GET' => [

        '/' => [
            'controller' => 'HomeController',
            'action' => 'index',
        ],

        '/login' => [
            'controller' => 'AuthController',
            'action' => 'loginForm',
        ],

        '/dashboard' => [
            'controller' => 'HomeController',
            'action' => 'dashboard',
            'middleware' => ['AuthMiddleware'],
        ],

        '/mahasiswa' => [
            'controller' => 'MahasiswaController',
            'action' => 'index',
            'middleware' => ['AuthMiddleware'],
        ],

        '/mahasiswa/create' => [
            'controller' => 'MahasiswaController',
            'action' => 'create',
            'middleware' => ['AuthMiddleware'],
        ],

        '/mahasiswa/edit' => [
            'controller' => 'MahasiswaController',
            'action' => 'edit',
            'middleware' => ['AuthMiddleware'],
        ],

        '/logout' => [
            'controller' => 'AuthController',
            'action' => 'logout',
        ],

    ],

    'POST' => [

        '/login' => [
            'controller' => 'AuthController',
            'action' => 'login',
        ],

        '/mahasiswa/store' => [
            'controller' => 'MahasiswaController',
            'action' => 'store',
            'middleware' => ['AuthMiddleware'],
        ],

        '/mahasiswa/update' => [
            'controller' => 'MahasiswaController',
            'action' => 'update',
            'middleware' => ['AuthMiddleware'],
        ],

        '/mahasiswa/delete' => [
            'controller' => 'MahasiswaController',
            'action' => 'destroy',
            'middleware' => ['AuthMiddleware'],
        ],

    ],

];