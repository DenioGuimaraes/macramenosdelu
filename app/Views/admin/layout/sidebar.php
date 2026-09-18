<?php

$menuGroups = [
    'Geral' => [
        ['key' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'admin'],
    ],
    'Catálogo' => [
        ['key' => 'produtos', 'label' => 'Produtos', 'icon' => 'package', 'route' => 'admin/produtos'],
        ['key' => 'categorias', 'label' => 'Categorias', 'icon' => 'tag', 'route' => 'admin/categorias'],
        ['key' => 'estoque', 'label' => 'Estoque', 'icon' => 'layers', 'route' => 'admin/estoque'],
    ],
    'Comercial' => [
        ['key' => 'pedidos', 'label' => 'Pedidos', 'icon' => 'clipboard', 'route' => 'admin/pedidos'],
    ],
    'Conteúdo' => [
        ['key' => 'galeria', 'label' => 'Galeria', 'icon' => 'image', 'route' => 'admin/galeria'],
        ['key' => 'home', 'label' => 'Home', 'icon' => 'home', 'route' => 'admin/home'],
        ['key' => 'links', 'label' => 'Links', 'icon' => 'link', 'route' => 'admin/links'],
    ],
    'Sistema' => [
        ['key' => 'usuarios', 'label' => 'Usuários', 'icon' => 'users', 'route' => 'admin/usuarios'],
        ['key' => 'configuracoes', 'label' => 'Configurações', 'icon' => 'settings', 'route' => 'admin/configuracoes'],
    ],
];

?>
<aside class="admin-sidebar" id="admin-sidebar">

    <div class="admin-brand">
        <span class="admin-brand__mark">nl</span>
        <span class="admin-brand__text">
            <strong>Nós de Lu</strong>
            <small>Painel admin</small>
        </span>
    </div>

    <nav class="admin-nav" aria-label="Menu do painel">
        <?php foreach ($menuGroups as $groupLabel => $items) : ?>
            <p class="admin-nav__group"><?= e($groupLabel) ?></p>
            <ul>
                <?php foreach ($items as $item) : ?>
                    <li>
                        <a
                            class="admin-nav__link<?= $activeMenu === $item['key'] ? ' is-active' : '' ?>"
                            href="index.php?url=<?= e($item['route']) ?>">
                            <?= admin_icon($item['icon'], 'admin-nav__icon') ?>
                            <span><?= e($item['label']) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    </nav>

    <div class="admin-sidebar__footer">
        <a class="admin-nav__link" href="index.php" target="_blank" rel="noopener">
            <?= admin_icon('external', 'admin-nav__icon') ?>
            <span>Ver site</span>
        </a>

        <a class="admin-nav__link" href="index.php?url=admin/logout">
            <?= admin_icon('logout', 'admin-nav__icon') ?>
            <span>Sair</span>
        </a>
    </div>
</aside>
