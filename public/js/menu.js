document.addEventListener('DOMContentLoaded', function () {

    const menuToggle = document.querySelector('.menu-toggle');
    const menuClose = document.querySelector('.menu-close');
    const drawer = document.querySelector('.main-menu--drawer');
    const overlay = document.querySelector('.menu-overlay');

    if (!menuToggle || !drawer || !overlay) {
        return;
    }

    function isDesktopNav() {
        return window.matchMedia('(min-width: 1024px)').matches;
    }

    function setMenuOpen(open) {
        if (isDesktopNav()) {
            return;
        }

        drawer.hidden = !open;
        overlay.hidden = !open;
        overlay.classList.toggle('is-visible', open);
        drawer.classList.toggle('is-open', open);
        document.body.classList.toggle('menu-open', open);
        menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        menuToggle.setAttribute('aria-label', open ? 'Fechar menu' : 'Abrir menu');
        menuToggle.textContent = open ? '×' : '☰';
    }

    function closeMenu() {
        setMenuOpen(false);
    }

    function openMenu() {
        setMenuOpen(true);
    }

    menuToggle.addEventListener('click', function () {
        const isOpen = drawer.classList.contains('is-open');
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    if (menuClose) {
        menuClose.addEventListener('click', closeMenu);
    }

    overlay.addEventListener('click', closeMenu);

    drawer.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && drawer.classList.contains('is-open')) {
            closeMenu();
            menuToggle.focus();
        }
    });

    window.addEventListener('resize', function () {
        if (isDesktopNav()) {
            closeMenu();
            drawer.hidden = true;
            overlay.hidden = true;
        }
    });
});

/* Galeria da página de produto */

document.addEventListener('DOMContentLoaded', function () {

    const mainImage = document.getElementById('product-main-image');
    const thumbs = document.querySelectorAll('.product-detail__thumb');

    if (!mainImage || thumbs.length === 0) {
        return;
    }

    thumbs.forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            mainImage.src = thumb.dataset.image;

            thumbs.forEach(function (item) {
                item.classList.toggle('is-active', item === thumb);
            });
        });
    });
});
