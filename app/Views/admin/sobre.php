<?php

$aboutImage = trim($settings['about_image'] ?? '');
$aboutImageUrl = $aboutImage !== '' ? url($aboutImage) : url('images/nodelu_logo.png');
$usingDefaultImage = $aboutImage === '';

$defaults = [
    'about_text_1' => 'O projeto Macramê Nós de Lu nasceu do amor pelo artesanato e pela criação de peças feitas à mão.',
    'about_text_2' => 'Nosso objetivo é transformar fios, nós e ideias em objetos que carregam afeto, beleza e personalidade — para decorar ambientes, presentear pessoas queridas ou marcar momentos especiais.',
    'about_sustainability_title' => 'Cuidado e sustentabilidade',
    'about_sustainability_text' => 'Valorizamos a produção consciente, o reaproveitamento quando possível e materiais selecionados com responsabilidade — sempre mantendo a delicadeza visual que define a marca.',
];

?>
<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>
</header>

<form method="post" action="<?= url('admin/sobreSalvar') ?>" enctype="multipart/form-data" class="admin-form-stack">
    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

    <section class="admin-card">
        <header class="admin-card__header">
            <h2>Imagem da página</h2>
            <p class="admin-muted admin-card__lead">Uma única foto ao lado dos textos principais.</p>
        </header>

        <figure class="admin-about-preview">
            <img src="<?= e($aboutImageUrl) ?>" alt="Pré-visualização da página Sobre">
            <?php if ($usingDefaultImage) : ?>
                <figcaption class="admin-muted">Logo padrão (nenhuma imagem personalizada enviada)</figcaption>
            <?php endif; ?>
        </figure>

        <div class="admin-field">
            <label for="about-image">Substituir imagem</label>
            <input type="file" id="about-image" name="about_image" accept="image/jpeg,image/png,image/webp,image/gif">
            <p class="admin-field__hint">JPG, PNG, WEBP ou GIF — até 10 MB. A imagem anterior é removida ao enviar outra.</p>
        </div>

        <?php if (!$usingDefaultImage) : ?>
            <label class="admin-checkbox">
                <input type="checkbox" name="remove_about_image" value="1">
                <span>Remover imagem personalizada e voltar para a logo padrão</span>
            </label>
        <?php endif; ?>
    </section>

    <section class="admin-card">
        <header class="admin-card__header">
            <h2>Textos</h2>
        </header>

        <div class="admin-field">
            <label for="about-text-1">Primeiro parágrafo</label>
            <textarea id="about-text-1" name="about_text_1" rows="3"><?= e($settings['about_text_1'] ?? $defaults['about_text_1']) ?></textarea>
        </div>

        <div class="admin-field">
            <label for="about-text-2">Segundo parágrafo</label>
            <textarea id="about-text-2" name="about_text_2" rows="4"><?= e($settings['about_text_2'] ?? $defaults['about_text_2']) ?></textarea>
        </div>

        <div class="admin-field">
            <label for="about-sus-title">Título — sustentabilidade</label>
            <input
                type="text"
                id="about-sus-title"
                name="about_sustainability_title"
                value="<?= e($settings['about_sustainability_title'] ?? $defaults['about_sustainability_title']) ?>">
        </div>

        <div class="admin-field">
            <label for="about-sus-text">Texto — sustentabilidade</label>
            <textarea id="about-sus-text" name="about_sustainability_text" rows="3"><?= e($settings['about_sustainability_text'] ?? $defaults['about_sustainability_text']) ?></textarea>
        </div>
    </section>

    <p>
        <button type="submit" class="admin-button admin-button--primary">Salvar página Sobre</button>
    </p>
</form>
