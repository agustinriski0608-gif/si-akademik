<h2 class="mb-4">Data Mahasiswa</h2>

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Program Studi</th>
                <th>Angkatan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mahasiswa as $i => $mhs): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= e($mhs->getNim()) ?></td>
                    <td><?= e($mhs->getNama()) ?></td>
                    <td><?= e($mhs->getProdi()) ?></td>
                    <td><?= e($mhs->getAngkatan()) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
