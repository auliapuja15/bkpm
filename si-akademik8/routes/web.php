<?php

return [

    'GET' => [

        '/' => [
            'AuthController',
            'login'
        ],

        '/login' => [
            'AuthController',
            'login'
        ],

        '/dashboard' => [
            'HomeController',
            'index'
        ],

        '/logout' => [
            'AuthController',
            'logout'
        ],

        '/mahasiswa' => [
            'MahasiswaController',
            'index'
        ],

        '/mahasiswa/create' => [
            'MahasiswaController',
            'create'
        ],

        '/mahasiswa/edit' => [
            'MahasiswaController',
            'edit'
        ],
    ],

    'POST' => [

        '/login' => [
            'AuthController',
            'processLogin'
        ],

        '/mahasiswa/store' => [
            'MahasiswaController',
            'store'
        ],

        '/mahasiswa/update' => [
            'MahasiswaController',
            'update'
        ],

        '/mahasiswa/delete' => [
            'MahasiswaController',
            'destroy'
        ],

    ]

];