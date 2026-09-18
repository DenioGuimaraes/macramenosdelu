<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>
</header>

<section class="admin-card">
    <form method="post" action="index.php?url=admin/configuracoesSalvar" class="admin-form">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

        <div class="admin-field-row">
            <div class="admin-field">
                <label for="store-name">Nome da loja</label>
                <input
                    type="text"
                    id="store-name"
                    name="store_name"
                    value="<?= e($settings['store_name'] ?? 'Macramê Nós de Lu') ?>">
            </div>

            <div class="admin-field">
                <label for="store-tagline">Slogan</label>
                <input
                    type="text"
                    id="store-tagline"
                    name="store_tagline"
                    value="<?= e($settings['store_tagline'] ?? 'Cada nó, uma história!') ?>">
            </div>
        </div>

        <div class="admin-field-row">
            <div class="admin-field">
                <label for="store-email">E-mail de contato</label>
                <input
                    type="email"
                    id="store-email"
                    name="store_email"
                    value="<?= e($settings['store_email'] ?? 'macramenosdelu@gmail.com') ?>">
            </div>

            <div class="admin-field">
                <label for="store-whatsapp">WhatsApp</label>
                <input
                    type="text"
                    id="store-whatsapp"
                    name="store_whatsapp"
                    value="<?= e($settings['store_whatsapp'] ?? '5521997175714') ?>">
            </div>
        </div>

        <div class="admin-field">
            <label for="low-stock">Alerta de estoque baixo (unidades)</label>
            <input
                type="number"
                id="low-stock"
                name="low_stock_threshold"
                min="0"
                value="<?= e($settings['low_stock_threshold'] ?? '3') ?>">
            <p class="admin-field__hint">Produtos com quantidade igual ou menor aparecem no painel como estoque baixo.</p>
        </div>

        <button type="submit" class="admin-button admin-button--primary">Salvar configurações</button>
    </form>
</section>
