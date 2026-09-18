<?php

$social = SiteData::links();

$directChannels = [];

foreach (['whatsapp', 'email', 'instagram', 'tiktok'] as $key) {
    if (isset($social[$key])) {
        $directChannels[] = ['key' => $key, 'item' => $social[$key]];
    }
}

?>
<section class="section contact-page">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Fale com a gente</h1>
            <?php require VIEW_PATH . '/partials/heart-divider.php'; ?>
            <p class="page-lead contact-page__intro">
                Tem uma dúvida ou quer uma peça sob encomenda? Adoraríamos conversar!
            </p>
        </header>

        <div class="contact-layout">
            <form class="contact-form" action="#" method="post">
                <div class="form-field">
                    <label for="nome">Nome</label>
                    <input type="text" id="nome" name="nome" autocomplete="name" required>
                </div>
                <div class="form-field">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" autocomplete="email" required>
                </div>
                <div class="form-field">
                    <label for="mensagem">Mensagem</label>
                    <textarea id="mensagem" name="mensagem" required></textarea>
                </div>
                <button type="submit" class="button-primary button-primary--full">Enviar mensagem</button>
                <p class="contact-form__note">
                    Responderemos pelo e-mail informado. Prefere agora? Use os canais ao lado.
                </p>
            </form>

            <aside class="contact-direct" aria-labelledby="contact-direct-title">
                <h2 id="contact-direct-title" class="contact-direct__title">Canais diretos</h2>
                <ul class="contact-direct__list">
                    <?php foreach ($directChannels as $entry) :
                        $item = $entry['item'];
                        $key = $entry['key'];
                        ?>
                        <li>
                            <a
                                class="contact-channel-card"
                                href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>"
                                <?= str_starts_with($item['url'], 'http') ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>
                                <?php $channel = $key; require VIEW_PATH . '/partials/contact-channel-icon.php'; ?>
                                <span class="contact-channel-card__text"><?= htmlspecialchars($item['display'], ENT_QUOTES, 'UTF-8') ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>
        </div>
    </div>
</section>
