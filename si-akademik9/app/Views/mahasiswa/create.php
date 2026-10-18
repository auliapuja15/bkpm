
<h2>Tambah Mahasiswa</h2>

<form
    method="POST"
    action="<?= BASE_URL ?>/mahasiswa"
>
    <div class="mb-3">
        <label for="nim" class="form-label">NIM</label>
        <input
            type="text"
            id="nim"
            name="nim"
            class="form-control"
            required
        >
    </div>

    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input
            type="text"
            id="nama"
            name="nama"
            class="form-control"
            required
        >
    </div>

    <div class="mb-3">
        <label for="prodi_id" class="form-label">
            Program Studi
        </label>

        <select
            name="prodi_id"
            id="prodi_id"
            class="form-select"
            required
        >
            <option value="">-- Pilih Program Studi --</option>
            <option value="1">Teknik Informatika</option>
            <option value="2">Sistem Informasi</option>
            <option value="3">Teknik Komputer</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>

        <select
            name="status"
            id="status"
            class="form-select"
            required
        >
            <option value="aktif">Aktif</option>
            <option value="cuti">Cuti</option>
            <option value="lulus">Lulus</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="dosen_id" class="form-label">
            Dosen ID (Opsional)
        </label>

        <input
            type="number"
            id="dosen_id"
            name="dosen_id"
            class="form-control"
            min="1"
            placeholder="Kosongkan jika belum ada dosen"
        >
    </div>

    <button type="submit" class="btn btn-primary">
        Simpan
    </button>

    <a
        href="<?= BASE_URL ?>/mahasiswa"
        class="btn btn-secondary"
    >
        Kembali
    </a>
</form>

