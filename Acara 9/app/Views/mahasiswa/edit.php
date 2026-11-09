<h2 class="mb-4">Edit Data Mahasiswa</h2>

<div class="card">
    <div class="card-body">
        <?php
        $action = '/mahasiswa/' . (int) $mhs->id;
        $submitLabel = 'Simpan Perubahan';
        require __DIR__ . '/_form.php';
        ?>
    </div>
</div>
