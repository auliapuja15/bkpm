<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Mahasiswa</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Tambah Mahasiswa</h2>

    <hr>

    <form
        action="/si-akademik8/public/mahasiswa/store"
        method="POST">

        <!-- NIM -->
        <div class="mb-3">
            <label class="form-label">
                NIM
            </label>

            <input
                type="text"
                class="form-control"
                name="nim"
                required>
        </div>

        <!-- Nama -->
        <div class="mb-3">
            <label class="form-label">
                Nama
            </label>

            <input
                type="text"
                class="form-control"
                name="nama"
                required>
        </div>

        <!-- Program Studi -->
        <div class="mb-3">
            <label class="form-label">
                Program Studi
            </label>

            <select
                name="id_prodi"
                class="form-select"
                required>

                <option value="">
                    -- Pilih Program Studi --
                </option>

                <?php foreach ($prodi as $p): ?>

                    <option value="<?= $p['id_prodi'] ?>">
                        <?= htmlspecialchars($p['nama_prodi']) ?>
                    </option>

                <?php endforeach; ?>

            </select>
        </div>

        <!-- Angkatan -->
        <div class="mb-3">
            <label class="form-label">
                Angkatan
            </label>

            <input
                type="number"
                class="form-control"
                name="angkatan"
                min="2000"
                max="2100"
                required>
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label class="form-label">
                Status
            </label>

            <select
                name="status"
                class="form-select"
                required>

                <option value="aktif">
                    Aktif
                </option>

                <option value="cuti">
                    Cuti
                </option>

                <option value="lulus">
                    Lulus
                </option>

            </select>
        </div>

        <!-- Tombol -->
        <button
            type="submit"
            class="btn btn-primary">
            Simpan
        </button>

        <a
            href="/si-akademik8/public/mahasiswa"
            class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>