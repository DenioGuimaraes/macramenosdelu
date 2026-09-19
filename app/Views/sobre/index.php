<section class="section">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Sobre</h1>
            <?php require VIEW_PATH . '/partials/heart-divider.php'; ?>
        </header>

        <?php
        $aboutImagePath = trim(SiteData::setting('about_image', ''));
        $aboutImageSrc = $aboutImagePath !== '' ? url($aboutImagePath) : url('images/nodelu_logo.png');

        $aboutText1 = SiteData::setting(
            'about_text_1',
            'O projeto Macramê Nós de Lu nasceu do amor pelo artesanato e pela criação de peças feitas à mão.'
        );
        $aboutText2 = SiteData::setting(
            'about_text_2',
            'Nosso objetivo é transformar fios, nós e ideias em objetos que carregam afeto, beleza e personalidade — para decorar ambientes, presentear pessoas queridas ou marcar momentos especiais.'
        );
        $aboutSusTitle = SiteData::setting('about_sustainability_title', 'Cuidado e sustentabilidade');
        $aboutSusText = SiteData::setting(
            'about_sustainability_text',
            'Valorizamos a produção consciente, o reaproveitamento quando possível e materiais selecionados com responsabilidade — sempre mantendo a delicadeza visual que define a marca.'
        );
        ?>

        <div class="about-split">
            <div class="about-split__media">
                <img src="<?= htmlspecialchars($aboutImageSrc, ENT_QUOTES, 'UTF-8') ?>" alt="Macramê Nós de Lu">
            </div>
            <div class="about-split__text">
                <p class="text-brand text-brand--in-column">
                    <?= htmlspecialchars($aboutText1, ENT_QUOTES, 'UTF-8') ?>
                </p>
                <p class="text-brand text-brand--in-column">
                    <?= htmlspecialchars($aboutText2, ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>
        </div>

        <div class="sustainability-block">
            <h2 class="text-brand"><?= htmlspecialchars($aboutSusTitle, ENT_QUOTES, 'UTF-8') ?></h2>
            <p class="text-brand">
                <?= htmlspecialchars($aboutSusText, ENT_QUOTES, 'UTF-8') ?>
            </p>
        </div>

        <div class="cta-row">
            <a class="button-primary" href="<?= url('catalogo') ?>">Ver loja</a>
            <a class="button-secondary" href="<?= url('contato') ?>">Falar conosco</a>
        </div>
    </div>
</section>
