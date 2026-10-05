<?php

require_once __DIR__ . '/Model.php';

class MahasiswaModel extends Model
{
    public function all()
    {
        $query = "SELECT mahasiswa.*, program_studi.nama_prodi
                  FROM mahasiswa
                  JOIN program_studi
                  ON mahasiswa.id_prodi = program_studi.id_prodi";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}