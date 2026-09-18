<?php

$heroTitle = SiteData::setting('home_hero_title', 'Macramê Nós de Lu');
$heroSubtitle = SiteData::setting(
    'home_hero_subtitle',
    'Cada nó, uma história — peças artesanais feitas à mão para trazer aconchego e personalidade ao seu lar.'
);
$heroCta = SiteData::setting('home_hero_cta', 'Conhecer a loja');
$brandBar = SiteData::setting('home_brand_bar', 'Inspiração em cada fio');
$welcome = SiteData::setting(
    'home_welcome',
    'Bem-vindo ao nosso espaço dedicado à arte do macramê. Aqui você encontra peças pensadas para decorar, presentear e emocionar — sempre com o toque humano do trabalho manual.'
);

?>
<section class="hero">
    <div class="container hero__grid">
        <div class="hero__content">
            <h1 class="hero__title"><?= htmlspecialchars($heroTitle, ENT_QUOTES, 'UTF-8') ?></h1>
            <?php require VIEW_PATH . '/partials/heart-divider.php'; ?>
            <p class="hero__subtitle"><?= htmlspecialchars($heroSubtitle, ENT_QUOTES, 'UTF-8') ?></p>
            <a class="button-primary" href="index.php?url=catalogo">
                <?= htmlspecialchars($heroCta, ENT_QUOTES, 'UTF-8') ?>
            </a>
        </div>
        <div class="hero__media">
            <img src="images/nodelu_logo.png" alt="Logo Macramê Nós de Lu">
        </div>
    </div>
</section>

<section class="section section--benefits">
    <div class="container">
        <div class="benefits-grid">
            <article class="benefit">
                <?php $icon = 'hammer'; require VIEW_PATH . '/partials/benefit-icon.php'; ?>
                <h2 class="benefit__title">Artesanal</h2>
                <p class="benefit__text">Feito à mão, com Amor!</p>
            </article>
            <article class="benefit">
                <?php $icon = 'star'; require VIEW_PATH . '/partials/benefit-icon.php'; ?>
                <h2 class="benefit__title">Exclusivo</h2>
                <p class="benefit__text">Peças únicas, como você!</p>
            </article>
            <article class="benefit benefit--green">
                <?php $icon = 'leaf'; require VIEW_PATH . '/partials/benefit-icon.php'; ?>
                <h2 class="benefit__title">Sustentável</h2>
                <p class="benefit__text">Materiais naturais e processo de baixo impacto ambiental.</p>
            </article>
            <article class="benefit">
                <?php $icon = 'truck'; require VIEW_PATH . '/partials/benefit-icon.php'; ?>
                <h2 class="benefit__title">Envio Seguro</h2>
                <p class="benefit__text">Enviamos com carinho para todo o Brasil.</p>
            </article>
        </div>
    </div>
</section>

<div class="section-brand-bar">
    <div class="container">
        <?= htmlspecialchars($brandBar, ENT_QUOTES, 'UTF-8') ?>
    </div>
</div>

<section class="section">
    <div class="container">
        <p class="home-welcome text-brand">
            <?= htmlspecialchars($welcome, ENT_QUOTES, 'UTF-8') ?>
        </p>
    </div>
</section>
