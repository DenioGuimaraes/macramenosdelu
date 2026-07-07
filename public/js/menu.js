//alert('menu.js carregado com sucesso');

document.addEventListener('DOMContentLoaded', function () {

    const menuToggle = document.querySelector('.menu-toggle');
    const mainMenu = document.querySelector('.main-menu');

    if (!menuToggle || !mainMenu) {
        return;
    }

    menuToggle.addEventListener('click', function () {

        mainMenu.classList.toggle('active');

        const menuAberto = mainMenu.classList.contains('active');

        menuToggle.setAttribute('aria-expanded', menuAberto ? 'true' : 'false');
        menuToggle.setAttribute('aria-label', menuAberto ? 'Fechar menu' : 'Abrir menu');

        menuToggle.textContent = menuAberto ? '×' : '☰';

    });

});