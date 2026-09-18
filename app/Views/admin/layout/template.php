<?php

require_once VIEW_PATH . '/admin/partials/icons.php';

$adminUser = Auth::user();
$flash = Auth::flash();
$csrfToken = Auth::csrfToken();

$activeMenu = $activeMenu ?? '';
$pageTitle = $pageTitle ?? 'Painel';
$pageSubtitle = $pageSubtitle ?? '';

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($title ?? 'Painel — Macramê Nós de Lu') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600;700&family=Leckerli+One&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="favicon/favicon.svg">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/admin.js" defer></script>
</head>

<body class="admin">
    <div class="admin-shell">

        <?php require VIEW_PATH . '/admin/layout/sidebar.php'; ?>

        <div class="admin-main">

            <?php require VIEW_PATH . '/admin/layout/topbar.php'; ?>

            <main class="admin-content">

                <?php if ($flash !== null) : ?>
                    <div class="admin-flash admin-flash--<?= e($flash['type']) ?>" role="status">
                        <?= e($flash['message']) ?>
                    </div>
                <?php endif; ?>

                <?php require $viewFile; ?>

            </main>
        </div>
    </div>

    <button type="button" class="admin-overlay" aria-label="Fechar menu" hidden></button>
</body>

</html>
