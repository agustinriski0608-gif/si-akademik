<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Data Mata Kuliah</h2>
    <a href="<?= e(url('/matakuliah/create')) ?>" class="btn btn-primary">+ Tambah Mata Kuliah</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Kode</th>
                <th>Nama Mata Kuliah</th>
                <th>SKS</th>
                <th>Program Studi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($matakuliah)): ?>
                <tr><td colspan="6" class="text-center">Belum ada data mata kuliah.</td></tr>
            <?php else: ?>
                <?php foreach ($matakuliah as $i => $item): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= e($item->kode) ?></td>
                        <td><?= e($item->nama) ?></td>
                        <td><?= (int) $item->sks ?></td>
                        <td><?= e($item->nama_prodi) ?></td>
                        <td class="text-nowrap">
                            <a href="<?= e(url('/matakuliah/' . (int) $item->id . '/edit')) ?>"
                               class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?= e(url('/matakuliah/' . (int) $item->id . '/delete')) ?>" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus mata kuliah ini?');">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
