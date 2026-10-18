
<?php

require_once __DIR__ . '/../Models/MahasiswaRepository.php';

class MahasiswaService
{
    private $repository;

    public function __construct(MahasiswaRepository $repository)
    {
        $this->repository = $repository;
    }

    private function validate($data, $excludeId = null)
    {
        $errors = [];

        $nim = trim($data['nim'] ?? '');
        $nama = trim($data['nama'] ?? '');
        $status = strtolower(trim($data['status'] ?? ''));

        if ($nim === '') {
            $errors[] = 'NIM wajib diisi.';
        } elseif ($this->repository->nimExists($nim, $excludeId)) {
            $errors[] = 'NIM sudah digunakan mahasiswa lain.';
        }

        if ($nama === '') {
            $errors[] = 'Nama mahasiswa wajib diisi.';
        }

        if (!in_array($status, ['aktif', 'cuti', 'lulus'], true)) {
            $errors[] = 'Status mahasiswa tidak valid.';
        }

        $prodiId = $data['prodi_id'] ?? null;

        if ($prodiId !== null && $prodiId !== '') {
            if (
                !ctype_digit((string) $prodiId) ||
                !$this->repository->prodiExists((int) $prodiId)
            ) {
                $errors[] = 'Program studi tidak valid.';
            }
        } else {
            $namaProdi = trim($data['prodi'] ?? '');

            $prodiValid = false;

            foreach ($this->repository->prodiList() as $prodi) {
                if ($prodi['nama'] === $namaProdi && $namaProdi !== '') {
                    $prodiValid = true;
                    break;
                }
            }

            if (!$prodiValid) {
                $errors[] = 'Program studi wajib dipilih.';
            }
        }

        if (isset($data['angkatan']) && $data['angkatan'] !== '') {
            if (
                !ctype_digit((string) $data['angkatan']) ||
                (int) $data['angkatan'] < 1900 ||
                (int) $data['angkatan'] > ((int) date('Y') + 1)
            ) {
                $errors[] = 'Tahun angkatan tidak valid.';
            }
        }

        if (isset($data['dosen_id']) && $data['dosen_id'] !== '') {
            if (
                !ctype_digit((string) $data['dosen_id']) ||
                (int) $data['dosen_id'] <= 0
            ) {
                $errors[] = 'Dosen ID tidak valid.';
            }
        }

        return $errors;
    }

    public function create($data)
    {
        $errors = $this->validate($data);

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        try {
            $success = $this->repository->create($data);

            return [
                'success' => $success,
                'errors' => $success ? [] : ['Data mahasiswa gagal disimpan.']
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'errors' => ['Data gagal disimpan. Periksa kembali data yang dimasukkan.']
            ];
        }
    }

    public function update($id, $data)
    {
        $id = (int) $id;

        if ($id <= 0 || !$this->repository->find($id)) {
            return [
                'success' => false,
                'errors' => ['Data mahasiswa tidak ditemukan.']
            ];
        }

        $errors = $this->validate($data, $id);

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }

        try {
            $success = $this->repository->update($id, $data);

            return [
                'success' => $success,
                'errors' => $success ? [] : ['Data mahasiswa gagal diperbarui.']
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'errors' => ['Data gagal diperbarui. Periksa kembali data yang dimasukkan.']
            ];
        }
    }
}
