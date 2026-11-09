<h2 class="mb-4">Data Mahasiswa - Acara 4</h2>

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
                    <td><?= htmlspecialchars($mhs->getNim()) ?></td>
                    <td><?= htmlspecialchars($mhs->getNama()) ?></td>
                    <td><?= htmlspecialchars($mhs->getProdi()) ?></td>
                    <td><?= htmlspecialchars($mhs->getAngkatan()) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
