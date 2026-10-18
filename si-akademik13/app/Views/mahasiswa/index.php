
<?php
$mahasiswa = $mahasiswa ?? [];
$flash = $flash ?? null;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
</head>
<body>

    <h1>Data Mahasiswa</h1>

    <?php if (!empty($flash)): ?>
        <p style="color: <?= ($flash['type'] ?? '') === 'success' ? 'green' : 'red' ?>;">
            <?= htmlspecialchars($flash['message'] ?? '') ?>
        </p>
    <?php endif; ?>

    <p>
        <a href="<?= BASE_URL ?>/mahasiswa/create">
            + Tambah Mahasiswa
        </a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Prodi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($mahasiswa)): ?>
                <?php foreach ($mahasiswa as $mhs): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) ($mhs['id'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($mhs['nim'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($mhs['nama'] ?? '')) ?></td>
                        <td><?= htmlspecialchars((string) ($mhs['prodi'] ?? '-')) ?></td>
                        <td><?= htmlspecialchars((string) ($mhs['status'] ?? '')) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/mahasiswa/edit?id=<?= (int) ($mhs['id'] ?? 0) ?>">
                                Edit
                            </a>

                            <form method="POST"
                                  action="<?= BASE_URL ?>/mahasiswa/delete"
                                  style="display:inline;">

                                <input type="hidden"
                                       name="id"
                                       value="<?= (int) ($mhs['id'] ?? 0) ?>">

                                <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Belum ada data mahasiswa.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
