<?php
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
$title = 'Tambah Mata Kuliah';

require __DIR__ . '/../layouts/main.php';
?>

<h2 class="mb-3">Tambah Mata Kuliah</h2>

<?php if ($errors): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="<?= $base . '/matakuliah/store' ?>" class="card card-body">
    <div class="mb-3">
        <label class="form-label">Kode</label>
        <input type="text" class="form-control" name="kode"
               value="<?= htmlspecialchars($data['kode']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Mata Kuliah</label>
        <input type="text" class="form-control" name="nama"
               value="<?= htmlspecialchars($data['nama']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">SKS</label>
        <input type="number" class="form-control" name="sks"
               min="1" max="6" value="<?= htmlspecialchars($data['sks']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Prodi</label>
        <select class="form-select" name="prodi_id" required>
            <option value="">-- Pilih Prodi --</option>
            <?php foreach ($prodi as $p): ?>
                <option value="<?= $p['id'] ?>"
                    <?= (string) $data['prodi_id'] === (string) $p['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['kode'] . ' - ' . $p['nama']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a class="btn btn-secondary" href="<?= $base . '/matakuliah' ?>">Batal</a>
    </div>
</form>

</div>
</body>
</html>
