<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            margin-top: 0;
            color: #333;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #b02a37;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #343a40;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .aksi {
            display: flex;
            gap: 5px;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-edit:hover {
            background-color: #e0a800;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-form input {
            padding: 9px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-form button {
            padding: 9px 14px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="top-bar">
        <h2>Data Mahasiswa</h2>

        <a href="/bkpm/acara9/public/mahasiswa/create" class="btn">
            + Tambah Mahasiswa
        </a>
    </div>

    <form method="GET" action="/bkpm/acara9/public/mahasiswa" class="search-form">
        <input
            type="text"
            name="keyword"
            placeholder="Cari NIM atau Nama..."
            value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>"
        >

        <button type="submit">Cari</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Angkatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php if (!empty($mahasiswa)): ?>

            <?php $no = 1; ?>

            <?php foreach ($mahasiswa as $m): ?>

                <tr>
                    <td><?= $no++ ?></td>

                    <td>
                        <?= htmlspecialchars($m['nim']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($m['nama']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($m['nama_prodi']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($m['angkatan']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($m['status']) ?>
                    </td>

                    <td>
                        <div class="aksi">

                            <a
                                href="/si-akademik9/public/mahasiswa/edit?nim=<?= urlencode($m['nim']) ?>"
                                class="btn btn-edit"
                            >
                                Edit
                            </a>

                            <form
                                action="/si-akademik9/public/mahasiswa/delete"
                                method="POST"
                                style="display:inline;"
                            >
                                <input
                                    type="hidden"
                                    name="nim"
                                    value="<?= htmlspecialchars($m['nim']) ?>"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                    onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')"
                                >
                                    Hapus
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>

            <?php endforeach; ?>

        <?php else: ?>

            <tr>
                <td colspan="7" style="text-align:center;">
                    Belum ada data mahasiswa.
                </td>
            </tr>

        <?php endif; ?>

        </tbody>
    </table>

</div>

</body>
</html>