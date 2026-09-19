<?php

$tickerMessage = trim($settings['header_ticker_message'] ?? '');

?>
<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>
</header>

<section class="admin-card">
    <header class="admin-card__header">
        <h2>Letreiro do topo</h2>
    </header>

    <form method="post" action="<?= url('admin/homeSalvar') ?>" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

        <div class="admin-field">
            <label for="header-ticker">Mensagem</label>
            <textarea
                id="header-ticker"
                name="header_ticker_message"
                rows="3"
                placeholder="Ex.: Sábados, de 8 às 14h na Feira de Laranjeiras…"><?= e($tickerMessage) ?></textarea>
            <p class="admin-field__hint">
                Aparece na faixa marrom acima do menu, em rolagem contínua.
                Deixe em branco para manter apenas a faixa decorativa.
            </p>
        </div>

        <div class="admin-ticker-preview" aria-hidden="true">
            <div class="admin-ticker-preview__track">
                <?php if ($tickerMessage !== '') : ?>
                    <span><?= e($tickerMessage) ?></span>
                    <span><?= e($tickerMessage) ?></span>
                <?php endif; ?>
            </div>
        </div>

        <button type="submit" class="admin-button admin-button--primary">Salvar letreiro</button>
    </form>
</section>

<section class="admin-card">
    <form method="post" action="<?= url('admin/homeSalvar') ?>" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

        <header class="admin-card__header admin-card__header--inset">
            <h2>Textos do hero</h2>
        </header>

        <div class="admin-field">
            <label for="home-title">Título do hero</label>
            <input
                type="text"
                id="home-title"
                name="home_hero_title"
                value="<?= e($settings['home_hero_title'] ?? 'Macramê Nós de Lu') ?>">
        </div>

        <div class="admin-field">
            <label for="home-subtitle">Subtítulo do hero</label>
            <textarea id="home-subtitle" name="home_hero_subtitle" rows="2"><?= e($settings['home_hero_subtitle'] ?? 'Cada nó, uma história — peças artesanais feitas à mão para trazer aconchego e personalidade ao seu lar.') ?></textarea>
        </div>

        <div class="admin-field">
            <label for="home-cta">Texto do botão</label>
            <input
                type="text"
                id="home-cta"
                name="home_hero_cta"
                value="<?= e($settings['home_hero_cta'] ?? 'Conhecer a loja') ?>">
        </div>

        <div class="admin-field">
            <label for="home-bar">Faixa de destaque</label>
            <input
                type="text"
                id="home-bar"
                name="home_brand_bar"
                value="<?= e($settings['home_brand_bar'] ?? 'Inspiração em cada fio') ?>">
        </div>

        <div class="admin-field">
            <label for="home-welcome">Texto de boas-vindas</label>
            <textarea id="home-welcome" name="home_welcome" rows="3"><?= e($settings['home_welcome'] ?? 'Bem-vindo ao nosso espaço dedicado à arte do macramê. Aqui você encontra peças pensadas para decorar, presentear e emocionar — sempre com o toque humano do trabalho manual.') ?></textarea>
        </div>

        <button type="submit" class="admin-button admin-button--primary">Salvar conteúdo</button>
    </form>
</section>

<section class="admin-card">
    <header class="admin-card__header">
        <div>
            <h2>Carrossel do hero</h2>
            <p class="admin-muted admin-card__lead">
                Monte a sequência de imagens e vídeos. Imagens ficam 3 segundos;
                vídeos rodam até o fim antes de avançar.
            </p>
        </div>
        <span class="admin-muted"><?= count($heroCarousel) ?> item<?= count($heroCarousel) === 1 ? '' : 's' ?></span>
    </header>

    <?php if (empty($heroCarousel)) : ?>
        <div class="admin-empty admin-empty--compact">
            <span class="admin-empty__icon"><?= admin_icon('image') ?></span>
            <p>Nenhuma mídia no carrossel — a logo padrão aparece na home.</p>
        </div>
    <?php else : ?>
        <ol class="admin-sequence">
            <?php foreach ($heroCarousel as $index => $item) : ?>
                <li class="admin-sequence__item">
                    <span class="admin-sequence__order"><?= $index + 1 ?></span>

                    <div class="admin-sequence__thumb">
                        <?php if ($item['media_type'] === 'video') : ?>
                            <video src="<?= url($item['file_path']) ?>" muted playsinline preload="metadata"></video>
                        <?php else : ?>
                            <img src="<?= url($item['file_path']) ?>" alt="">
                        <?php endif; ?>
                    </div>

                    <div class="admin-sequence__info">
                        <strong><?= $item['media_type'] === 'video' ? 'Vídeo' : 'Imagem' ?></strong>
                        <span class="admin-muted admin-sequence__path"><?= e($item['file_path']) ?></span>
                    </div>

                    <div class="admin-sequence__actions">
                        <form method="post" action="<?= url('admin/homeHeroMover') ?>">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                            <input type="hidden" name="direction" value="up">
                            <button type="submit" class="admin-icon-button" title="Subir"<?= $index === 0 ? ' disabled' : '' ?>>
                                <?= admin_icon('arrow-up', 'icon') ?>
                            </button>
                        </form>

                        <form method="post" action="<?= url('admin/homeHeroMover') ?>">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                            <input type="hidden" name="direction" value="down">
                            <button
                                type="submit"
                                class="admin-icon-button"
                                title="Descer"<?= $index === count($heroCarousel) - 1 ? ' disabled' : '' ?>>
                                <?= admin_icon('arrow-down', 'icon') ?>
                            </button>
                        </form>

                        <form
                            method="post"
                            action="<?= url('admin/homeHeroExcluir') ?>"
                            data-confirm="Remover este item do carrossel?">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                            <button type="submit" class="admin-icon-button is-danger" title="Excluir">
                                <?= admin_icon('trash', 'icon') ?>
                            </button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>

    <div class="admin-sequence__add">
        <form method="post" action="<?= url('admin/homeHeroUpload') ?>" enctype="multipart/form-data" class="admin-form admin-form--inline">
            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
            <input type="hidden" name="media_type" value="image">
            <input type="file" id="hero-image-upload" name="image" accept="image/*" hidden>
            <button type="button" class="admin-button admin-button--ghost" data-trigger-file="hero-image-upload">
                <?= admin_icon('image', 'icon') ?>
                Adicionar imagem
            </button>
        </form>

        <form method="post" action="<?= url('admin/homeHeroUpload') ?>" enctype="multipart/form-data" class="admin-form admin-form--inline">
            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
            <input type="hidden" name="media_type" value="video">
            <input type="file" id="hero-video-upload" name="video" accept="video/mp4,video/webm" hidden>
            <button type="button" class="admin-button admin-button--ghost" data-trigger-file="hero-video-upload">
                <?= admin_icon('video', 'icon') ?>
                Adicionar vídeo
            </button>
        </form>
    </div>
</section>
