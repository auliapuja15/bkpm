<?php

namespace App\Controllers;

class MahasiswaController
{
    public function index()
    {
        echo "<h1>Daftar Mahasiswa</h1>";
        echo "<p>Routing ke MahasiswaController berhasil!</p>";
    }

    public function create()
    {
        echo "<h1>Tambah Mahasiswa</h1>";
        echo "<p>Halaman tambah mahasiswa berhasil dibuka.</p>";
    }

    public function show($id)
    {
        echo "<h1>Detail Mahasiswa</h1>";
        echo "<p>ID Mahasiswa: " . htmlspecialchars($id) . "</p>";
    }
}