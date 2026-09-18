<section class="section">
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Contato</h1>
            <?php require VIEW_PATH . '/partials/heart-divider.php'; ?>
            <p class="text-brand">
                Tire dúvidas, solicite informações ou converse sobre peças personalizadas.
            </p>
        </header>

        <form class="form-stack" action="#" method="post">
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
            <button type="submit" class="button-primary">Enviar mensagem</button>
        </form>

        <div class="contact-channels">
            <p class="text-brand">Outros canais</p>
            <ul class="contact-channels__list">
                <li><a href="#">WhatsApp</a></li>
                <li><a href="mailto:contato@macramenosdelu.com.br">contato@macramenosdelu.com.br</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
            <p class="text-brand form-hint">O envio do formulário será conectado em uma próxima etapa.</p>
        </div>
    </div>
</section>
