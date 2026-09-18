<?php

$categories = require CONFIG_PATH . '/categories.php';
$activeCategory = 'Todas';

?>
<section class="section section--loja">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Nossa Loja</h1>
            <?php require VIEW_PATH . '/partials/heart-divider.php'; ?>
            <p class="page-lead loja-lead">
                Escolha uma categoria para explorar as peças feitas à mão.
            </p>
        </header>

        <div class="chip-list" role="group" aria-label="Filtrar por categoria">
            <?php foreach ($categories as $category) :
                $isActive = $category === $activeCategory;
                $chipClass = 'chip' . ($isActive ? ' is-active' : '');
                ?>
                <button
                    type="button"
                    class="<?= $chipClass ?>"
                    aria-pressed="<?= $isActive ? 'true' : 'false' ?>"
                    disabled>
                    <?= htmlspecialchars($category, ENT_QUOTES, 'UTF-8') ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="products-grid">
            <article class="product-card">
                <div class="product-card__media" role="img" aria-label="Imagem em breve"></div>
                <div class="product-card__body">
                    <h2 class="product-card__name">Peça em breve</h2>
                    <p class="product-card__price">Consulte</p>
                    <p class="product-card__note">Catálogo completo em atualização.</p>
                </div>
            </article>
            <article class="product-card">
                <div class="product-card__media" role="img" aria-label="Imagem em breve"></div>
                <div class="product-card__body">
                    <h2 class="product-card__name">Peça em breve</h2>
                    <p class="product-card__price">Consulte</p>
                    <p class="product-card__note">Catálogo completo em atualização.</p>
                </div>
            </article>
            <article class="product-card">
                <div class="product-card__media" role="img" aria-label="Imagem em breve"></div>
                <div class="product-card__body">
                    <h2 class="product-card__name">Peça em breve</h2>
                    <p class="product-card__price">Consulte</p>
                    <p class="product-card__note">Catálogo completo em atualização.</p>
                </div>
            </article>
        </div>

        <p class="empty-state">
            Em breve, os produtos serão carregados a partir do banco de dados local.
        </p>
    </div>
</section>
