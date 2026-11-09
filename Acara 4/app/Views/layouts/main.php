<?php require __DIR__ . '/../partials/header.php'; ?>

<body>
    <?php require __DIR__ . '/../partials/navbar.php'; ?>

    <main class="container py-4">
        <?php
        if (isset($contentView)) {
            require $contentView;
        }
        ?>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
