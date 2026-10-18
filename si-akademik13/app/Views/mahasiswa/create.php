
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: white;
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
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: white;
            color: #222;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 24px;
        }

        button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .back {
            display: inline-block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Tambah Mahasiswa</h1>

    <form method="POST"
          action="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>/mahasiswa/store">

        <!-- NIM -->
        <div class="form-group">
            <label for="nim">NIM</label>
            <input
                type="text"
                id="nim"
                name="nim"
                placeholder="NIM harus angka"
                pattern="[0-9]+"
                title="NIM harus berupa angka"
                required
            >
        </div>

        <!-- Nama Mahasiswa -->
        <div class="form-group">
            <label for="nama">Nama Mahasiswa</label>
            <input
                type="text"
                id="nama"
                name="nama"
                required
            >
        </div>

        <!-- Program Studi -->
        <div class="form-group">
            <label for="prodi">Prodi</label>

            <select name="prodi" id="prodi" required>
                <option value="">-- Pilih Prodi --</option>

                <?php foreach (($prodiList ?? []) as $prodi): ?>
                    <?php
                    if (is_array($prodi)) {
                        $namaProdi = $prodi['nama']
                            ?? $prodi['nama_prodi']
                            ?? '';
                    } else {
                        $namaProdi = $prodi;
                    }
                    ?>

                    <?php if (is_string($namaProdi) && trim($namaProdi) !== ''): ?>
                        <option value="<?= htmlspecialchars($namaProdi, ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($namaProdi, ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Angkatan -->
        <div class="form-group">
            <label for="angkatan">Angkatan</label>
            <input
                type="number"
                id="angkatan"
                name="angkatan"
                placeholder="Contoh: 2026"
                min="2000"
                max="2100"
                required
            >
        </div>

        <!-- Status Mahasiswa -->
        <div class="form-group">
            <label for="status">Status</label>

            <select name="status" id="status" required>
                <option value="">-- Pilih Status --</option>
                <option value="Aktif">Aktif</option>
                <option value="Lulus">Lulus</option>
                <option value="Cuti">Cuti</option>
            </select>
        </div>

        <!-- Tombol -->
        <div class="form-actions">
            <button type="submit">Tambah Mahasiswa</button>

            <a
                href="<?= htmlspecialchars(BASE_URL, ENT_QUOTES, 'UTF-8') ?>/mahasiswa"
                class="back"
            >
                Kembali
            </a>
        </div>

    </form>
</div>

</body>
</html>
