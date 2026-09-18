<?php

$social = SiteData::links();
$whatsappUrl = $social['whatsapp']['url'] ?? '#';

$images = array_values(array_filter($media, static fn ($item) => $item['media_type'] === 'image'));
$videos = array_values(array_filter($media, static fn ($item) => $item['media_type'] === 'video'));

$specs = [
    'Material'          => $product['material'],
    'Dimensões'         => $product['dimensions'],
    'Cores'             => $product['colors'],
    'Prazo de produção' => $product['production_time'],
];

$specs = array_filter($specs, static fn ($value) => $value !== null && $value !== '');

$whatsappMessage = $whatsappUrl . (str_contains($whatsappUrl, '?') ? '&' : '?')
    . 'text=' . rawurlencode('Olá! Tenho interesse na peça "' . $product['name'] . '".');

?>
<section class="section">
    <div class="container">

        <nav class="breadcrumb" aria-label="Você está aqui">
            <a href="<?= url() ?>">Home</a>
            <span>/</span>
            <a href="<?= url('catalogo') ?>">Loja</a>
            <?php if (!empty($product['category_name'])) : ?>
                <span>/</span>
                <a href="<?= url('catalogo') ?>?cat=<?= urlencode($product['category_slug']) ?>">
                    <?= htmlspecialchars($product['category_name'], ENT_QUOTES, 'UTF-8') ?>
                </a>
            <?php endif; ?>
        </nav>

        <div class="product-detail">

            <div class="product-detail__media">
                <?php if (!empty($images)) : ?>
                    <div class="product-detail__main">
                        <img
                            id="product-main-image"
                            src="<?= url($images[0]['file_path']) ?>"
                            alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <?php if (count($images) > 1) : ?>
                        <div class="product-detail__thumbs">
                            <?php foreach ($images as $index => $image) : ?>
                                <button
                                    type="button"
                                    class="product-detail__thumb<?= $index === 0 ? ' is-active' : '' ?>"
                                    data-image="<?= url($image['file_path']) ?>">
                                    <img
                                        src="<?= url($image['file_path']) ?>"
                                        alt="">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="product-detail__main product-detail__main--empty"></div>
                <?php endif; ?>

                <?php foreach ($videos as $video) : ?>
                    <video class="product-detail__video" controls preload="metadata">
                        <source src="<?= url($video['file_path']) ?>">
                    </video>
                <?php endforeach; ?>
            </div>

            <div class="product-detail__info">
                <h1 class="product-detail__name">
                    <?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>
                </h1>

                <p class="product-detail__price">
                    R$ <?= number_format((float) $product['price'], 2, ',', '.') ?>
                </p>

                <?php require VIEW_PATH . '/partials/heart-divider.php'; ?>

                <?php if (!empty($product['description'])) : ?>
                    <p class="product-detail__description">
                        <?= nl2br(htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8')) ?>
                    </p>
                <?php elseif (!empty($product['short_description'])) : ?>
                    <p class="product-detail__description">
                        <?= htmlspecialchars($product['short_description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($specs)) : ?>
                    <dl class="product-detail__specs">
                        <?php foreach ($specs as $label => $value) : ?>
                            <div>
                                <dt><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?></dt>
                                <dd><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?></dd>
                            </div>
                        <?php endforeach; ?>
                    </dl>
                <?php endif; ?>

                <?php if (!empty($product['artisan_note'])) : ?>
                    <p class="product-detail__note">
                        <?= htmlspecialchars($product['artisan_note'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php endif; ?>

                <?php if (!empty($product['care_instructions'])) : ?>
                    <p class="product-detail__care">
                        <strong>Cuidados:</strong>
                        <?= htmlspecialchars($product['care_instructions'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php endif; ?>

                <div class="product-detail__actions">
                    <a
                        class="button-primary"
                        href="<?= htmlspecialchars($whatsappMessage, ENT_QUOTES, 'UTF-8') ?>"
                        target="_blank"
                        rel="noopener noreferrer">
                        Encomendar pelo WhatsApp
                    </a>

                    <?php if (!empty($product['shopee_url'])) : ?>
                        <a
                            class="button-secondary"
                            href="<?= htmlspecialchars($product['shopee_url'], ENT_QUOTES, 'UTF-8') ?>"
                            target="_blank"
                            rel="noopener noreferrer">
                            Comprar na Shopee
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
