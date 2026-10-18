
<?php

require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/Mahasiswa.php';

class MahasiswaRepository extends Model
{
    public function all()
    {
        $sql = "SELECT m.id, m.nim, m.nama, p.nama AS prodi,
                       m.prodi_id, m.angkatan, m.status, m.dosen_id
                FROM mahasiswa m
                LEFT JOIN prodi p ON m.prodi_id = p.id
                ORDER BY m.nim";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function prodiList()
    {
        $stmt = $this->db->query(
            "SELECT id, nama FROM prodi ORDER BY nama"
        );

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function prodiExists($prodiId)
    {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM prodi WHERE id = :id"
        );

        $stmt->execute([':id' => $prodiId]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function find($id)
    {
        $sql = "SELECT * FROM mahasiswa WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findDetail($id)
    {
        $sql = "SELECT m.id, m.nim, m.nama, m.prodi_id,
                       p.nama AS prodi, m.angkatan,
                       m.status, m.dosen_id
                FROM mahasiswa m
                LEFT JOIN prodi p ON m.prodi_id = p.id
                WHERE m.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function nimExists($nim, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM mahasiswa WHERE nim = :nim";

        if ($excludeId !== null) {
            $sql .= " AND id != :id";
        }

        $stmt = $this->db->prepare($sql);

        $params = [':nim' => trim($nim)];

        if ($excludeId !== null) {
            $params[':id'] = (int) $excludeId;
        }

        $stmt->execute($params);

        return (int) $stmt->fetchColumn() > 0;
    }

    private function resolveProdiId($data)
    {
        // Form edit mengirim prodi_id.
        if (
            isset($data['prodi_id']) &&
            ctype_digit((string) $data['prodi_id']) &&
            (int) $data['prodi_id'] > 0
        ) {
            $id = (int) $data['prodi_id'];

            return $this->prodiExists($id) ? $id : null;
        }

        // Form tambah yang lama mengirim nama prodi.
        $nama = trim($data['prodi'] ?? '');

        if ($nama === '') {
            return null;
        }

        $stmt = $this->db->prepare(
            "SELECT id FROM prodi WHERE nama = :nama"
        );

        $stmt->execute([':nama' => $nama]);

        $id = $stmt->fetchColumn();

        return $id !== false ? (int) $id : null;
    }

    public function create($data)
    {
        $prodiId = $this->resolveProdiId($data);

        if ($prodiId === null) {
            return false;
        }

        $angkatan = trim((string) ($data['angkatan'] ?? ''));
        $dosenId = trim((string) ($data['dosen_id'] ?? ''));

        $sql = "INSERT INTO mahasiswa
                    (nim, nama, prodi_id, angkatan, status, dosen_id)
                VALUES
                    (:nim, :nama, :prodi_id, :angkatan, :status, :dosen_id)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nim' => trim($data['nim'] ?? ''),
            ':nama' => trim($data['nama'] ?? ''),
            ':prodi_id' => $prodiId,
            ':angkatan' => $angkatan === '' ? null : (int) $angkatan,
            ':status' => strtolower(trim($data['status'] ?? '')),
            ':dosen_id' => $dosenId === '' ? null : (int) $dosenId
        ]);
    }

    public function update($id, $data)
    {
        $prodiId = $this->resolveProdiId($data);

        if ((int) $id <= 0 || $prodiId === null) {
            return false;
        }

        $angkatan = trim((string) ($data['angkatan'] ?? ''));
        $dosenId = trim((string) ($data['dosen_id'] ?? ''));

        $sql = "UPDATE mahasiswa SET
                    nim = :nim,
                    nama = :nama,
                    prodi_id = :prodi_id,
                    angkatan = :angkatan,
                    status = :status,
                    dosen_id = :dosen_id
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => (int) $id,
            ':nim' => trim($data['nim'] ?? ''),
            ':nama' => trim($data['nama'] ?? ''),
            ':prodi_id' => $prodiId,
            ':angkatan' => $angkatan === '' ? null : (int) $angkatan,
            ':status' => strtolower(trim($data['status'] ?? '')),
            ':dosen_id' => $dosenId === '' ? null : (int) $dosenId
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare(
            "DELETE FROM mahasiswa WHERE id = :id"
        );

        return $stmt->execute([':id' => (int) $id]);
    }
}
