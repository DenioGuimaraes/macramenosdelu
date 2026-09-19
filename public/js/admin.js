/**
 * Painel administrativo — Macramê Nós de Lu
 * Menu lateral, confirmações, modal de produto e seleção de mídia.
 */

document.addEventListener('DOMContentLoaded', function () {

    setupSidebar();
    setupConfirmations();
    setupProductModal();
    setupHeroUploadTriggers();
});

function setupHeroUploadTriggers() {
    document.querySelectorAll('[data-trigger-file]').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(button.dataset.triggerFile);

            if (!input) {
                return;
            }

            input.click();
        });
    });

    document.querySelectorAll('[data-trigger-file]').forEach(function (button) {
        const input = document.getElementById(button.dataset.triggerFile);

        if (!input) {
            return;
        }

        input.addEventListener('change', function () {
            if (input.files && input.files.length > 0) {
                input.form.submit();
            }
        });
    });
}

/* ------------------------------------------------------------
   Sidebar (mobile)
   ------------------------------------------------------------ */

function setupSidebar() {
    const toggle = document.querySelector('.admin-menu-toggle');
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.querySelector('.admin-overlay');

    if (!toggle || !sidebar || !overlay) {
        return;
    }

    function setOpen(open) {
        sidebar.classList.toggle('is-open', open);
        overlay.classList.toggle('is-visible', open);
        overlay.hidden = !open;
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    toggle.addEventListener('click', function () {
        setOpen(!sidebar.classList.contains('is-open'));
    });

    overlay.addEventListener('click', function () {
        setOpen(false);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            setOpen(false);
        }
    });
}

/* ------------------------------------------------------------
   Confirmação antes de excluir
   ------------------------------------------------------------ */

function setupConfirmations() {
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });
}

/* ------------------------------------------------------------
   Modal de produto
   ------------------------------------------------------------ */

function setupProductModal() {
    const modal = document.getElementById('product-modal');
    const form = document.getElementById('product-form');
    const baseUrl = document.body.dataset.baseUrl || '/';

    if (!modal || !form) {
        return;
    }

    const dataScript = document.getElementById('products-data');
    const products = dataScript ? JSON.parse(dataScript.textContent || '{}') : {};

    const title = document.getElementById('product-modal-title');
    const submit = document.getElementById('product-submit');
    const mediaGrid = document.getElementById('product-media-grid');
    const mediaEmpty = document.getElementById('product-media-empty');
    const shopeeInput = document.getElementById('product-shopee');
    const shopeeWarning = document.getElementById('shopee-warning');
    const nameInput = document.getElementById('product-name');
    const slugInput = document.getElementById('product-slug');
    const imagesInput = document.getElementById('product-images');
    const videosInput = document.getElementById('product-videos');
    const filesLabel = document.getElementById('product-files-selected');
    const mediaDeleteForm = document.getElementById('media-delete-form');

    let lastFocused = null;

    /* ---------- abrir / fechar ---------- */

    function openModal() {
        lastFocused = document.activeElement;
        modal.hidden = false;
        document.body.style.overflow = 'hidden';
        window.setTimeout(function () {
            nameInput.focus();
        }, 50);
    }

    function closeModal() {
        modal.hidden = true;
        document.body.style.overflow = '';

        if (lastFocused) {
            lastFocused.focus();
        }
    }

    modal.querySelectorAll('[data-modal-close]').forEach(function (element) {
        element.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.hidden) {
            closeModal();
        }
    });

    /* ---------- estado do formulário ---------- */

    function resetForm() {
        form.reset();
        document.getElementById('product-id').value = '';
        document.getElementById('product-status').checked = true;
        mediaGrid.innerHTML = '';
        updateMediaEmpty();
        updateShopeeWarning();
        updateFilesLabel();
    }

    function fillForm(product) {
        document.getElementById('product-id').value = product.id;
        nameInput.value = product.name || '';
        slugInput.value = product.slug || '';
        document.getElementById('product-category').value = product.category_id || '';
        document.getElementById('product-price').value = product.price || '';
        document.getElementById('product-status').checked = product.status === 'ativo';
        shopeeInput.value = product.shopee_url || '';
        document.getElementById('product-short').value = product.short_description || '';
        document.getElementById('product-description').value = product.description || '';
        document.getElementById('product-material').value = product.material || '';
        document.getElementById('product-dimensions').value = product.dimensions || '';
        document.getElementById('product-colors').value = product.colors || '';
        document.getElementById('product-production').value = product.production_time || '';
        document.getElementById('product-note').value = product.artisan_note || '';
        document.getElementById('product-care').value = product.care_instructions || '';

        renderExistingMedia(product.media || []);
        updateShopeeWarning();
        updateFilesLabel();
    }

    /* ---------- mídia já salva ---------- */

    function renderExistingMedia(mediaList) {
        mediaGrid.innerHTML = '';

        mediaList.forEach(function (media) {
            const item = document.createElement('div');
            item.className = 'admin-media__item';

            if (media.media_type === 'video') {
                const video = document.createElement('video');
                video.src = baseUrl + media.file_path;
                video.muted = true;
                item.appendChild(video);
            } else {
                const image = document.createElement('img');
                image.src = baseUrl + media.file_path;
                image.alt = '';
                item.appendChild(image);
            }

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'admin-media__remove';
            remove.title = 'Remover mídia';
            remove.innerHTML = '&times;';
            remove.addEventListener('click', function () {
                if (!window.confirm('Remover esta mídia do produto?')) {
                    return;
                }

                mediaDeleteForm.querySelector('[name="media_id"]').value = media.id;
                mediaDeleteForm.submit();
            });

            item.appendChild(remove);
            mediaGrid.appendChild(item);
        });

        updateMediaEmpty();
    }

    function updateMediaEmpty() {
        mediaEmpty.hidden = mediaGrid.children.length > 0;
    }

    /* ---------- avisos e apoio ---------- */

    function updateShopeeWarning() {
        shopeeWarning.hidden = shopeeInput.value.trim() !== '';
    }

    function updateFilesLabel() {
        const images = imagesInput.files.length;
        const videos = videosInput.files.length;

        if (images === 0 && videos === 0) {
            filesLabel.textContent = '';
            return;
        }

        const parts = [];

        if (images > 0) {
            parts.push(images + (images === 1 ? ' imagem' : ' imagens'));
        }

        if (videos > 0) {
            parts.push(videos + (videos === 1 ? ' vídeo' : ' vídeos'));
        }

        filesLabel.textContent = 'Selecionado para envio: ' + parts.join(' e ') + '.';
    }

    shopeeInput.addEventListener('input', updateShopeeWarning);
    imagesInput.addEventListener('change', updateFilesLabel);
    videosInput.addEventListener('change', updateFilesLabel);

    document.querySelector('[data-add-image]').addEventListener('click', function () {
        imagesInput.click();
    });

    document.querySelector('[data-add-video]').addEventListener('click', function () {
        videosInput.click();
    });

    document.querySelector('[data-slug-generate]').addEventListener('click', function () {
        slugInput.value = slugify(nameInput.value);
    });

    /* ---------- gatilhos ---------- */

    const newButton = document.querySelector('[data-product-new]');

    if (newButton) {
        newButton.addEventListener('click', function () {
            resetForm();
            title.textContent = 'Novo produto';
            submit.textContent = 'Adicionar produto';
            openModal();
        });
    }

    document.querySelectorAll('[data-product-edit]').forEach(function (button) {
        button.addEventListener('click', function () {
            const product = products[button.dataset.productEdit];

            if (!product) {
                return;
            }

            resetForm();
            fillForm(product);
            title.textContent = 'Editar produto';
            submit.textContent = 'Salvar alterações';
            openModal();
        });
    });

    // Abre o modal automaticamente quando vier do atalho do dashboard.
    if (new URLSearchParams(window.location.search).get('novo') === '1' && newButton) {
        newButton.click();
    }

    updateMediaEmpty();
    updateShopeeWarning();
}

/* ------------------------------------------------------------
   Slug
   ------------------------------------------------------------ */

function slugify(text) {
    return (text || '')
        .toString()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
}
