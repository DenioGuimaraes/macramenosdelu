<?php

require_once VIEW_PATH . '/admin/partials/icons.php';

$csrfToken = Auth::csrfToken();

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($title ?? 'Painel') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Leckerli+One&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="<?= url() ?>favicon/favicon.svg">
    <link rel="stylesheet" href="<?= url() ?>css/admin.css">
</head>

<body class="admin admin-login-page">

    <main class="admin-login">
        <div class="admin-login__card">

            <div class="admin-login__brand">
                <span class="admin-brand__mark">nl</span>
                <h1>Nós de Lu</h1>
                <p>Painel administrativo</p>
            </div>

            <?php if (!empty($error)) : ?>
                <p class="admin-flash admin-flash--error" role="alert"><?= e($error) ?></p>
            <?php endif; ?>

            <form method="post" action="<?= url('admin/login') ?>" class="admin-login__form">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

                <div class="admin-field">
                    <label for="email">E-mail</label>
                    <div class="admin-input-icon">
                        <?= admin_icon('mail', 'icon') ?>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= e($email ?? '') ?>"
                            autocomplete="username"
                            required
                            autofocus>
                    </div>
                </div>

                <div class="admin-field">
                    <label for="password">Senha</label>
                    <div class="admin-input-icon">
                        <?= admin_icon('lock', 'icon') ?>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="current-password"
                            required>
                    </div>
                </div>

                <button type="submit" class="admin-button admin-button--primary admin-button--full">
                    Entrar no painel
                </button>
            </form>

            <p class="admin-login__note">Acesso restrito à administração da loja.</p>
        </div>
    </main>

</body>

</html>
