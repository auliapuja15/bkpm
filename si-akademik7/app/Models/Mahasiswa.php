<?php

namespace App\Models;

use PDO;

class Mahasiswa
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll(): array
    {
        $sql = "
            SELECT
                m.id,
                m.nim,
                m.nama,
                m.prodi,
                m.status,
                d.nama AS nama_dosen
            FROM mahasiswa AS m
            LEFT JOIN dosen AS d
                ON m.dosen_id = d.id
            ORDER BY m.id ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}