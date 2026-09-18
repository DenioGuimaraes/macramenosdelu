<?php

/**
 * Ícone de canal de contato.
 * $channel: whatsapp | email | instagram | tiktok
 */

$channel = $channel ?? '';

?>
<span class="contact-channel-card__icon" aria-hidden="true">
<?php if ($channel === 'whatsapp') : ?>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M8.5 16.5 7 21l4.5-1.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        <path d="M7 17.5A8.5 8.5 0 1 1 16.5 8c0 1.6-.45 3.1-1.2 4.4L7 17.5z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
    </svg>
<?php elseif ($channel === 'email') : ?>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.5" />
        <path d="m3 7 9 6 9-6" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
    </svg>
<?php elseif ($channel === 'instagram') : ?>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="4" y="4" width="16" height="16" rx="4" stroke="currentColor" stroke-width="1.5" />
        <circle cx="12" cy="12" r="3.5" stroke="currentColor" stroke-width="1.5" />
        <circle cx="17.2" cy="6.8" r="1" fill="currentColor" />
    </svg>
<?php elseif ($channel === 'tiktok') : ?>
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M14 4v8.2a4 4 0 1 1-2.8-3.8V8.5c1.2.9 2.6 1.5 4.2 1.6V4H14z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
    </svg>
<?php endif; ?>
</span>
