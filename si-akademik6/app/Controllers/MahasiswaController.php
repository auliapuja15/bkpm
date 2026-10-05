<?php

namespace App\Controllers;

class MahasiswaController
{
    // Halaman daftar mahasiswa
    public function index()
    {
        require __DIR__ . '/../Views/mahasiswa/index.php';
    }

    // Halaman tambah mahasiswa
    public function create()
    {
        require __DIR__ . '/../Views/mahasiswa/create.php';
    }

    // Halaman edit mahasiswa
    public function edit()
    {
        require __DIR__ . '/../Views/mahasiswa/edit.php';
    }
}