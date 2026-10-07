<?php

require_once __DIR__ . '/../Models/MatakuliahModel.php';
require_once __DIR__ . '/../Models/ProdiModel.php';

class MatakuliahController
{
    private MatakuliahModel $model;
    private ProdiModel $prodiModel;

    public function __construct()
    {
        $this->model = new MatakuliahModel();
        $this->prodiModel = new ProdiModel();
    }

    public function index(): void
    {
        $matakuliah = $this->model->all();
        require __DIR__ . '/../Views/matakuliah/index.php';
    }

    public function create(): void
    {
        $prodi = $this->prodiModel->all();
        $data = [
            'kode' => '',
            'nama' => '',
            'sks' => '',
            'prodi_id' => ''
        ];
        $errors = [];

        require __DIR__ . '/../Views/matakuliah/create.php';
    }

    public function store(): void
    {
        $data = [
            'kode' => trim($_POST['kode'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'sks' => (int) ($_POST['sks'] ?? 0),
            'prodi_id' => (int) ($_POST['prodi_id'] ?? 0),
        ];

        $errors = $this->validate($data);

        if ($errors) {
            $prodi = $this->prodiModel->all();
            require __DIR__ . '/../Views/matakuliah/create.php';
            return;
        }

        try {
            $this->model->create($data);
            $this->redirect('/matakuliah');
        } catch (PDOException $e) {
            $errors[] = 'Kode mata kuliah sudah digunakan atau data gagal disimpan.';
            $prodi = $this->prodiModel->all();
            require __DIR__ . '/../Views/matakuliah/create.php';
        }
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);
        $data = $this->model->find($id);

        if (!$data) {
            $this->redirect('/matakuliah');
        }

        $prodi = $this->prodiModel->all();
        $errors = [];

        require __DIR__ . '/../Views/matakuliah/edit.php';
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        $data = [
            'kode' => trim($_POST['kode'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'sks' => (int) ($_POST['sks'] ?? 0),
            'prodi_id' => (int) ($_POST['prodi_id'] ?? 0),
        ];

        $errors = $this->validate($data);

        if ($errors) {
            $data['id'] = $id;
            $prodi = $this->prodiModel->all();
            require __DIR__ . '/../Views/matakuliah/edit.php';
            return;
        }

        try {
            $this->model->update($id, $data);
            $this->redirect('/matakuliah');
        } catch (PDOException $e) {
            $errors[] = 'Kode mata kuliah sudah digunakan atau data gagal diperbarui.';
            $data['id'] = $id;
            $prodi = $this->prodiModel->all();
            require __DIR__ . '/../Views/matakuliah/edit.php';
        }
    }

    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->model->delete($id);
        }

        $this->redirect('/matakuliah');
    }

    private function validate(array $data): array
    {
        $errors = [];

        if ($data['kode'] === '') {
            $errors[] = 'Kode mata kuliah wajib diisi.';
        }

        if ($data['nama'] === '') {
            $errors[] = 'Nama mata kuliah wajib diisi.';
        }

        if ($data['sks'] < 1 || $data['sks'] > 6) {
            $errors[] = 'SKS harus antara 1 sampai 6.';
        }

        if ($data['prodi_id'] <= 0) {
            $errors[] = 'Program studi wajib dipilih.';
        }

        return $errors;
    }

    private function redirect(string $path): void
    {
        header('Location: ' . dirname($_SERVER['SCRIPT_NAME']) . $path);
        exit;
    }
}
