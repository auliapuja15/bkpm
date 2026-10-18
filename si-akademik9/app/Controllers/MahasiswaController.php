
<?php

require_once __DIR__ . '/../Models/Mahasiswa.php';
require_once __DIR__ . '/../Repositories/MahasiswaRepository.php';

class MahasiswaController
{
    private MahasiswaRepository $repo;

    public function __construct(MahasiswaRepository $repo)
    {
        $this->repo = $repo;
    }

    // Menampilkan daftar mahasiswa
    public function index(): void
    {
        $mahasiswa = $this->repo->all();

        $content = __DIR__ . '/../Views/mahasiswa/index.php';

        require __DIR__ . '/../Views/layouts/main.php';
    }

    // Menampilkan form tambah mahasiswa
    public function create(): void
    {
        $content = __DIR__ . '/../Views/mahasiswa/create.php';

        require __DIR__ . '/../Views/layouts/main.php';
    }

    // Menyimpan mahasiswa baru
    public function store(): void
    {
        try {
            $nim = trim($_POST['nim'] ?? '');
            $nama = trim($_POST['nama'] ?? '');

            // Ambil ID program studi, bukan nama program studi
            $prodi_id = filter_var(
                $_POST['prodi_id'] ?? null,
                FILTER_VALIDATE_INT
            );

            $status = $_POST['status'] ?? 'aktif';

            // Pilihan dosen kosong berarti NULL
            $dosenInput = $_POST['dosen_id'] ?? '';

            $dosen_id = ($dosenInput !== '')
                ? filter_var($dosenInput, FILTER_VALIDATE_INT)
                : null;

            if ($prodi_id === false || $prodi_id === null || $prodi_id <= 0) {
                throw new InvalidArgumentException(
                    'Silakan pilih program studi yang valid.'
                );
            }

            if ($dosenInput !== '' &&
                ($dosen_id === false || $dosen_id <= 0)) {
                throw new InvalidArgumentException(
                    'Silakan pilih dosen yang valid.'
                );
            }

            $mahasiswa = new Mahasiswa(
                $nim,
                $nama,
                $prodi_id,
                $status,
                $dosen_id
            );

            $this->repo->create($mahasiswa);

            header('Location: ' . BASE_URL . '/mahasiswa');
            exit;

        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo htmlspecialchars(
                $e->getMessage(),
                ENT_QUOTES,
                'UTF-8'
            );
        }
    }

    // Menampilkan form edit mahasiswa
    public function edit(int $id): void
    {
        $mahasiswa = $this->repo->find($id);

        if (!$mahasiswa) {
            http_response_code(404);
            echo 'Data mahasiswa tidak ditemukan.';
            return;
        }

        $content = __DIR__ . '/../Views/mahasiswa/edit.php';

        require __DIR__ . '/../Views/layouts/main.php';
    }

    // Memperbarui data mahasiswa
    public function update(int $id): void
    {
        try {
            $nim = trim($_POST['nim'] ?? '');
            $nama = trim($_POST['nama'] ?? '');

            // Ambil ID program studi, bukan nama program studi
            $prodi_id = filter_var(
                $_POST['prodi_id'] ?? null,
                FILTER_VALIDATE_INT
            );

            $status = $_POST['status'] ?? 'aktif';

            $dosenInput = $_POST['dosen_id'] ?? '';

            $dosen_id = ($dosenInput !== '')
                ? filter_var($dosenInput, FILTER_VALIDATE_INT)
                : null;

            if ($prodi_id === false || $prodi_id === null || $prodi_id <= 0) {
                throw new InvalidArgumentException(
                    'Silakan pilih program studi yang valid.'
                );
            }

            if ($dosenInput !== '' &&
                ($dosen_id === false || $dosen_id <= 0)) {
                throw new InvalidArgumentException(
                    'Silakan pilih dosen yang valid.'
                );
            }

            $mahasiswa = new Mahasiswa(
                $nim,
                $nama,
                $prodi_id,
                $status,
                $dosen_id
            );

            $this->repo->update($id, $mahasiswa);

            header('Location: ' . BASE_URL . '/mahasiswa');
            exit;

        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo htmlspecialchars(
                $e->getMessage(),
                ENT_QUOTES,
                'UTF-8'
            );
        }
    }

    // Menghapus mahasiswa
    public function destroy(int $id): void
    {
        $this->repo->delete($id);

        header('Location: ' . BASE_URL . '/mahasiswa');
        exit;
    }
}
