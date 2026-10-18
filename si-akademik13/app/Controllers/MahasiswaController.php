
<?php

require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../Models/MahasiswaRepository.php';
require_once __DIR__ . '/../Services/MahasiswaService.php';

class MahasiswaController extends BaseController
{
    private const LIST_URL = BASE_URL . '/mahasiswa';

    private $repository;
    private $service;

    public function __construct()
    {
        $this->repository = new MahasiswaRepository(new Database());
        $this->service = new MahasiswaService($this->repository);
    }

    public function index()
    {
        AuthMiddleware::handle();

        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        $this->view('mahasiswa/index', [
            'mahasiswa' => $this->repository->all(),
            'flash' => $flash
        ]);
    }

    public function detail()
    {
        AuthMiddleware::handle();

        $mahasiswa = $this->repository->findDetail(
            (int) ($_GET['id'] ?? 0)
        );

        if (!$mahasiswa) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan.'
            ];

            $this->redirect(self::LIST_URL);
        }

        $this->view('mahasiswa/detail', [
            'mahasiswa' => $mahasiswa
        ]);
    }

    public function create()
    {
        AuthMiddleware::handle();

        $this->view('mahasiswa/create', [
            'prodiList' => $this->repository->prodiList()
        ]);
    }

    public function store()
    {
        AuthMiddleware::handle();
        $this->mustBePost();

        $result = $this->service->create($_POST);

        if ($result['success']) {
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Data mahasiswa berhasil ditambahkan.'
            ];
        } else {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => implode(' ', $result['errors'])
            ];
        }

        $this->redirect(self::LIST_URL);
    }

    public function edit()
    {
        AuthMiddleware::handle();

        $id = (int) ($_GET['id'] ?? 0);
        $mahasiswa = $this->repository->find($id);

        if (!$mahasiswa) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan.'
            ];

            $this->redirect(self::LIST_URL);
        }

        $this->view('mahasiswa/edit', [
            'mahasiswa' => $mahasiswa,
            'prodiList' => $this->repository->prodiList()
        ]);
    }

    public function update()
    {
        AuthMiddleware::handle();
        $this->mustBePost();

        $id = (int) ($_POST['id'] ?? 0);
        $result = $this->service->update($id, $_POST);

        if ($result['success']) {
            $_SESSION['flash'] = [
                'type' => 'success',
                'message' => 'Data mahasiswa berhasil diperbarui.'
            ];
        } else {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => implode(' ', $result['errors'])
            ];
        }

        $this->redirect(self::LIST_URL);
    }

    public function delete()
    {
        AuthMiddleware::handle();
        $this->mustBePost();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0 || !$this->repository->find($id)) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'message' => 'Data mahasiswa tidak ditemukan.'
            ];
        } else {
            try {
                $success = $this->repository->delete($id);

                $_SESSION['flash'] = [
                    'type' => $success ? 'success' : 'error',
                    'message' => $success
                        ? 'Data mahasiswa berhasil dihapus.'
                        : 'Data mahasiswa gagal dihapus.'
                ];
            } catch (PDOException $e) {
                $_SESSION['flash'] = [
                    'type' => 'error',
                    'message' => 'Data mahasiswa gagal dihapus. Periksa relasi data di database.'
                ];
            }
        }

        $this->redirect(self::LIST_URL);
    }

    private function mustBePost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(self::LIST_URL);
        }
    }
}
