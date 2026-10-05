<div class="container mt-4">

    <h1 class="mb-4">Daftar Mahasiswa</h1>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Angkatan</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php $no = 1; ?>

                        <?php foreach ($mahasiswa as $mhs): ?>

                            <tr>
                                <td><?= $no++; ?></td>

                                <td>
                                    <?= htmlspecialchars($mhs->getNim()); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($mhs->getNama()); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($mhs->getProdi()); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($mhs->getAngkatan()); ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>