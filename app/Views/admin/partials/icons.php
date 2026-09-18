<?php

/**
 * Ícones line-art do painel administrativo.
 */

if (!function_exists('admin_icon')) {

    function admin_icon(string $name, string $class = 'icon'): string
    {
        $paths = [
            'dashboard' => '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>',
            'package'   => '<path d="M12 22V12"/><path d="M12 12 2 7l10-5 10 5-10 5z"/><path d="M6 9.5V16l6 3 6-3V9.5"/>',
            'tag'       => '<path d="M3 11V5a2 2 0 0 1 2-2h6l10 10-8 8L3 11z"/><circle cx="7.5" cy="7.5" r="1.2"/>',
            'layers'    => '<path d="M12 3 3 7.5 12 12l9-4.5L12 3z"/><path d="m3 12.5 9 4.5 9-4.5"/><path d="m3 17 9 4.5 9-4.5"/>',
            'cart'      => '<path d="M6 6h15l-1.5 9h-12L5 3H2"/><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/>',
            'clipboard' => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4h6v3H9z"/><path d="M9 12h6"/><path d="M9 16h4"/>',
            'image'     => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="8.5" cy="9.5" r="1.5"/><path d="m21 16-5-5-4 4-2-2-7 7"/>',
            'home'      => '<path d="M3 10.5 12 3l9 7.5"/><path d="M5.5 9.5V20a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1V9.5"/><path d="M10 21v-6h4v6"/>',
            'link'      => '<path d="M10 13a5 5 0 0 0 7.5.5l2-2A5 5 0 0 0 12.5 4.5l-1 1"/><path d="M14 11a5 5 0 0 0-7.5-.5l-2 2A5 5 0 0 0 11.5 19.5l1-1"/>',
            'users'     => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7"/><path d="M18 20a6.5 6.5 0 0 0-3-5.5"/>',
            'settings'  => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.6 1.6 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.6 1.6 0 0 0-2.7 1.1V21a2 2 0 1 1-4 0v-.1A1.6 1.6 0 0 0 7.5 19.4l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1A1.6 1.6 0 0 0 3 14.6a2 2 0 1 1 0-4 1.6 1.6 0 0 0 1.7-2.6l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1A1.6 1.6 0 0 0 10.2 3H10a2 2 0 1 1 4 0 1.6 1.6 0 0 0 2.6 1.7l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1A1.6 1.6 0 0 0 21 10.2h.1a2 2 0 1 1 0 4H21a1.6 1.6 0 0 0-1.6 .8z"/>',
            'external'  => '<path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M19 13v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h7"/>',
            'logout'    => '<path d="M9 21H5a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/>',
            'sun'       => '<circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.9 4.9 1.4 1.4"/><path d="m17.7 17.7 1.4 1.4"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m4.9 19.1 1.4-1.4"/><path d="m17.7 6.3 1.4-1.4"/>',
            'search'    => '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>',
            'plus'      => '<path d="M12 5v14"/><path d="M5 12h14"/>',
            'pencil'    => '<path d="M4 20h4L20 8a2.8 2.8 0 0 0-4-4L4 16v4z"/><path d="m14 6 4 4"/>',
            'pause'     => '<circle cx="12" cy="12" r="9"/><path d="M10 9v6"/><path d="M14 9v6"/>',
            'play'      => '<circle cx="12" cy="12" r="9"/><path d="m10 8.5 6 3.5-6 3.5z"/>',
            'trash'     => '<path d="M4 7h16"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M6 7l1 13a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1l1-13"/><path d="M9 7V4h6v3"/>',
            'check'     => '<circle cx="12" cy="12" r="9"/><path d="m8.5 12.5 2.5 2.5 4.5-5"/>',
            'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
            'refresh'   => '<path d="M3 12a9 9 0 0 1 15.3-6.4L21 8"/><path d="M21 4v4h-4"/><path d="M21 12a9 9 0 0 1-15.3 6.4L3 16"/><path d="M3 20v-4h4"/>',
            'video'     => '<rect x="3" y="6" width="12" height="12" rx="2"/><path d="m15 10 6-3v10l-6-3z"/>',
            'arrow'     => '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
            'close'     => '<path d="m6 6 12 12"/><path d="m18 6-12 12"/>',
            'lock'      => '<rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>',
            'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        ];

        $content = $paths[$name] ?? '';

        return '<svg class="' . htmlspecialchars($class, ENT_QUOTES, 'UTF-8') . '" viewBox="0 0 24 24" fill="none" '
            . 'stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" '
            . 'xmlns="http://www.w3.org/2000/svg" aria-hidden="true">' . $content . '</svg>';
    }
}

if (!function_exists('admin_date_br')) {

    function admin_date_br(?string $datetime = null, bool $short = true): string
    {
        $timestamp = $datetime === null ? time() : strtotime($datetime);

        $weekdays = ['dom.', 'seg.', 'ter.', 'qua.', 'qui.', 'sex.', 'sáb.'];
        $months = ['jan.', 'fev.', 'mar.', 'abr.', 'mai.', 'jun.', 'jul.', 'ago.', 'set.', 'out.', 'nov.', 'dez.'];

        $weekday = $weekdays[(int) date('w', $timestamp)];
        $day = (int) date('j', $timestamp);
        $month = $months[(int) date('n', $timestamp) - 1];

        if ($short) {
            return sprintf('%s, %d de %s', $weekday, $day, $month);
        }

        return sprintf('%d de %s, %s', $day, $month, date('H:i', $timestamp));
    }
}

if (!function_exists('admin_greeting')) {

    function admin_greeting(): string
    {
        $hour = (int) date('G');

        if ($hour < 12) {
            return 'Bom dia';
        }

        if ($hour < 18) {
            return 'Boa tarde';
        }

        return 'Boa noite';
    }
}

if (!function_exists('admin_money')) {

    function admin_money($value): string
    {
        return 'R$ ' . number_format((float) $value, 2, ',', '.');
    }
}

if (!function_exists('e')) {

    function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}
