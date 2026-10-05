<?php

namespace App\Models;

use PDO;

class Mahasiswa
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $sql = "
            SELECT
                mahasiswa.nim,
                mahasiswa.nama,
                program_studi.nama_prodi,
                mahasiswa.angkatan,
                mahasiswa.status
            FROM mahasiswa
            LEFT JOIN program_studi
                ON mahasiswa.id_prodi = program_studi.id_prodi
            ORDER BY mahasiswa.nim ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}