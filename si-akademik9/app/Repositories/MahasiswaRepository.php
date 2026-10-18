
<?php

require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Models/Mahasiswa.php';

class MahasiswaRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Mengambil semua data mahasiswa
    public function all(): array
    {
        $stmt = $this->db->query("
            SELECT
                m.*,
                p.nama AS nama_prodi,
                d.nama AS nama_dosen
            FROM mahasiswa m
            LEFT JOIN prodi p ON m.prodi_id = p.id
            LEFT JOIN dosen d ON m.dosen_id = d.id
            ORDER BY m.id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil satu mahasiswa berdasarkan ID
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                m.*,
                p.nama AS nama_prodi,
                d.nama AS nama_dosen
            FROM mahasiswa m
            LEFT JOIN prodi p ON m.prodi_id = p.id
            LEFT JOIN dosen d ON m.dosen_id = d.id
            WHERE m.id = :id
        ");

        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ?: null;
    }

    // Menambahkan mahasiswa
    public function create(Mahasiswa $mahasiswa): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO mahasiswa
                (nim, nama, prodi_id, angkatan, status, dosen_id)
            VALUES
                (:nim, :nama, :prodi_id, :angkatan, :status, :dosen_id)
        ");

        return $stmt->execute([
            'nim'       => $mahasiswa->getNim(),
            'nama'      => $mahasiswa->getNama(),
            'prodi_id'  => $mahasiswa->getProdi(),
            'angkatan'  => $mahasiswa->getAngkatan(),
            'status'    => $mahasiswa->getStatus(),
            'dosen_id'  => $mahasiswa->getDosenId()
        ]);
    }

    // Memperbarui mahasiswa
    public function update(int $id, Mahasiswa $mahasiswa): bool
    {
        $stmt = $this->db->prepare("
            UPDATE mahasiswa SET
                nim = :nim,
                nama = :nama,
                prodi_id = :prodi_id,
                angkatan = :angkatan,
                status = :status,
                dosen_id = :dosen_id
            WHERE id = :id
        ");

        return $stmt->execute([
            'id'        => $id,
            'nim'       => $mahasiswa->getNim(),
            'nama'      => $mahasiswa->getNama(),
            'prodi_id'  => $mahasiswa->getProdi(),
            'angkatan'  => $mahasiswa->getAngkatan(),
            'status'    => $mahasiswa->getStatus(),
            'dosen_id'  => $mahasiswa->getDosenId()
        ]);
    }

    // Menghapus mahasiswa
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM mahasiswa
            WHERE id = :id
        ");

        return $stmt->execute(['id' => $id]);
    }
}