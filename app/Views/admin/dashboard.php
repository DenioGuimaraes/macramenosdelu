<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>
</header>

<section class="admin-stats">
    <article class="admin-stat">
        <span class="admin-stat__icon admin-stat__icon--brown"><?= admin_icon('package') ?></span>
        <div>
            <p class="admin-stat__label">Total de produtos</p>
            <p class="admin-stat__value"><?= (int) $totalProducts ?></p>
        </div>
    </article>

    <article class="admin-stat">
        <span class="admin-stat__icon admin-stat__icon--green"><?= admin_icon('check') ?></span>
        <div>
            <p class="admin-stat__label">Ativos</p>
            <p class="admin-stat__value admin-stat__value--green"><?= (int) $activeProducts ?></p>
        </div>
    </article>

    <article class="admin-stat">
        <span class="admin-stat__icon admin-stat__icon--amber"><?= admin_icon('pause') ?></span>
        <div>
            <p class="admin-stat__label">Pausados</p>
            <p class="admin-stat__value admin-stat__value--amber"><?= (int) $pausedProducts ?></p>
        </div>
    </article>

    <article class="admin-stat">
        <span class="admin-stat__icon admin-stat__icon--blue"><?= admin_icon('clipboard') ?></span>
        <div>
            <p class="admin-stat__label">Pedidos pendentes</p>
            <p class="admin-stat__value admin-stat__value--blue"><?= (int) $pendingOrders ?></p>
        </div>
    </article>
</section>

<div class="admin-grid admin-grid--2-1">

    <section class="admin-card">
        <header class="admin-card__header">
            <h2>Estoque baixo</h2>
            <a class="admin-card__link" href="<?= url('admin/estoque') ?>">Gerenciar estoque →</a>
        </header>

        <?php if (empty($lowStock)) : ?>
            <div class="admin-empty">
                <span class="admin-empty__icon"><?= admin_icon('layers') ?></span>
                <p>Nenhum produto com estoque baixo</p>
            </div>
        <?php else : ?>
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th class="is-center">Qtd.</th>
                            <th class="is-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lowStock as $item) : ?>
                            <tr>
                                <td>
                                    <div class="admin-product-cell">
                                        <span class="admin-thumb">
                                            <?php if (!empty($item['cover_image'])) : ?>
                                                <img src="<?= url($item['cover_image']) ?>" alt="">
                                            <?php else : ?>
                                                <?= admin_icon('image') ?>
                                            <?php endif; ?>
                                        </span>
                                        <span><?= e($item['name']) ?></span>
                                    </div>
                                </td>
                                <td><?= e($item['category_name'] ?? '—') ?></td>
                                <td class="is-center"><?= (int) $item['stock_qty'] ?></td>
                                <td class="is-right">
                                    <?php if ((int) $item['stock_qty'] === 0) : ?>
                                        <span class="admin-badge admin-badge--danger">Esgotado</span>
                                    <?php else : ?>
                                        <span class="admin-badge admin-badge--warning">Baixo</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>

    <section class="admin-card">
        <header class="admin-card__header">
            <h2>Atalhos rápidos</h2>
        </header>

        <div class="admin-shortcuts">
            <a class="admin-shortcut admin-shortcut--primary" href="<?= url('admin/produtos') ?>?novo=1">
                <span class="admin-shortcut__icon"><?= admin_icon('plus') ?></span>
                <span class="admin-shortcut__text">
                    <strong>Novo produto</strong>
                    <small>Adicionar ao catálogo</small>
                </span>
                <span class="admin-shortcut__arrow"><?= admin_icon('arrow') ?></span>
            </a>

            <a class="admin-shortcut" href="<?= url('admin/sobre') ?>">
                <span class="admin-shortcut__icon"><?= admin_icon('image') ?></span>
                <span class="admin-shortcut__text">
                    <strong>Editar página Sobre</strong>
                    <small>Imagem e textos institucionais</small>
                </span>
                <span class="admin-shortcut__arrow"><?= admin_icon('arrow') ?></span>
            </a>
        </div>
    </section>
</div>

<section class="admin-card">
    <header class="admin-card__header">
        <h2>Alterados recentemente</h2>
        <a class="admin-card__link" href="<?= url('admin/produtos') ?>">Ver produtos →</a>
    </header>

    <?php if (empty($recentActivity)) : ?>
        <div class="admin-empty">
            <span class="admin-empty__icon"><?= admin_icon('package') ?></span>
            <p>Nenhuma alteração recente</p>
        </div>
    <?php else : ?>
        <ul class="admin-activity">
            <?php foreach ($recentActivity as $entry) : ?>
                <li>
                    <span class="admin-activity__icon"><?= admin_icon('clock') ?></span>
                    <span class="admin-activity__text"><?= e($entry['description']) ?></span>
                    <span class="admin-activity__time"><?= e(admin_date_br($entry['created_at'], false)) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
