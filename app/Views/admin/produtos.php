<?php

/**
 * Dados dos produtos em JSON para preencher o modal de edição.
 */
$productsJson = [];

foreach ($products as $product) {
    $productsJson[(int) $product['id']] = [
        'id'                => (int) $product['id'],
        'name'              => $product['name'],
        'slug'              => $product['slug'],
        'category_id'       => $product['category_id'],
        'price'             => number_format((float) $product['price'], 2, ',', ''),
        'status'            => $product['status'],
        'stock_qty'         => (int) $product['stock_qty'],
        'shopee_url'        => $product['shopee_url'],
        'short_description' => $product['short_description'],
        'description'       => $product['description'],
        'material'          => $product['material'],
        'dimensions'        => $product['dimensions'],
        'colors'            => $product['colors'],
        'production_time'   => $product['production_time'],
        'artisan_note'      => $product['artisan_note'],
        'care_instructions' => $product['care_instructions'],
        'media'             => $mediaByProduct[(int) $product['id']] ?? [],
    ];
}

?>
<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>

    <button type="button" class="admin-button admin-button--primary" data-product-new>
        <?= admin_icon('plus', 'icon') ?>
        Novo produto
    </button>
</header>

<section class="admin-stats admin-stats--3">
    <article class="admin-stat admin-stat--plain">
        <p class="admin-stat__label">Total</p>
        <p class="admin-stat__value"><?= (int) $totalProducts ?></p>
    </article>
    <article class="admin-stat admin-stat--plain">
        <p class="admin-stat__label">Ativos</p>
        <p class="admin-stat__value admin-stat__value--green"><?= (int) $activeProducts ?></p>
    </article>
    <article class="admin-stat admin-stat--plain">
        <p class="admin-stat__label">Pausados</p>
        <p class="admin-stat__value admin-stat__value--amber"><?= (int) $pausedProducts ?></p>
    </article>
</section>

<form class="admin-toolbar" method="get" action="<?= url('admin/produtos') ?>">

    <label class="admin-search">
        <?= admin_icon('search', 'icon') ?>
        <input
            type="search"
            name="busca"
            value="<?= e($searchTerm) ?>"
            placeholder="Buscar produto..."
            aria-label="Buscar produto">
    </label>

    <label class="admin-select">
        <select name="categoria" onchange="this.form.submit()" aria-label="Filtrar por categoria">
            <option value="">Todas as categorias</option>
            <?php foreach ($categories as $category) : ?>
                <option
                    value="<?= (int) $category['id'] ?>"
                    <?= $categoryId === (int) $category['id'] ? 'selected' : '' ?>>
                    <?= e($category['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <button type="submit" class="admin-button admin-button--ghost">Filtrar</button>
</form>

<section class="admin-card admin-card--flush">
    <div class="admin-table-wrap">
        <table class="admin-table admin-table--products">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th class="is-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)) : ?>
                    <tr>
                        <td colspan="6">
                            <div class="admin-empty">
                                <span class="admin-empty__icon"><?= admin_icon('package') ?></span>
                                <p>Nenhum produto cadastrado ainda</p>
                            </div>
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($products as $product) : ?>
                        <tr>
                            <td>
                                <span class="admin-thumb">
                                    <?php if (!empty($product['cover_image'])) : ?>
                                        <img src="<?= url($product['cover_image']) ?>" alt="">
                                    <?php else : ?>
                                        <?= admin_icon('image') ?>
                                    <?php endif; ?>
                                </span>
                            </td>
                            <td class="admin-table__name"><?= e($product['name']) ?></td>
                            <td><?= e($product['category_name'] ?? '—') ?></td>
                            <td><?= e(admin_money($product['price'])) ?></td>
                            <td>
                                <?php if ($product['status'] === 'ativo') : ?>
                                    <span class="admin-badge admin-badge--success">Ativo</span>
                                <?php else : ?>
                                    <span class="admin-badge admin-badge--warning">Pausado</span>
                                <?php endif; ?>
                            </td>
                            <td class="is-right">
                                <div class="admin-actions">
                                    <button
                                        type="button"
                                        class="admin-icon-button"
                                        title="Editar"
                                        data-product-edit="<?= (int) $product['id'] ?>">
                                        <?= admin_icon('pencil', 'icon') ?>
                                    </button>

                                    <form method="post" action="<?= url('admin/produtoStatus') ?>">
                                        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                                        <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
                                        <button
                                            type="submit"
                                            class="admin-icon-button<?= $product['status'] === 'ativo' ? '' : ' is-green' ?>"
                                            title="<?= $product['status'] === 'ativo' ? 'Pausar' : 'Ativar' ?>">
                                            <?= admin_icon($product['status'] === 'ativo' ? 'pause' : 'play', 'icon') ?>
                                        </button>
                                    </form>

                                    <form
                                        method="post"
                                        action="<?= url('admin/produtoExcluir') ?>"
                                        data-confirm="Excluir definitivamente o produto &quot;<?= e($product['name']) ?>&quot;?">
                                        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                                        <input type="hidden" name="id" value="<?= (int) $product['id'] ?>">
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

    <footer class="admin-card__footer">
        <?= count($products) ?> produto<?= count($products) === 1 ? '' : 's' ?>
    </footer>
</section>

<?php require VIEW_PATH . '/admin/partials/product-modal.php'; ?>

<form id="media-delete-form" method="post" action="<?= url('admin/midiaExcluir') ?>" hidden>
    <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
    <input type="hidden" name="media_id" value="">
</form>

<script type="application/json" id="products-data">
    <?= json_encode($productsJson, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?>
</script>
