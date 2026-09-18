<?php

$firstName = trim(explode(' ', (string) ($adminUser['name'] ?? 'Admin'))[0]);

?>
<header class="admin-topbar">

    <button type="button" class="admin-menu-toggle" aria-label="Abrir menu" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>

    <p class="admin-greeting">
        <?= admin_icon('sun', 'admin-greeting__icon') ?>
        <span><?= e(admin_greeting()) ?>, <em><?= e($firstName) ?></em>!</span>
    </p>

    <div class="admin-topbar__right">
        <span class="admin-date"><?= e(admin_date_br()) ?></span>
        <span class="admin-avatar" aria-hidden="true">
            <?= e(mb_strtoupper(mb_substr($firstName, 0, 2, 'UTF-8'), 'UTF-8')) ?>
        </span>
    </div>
</header>
