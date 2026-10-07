<?php

require_once __DIR__ . '/../Models/MahasiswaModel.php';
require_once __DIR__ . '/../Models/ProdiModel.php';

class MahasiswaController
{
    private MahasiswaModel $model;
    private ProdiModel $prodiModel;

    public function __construct()
    {
        $this->model = new MahasiswaModel();
        $this->prodiModel = new ProdiModel();
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $mahasiswa = $this->model->all($search);

        require __DIR__ . '/../Views/mahasiswa/index.php';
    }

    public function create(): void
    {
        $prodi = $this->prodiModel->all();

        $data = [
            'nim' => '',
            'nama' => '',
            'prodi_id' => '',
            'angkatan' => '',
            'status' => 'aktif',
        ];

        $errors = [];

        require __DIR__ . '/../Views/mahasiswa/create.php';
    }

    public function store(): void
    {
        $data = [
            'nim' => trim($_POST['nim'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'prodi_id' => (int) ($_POST['prodi_id'] ?? 0),
            'angkatan' => (int) ($_POST['angkatan'] ?? 0),
            'status' => $_POST['status'] ?? 'aktif',
        ];

        $errors = $this->validate($data);

        if ($this->model->existsByNim($data['nim'])) {
            $errors[] = 'NIM sudah digunakan.';
        }

        if ($errors) {
            $prodi = $this->prodiModel->all();
            require __DIR__ . '/../Views/mahasiswa/create.php';
            return;
        }

        try {
            $this->model->create($data);
            $this->redirect('/mahasiswa');
        } catch (PDOException $e) {
            $errors[] = 'Data mahasiswa gagal disimpan.';
            $prodi = $this->prodiModel->all();
            require __DIR__ . '/../Views/mahasiswa/create.php';
        }
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $data = $this->model->find($id);

        if (!$data) {
            $this->redirect('/mahasiswa');
        }

        $prodi = $this->prodiModel->all();
        $errors = [];

        require __DIR__ . '/../Views/mahasiswa/edit.php';
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $data = [
            'nim' => trim($_POST['nim'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'prodi_id' => (int) ($_POST['prodi_id'] ?? 0),
            'angkatan' => (int) ($_POST['angkatan'] ?? 0),
            'status' => $_POST['status'] ?? 'aktif',
        ];

        $errors = $this->validate($data);

        if ($this->model->existsByNim($data['nim'], $id)) {
            $errors[] = 'NIM sudah digunakan oleh mahasiswa lain.';
        }

        if ($errors) {
            $data['id'] = $id;
            $prodi = $this->prodiModel->all();
            require __DIR__ . '/../Views/mahasiswa/edit.php';
            return;
        }

        try {
            $this->model->update($id, $data);
            $this->redirect('/mahasiswa');
        } catch (PDOException $e) {
            $errors[] = 'Data mahasiswa gagal diperbarui.';
            $data['id'] = $id;
            $prodi = $this->prodiModel->all();
            require __DIR__ . '/../Views/mahasiswa/edit.php';
        }
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->model->delete($id);
        }

        $this->redirect('/mahasiswa');
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['nim'] === '') {
            $errors[] = 'NIM wajib diisi.';
        }

        if ($data['nama'] === '') {
            $errors[] = 'Nama wajib diisi.';
        }

        if ($data['prodi_id'] <= 0) {
            $errors[] = 'Program studi wajib dipilih.';
        }

        if ($data['angkatan'] < 2000 || $data['angkatan'] > 2100) {
            $errors[] = 'Angkatan harus diisi dengan tahun yang valid.';
        }

        if (!in_array($data['status'], ['aktif', 'cuti', 'lulus'], true)) {
            $errors[] = 'Status mahasiswa tidak valid.';
        }

        return $errors;
    }

    private function redirect(string $path): void
    {
        header(
            'Location: ' . dirname($_SERVER['SCRIPT_NAME']) . $path
        );

        exit;
    }
}
