<div class="admin-modal" id="product-modal" hidden>
    <div class="admin-modal__backdrop" data-modal-close></div>

    <div class="admin-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="product-modal-title">

        <header class="admin-modal__header">
            <div>
                <h2 id="product-modal-title" class="admin-modal__title">Novo produto</h2>
                <p class="admin-modal__subtitle">Preencha os dados do produto e salve.</p>
            </div>
            <button type="button" class="admin-modal__close" data-modal-close aria-label="Fechar">
                <?= admin_icon('close', 'icon') ?>
            </button>
        </header>

        <form
            class="admin-modal__body"
            id="product-form"
            method="post"
            action="index.php?url=admin/produtoSalvar"
            enctype="multipart/form-data">

            <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">
            <input type="hidden" name="id" id="product-id" value="">

            <div class="admin-field">
                <label for="product-name">Nome <span class="is-required">*</span></label>
                <input type="text" id="product-name" name="name" placeholder="Nome do produto" required>
            </div>

            <div class="admin-field">
                <label for="product-slug">Slug / ID</label>
                <div class="admin-field__inline">
                    <input type="text" id="product-slug" name="slug" placeholder="slug-do-produto">
                    <button type="button" class="admin-button admin-button--ghost" data-slug-generate>
                        <?= admin_icon('refresh', 'icon') ?>
                        Gerar
                    </button>
                </div>
            </div>

            <div class="admin-field-row">
                <div class="admin-field">
                    <label for="product-category">Categoria <span class="is-required">*</span></label>
                    <select id="product-category" name="category_id" required>
                        <option value="">Selecionar</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= (int) $category['id'] ?>"><?= e($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="admin-field">
                    <label for="product-price">Preço (R$) <span class="is-required">*</span></label>
                    <input type="text" id="product-price" name="price" placeholder="0,00" inputmode="decimal" required>
                </div>
            </div>

            <div class="admin-field admin-field--switch">
                <label class="admin-switch">
                    <input type="hidden" name="status" value="pausado">
                    <input type="checkbox" id="product-status" name="status" value="ativo" checked>
                    <span class="admin-switch__track"><span class="admin-switch__thumb"></span></span>
                    <span class="admin-switch__label">Disponível</span>
                </label>
            </div>

            <div class="admin-field">
                <label for="product-shopee">Link do anúncio na Shopee</label>
                <p class="admin-field__hint">Cole o endereço completo do anúncio correspondente a este produto.</p>
                <input type="url" id="product-shopee" name="shopee_url" placeholder="https://shopee.com.br/...">
                <p class="admin-field__warning" id="shopee-warning">Produto sem anúncio vinculado na Shopee.</p>
            </div>

            <div class="admin-field">
                <label for="product-short">Descrição curta</label>
                <textarea id="product-short" name="short_description" rows="2" placeholder="Breve descrição exibida na listagem..."></textarea>
            </div>

            <div class="admin-field">
                <label for="product-description">Descrição completa</label>
                <textarea id="product-description" name="description" rows="4" placeholder="Texto detalhado exibido na página do produto..."></textarea>
            </div>

            <div class="admin-field-row">
                <div class="admin-field">
                    <label for="product-material">Material</label>
                    <input type="text" id="product-material" name="material" placeholder="Fio de algodão...">
                </div>

                <div class="admin-field">
                    <label for="product-dimensions">Dimensões</label>
                    <input type="text" id="product-dimensions" name="dimensions" placeholder="40 × 35 × 12 cm">
                </div>
            </div>

            <div class="admin-field-row">
                <div class="admin-field">
                    <label for="product-colors">Cores <span class="admin-field__note">(vírgula)</span></label>
                    <input type="text" id="product-colors" name="colors" placeholder="Cru, Areia, Terracota">
                </div>

                <div class="admin-field">
                    <label for="product-production">Prazo de produção</label>
                    <input type="text" id="product-production" name="production_time" placeholder="5 a 7 dias úteis">
                </div>
            </div>

            <div class="admin-field">
                <label for="product-note">Nota artesanal</label>
                <textarea id="product-note" name="artisan_note" rows="2" placeholder="Cada nó é atado à mão..."></textarea>
            </div>

            <div class="admin-field">
                <label for="product-care">Cuidados</label>
                <textarea id="product-care" name="care_instructions" rows="2" placeholder="Lave à mão com água fria..."></textarea>
            </div>

            <div class="admin-field">
                <label>Fotos e vídeos do produto</label>
                <p class="admin-field__warning">
                    Defina a ordem de exibição na página do produto. Imagens e vídeos aparecem na sequência abaixo.
                </p>

                <div class="admin-media" id="product-media">
                    <p class="admin-media__empty" id="product-media-empty">
                        Nenhuma mídia ainda. Adicione fotos ou vídeos abaixo.
                    </p>
                    <div class="admin-media__grid" id="product-media-grid"></div>
                </div>

                <div class="admin-media__actions">
                    <button type="button" class="admin-button admin-button--ghost" data-add-image>
                        <?= admin_icon('image', 'icon') ?>
                        Adicionar imagem
                    </button>
                    <button type="button" class="admin-button admin-button--ghost" data-add-video>
                        <?= admin_icon('video', 'icon') ?>
                        Adicionar vídeo
                    </button>
                </div>

                <input type="file" id="product-images" name="images[]" accept="image/*" multiple hidden>
                <input type="file" id="product-videos" name="videos[]" accept="video/mp4,video/webm" multiple hidden>

                <p class="admin-field__warning">
                    Imagens: JPG, PNG, WEBP ou GIF (até 10 MB). Vídeos: MP4 ou WEBM (até 10 MB).
                </p>
                <p class="admin-field__hint" id="product-files-selected"></p>
            </div>
        </form>

        <footer class="admin-modal__footer">
            <button type="button" class="admin-button admin-button--ghost" data-modal-close>Cancelar</button>
            <button type="submit" form="product-form" class="admin-button admin-button--primary" id="product-submit">
                Adicionar produto
            </button>
        </footer>
    </div>
</div>
