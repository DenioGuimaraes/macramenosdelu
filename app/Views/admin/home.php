<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>
</header>

<section class="admin-card">
    <form method="post" action="<?= url('admin/homeSalvar') ?>" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

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
