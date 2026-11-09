<?php
/** Variabel: $action, $prodiList, $submitLabel, $mk (opsional, untuk edit) */
$mk = $mk ?? null;
$prodiNow = (int) old('prodi_id', $mk->prodi_id ?? 0);
?>
<form action="<?= e(url($action)) ?>" method="POST">
    <div class="mb-3">
        <label class="form-label">Kode Mata Kuliah</label>
        <input type="text" class="form-control" name="kode" maxlength="10"
               value="<?= e(old('kode', $mk->kode ?? '')) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Mata Kuliah</label>
        <input type="text" class="form-control" name="nama" maxlength="150"
               value="<?= e(old('nama', $mk->nama ?? '')) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">SKS</label>
        <input type="number" class="form-control" name="sks" min="1" max="6"
               value="<?= e(old('sks', $mk->sks ?? '')) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Program Studi</label>
        <select class="form-select" name="prodi_id" required>
            <option value="">-- Pilih program studi --</option>
            <?php foreach ($prodiList as $p): ?>
                <option value="<?= (int) $p->id ?>" <?= $prodiNow === (int) $p->id ? 'selected' : '' ?>>
                    <?= e($p->nama) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <a href="<?= e(url('/matakuliah')) ?>" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-success"><?= e($submitLabel) ?></button>
</form>
