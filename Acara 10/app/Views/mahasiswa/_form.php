<?php
/** Variabel: $action, $prodiList, $submitLabel, $mhs (opsional, untuk edit) */
$mhs = $mhs ?? null;
$statusNow = old('status', $mhs->status ?? 'aktif');
$prodiNow = (int) old('prodi_id', $mhs->prodi_id ?? 0);
?>
<form action="<?= e(url($action)) ?>" method="POST">
    <div class="mb-3">
        <label class="form-label">NIM</label>
        <input type="text" class="form-control" name="nim" value="<?= e(old('nim', $mhs->nim ?? '')) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="nama" value="<?= e(old('nama', $mhs->nama ?? '')) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" value="<?= e(old('email', $mhs->email ?? '')) ?>" required>
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

    <div class="mb-3">
        <label class="form-label">Angkatan</label>
        <input type="number" class="form-control" name="angkatan" min="2000" max="2100"
               value="<?= e(old('angkatan', $mhs->angkatan ?? '')) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Status</label>
        <select class="form-select" name="status" required>
            <?php foreach (['aktif' => 'Aktif', 'cuti' => 'Cuti', 'lulus' => 'Lulus'] as $val => $label): ?>
                <option value="<?= $val ?>" <?= $statusNow === $val ? 'selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <a href="<?= e(url('/mahasiswa')) ?>" class="btn btn-secondary">Kembali</a>
    <button type="submit" class="btn btn-success"><?= e($submitLabel) ?></button>
</form>
