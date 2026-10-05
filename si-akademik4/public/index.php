<?php

require_once __DIR__ . '/../app/Models/Mahasiswa.php';

use App\Models\Mahasiswa;

$mahasiswa = [
    new Mahasiswa(
        "2401001",
        "Azira Mutia Gani",
        "Teknik Informatika"
    ),

    new Mahasiswa(
        "2401002",
        "Nindia Tri Anggraini",
        "Teknik Informatika"
    ),

    new Mahasiswa(
        "2401003",
        "Aulia Luh Bilkis",
        "Teknik Informatika"
    ),

    new Mahasiswa(
        "2501004",
        "Shopi Maulana Shofa",
        "Manajemen Informatika"
    )
];

$content = __DIR__ . '/../app/Views/mahasiswa/index.php';

require __DIR__ . '/../app/Views/layouts/main.php';