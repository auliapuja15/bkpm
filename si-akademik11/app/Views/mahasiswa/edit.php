
<?php
// Pastikan variabel tersedia
$mahasiswa = $mahasiswa ?? [];
$prodiList = $prodiList ?? [];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Mahasiswa</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        .container {
            width: 80%;
            max-width: 700px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back {
            display: inline-block;
            margin-left: 10px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Edit Mahasiswa</h1>

    <form method="POST"
          action="/bkpm/si-akademik10/public/mahasiswa/edit?id=<?= htmlspecialchars($mahasiswa['id'] ?? '') ?>">

        <!-- NIM -->
        <div class="form-group">
            <label for="nim">NIM</label>

            <input
                type="text"
                id="nim"
                name="nim"
                value="<?= htmlspecialchars($mahasiswa['nim'] ?? '') ?>"
                required
            >
        </div>

        <!-- Nama -->
        <div class="form-group">
            <label for="nama">Nama</label>

            <input
                type="text"
                id="nama"
                name="nama"
                value="<?= htmlspecialchars($mahasiswa['nama'] ?? '') ?>"
                required
            >
        </div>

        <!-- PRODI -->
        <div class="form-group">
            <label for="prodi_id">Prodi</label>

            <select
                id="prodi_id"
                name="prodi_id"
                required
            >

                <option value="">-- Pilih Prodi --</option>

                <?php if (!empty($prodiList)): ?>

                    <?php foreach ($prodiList as $prodi): ?>

                        <option
                            value="<?= htmlspecialchars($prodi['id'] ?? '') ?>"
                            <?= (
                                isset($mahasiswa['prodi_id']) &&
                                isset($prodi['id']) &&
                                $mahasiswa['prodi_id'] == $prodi['id']
                            ) ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($prodi['nama'] ?? '') ?>
                        </option>

                    <?php endforeach; ?>

                <?php else: ?>

                    <option value="">Data prodi tidak tersedia</option>

                <?php endif; ?>

            </select>
        </div>

        <!-- Angkatan -->
        <div class="form-group">
            <label for="angkatan">Angkatan</label>

            <input
                type="number"
                id="angkatan"
                name="angkatan"
                value="<?= htmlspecialchars($mahasiswa['angkatan'] ?? '') ?>"
                required
            >
        </div>

        <!-- Status -->
        <div class="form-group">
            <label for="status">Status</label>

            <select
                id="status"
                name="status"
                required
            >
                <option
                    value="aktif"
                    <?= (($mahasiswa['status'] ?? '') == 'aktif') ? 'selected' : '' ?>
                >
                    Aktif
                </option>

                <option
                    value="cuti"
                    <?= (($mahasiswa['status'] ?? '') == 'cuti') ? 'selected' : '' ?>
                >
                    Cuti
                </option>

                <option
                    value="lulus"
                    <?= (($mahasiswa['status'] ?? '') == 'lulus') ? 'selected' : '' ?>
                >
                    Lulus
                </option>
            </select>
        </div>

        <!-- Dosen ID -->
        <div class="form-group">
            <label for="dosen_id">Dosen ID</label>

            <input
                type="number"
                id="dosen_id"
                name="dosen_id"
                value="<?= htmlspecialchars($mahasiswa['dosen_id'] ?? '') ?>"
            >
        </div>

        <!-- Tombol -->
        <button type="submit">
            Simpan Perubahan
        </button>

        <a
            href="/bkpm/si-akademik10/public/mahasiswa"
            class="back"
        >
            Kembali
        </a>

    </form>

</div>

</body>

</html>
