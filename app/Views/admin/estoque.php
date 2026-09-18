<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>
</header>

<form method="post" action="<?= url('admin/estoqueSalvar') ?>">
    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

    <section class="admin-card admin-card--flush">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Categoria</th>
                        <th class="is-center">Quantidade</th>
                        <th class="is-right">Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)) : ?>
                        <tr>
                            <td colspan="4">
                                <div class="admin-empty">
                                    <span class="admin-empty__icon"><?= admin_icon('layers') ?></span>
                                    <p>Nenhum produto cadastrado</p>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td class="admin-table__name"><?= e($product['name']) ?></td>
                                <td><?= e($product['category_name'] ?? '—') ?></td>
                                <td class="is-center">
                                    <input
                                        class="admin-inline-input admin-inline-input--small"
                                        type="number"
                                        min="0"
                                        name="stock[<?= (int) $product['id'] ?>]"
                                        value="<?= (int) $product['stock_qty'] ?>">
                                </td>
                                <td class="is-right">
                                    <?php if ((int) $product['stock_qty'] === 0) : ?>
                                        <span class="admin-badge admin-badge--danger">Esgotado</span>
                                    <?php elseif ((int) $product['stock_qty'] <= 3) : ?>
                                        <span class="admin-badge admin-badge--warning">Baixo</span>
                                    <?php else : ?>
                                        <span class="admin-badge admin-badge--success">Disponível</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($products)) : ?>
            <footer class="admin-card__footer admin-card__footer--action">
                <button type="submit" class="admin-button admin-button--primary">Salvar estoque</button>
            </footer>
        <?php endif; ?>
    </section>
</form>
