<?php

/**
 * Ícones line-art dos diferenciais (referência visual do site aprovado).
 * Uso: require com $icon = 'hammer' | 'star' | 'leaf' | 'truck'
 */

$icon = $icon ?? '';

?>
<span class="benefit__icon" aria-hidden="true">
<?php if ($icon === 'hammer') : ?>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
<?php elseif ($icon === 'star') : ?>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 3.5l2.35 4.76 5.25.77-3.8 3.7.9 5.24L12 15.9l-4.7 2.47.9-5.24-3.8-3.7 5.25-.77L12 3.5z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
    </svg>
<?php elseif ($icon === 'leaf') : ?>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.5 18 2c1 2.5 2 4.5 2 8a6 6 0 0 1-9 10z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M12 12c-2 2-4 5-4 8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
    </svg>
<?php elseif ($icon === 'truck') : ?>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M15 18H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-8.582-2.876a2 2 0 0 0-1.368.894V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M2 18h1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        <circle cx="7" cy="18" r="2" stroke="currentColor" stroke-width="1.5" />
        <circle cx="17" cy="18" r="2" stroke="currentColor" stroke-width="1.5" />
    </svg>
<?php endif; ?>
</span>
