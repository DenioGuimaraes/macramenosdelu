<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>
</header>

<section class="admin-card admin-card--flush">
    <form method="post" action="<?= url('admin/linksSalvar') ?>">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Canal</th>
                        <th>Rótulo</th>
                        <th>URL</th>
                        <th>Exibição</th>
                        <th class="is-center">Ativo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($links as $link) : ?>
                        <tr>
                            <td class="admin-table__name"><?= e(ucfirst($link['link_key'])) ?></td>
                            <td>
                                <input
                                    class="admin-inline-input"
                                    type="text"
                                    name="links[<?= (int) $link['id'] ?>][label]"
                                    value="<?= e($link['label']) ?>">
                            </td>
                            <td>
                                <input
                                    class="admin-inline-input"
                                    type="text"
                                    name="links[<?= (int) $link['id'] ?>][url]"
                                    value="<?= e($link['url']) ?>">
                            </td>
                            <td>
                                <input
                                    class="admin-inline-input"
                                    type="text"
                                    name="links[<?= (int) $link['id'] ?>][display]"
                                    value="<?= e($link['display'] ?? '') ?>">
                            </td>
                            <td class="is-center">
                                <input
                                    type="checkbox"
                                    name="links[<?= (int) $link['id'] ?>][is_active]"
                                    <?= (int) $link['is_active'] === 1 ? 'checked' : '' ?>>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <footer class="admin-card__footer admin-card__footer--action">
            <button type="submit" class="admin-button admin-button--primary">Salvar links</button>
        </footer>
    </form>
</section>
