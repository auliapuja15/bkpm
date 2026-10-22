
<?php

require_once __DIR__ . '/../config/Database.php';

class Buku
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll(): array
    {
        $stmt = $this->db->query(
            "SELECT * FROM buku ORDER BY id ASC"
        );

        return $stmt->fetchAll();
    }

    public function find(int $id): array|false
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM buku WHERE id = :id"
        );

        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO buku
                (judul, penulis, penerbit, tahun_terbit)
                VALUES
                (:judul, :penulis, :penerbit, :tahun_terbit)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'judul' => $data['judul'],
            'penulis' => $data['penulis'],
            'penerbit' => $data['penerbit'],
            'tahun_terbit' => $data['tahun_terbit'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE buku
                SET judul = :judul,
                    penulis = :penulis,
                    penerbit = :penerbit,
                    tahun_terbit = :tahun_terbit
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'judul' => $data['judul'],
            'penulis' => $data['penulis'],
            'penerbit' => $data['penerbit'],
            'tahun_terbit' => $data['tahun_terbit'],
            'id' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM buku WHERE id = :id"
        );

        return $stmt->execute(['id' => $id]);
    }
}
