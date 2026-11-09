<?php
/** Variabel: $action, $submitLabel, $prodi (opsional, untuk edit) */
$prodi = $prodi ?? null;
?>
<form action="<?= e(url($action)) ?>" method="POST">
    <div class="mb-3">
        <label class="form-label">Kode Prodi</label>
        <input type="text" class="form-control" name="kode" maxlength="10"
               value="<?= e(old('kode', $prodi->kode ?? '')) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Program Studi</label>
        <input type="text" class="form-control" name="nama" maxlength="100"
               value="<?= e(old('nama', $prodi->nama ?? '')) ?>" required>
    </div>

    <a href="<?= e(url('/prodi')) ?>" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-success"><?= e($submitLabel) ?></button>
</form>
