<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>
</header>

<div class="admin-grid admin-grid--2-1">

    <section class="admin-card admin-card--flush">
        <?php foreach ($categories as $category) : ?>
            <form method="post" action="<?= url('admin/categoriaSalvar') ?>" id="cat-<?= (int) $category['id'] ?>" hidden>
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                <input type="hidden" name="id" value="<?= (int) $category['id'] ?>">
            </form>
        <?php endforeach; ?>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Slug</th>
                        <th class="is-center">Produtos</th>
                        <th class="is-center">Ordem</th>
                        <th class="is-center">Ativa</th>
                        <th class="is-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($categories)) : ?>
                        <tr>
                            <td colspan="6">
                                <div class="admin-empty">
                                    <span class="admin-empty__icon"><?= admin_icon('tag') ?></span>
                                    <p>Nenhuma categoria cadastrada</p>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($categories as $category) : ?>
                            <tr>
                                <td>
                                    <input
                                        class="admin-inline-input"
                                        type="text"
                                        name="name"
                                        form="cat-<?= (int) $category['id'] ?>"
                                        value="<?= e($category['name']) ?>">
                                </td>
                                <td class="admin-muted"><?= e($category['slug']) ?></td>
                                <td class="is-center"><?= (int) $category['total_products'] ?></td>
                                <td class="is-center">
                                    <input
                                        class="admin-inline-input admin-inline-input--small"
                                        type="number"
                                        name="sort_order"
                                        form="cat-<?= (int) $category['id'] ?>"
                                        value="<?= (int) $category['sort_order'] ?>">
                                </td>
                                <td class="is-center">
                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        form="cat-<?= (int) $category['id'] ?>"
                                        <?= (int) $category['is_active'] === 1 ? 'checked' : '' ?>>
                                </td>
                                <td class="is-right">
                                    <div class="admin-actions">
                                        <button
                                            type="submit"
                                            form="cat-<?= (int) $category['id'] ?>"
                                            class="admin-icon-button"
                                            title="Salvar">
                                            <?= admin_icon('check', 'icon') ?>
                                        </button>

                                        <form
                                            method="post"
                                            action="<?= url('admin/categoriaExcluir') ?>"
                                            data-confirm="Excluir a categoria &quot;<?= e($category['name']) ?>&quot;? Os produtos ficarão sem categoria.">
                                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                                            <input type="hidden" name="id" value="<?= (int) $category['id'] ?>">
                                            <button type="submit" class="admin-icon-button is-danger" title="Excluir">
                                                <?= admin_icon('trash', 'icon') ?>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="admin-card">
        <header class="admin-card__header">
            <h2>Nova categoria</h2>
        </header>

        <form method="post" action="<?= url('admin/categoriaSalvar') ?>" class="admin-form">
            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

            <div class="admin-field">
                <label for="new-category">Nome</label>
                <input type="text" id="new-category" name="name" placeholder="Ex.: Bolsas" required>
            </div>

            <div class="admin-field">
                <label for="new-category-order">Ordem de exibição</label>
                <input type="number" id="new-category-order" name="sort_order" value="0">
            </div>

            <button type="submit" class="admin-button admin-button--primary admin-button--full">
                <?= admin_icon('plus', 'icon') ?>
                Adicionar categoria
            </button>
        </form>
    </section>
</div>
