<div class="text-center py-5">
    <h1 class="display-4"><?= (int) $code ?></h1>
    <h4 class="mb-3"><?= e($title) ?></h4>
    <p class="text-muted"><?= e($message) ?></p>
    <a href="<?= e(url('/')) ?>" class="btn btn-primary">Kembali ke Beranda</a>
</div>
