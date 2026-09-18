<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>
</header>

<section class="admin-card">
    <header class="admin-card__header">
        <h2>Enviar imagens</h2>
    </header>

    <form method="post" action="<?= url('admin/galeriaUpload') ?>" enctype="multipart/form-data" class="admin-form admin-form--inline">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

        <div class="admin-field">
            <label for="gallery-title">Título (opcional)</label>
            <input type="text" id="gallery-title" name="title" placeholder="Ex.: Bolsa Praiana">
        </div>

        <div class="admin-field">
            <label for="gallery-images">Imagens</label>
            <input type="file" id="gallery-images" name="images[]" accept="image/*" multiple required>
            <p class="admin-field__hint">JPG, PNG, WEBP ou GIF — até 10 MB por arquivo.</p>
        </div>

        <button type="submit" class="admin-button admin-button--primary">
            <?= admin_icon('image', 'icon') ?>
            Enviar
        </button>
    </form>
</section>

<section class="admin-card">
    <header class="admin-card__header">
        <h2>Imagens da galeria</h2>
        <span class="admin-muted"><?= count($items) ?> item<?= count($items) === 1 ? '' : 's' ?></span>
    </header>

    <?php if (empty($items)) : ?>
        <div class="admin-empty">
            <span class="admin-empty__icon"><?= admin_icon('image') ?></span>
            <p>Nenhuma imagem na galeria</p>
        </div>
    <?php else : ?>
        <div class="admin-gallery">
            <?php foreach ($items as $item) : ?>
                <figure class="admin-gallery__item">
                    <img src="<?= url($item['file_path']) ?>" alt="<?= e($item['title'] ?? '') ?>">
                    <figcaption>
                        <span><?= e($item['title'] ?? 'Sem título') ?></span>
                        <form
                            method="post"
                            action="<?= url('admin/galeriaExcluir') ?>"
                            data-confirm="Remover esta imagem da galeria?">
                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                            <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
                            <button type="submit" class="admin-icon-button is-danger" title="Remover">
                                <?= admin_icon('trash', 'icon') ?>
                            </button>
                        </form>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
