
<?php

require_once __DIR__ . '/../app/config/Database.php';

try {
    $db = Database::getConnection();
    echo 'Koneksi database berhasil!';
} catch (Throwable $e) {
    echo 'Koneksi gagal. Periksa konfigurasi database.';
}
