<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Data Program Studi</h2>
    <a href="<?= e(url('/prodi/create')) ?>" class="btn btn-primary">+ Tambah Prodi</a>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Kode Prodi</th>
                <th>Nama Program Studi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($prodi)): ?>
                <tr><td colspan="4" class="text-center">Belum ada data program studi.</td></tr>
            <?php else: ?>
                <?php foreach ($prodi as $i => $item): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= e($item->kode) ?></td>
                        <td><?= e($item->nama) ?></td>
                        <td class="text-nowrap">
                            <a href="<?= e(url('/prodi/' . (int) $item->id . '/edit')) ?>"
                               class="btn btn-warning btn-sm">Edit</a>
                            <form action="<?= e(url('/prodi/' . (int) $item->id . '/delete')) ?>" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus program studi ini?');">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
