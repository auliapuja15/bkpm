<?php

header('Content-Type: application/json; charset=utf-8');

function responseJson(int $status, array $body): void
{
    http_response_code($status);
    echo json_encode($body, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

function readJsonBody(): array
{
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
        responseJson(400, [
            'success' => false,
            'message' => 'Format JSON tidak valid atau body JSON kosong'
        ]);
    }

    return $data;
}

function validateMahasiswa(array $input, PDO $pdo, ?int $id = null): array
{
    $nim = trim((string) ($input['nim'] ?? ''));
    $nama = trim((string) ($input['nama'] ?? ''));
    $email = trim((string) ($input['email'] ?? ''));
    $prodiId = filter_var($input['prodi_id'] ?? null, FILTER_VALIDATE_INT);
    $angkatan = filter_var($input['angkatan'] ?? null, FILTER_VALIDATE_INT);
    $status = strtolower(trim((string) ($input['status'] ?? 'aktif')));
    $dosenInput = $input['dosen_id'] ?? null;

    if ($nim === '' || $nama === '' || $prodiId === false || $prodiId === null || $prodiId < 1 ||
        $angkatan === false || $angkatan === null || $angkatan < 1) {
        responseJson(422, [
            'success' => false,
            'message' => 'NIM, nama, prodi_id, dan angkatan wajib diisi dengan benar'
        ]);
    }

    if (strlen($nim) > 20 || strlen($nama) > 100) {
        responseJson(422, [
            'success' => false,
            'message' => 'NIM maksimal 20 karakter dan nama maksimal 100 karakter'
        ]);
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        responseJson(422, [
            'success' => false,
            'message' => 'Format email tidak valid'
        ]);
    }
    $email = $email === '' ? null : $email;

    if (!in_array($status, ['aktif', 'cuti', 'lulus'], true)) {
        responseJson(422, [
            'success' => false,
            'message' => 'Status harus aktif, cuti, atau lulus'
        ]);
    }

    if ($dosenInput === '' || $dosenInput === null) {
        $dosenId = null;
    } else {
        $dosenId = filter_var($dosenInput, FILTER_VALIDATE_INT);
        if ($dosenId === false || $dosenId < 1) {
            responseJson(422, [
                'success' => false,
                'message' => 'dosen_id tidak valid'
            ]);
        }
    }

    $sqlNim = 'SELECT id FROM mahasiswa WHERE nim = :nim';
    if ($id !== null) {
        $sqlNim .= ' AND id <> :id';
    }
    $check = $pdo->prepare($sqlNim);
    $paramsNim = ['nim' => $nim];
    if ($id !== null) {
        $paramsNim['id'] = $id;
    }
    $check->execute($paramsNim);
    if ($check->fetch()) {
        responseJson(409, ['success' => false, 'message' => 'NIM sudah terdaftar']);
    }

    $check = $pdo->prepare('SELECT id FROM prodi WHERE id = :id');
    $check->execute(['id' => $prodiId]);
    if (!$check->fetch()) {
        responseJson(422, ['success' => false, 'message' => 'Program studi tidak ditemukan']);
    }

    if ($dosenId !== null) {
        $check = $pdo->prepare('SELECT id FROM dosen WHERE id = :id');
        $check->execute(['id' => $dosenId]);
        if (!$check->fetch()) {
            responseJson(422, ['success' => false, 'message' => 'Dosen tidak ditemukan']);
        }
    }

    return [
        'nim' => $nim,
        'nama' => $nama,
        'email' => $email,
        'prodi_id' => $prodiId,
        'angkatan' => $angkatan,
        'status' => $status,
        'dosen_id' => $dosenId
    ];
}

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=si_akademik;charset=utf8mb4',
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    // ID dapat berasal dari aturan rewrite /api/mahasiswa/1 atau query ?id=1.
    $idInput = $_GET['id'] ?? null;
    if ($idInput === null && !empty($_SERVER['PATH_INFO'])) {
        $idInput = trim($_SERVER['PATH_INFO'], '/');
    }
    $id = null;
    if ($idInput !== null && $idInput !== '') {
        $id = filter_var($idInput, FILTER_VALIDATE_INT);
        if ($id === false || $id < 1) {
            responseJson(400, ['success' => false, 'message' => 'ID mahasiswa tidak valid']);
        }
    }

    if ($method === 'GET') {
        if ($id !== null) {
            $stmt = $pdo->prepare(
                'SELECT m.id, m.nim, m.nama, m.email, m.prodi_id, p.nama AS prodi,
                        m.angkatan, m.status, m.dosen_id
                 FROM mahasiswa m LEFT JOIN prodi p ON p.id = m.prodi_id
                 WHERE m.id = :id'
            );
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch();
            if (!$data) {
                responseJson(404, ['success' => false, 'message' => 'Mahasiswa tidak ditemukan']);
            }
            responseJson(200, ['success' => true, 'message' => 'Data mahasiswa berhasil diambil', 'data' => $data]);
        }

        $stmt = $pdo->query(
            'SELECT m.id, m.nim, m.nama, m.email, m.prodi_id, p.nama AS prodi,
                    m.angkatan, m.status, m.dosen_id
             FROM mahasiswa m LEFT JOIN prodi p ON p.id = m.prodi_id
             ORDER BY m.id ASC'
        );
        responseJson(200, ['success' => true, 'message' => 'Data mahasiswa berhasil diambil', 'data' => $stmt->fetchAll()]);
    }

    if ($method === 'POST') {
        $data = validateMahasiswa(readJsonBody(), $pdo);
        $stmt = $pdo->prepare(
            'INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan, status, dosen_id)
             VALUES (:nim, :nama, :email, :prodi_id, :angkatan, :status, :dosen_id)'
        );
        $stmt->execute($data);
        $data['id'] = (int) $pdo->lastInsertId();
        responseJson(201, ['success' => true, 'message' => 'Mahasiswa berhasil ditambahkan', 'data' => $data]);
    }

    if ($method === 'PUT') {
        if ($id === null) {
            responseJson(400, ['success' => false, 'message' => 'ID mahasiswa wajib dicantumkan pada URL']);
        }
        $check = $pdo->prepare('SELECT id FROM mahasiswa WHERE id = :id');
        $check->execute(['id' => $id]);
        if (!$check->fetch()) {
            responseJson(404, ['success' => false, 'message' => 'Mahasiswa tidak ditemukan']);
        }

        $data = validateMahasiswa(readJsonBody(), $pdo, $id);
        $data['id'] = $id;
        $stmt = $pdo->prepare(
            'UPDATE mahasiswa SET nim = :nim, nama = :nama, email = :email,
             prodi_id = :prodi_id, angkatan = :angkatan, status = :status, dosen_id = :dosen_id
             WHERE id = :id'
        );
        $stmt->execute($data);
        responseJson(200, ['success' => true, 'message' => 'Data mahasiswa berhasil diperbarui', 'data' => $data]);
    }

    if ($method === 'DELETE') {
        if ($id === null) {
            responseJson(400, ['success' => false, 'message' => 'ID mahasiswa wajib dicantumkan pada URL']);
        }
        $check = $pdo->prepare('SELECT id, nim, nama FROM mahasiswa WHERE id = :id');
        $check->execute(['id' => $id]);
        $data = $check->fetch();
        if (!$data) {
            responseJson(404, ['success' => false, 'message' => 'Mahasiswa tidak ditemukan']);
        }
        $stmt = $pdo->prepare('DELETE FROM mahasiswa WHERE id = :id');
        $stmt->execute(['id' => $id]);
        responseJson(200, ['success' => true, 'message' => 'Mahasiswa berhasil dihapus', 'data' => $data]);
    }

    header('Allow: GET, POST, PUT, DELETE');
    responseJson(405, ['success' => false, 'message' => 'Method tidak diizinkan']);

} catch (Throwable $e) {
    error_log('[' . date('Y-m-d H:i:s') . '] API error: ' . $e->getMessage() . PHP_EOL,
        3, __DIR__ . '/../storage/logs/app.log');
    responseJson(500, ['success' => false, 'message' => 'Terjadi kesalahan pada server']);
}
