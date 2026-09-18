<?php

$statusLabels = [
    'pendente'  => ['label' => 'Pendente', 'class' => 'admin-badge--warning'],
    'concluido' => ['label' => 'Concluído', 'class' => 'admin-badge--success'],
    'cancelado' => ['label' => 'Cancelado', 'class' => 'admin-badge--danger'],
];

$channelLabels = [
    'whatsapp' => 'WhatsApp',
    'shopee'   => 'Shopee',
    'site'     => 'Site',
    'outro'    => 'Outro',
];

?>
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
                        <th>Cliente</th>
                        <th>Contato</th>
                        <th>Canal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th class="is-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)) : ?>
                        <tr>
                            <td colspan="6">
                                <div class="admin-empty">
                                    <span class="admin-empty__icon"><?= admin_icon('clipboard') ?></span>
                                    <p>Nenhum pedido registrado</p>
                                </div>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($orders as $order) :
                            $status = $statusLabels[$order['status']] ?? $statusLabels['pendente'];
                            ?>
                            <tr>
                                <td class="admin-table__name"><?= e($order['customer_name']) ?></td>
                                <td class="admin-muted"><?= e($order['contact'] ?? '—') ?></td>
                                <td><?= e($channelLabels[$order['channel']] ?? $order['channel']) ?></td>
                                <td><?= e(admin_money($order['total'])) ?></td>
                                <td><span class="admin-badge <?= e($status['class']) ?>"><?= e($status['label']) ?></span></td>
                                <td class="is-right">
                                    <div class="admin-actions">
                                        <form method="post" action="<?= url('admin/pedidoStatus') ?>">
                                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                                            <input type="hidden" name="id" value="<?= (int) $order['id'] ?>">
                                            <input type="hidden" name="status" value="<?= $order['status'] === 'pendente' ? 'concluido' : 'pendente' ?>">
                                            <button type="submit" class="admin-icon-button is-green" title="Alternar status">
                                                <?= admin_icon('check', 'icon') ?>
                                            </button>
                                        </form>

                                        <form
                                            method="post"
                                            action="<?= url('admin/pedidoExcluir') ?>"
                                            data-confirm="Excluir este pedido?">
                                            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
                                            <input type="hidden" name="id" value="<?= (int) $order['id'] ?>">
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
            <?= count($orders) ?> pedido<?= count($orders) === 1 ? '' : 's' ?> — <?= (int) $pending ?> pendente<?= (int) $pending === 1 ? '' : 's' ?>
        </footer>
    </section>

    <section class="admin-card">
        <header class="admin-card__header">
            <h2>Registrar pedido</h2>
        </header>

        <form method="post" action="<?= url('admin/pedidoSalvar') ?>" class="admin-form">
            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

            <div class="admin-field">
                <label for="order-name">Cliente</label>
                <input type="text" id="order-name" name="customer_name" required>
            </div>

            <div class="admin-field">
                <label for="order-contact">Contato</label>
                <input type="text" id="order-contact" name="contact" placeholder="WhatsApp ou e-mail">
            </div>

            <div class="admin-field-row">
                <div class="admin-field">
                    <label for="order-channel">Canal</label>
                    <select id="order-channel" name="channel">
                        <option value="whatsapp">WhatsApp</option>
                        <option value="shopee">Shopee</option>
                        <option value="site">Site</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>

                <div class="admin-field">
                    <label for="order-total">Total (R$)</label>
                    <input type="text" id="order-total" name="total" placeholder="0,00" inputmode="decimal">
                </div>
            </div>

            <div class="admin-field">
                <label for="order-notes">Observações</label>
                <textarea id="order-notes" name="notes" rows="3"></textarea>
            </div>

            <button type="submit" class="admin-button admin-button--primary admin-button--full">
                <?= admin_icon('plus', 'icon') ?>
                Registrar pedido
            </button>
        </form>
    </section>
</div>
