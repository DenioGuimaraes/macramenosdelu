<?php

/**
 * Links institucionais exibidos no site (footer e contato).
 */
class SiteLink extends Model
{
    public function all(): array
    {
        return $this->fetchAll(
            'SELECT id, link_key, label, url, display, sort_order, is_active
             FROM site_links
             ORDER BY sort_order ASC, id ASC'
        );
    }

    /**
     * Mapa chave => dados, para uso nas views públicas.
     */
    public function map(): array
    {
        $rows = $this->fetchAll(
            'SELECT link_key, label, url, display, is_active
             FROM site_links
             ORDER BY sort_order ASC, id ASC'
        );

        $map = [];

        foreach ($rows as $row) {
            $map[$row['link_key']] = $row;
        }

        return $map;
    }

    public function update(int $id, string $label, string $url, string $display, int $isActive): bool
    {
        $this->run(
            'UPDATE site_links SET label = ?, url = ?, display = ?, is_active = ? WHERE id = ?',
            [$label, $url, $display ?: null, $isActive, $id]
        );

        return true;
    }
}
