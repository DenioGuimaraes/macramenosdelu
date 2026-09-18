<?php

$social = SiteData::links();

$footerOrder = ['whatsapp', 'shopee', 'email', 'instagram', 'tiktok'];

?>
<footer class="site-footer">
    <div class="container footer-inner">
        <p class="footer-copy">
            &copy; <?= date('Y'); ?> Macramê Nós de Lu. Todos os direitos reservados.
        </p>

        <nav class="footer-social" aria-label="Redes e contato">
            <?php foreach ($footerOrder as $key) :
                if (!isset($social[$key])) {
                    continue;
                }

                $link = $social[$key];
                $external = str_starts_with($link['url'], 'http');
                ?>
                <a
                    href="<?= htmlspecialchars($link['url'], ENT_QUOTES, 'UTF-8') ?>"
                    <?= $external ? 'target="_blank" rel="noopener noreferrer"' : '' ?>>
                    <?= htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8') ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>
</footer>

</body>

</html>
