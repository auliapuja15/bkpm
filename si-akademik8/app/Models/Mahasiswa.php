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

    // Menampilkan semua data mahasiswa
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

    // Mencari mahasiswa berdasarkan NIM
    public function find($nim)
    {
        $sql = "
            SELECT
                mahasiswa.*,
                program_studi.nama_prodi
            FROM mahasiswa
            LEFT JOIN program_studi
                ON mahasiswa.id_prodi = program_studi.id_prodi
            WHERE mahasiswa.nim = :nim
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'nim' => $nim
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Menambahkan mahasiswa
    public function create($data)
    {
        $sql = "
            INSERT INTO mahasiswa
            (
                nim,
                nama,
                id_prodi,
                angkatan,
                status
            )
            VALUES
            (
                :nim,
                :nama,
                :id_prodi,
                :angkatan,
                :status
            )
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'id_prodi' => $data['id_prodi'],
            'angkatan' => $data['angkatan'],
            'status' => $data['status']
        ]);
    }

    // Mengubah data mahasiswa
    public function update($nim, $data)
    {
        $sql = "
            UPDATE mahasiswa
            SET
                nama = :nama,
                id_prodi = :id_prodi,
                angkatan = :angkatan,
                status = :status
            WHERE nim = :nim
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nama' => $data['nama'],
            'id_prodi' => $data['id_prodi'],
            'angkatan' => $data['angkatan'],
            'status' => $data['status'],
            'nim' => $nim
        ]);
    }

    // Menghapus data mahasiswa
    public function delete($nim)
    {
        $sql = "
            DELETE FROM mahasiswa
            WHERE nim = :nim
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'nim' => $nim
        ]);
    }

    // Search berdasarkan NIM atau nama
    public function search($keyword)
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
            WHERE mahasiswa.nim LIKE :keyword_nim
               OR mahasiswa.nama LIKE :keyword_nama
            ORDER BY mahasiswa.nim ASC
        ";

        $stmt = $this->pdo->prepare($sql);

        $keyword = '%' . $keyword . '%';

        $stmt->execute([
            'keyword_nim' => $keyword,
            'keyword_nama' => $keyword
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mengambil semua program studi
    public function getProgramStudi()
    {
        $sql = "
            SELECT
                id_prodi,
                nama_prodi
            FROM program_studi
            ORDER BY nama_prodi ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}