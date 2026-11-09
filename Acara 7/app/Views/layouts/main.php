<?php require __DIR__ . '/../partials/header.php'; ?>

<body>
    <?php require __DIR__ . '/../partials/navbar.php'; ?>

    <main class="container py-4">
        <?php if ($flash = pull_flash()): ?>
            <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show" role="alert">
                <?= e($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php
        if (isset($contentView)) {
            require $contentView;
        }
        ?>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
