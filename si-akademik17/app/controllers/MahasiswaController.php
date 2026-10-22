
<?php

require_once __DIR__ . '/../models/Mahasiswa.php';

class MahasiswaController
{
    private Mahasiswa $model;

    public function __construct()
    {
        $this->model = new Mahasiswa();
    }

    // GET: mengambil semua data atau satu mahasiswa
    public function index(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if (isset($_GET['id'])) {
                $id = filter_var(
                    $_GET['id'],
                    FILTER_VALIDATE_INT
                );

                if ($id === false || $id === null || $id < 1) {
                    http_response_code(400);
                    echo json_encode([
                        'message' => 'ID tidak valid'
                    ]);
                    return;
                }

                $data = $this->model->find($id);

                if (!$data) {
                    http_response_code(404);
                    echo json_encode([
                        'message' => 'Data mahasiswa tidak ditemukan'
                    ]);
                    return;
                }

                echo json_encode($data);
                return;
            }

            echo json_encode($this->model->getAll());

        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Terjadi kesalahan pada server'
            ]);
        }
    }

    // POST: menambahkan mahasiswa
    public function store(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        // Validasi input
        if (
            !is_array($data) ||
            !isset($data['nim'], $data['nama'], $data['prodi']) ||
            !is_string($data['nim']) ||
            !is_string($data['nama']) ||
            !is_string($data['prodi']) ||
            trim($data['nim']) === '' ||
            trim($data['nama']) === '' ||
            trim($data['prodi']) === ''
        ) {
            http_response_code(400);
            echo json_encode([
                'message' => 'NIM, nama, dan prodi wajib diisi'
            ]);
            return;
        }

        try {
            $berhasil = $this->model->create([
                'nim' => trim($data['nim']),
                'nama' => trim($data['nama']),
                'prodi' => trim($data['prodi']),
            ]);

            if (!$berhasil) {
                http_response_code(409);
                echo json_encode([
                    'message' => 'NIM sudah terdaftar'
                ]);
                return;
            }

            http_response_code(201);
            echo json_encode([
                'message' => 'Mahasiswa berhasil ditambahkan'
            ]);

        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Terjadi kesalahan pada server'
            ]);
        }
    }

    // PUT: mengubah mahasiswa
    public function update(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_var(
            $_GET['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($id === false || $id === null || $id < 1) {
            http_response_code(400);
            echo json_encode([
                'message' => 'ID tidak valid'
            ]);
            return;
        }

        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        // Validasi input
        if (
            !is_array($data) ||
            !isset($data['nim'], $data['nama'], $data['prodi']) ||
            !is_string($data['nim']) ||
            !is_string($data['nama']) ||
            !is_string($data['prodi']) ||
            trim($data['nim']) === '' ||
            trim($data['nama']) === '' ||
            trim($data['prodi']) === ''
        ) {
            http_response_code(400);
            echo json_encode([
                'message' => 'NIM, nama, dan prodi wajib diisi'
            ]);
            return;
        }

        try {
            // Pastikan mahasiswa yang akan diubah tersedia
            if (!$this->model->find($id)) {
                http_response_code(404);
                echo json_encode([
                    'message' => 'Data mahasiswa tidak ditemukan'
                ]);
                return;
            }

            $berhasil = $this->model->update($id, [
                'nim' => trim($data['nim']),
                'nama' => trim($data['nama']),
                'prodi' => trim($data['prodi']),
            ]);

            if (!$berhasil) {
                http_response_code(409);
                echo json_encode([
                    'message' => 'NIM sudah digunakan mahasiswa lain'
                ]);
                return;
            }

            echo json_encode([
                'message' => 'Data mahasiswa berhasil diubah'
            ]);

        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Terjadi kesalahan pada server'
            ]);
        }
    }

    // DELETE: menghapus mahasiswa
    public function destroy(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_var(
            $_GET['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($id === false || $id === null || $id < 1) {
            http_response_code(400);
            echo json_encode([
                'message' => 'ID tidak valid'
            ]);
            return;
        }

        try {
            if (!$this->model->find($id)) {
                http_response_code(404);
                echo json_encode([
                    'message' => 'Data mahasiswa tidak ditemukan'
                ]);
                return;
            }

            $this->model->delete($id);

            echo json_encode([
                'message' => 'Data mahasiswa berhasil dihapus'
            ]);

        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'message' => 'Terjadi kesalahan pada server'
            ]);
        }
    }
}
