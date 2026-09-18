<?php

$social = SiteData::links();
$whatsappUrl = $social['whatsapp']['url'] ?? '#';

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

        <nav class="chip-list" aria-label="Filtrar por categoria">
            <a
                class="chip<?= $activeSlug === '' ? ' is-active' : '' ?>"
                href="index.php?url=catalogo">Todas</a>

            <?php foreach ($categories as $category) : ?>
                <a
                    class="chip<?= $activeSlug === $category['slug'] ? ' is-active' : '' ?>"
                    href="index.php?url=catalogo&amp;cat=<?= urlencode($category['slug']) ?>">
                    <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <?php if (empty($products)) : ?>
            <p class="empty-state">
                Nenhuma peça publicada nesta categoria por enquanto. Em breve, novidades!
            </p>
        <?php else : ?>
            <div class="products-grid">
                <?php foreach ($products as $product) : ?>
                    <article class="product-card">
                        <a
                            class="product-card__link"
                            href="index.php?url=produto&amp;slug=<?= urlencode($product['slug']) ?>">
                            <div class="product-card__media">
                                <?php if (!empty($product['cover_image'])) : ?>
                                    <img
                                        src="<?= htmlspecialchars($product['cover_image'], ENT_QUOTES, 'UTF-8') ?>"
                                        alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>">
                                <?php endif; ?>
                            </div>

                            <div class="product-card__body">
                                <h2 class="product-card__name">
                                    <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                                </h2>
                                <p class="product-card__price">
                                    R$ <?= number_format((float) $product['price'], 2, ',', '.') ?>
                                </p>
                                <?php if (!empty($product['short_description'])) : ?>
                                    <p class="product-card__note">
                                        <?= htmlspecialchars($product['short_description'], ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="cta-row">
            <a class="button-secondary" href="<?= htmlspecialchars($whatsappUrl, ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer">
                Encomendar pelo WhatsApp
            </a>
        </div>
    </div>
</section>
