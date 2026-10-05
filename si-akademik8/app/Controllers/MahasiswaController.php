<?php

namespace App\Controllers;

require_once __DIR__ . '/../Models/Mahasiswa.php';

use App\Models\Mahasiswa;

class MahasiswaController
{
    // Menampilkan semua mahasiswa
    public function index()
    {
        global $pdo;

        $model = new Mahasiswa($pdo);

        $keyword = $_GET['search'] ?? '';

        if ($keyword !== '') {
            $mahasiswa = $model->search($keyword);
        } else {
            $mahasiswa = $model->getAll();
        }

        require __DIR__ . '/../Views/mahasiswa/index.php';
    }

    // Menampilkan form tambah
    public function create()
    {
        global $pdo;

        $model = new Mahasiswa($pdo);
        $prodi = $model->getProgramStudi();

        require __DIR__ . '/../Views/mahasiswa/create.php';
    }

    // Menyimpan mahasiswa
    public function store()
    {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /si-akademik8/public/mahasiswa');
            exit;
        }

        $model = new Mahasiswa($pdo);

        $data = [
            'nim' => trim($_POST['nim']),
            'nama' => trim($_POST['nama']),
            'id_prodi' => $_POST['id_prodi'],
            'angkatan' => $_POST['angkatan'],
            'status' => $_POST['status']
        ];

        $model->create($data);

        header('Location: /si-akademik8/public/mahasiswa');
        exit;
    }

    // Menampilkan form edit
    public function edit()
    {
        global $pdo;

        $nim = $_GET['nim'] ?? null;

        if (!$nim) {
            header('Location: /si-akademik8/public/mahasiswa');
            exit;
        }

        $model = new Mahasiswa($pdo);

        $mahasiswa = $model->find($nim);
        $prodi = $model->getProgramStudi();

        if (!$mahasiswa) {
            header('Location: /si-akademik8/public/mahasiswa');
            exit;
        }

        require __DIR__ . '/../Views/mahasiswa/edit.php';
    }

    // Mengupdate mahasiswa
    public function update()
    {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /si-akademik8/public/mahasiswa');
            exit;
        }

        $nim = $_POST['nim'];

        $data = [
            'nama' => trim($_POST['nama']),
            'id_prodi' => $_POST['id_prodi'],
            'angkatan' => $_POST['angkatan'],
            'status' => $_POST['status']
        ];

        $model = new Mahasiswa($pdo);
        $model->update($nim, $data);

        header('Location: /si-akademik8/public/mahasiswa');
        exit;
    }

    // Menghapus mahasiswa
    public function destroy()
    {
        global $pdo;

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /si-akademik8/public/mahasiswa');
            exit;
        }

        $nim = $_POST['nim'];

        $model = new Mahasiswa($pdo);
        $model->delete($nim);

        header('Location: /si-akademik8/public/mahasiswa');
        exit;
    }
}