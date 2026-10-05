<?php

$config = [
    'host' => 'localhost',
    'dbname' => 'si_akademik1',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4'
];

try {

    $pdo = new PDO(
        "mysql:host=" . $config['host'] .
        ";dbname=" . $config['dbname'] .
        ";charset=" . $config['charset'],
        $config['username'],
        $config['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );

} catch (PDOException $e) {

    die("Koneksi database gagal: " . $e->getMessage());
}