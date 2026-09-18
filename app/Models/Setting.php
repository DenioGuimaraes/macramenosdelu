<?php

/**
 * Configurações gerais (chave/valor).
 */
class Setting extends Model
{
    public function map(): array
    {
        $rows = $this->fetchAll('SELECT setting_key, setting_value FROM settings');

        $map = [];

        foreach ($rows as $row) {
            $map[$row['setting_key']] = $row['setting_value'];
        }

        return $map;
    }

    public function get(string $key, ?string $default = null): ?string
    {
        $value = $this->fetchValue(
            'SELECT setting_value FROM settings WHERE setting_key = ? LIMIT 1',
            [$key]
        );

        return $value === null ? $default : (string) $value;
    }

    public function set(string $key, ?string $value): bool
    {
        $this->run(
            'INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)',
            [$key, $value]
        );

        return true;
    }
}
