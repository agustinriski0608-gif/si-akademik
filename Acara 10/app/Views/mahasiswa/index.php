<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Data Mahasiswa</h2>
    <a href="<?= e(url('/mahasiswa/create')) ?>" class="btn btn-primary">+ Tambah Mahasiswa</a>
</div>

<form action="<?= e(url('/mahasiswa')) ?>" method="GET" class="d-flex gap-2 mb-4">
    <input type="text" name="keyword" class="form-control"
           placeholder="Cari berdasarkan nama atau NIM..." value="<?= e($keyword) ?>">
    <button type="submit" class="btn btn-success">Cari</button>
    <a href="<?= e(url('/mahasiswa')) ?>" class="btn btn-secondary">Reset</a>
</form>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Program Studi</th>
                <th>Angkatan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($mahasiswa)): ?>
                <tr>
                    <td colspan="8" class="text-center">
                        <?= $keyword !== '' ? 'Tidak ada data yang cocok dengan pencarian.' : 'Belum ada data mahasiswa.' ?>
                    </td>
                </tr>
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
                        <td class="text-nowrap">
                            <a href="<?= e(url('/mahasiswa/' . (int) $mhs->id . '/edit')) ?>"
                               class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?= e(url('/mahasiswa/' . (int) $mhs->id . '/delete')) ?>" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus mahasiswa ini?');">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
