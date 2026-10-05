<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Daftar Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <h1 class="mb-4">Daftar Mahasiswa</h1>

    <a href="create.php" class="btn btn-primary mb-3">
        + Tambah Mahasiswa
    </a>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Prodi</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>E4150656</td>
                <td>Arshinta Puja Aulia</td>
                <td>Teknik Informatika</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </td>
            </tr>

            <tr>
                <td>E41250290</td>
                <td>Azira Mutia Gani</td>
                <td>Teknik Informatika</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </td>
            </tr>

            <tr>
                <td>E41250030</td>
                <td>Nindia Tri Anggraini</td>
                <td>Teknik Informatika</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </td>
            </tr>

            <tr>
                <td>E41251234</td>
                <td>Shofi Maulana Shofa</td>
                <td>Teknik Informatika</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </td>
            </tr>

            <tr>
                <td>E41250343</td>
                <td>Aulia Luh Bilkis</td>
                <td>Teknik Informatika</td>
                <td>
                    <button class="btn btn-warning btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Hapus</button>
                </td>
            </tr>

        </tbody>

    </table>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>