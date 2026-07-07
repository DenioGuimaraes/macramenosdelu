<?php

/**
 * ============================================================
 * Template Principal
 * Projeto: Macramê Nós de Lu
 * ============================================================
 *
 * Responsável por montar todas as páginas da aplicação.
 *
 * Estrutura:
 *
 * Header
 * Main
 * View
 * Footer
 *
 * ============================================================
 */

// Cabeçalho
require_once VIEW_PATH . '/layout/header.php';

?>

<main class="site-content">

    <?php require_once $viewFile; ?>

</main>

<?php

// Rodapé
require_once VIEW_PATH . '/layout/footer.php';
