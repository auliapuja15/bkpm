
<?php

require_once __DIR__ . '/../models/Buku.php';

class BukuController
{
    private Buku $model;

    public function __construct()
    {
        $this->model = new Buku();
    }

    private function input(): array|false
    {
        $data = json_decode(
            file_get_contents('php://input'),
            true
        );

        if (!is_array($data)) {
            return false;
        }

        foreach (['judul', 'penulis', 'penerbit', 'tahun_terbit'] as $field) {
            if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                return false;
            }
        }

        $tahun = filter_var(
            $data['tahun_terbit'],
            FILTER_VALIDATE_INT
        );

        if ($tahun === false || $tahun < 1 || $tahun > 2155) {
            return false;
        }

        return [
            'judul' => trim($data['judul']),
            'penulis' => trim($data['penulis']),
            'penerbit' => trim($data['penerbit']),
            'tahun_terbit' => $tahun,
        ];
    }

    public function index(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if (isset($_GET['id'])) {
                $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

                if (!$id || $id < 1) {
                    http_response_code(400);
                    echo json_encode(['message' => 'ID tidak valid']);
                    return;
                }

                $buku = $this->model->find($id);

                if (!$buku) {
                    http_response_code(404);
                    echo json_encode(['message' => 'Buku tidak ditemukan']);
                    return;
                }

                echo json_encode($buku);
                return;
            }

            echo json_encode($this->model->getAll());
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Terjadi kesalahan pada server']);
        }
    }

    public function store(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $data = $this->input();

        if ($data === false) {
            http_response_code(400);
            echo json_encode(['message' => 'Data buku tidak valid atau belum lengkap']);
            return;
        }

        try {
            $this->model->create($data);

            http_response_code(201);
            echo json_encode(['message' => 'Buku berhasil ditambahkan']);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Terjadi kesalahan pada server']);
        }
    }

    public function update(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak valid']);
            return;
        }

        $data = $this->input();

        if ($data === false) {
            http_response_code(400);
            echo json_encode(['message' => 'Data buku tidak valid atau belum lengkap']);
            return;
        }

        try {
            if (!$this->model->find($id)) {
                http_response_code(404);
                echo json_encode(['message' => 'Buku tidak ditemukan']);
                return;
            }

            $this->model->update($id, $data);

            echo json_encode(['message' => 'Buku berhasil diubah']);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Terjadi kesalahan pada server']);
        }
    }

    public function destroy(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            http_response_code(400);
            echo json_encode(['message' => 'ID tidak valid']);
            return;
        }

        try {
            if (!$this->model->find($id)) {
                http_response_code(404);
                echo json_encode(['message' => 'Buku tidak ditemukan']);
                return;
            }

            $this->model->delete($id);

            echo json_encode(['message' => 'Buku berhasil dihapus']);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Terjadi kesalahan pada server']);
        }
    }
}
