<h2 class="mb-4">Edit Mata Kuliah</h2>

<div class="card">
    <div class="card-body">
        <?php
        $action = '/matakuliah/' . (int) $mk->id;
        $submitLabel = 'Simpan Perubahan';
        require __DIR__ . '/_form.php';
        ?>
    </div>
</div>
