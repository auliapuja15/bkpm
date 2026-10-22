
<?php

require_once __DIR__ . '/../config/Database.php';

class Mahasiswa
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Mengambil semua data mahasiswa
    public function getAll(): array
    {
        $sql = "SELECT * FROM mahasiswa ORDER BY id ASC";
        $stmt = $this->db->query($sql);

        return $stmt->fetchAll();
    }

    // Mengambil satu data mahasiswa berdasarkan ID
    public function find(int $id): array|false
    {
        $sql = "SELECT * FROM mahasiswa WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    // Memeriksa apakah NIM sudah digunakan
    public function existsNim(
        string $nim,
        ?int $excludeId = null
    ): bool {
        if ($excludeId !== null) {
            $sql = "SELECT COUNT(*) FROM mahasiswa
                    WHERE nim = :nim AND id != :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'nim' => $nim,
                'id' => $excludeId,
            ]);
        } else {
            $sql = "SELECT COUNT(*) FROM mahasiswa
                    WHERE nim = :nim";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'nim' => $nim,
            ]);
        }

        return (int) $stmt->fetchColumn() > 0;
    }

    // Menambahkan data mahasiswa
    public function create(array $data): bool
    {
        // Tolak NIM yang sudah terdaftar
        if ($this->existsNim($data['nim'])) {
            return false;
        }

        $sql = "INSERT INTO mahasiswa (nim, nama, prodi)
                VALUES (:nim, :nama, :prodi)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'prodi' => $data['prodi'],
        ]);
    }

    // Mengubah data mahasiswa
    public function update(int $id, array $data): bool
    {
        // Tolak NIM yang digunakan mahasiswa lain
        if ($this->existsNim($data['nim'], $id)) {
            return false;
        }

        $sql = "UPDATE mahasiswa
                SET nim = :nim,
                    nama = :nama,
                    prodi = :prodi
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'prodi' => $data['prodi'],
            'id' => $id,
        ]);
    }

    // Menghapus data mahasiswa
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM mahasiswa WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $id,
        ]);
    }
}
