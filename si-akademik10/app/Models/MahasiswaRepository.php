<?php

require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Mahasiswa.php';

class MahasiswaRepository extends Model
{

   public function all()
{
    $sql = "SELECT m.id, m.nim, m.nama, p.nama AS prodi, m.status, m.dosen_id
            FROM mahasiswa m
            LEFT JOIN prodi p ON m.prodi_id = p.id
            ORDER BY m.nim";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Daftar nama prodi untuk dropdown form
    public function prodiList()
    {
        $stmt = $this->db->query("SELECT nama FROM prodi ORDER BY nama");

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM mahasiswa WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findDetail($id)
    {
       $sql = "SELECT m.nim, m.nama, m.prodi_id, p.nama AS prodi,
               m.angkatan, m.status, m.dosen_id
        FROM mahasiswa m
        LEFT JOIN prodi p ON m.prodi_id = p.id
        WHERE m.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $mahasiswa = new Mahasiswa();

        $mahasiswa->setNim($data['nim']);
        $mahasiswa->setNama($data['nama']);
        $mahasiswa->setProdi($data['prodi']);
        $mahasiswa->setStatus($data['status']);

        $sql = "INSERT INTO mahasiswa
        (nim, nama, prodi_id, status)
        VALUES
        (:nim, :nama, :prodi_id, :status)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nim' => $mahasiswa->getNim(),
            ':nama' => $mahasiswa->getNama(),
            ':prodi' => $mahasiswa->getProdi(),
            ':status' => $mahasiswa->getStatus()
        ]);
    }

    public function update($id, $data)
    {
        $mahasiswa = new Mahasiswa();

        $mahasiswa->setId($id);
        $mahasiswa->setNim($data['nim']);
        $mahasiswa->setNama($data['nama']);
        $mahasiswa->setProdi($data['prodi']);
        $mahasiswa->setStatus($data['status']);

        $sql = "UPDATE mahasiswa SET
                    nim = :nim,
                    nama = :nama,
                   prodi_id = :prodi_id,
                    status = :status
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $mahasiswa->getId(),
            ':nim' => $mahasiswa->getNim(),
            ':nama' => $mahasiswa->getNama(),
            ':prodi' => $mahasiswa->getProdi(),
            ':status' => $mahasiswa->getStatus()
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM mahasiswa WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id
        ]);
    }
}