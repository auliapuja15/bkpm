<?php

require_once __DIR__ . '/../Models/ProdiModel.php';

class ProdiController
{
    private ProdiModel $model;

    public function __construct()
    {
        $this->model = new ProdiModel();
    }

    public function index(): void
    {
        $prodi = $this->model->all();
        require __DIR__ . '/../Views/prodi/index.php';
    }

    public function create(): void
    {
        $data = ['kode' => '', 'nama' => ''];
        $errors = [];
        require __DIR__ . '/../Views/prodi/create.php';
    }

    public function store(): void
    {
        $data = [
            'kode' => trim($_POST['kode'] ?? ''),
            'nama' => trim($_POST['nama'] ?? '')
        ];

        $errors = $this->validate($data);

        if ($errors) {
            require __DIR__ . '/../Views/prodi/create.php';
            return;
        }

        try {
            $this->model->create($data);
            $this->redirect('/prodi');
        } catch (PDOException $e) {
            $errors[] = 'Kode prodi sudah digunakan atau data gagal disimpan.';
            require __DIR__ . '/../Views/prodi/create.php';
        }
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $data = $this->model->find($id);

        if (!$data) {
            $this->redirect('/prodi');
        }

        $errors = [];
        require __DIR__ . '/../Views/prodi/edit.php';
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $data = [
            'kode' => trim($_POST['kode'] ?? ''),
            'nama' => trim($_POST['nama'] ?? '')
        ];

        $errors = $this->validate($data);

        if ($errors) {
            $data['id'] = $id;
            require __DIR__ . '/../Views/prodi/edit.php';
            return;
        }

        try {
            $this->model->update($id, $data);
            $this->redirect('/prodi');
        } catch (PDOException $e) {
            $errors[] = 'Kode prodi sudah digunakan atau data gagal diperbarui.';
            $data['id'] = $id;
            require __DIR__ . '/../Views/prodi/edit.php';
        }
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        try {
            if ($id > 0) {
                $this->model->delete($id);
            }
        } catch (PDOException $e) {
            // Jangan tampilkan detail SQL kepada pengguna.
        }

        $this->redirect('/prodi');
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['kode'] === '') {
            $errors[] = 'Kode prodi wajib diisi.';
        }

        if ($data['nama'] === '') {
            $errors[] = 'Nama prodi wajib diisi.';
        }

        return $errors;
    }

    private function redirect(string $path): void
    {
        header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . $path);
        exit;
    }
}
