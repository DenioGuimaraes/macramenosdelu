<?php

/**
 * ============================================================
 * SiteData
 * Projeto: Macramê Nós de Lu
 * ============================================================
 *
 * Dados usados pelas views públicas (links e textos editáveis).
 * Se o banco estiver indisponível, recorre aos arquivos de
 * configuração para que o site continue no ar.
 * ============================================================
 */

class SiteData
{
    private static ?array $links = null;
    private static ?array $settings = null;

    public static function links(): array
    {
        if (self::$links !== null) {
            return self::$links;
        }

        try {
            $statement = Database::connection()->query(
                'SELECT link_key, label, url, display, is_active
                 FROM site_links
                 ORDER BY sort_order ASC, id ASC'
            );

            $map = [];

            foreach ($statement->fetchAll() as $row) {
                if ((int) $row['is_active'] !== 1) {
                    continue;
                }

                $map[$row['link_key']] = [
                    'label'   => $row['label'],
                    'url'     => $row['url'],
                    'display' => $row['display'] ?? $row['label'],
                ];
            }

            if ($map !== []) {
                return self::$links = $map;
            }
        } catch (Throwable $e) {
            // Segue para o fallback.
        }

        return self::$links = require CONFIG_PATH . '/social.php';
    }

    public static function settings(): array
    {
        if (self::$settings !== null) {
            return self::$settings;
        }

        try {
            $statement = Database::connection()->query(
                'SELECT setting_key, setting_value FROM settings'
            );

            $map = [];

            foreach ($statement->fetchAll() as $row) {
                $map[$row['setting_key']] = $row['setting_value'];
            }

            return self::$settings = $map;
        } catch (Throwable $e) {
            return self::$settings = [];
        }
    }

    public static function setting(string $key, string $default = ''): string
    {
        $settings = self::settings();
        $value = $settings[$key] ?? '';

        return $value === '' || $value === null ? $default : (string) $value;
    }
}
