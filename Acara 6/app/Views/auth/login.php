<?php require __DIR__ . '/../partials/header.php'; ?>

<body class="bg-light">
    <div class="container" style="max-width: 420px;">
        <div class="card shadow-sm mt-5">
            <div class="card-body p-4">
                <h3 class="text-center mb-1">Login Admin</h3>
                <p class="text-center text-muted mb-4"><?= e(config('app.name', 'Si Akademik')) ?></p>

                <?php if ($flash = pull_flash()): ?>
                    <div class="alert alert-<?= e($flash['type']) ?>" role="alert">
                        <?= e($flash['message']) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= e(url('/login')) ?>" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
