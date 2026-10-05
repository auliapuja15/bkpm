<?php

namespace App\Controllers;

use App\Models\Mahasiswa;

class MahasiswaController
{
    public function index()
    {
        global $pdo;

        $model = new Mahasiswa($pdo);

        $mahasiswa = $model->getAll();

        require __DIR__ . '/../Views/mahasiswa/index.php';
    }

    public function create()
    {
        require __DIR__ . '/../Views/mahasiswa/create.php';
    }

    public function edit()
    {
        require __DIR__ . '/../Views/mahasiswa/edit.php';
    }
}