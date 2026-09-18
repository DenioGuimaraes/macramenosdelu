<header class="admin-page-header">
    <div>
        <h1 class="admin-page-title"><?= e($pageTitle) ?></h1>
        <p class="admin-page-subtitle"><?= e($pageSubtitle) ?></p>
    </div>
</header>

<div class="admin-grid admin-grid--2-1">

    <section class="admin-card admin-card--flush">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Criado em</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td class="admin-table__name"><?= e($user['name']) ?></td>
                            <td class="admin-muted"><?= e($user['email']) ?></td>
                            <td class="admin-muted"><?= e(admin_date_br($user['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <div class="admin-stack">

        <section class="admin-card">
            <header class="admin-card__header">
                <h2>Alterar senha</h2>
            </header>

            <form method="post" action="index.php?url=admin/senhaAlterar" class="admin-form">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

                <div class="admin-field">
                    <label for="current-password">Senha atual</label>
                    <input type="password" id="current-password" name="current_password" autocomplete="current-password" required>
                </div>

                <div class="admin-field">
                    <label for="new-password">Nova senha</label>
                    <input type="password" id="new-password" name="new_password" autocomplete="new-password" minlength="6" required>
                    <p class="admin-field__hint">Mínimo de 6 caracteres.</p>
                </div>

                <div class="admin-field">
                    <label for="confirm-password">Confirmar nova senha</label>
                    <input type="password" id="confirm-password" name="confirm_password" autocomplete="new-password" minlength="6" required>
                </div>

                <button type="submit" class="admin-button admin-button--primary admin-button--full">
                    <?= admin_icon('lock', 'icon') ?>
                    Alterar senha
                </button>
            </form>
        </section>

        <section class="admin-card">
            <header class="admin-card__header">
                <h2>Nome de exibição</h2>
            </header>

            <form method="post" action="index.php?url=admin/perfilSalvar" class="admin-form">
                <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

                <div class="admin-field">
                    <label for="profile-name">Nome</label>
                    <input type="text" id="profile-name" name="name" value="<?= e($adminUser['name'] ?? '') ?>" required>
                </div>

                <button type="submit" class="admin-button admin-button--ghost admin-button--full">Salvar nome</button>
            </form>
        </section>
    </div>
</div>
