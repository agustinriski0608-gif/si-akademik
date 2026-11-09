<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="<?= e(url('/')) ?>"><?= e(config('app.name', 'Si Akademik')) ?></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#menuUtama" aria-controls="menuUtama" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuUtama">
            <ul class="navbar-nav me-auto">
                <?php foreach (config('app.nav', []) as [$label, $path]): ?>
                    <?php $active = current_path() === $path || ($path !== '/dashboard' && str_starts_with(current_path(), $path . '/')); ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $active ? 'active fw-semibold' : '' ?>"
                           href="<?= e(url($path)) ?>"><?= e($label) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <?php if (!empty($_SESSION['logged_in'])): ?>
                <span class="navbar-text me-3">Halo, <?= e($_SESSION['user_name'] ?? 'Admin') ?></span>
                <a class="btn btn-outline-light btn-sm" href="<?= e(url('/logout')) ?>">Logout</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
