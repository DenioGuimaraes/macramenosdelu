<section class="section">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Página não encontrada</h1>
            <?php require VIEW_PATH . '/partials/heart-divider.php'; ?>
            <p class="text-brand">
                O endereço digitado não existe ou foi alterado.
            </p>
        </header>

        <div class="cta-row">
            <a class="button-primary" href="<?= url() ?>">Voltar para a home</a>
            <a class="button-secondary" href="<?= url('catalogo') ?>">Ver a loja</a>
        </div>
    </div>
</section>
