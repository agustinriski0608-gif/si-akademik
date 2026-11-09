<h2 class="mb-4">Data Mahasiswa</h2>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Program Studi</th>
                <th>Angkatan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($mahasiswa)): ?>
                <tr><td colspan="7" class="text-center">Belum ada data mahasiswa.</td></tr>
            <?php else: ?>
                <?php foreach ($mahasiswa as $i => $mhs): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= e($mhs->nim) ?></td>
                        <td><?= e($mhs->nama) ?></td>
                        <td><?= e($mhs->email) ?></td>
                        <td><?= e($mhs->nama_prodi) ?></td>
                        <td><?= e($mhs->angkatan) ?></td>
                        <td><?= e($mhs->status) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
