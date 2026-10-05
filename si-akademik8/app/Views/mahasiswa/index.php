<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Mahasiswa</title>

    <style>
        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            max-width: 1100px;
        }

        h1 {
            font-size: 36px;
            margin: 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-tambah {
            background-color: #198754;
            color: white;
        }

        .btn-edit {
            background-color: #ffc107;
            color: black;
        }

        .btn-hapus {
            background-color: #dc3545;
            color: white;
        }

        .search-box {
            margin-bottom: 20px;
            max-width: 1100px;
        }

        .search-box input {
            padding: 10px;
            width: 300px;
            border: 1px solid #aaa;
            border-radius: 5px;
        }

        .search-box button {
            padding: 10px 16px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: white;
            cursor: pointer;
        }

        .search-box a {
            margin-left: 5px;
            text-decoration: none;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 1100px;
        }

        th,
        td {
            border: 1px solid #777;
            padding: 12px 10px;
            font-size: 16px;
        }

        th {
            font-weight: bold;
            text-align: center;
            background-color: #333;
            color: white;
        }

        td:first-child {
            text-align: center;
        }

        td:nth-child(2) {
            width: 120px;
        }

        td:nth-child(3) {
            width: 200px;
        }

        td:nth-child(4) {
            width: 280px;
        }

        td:nth-child(5),
        td:nth-child(6) {
            text-align: center;
            width: 120px;
        }

        .aksi {
            text-align: center;
            white-space: nowrap;
        }

        .aksi form {
            display: inline;
        }
    </style>
</head>

<body>

    <div class="header">

        <h1>Data Mahasiswa</h1>

        <a
            href="/si-akademik8/public/mahasiswa/create"
            class="btn btn-tambah">
            + Tambah Mahasiswa
        </a>

    </div>


    <!-- Search -->
    <div class="search-box">

        <form
            action="/si-akademik8/public/mahasiswa"
            method="GET">

            <input
                type="text"
                name="search"
                placeholder="Cari NIM atau nama..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

            <button type="submit">
                Cari
            </button>

            <?php if (!empty($_GET['search'])): ?>

                <a href="/si-akademik8/public/mahasiswa">
                    Reset
                </a>

            <?php endif; ?>

        </form>

    </div>


    <!-- Tabel -->
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

            <?php if (empty($mahasiswa)): ?>

                <tr>
                    <td colspan="7" style="text-align: center;">
                        Data mahasiswa tidak ditemukan.
                    </td>
                </tr>

            <?php else: ?>

                <?php $no = 1; ?>

                <?php foreach ($mahasiswa as $mhs): ?>

                    <tr>

                        <td>
                            <?= $no++ ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($mhs['nim']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($mhs['nama']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($mhs['nama_prodi']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($mhs['angkatan']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($mhs['status']) ?>
                        </td>

                        <td class="aksi">

                            <!-- Edit -->
                            <a
                                href="/si-akademik8/public/mahasiswa/edit?nim=<?= urlencode($mhs['nim']) ?>"
                                class="btn btn-edit">
                                Edit
                            </a>

                            <!-- Hapus -->
                            <form
                                action="/si-akademik8/public/mahasiswa/delete"
                                method="POST"
                                onsubmit="return confirm('Apakah kamu yakin ingin menghapus data mahasiswa ini?');">

                                <input
                                    type="hidden"
                                    name="nim"
                                    value="<?= htmlspecialchars($mhs['nim']) ?>">

                                <button
                                    type="submit"
                                    class="btn btn-hapus">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php endif; ?>

        </tbody>

    </table>

</body>

</html>