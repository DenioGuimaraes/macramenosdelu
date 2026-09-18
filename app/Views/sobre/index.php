<section class="section">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Sobre</h1>
            <?php require VIEW_PATH . '/partials/heart-divider.php'; ?>
        </header>

        <div class="about-split">
            <div class="about-split__media">
                <img src="<?= url('images/nodelu_logo.png') ?>" alt="Macramê Nós de Lu">
            </div>
            <div class="about-split__text">
                <p class="text-brand text-brand--in-column">
                    O projeto Macramê Nós de Lu nasceu do amor pelo artesanato e pela criação de peças feitas à mão.
                </p>
                <p class="text-brand text-brand--in-column">
                    Nosso objetivo é transformar fios, nós e ideias em objetos que carregam afeto, beleza e personalidade —
                    para decorar ambientes, presentear pessoas queridas ou marcar momentos especiais.
                </p>
            </div>
        </div>

        <div class="sustainability-block">
            <h2 class="text-brand">Cuidado e sustentabilidade</h2>
            <p class="text-brand">
                Valorizamos a produção consciente, o reaproveitamento quando possível e materiais selecionados
                com responsabilidade — sempre mantendo a delicadeza visual que define a marca.
            </p>
        </div>

        <div class="cta-row">
            <a class="button-primary" href="<?= url('catalogo') ?>">Ver loja</a>
            <a class="button-secondary" href="<?= url('contato') ?>">Falar conosco</a>
        </div>
    </div>
</section>
