<footer class="bg-light text-center py-3 mt-5">
    <p class="mb-0">&copy; <?= date('Y') ?> <?= e(config('app.name', 'Si Akademik')) ?> &middot; <?= e(config('app.acara', '')) ?></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(url('assets/js/app.js')) ?>"></script>
<?php unset($_SESSION['old']); ?>
