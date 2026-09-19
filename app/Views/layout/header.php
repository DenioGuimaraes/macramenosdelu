<?php

$navItems = require CONFIG_PATH . '/nav.php';

$rawUrl = isset($_GET['url']) ? trim((string) $_GET['url'], '/') : '';
$currentSlug = $rawUrl === '' ? 'home' : explode('/', $rawUrl)[0];

$pageTitle = $title ?? 'Macramê Nós de Lu';
$tickerMessage = trim(SiteData::setting('header_ticker_message', ''));
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Inter:wght@400;500;600;700&family=Leckerli+One&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= url('favicon/favicon-96x96.png') ?>" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="<?= url('favicon/favicon.svg') ?>">
    <link rel="shortcut icon" href="<?= url('favicon/favicon.ico') ?>">
    <link rel="apple-touch-icon" href="<?= url('favicon/apple-touch-icon.png') ?>">
    <link rel="manifest" href="<?= url('favicon/site.webmanifest') ?>">
    <link rel="stylesheet" href="<?= url('css/style.css') ?>">
    <script src="<?= url('js/menu.js') ?>" defer></script>
</head>

<body>
    <header class="site-header">
        <div class="header-ticker<?= $tickerMessage === '' ? ' header-ticker--empty' : '' ?>" aria-hidden="true">
            <?php if ($tickerMessage !== '') : ?>
                <div class="header-ticker__track">
                    <?php for ($i = 0; $i < 4; $i++) : ?>
                        <span class="header-ticker__item"><?= htmlspecialchars($tickerMessage, ENT_QUOTES, 'UTF-8') ?></span>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="header-bar">
            <div class="container header-bar__inner">
                <div class="site-brand">
                    <a class="site-brand__link" href="<?= url() ?>" aria-label="Nós de Lu — Arte em Macramê, ir para a página inicial">
                        <img
                            class="site-brand__logo"
                            src="<?= url('images/nodelu_logo.png') ?>"
                            alt=""
                            width="100"
                            height="100"
                            decoding="async">
                        <span class="site-brand__text">
                            <span class="site-brand__title">Nós de Lu</span>
                            <span class="site-brand__tagline">Arte em Macramê</span>
                        </span>
                    </a>
                </div>

                <nav class="main-menu" aria-label="Menu principal">
                    <ul>
                        <?php foreach ($navItems as $item) :
                            $isActive = $currentSlug === $item['slug'];
                            ?>
                            <li>
                                <a href="<?= url($item['route']) ?>"<?= $isActive ? ' class="is-active"' : '' ?>><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <button class="menu-toggle"
                    type="button"
                    aria-label="Abrir menu"
                    aria-expanded="false"
                    aria-controls="mobile-menu">
                    ☰
                </button>
            </div>
        </div>

        <button type="button" class="menu-overlay" aria-label="Fechar menu" hidden></button>

        <nav id="mobile-menu" class="main-menu main-menu--drawer" aria-label="Menu mobile" hidden>
            <button type="button" class="menu-close" aria-label="Fechar menu">×</button>
            <ul>
                <?php foreach ($navItems as $item) :
                    $isActive = $currentSlug === $item['slug'];
                    ?>
                    <li>
                        <a href="<?= url($item['route']) ?>"<?= $isActive ? ' class="is-active"' : '' ?>><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
    </header>
