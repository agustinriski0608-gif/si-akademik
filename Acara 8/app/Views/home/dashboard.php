<h2 class="mb-4">Dashboard</h2>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-bg-primary h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Mahasiswa</h6>
                <p class="display-5 mb-2"><?= (int) $totalMahasiswa ?></p>
                <a href="<?= e(url('/mahasiswa')) ?>" class="link-light">Lihat data &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-success h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Program Studi</h6>
                <p class="display-5 mb-2"><?= (int) $totalProdi ?></p>
                <a href="<?= e(url('/prodi')) ?>" class="link-light">Lihat data &rarr;</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-warning h-100">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Mata Kuliah</h6>
                <p class="display-5 mb-2"><?= (int) $totalMatakuliah ?></p>
                <a href="<?= e(url('/matakuliah')) ?>" class="link-dark">Lihat data &rarr;</a>
            </div>
        </div>
    </div>
</div>
