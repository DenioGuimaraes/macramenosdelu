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

/* Carrossel do hero (home) */

document.addEventListener('DOMContentLoaded', function () {

    const root = document.querySelector('[data-hero-carousel]');

    if (!root) {
        return;
    }

    const slides = Array.from(root.querySelectorAll('.hero-carousel__slide'));

    if (slides.length <= 1) {
        const only = slides[0];

        if (only && only.dataset.mediaType === 'video') {
            const video = only.querySelector('video');

            if (video) {
                video.muted = true;
                video.play().catch(function () {
                    /* autoplay bloqueado */
                });
            }
        }

        return;
    }

    let index = slides.findIndex(function (slide) {
        return slide.classList.contains('is-active');
    });

    if (index < 0) {
        index = 0;
    }

    let timer = null;

    function clearTimer() {
        if (timer !== null) {
            window.clearTimeout(timer);
            timer = null;
        }
    }

    function pauseAllVideos() {
        slides.forEach(function (slide) {
            const video = slide.querySelector('video');

            if (video) {
                video.pause();
                video.currentTime = 0;
            }
        });
    }

    function showSlide(nextIndex) {
        clearTimer();
        pauseAllVideos();

        index = (nextIndex + slides.length) % slides.length;

        slides.forEach(function (slide, slideIndex) {
            slide.classList.toggle('is-active', slideIndex === index);
        });

        const active = slides[index];
        const mediaType = active.dataset.mediaType;

        if (mediaType === 'video') {
            const video = active.querySelector('video');

            if (!video) {
                timer = window.setTimeout(function () {
                    showSlide(index + 1);
                }, 3000);

                return;
            }

            video.muted = true;

            const onEnded = function () {
                video.removeEventListener('ended', onEnded);
                showSlide(index + 1);
            };

            video.addEventListener('ended', onEnded);
            video.play().catch(function () {
                timer = window.setTimeout(function () {
                    showSlide(index + 1);
                }, 3000);
            });

            return;
        }

        timer = window.setTimeout(function () {
            showSlide(index + 1);
        }, 3000);
    }

    showSlide(index);
});
