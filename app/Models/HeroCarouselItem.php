<?php

/**
 * Sequência de mídias do carrossel ao lado do hero na home.
 */
class HeroCarouselItem extends Model
{
    public function all(): array
    {
        return $this->fetchAll(
            'SELECT id, media_type, file_path, sort_order, created_at
             FROM hero_carousel_items
             ORDER BY sort_order ASC, id ASC'
        );
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne('SELECT * FROM hero_carousel_items WHERE id = ? LIMIT 1', [$id]);
    }

    public function create(string $mediaType, string $path, int $sortOrder = 0): int
    {
        $this->run(
            'INSERT INTO hero_carousel_items (media_type, file_path, sort_order) VALUES (?, ?, ?)',
            [$mediaType, $path, $sortOrder]
        );

        return $this->lastId();
    }

    public function delete(int $id): bool
    {
        $this->run('DELETE FROM hero_carousel_items WHERE id = ?', [$id]);

        return true;
    }

    public function nextOrder(): int
    {
        $max = $this->fetchValue('SELECT MAX(sort_order) FROM hero_carousel_items');

        return $max === null ? 0 : ((int) $max) + 1;
    }

    public function move(int $id, string $direction): bool
    {
        $current = $this->find($id);

        if ($current === null) {
            return false;
        }

        if ($direction === 'up') {
            $neighbor = $this->fetchOne(
                'SELECT id, sort_order FROM hero_carousel_items
                 WHERE sort_order < ? OR (sort_order = ? AND id < ?)
                 ORDER BY sort_order DESC, id DESC
                 LIMIT 1',
                [(int) $current['sort_order'], (int) $current['sort_order'], (int) $current['id']]
            );
        } else {
            $neighbor = $this->fetchOne(
                'SELECT id, sort_order FROM hero_carousel_items
                 WHERE sort_order > ? OR (sort_order = ? AND id > ?)
                 ORDER BY sort_order ASC, id ASC
                 LIMIT 1',
                [(int) $current['sort_order'], (int) $current['sort_order'], (int) $current['id']]
            );
        }

        if ($neighbor === null) {
            return false;
        }

        $this->run(
            'UPDATE hero_carousel_items SET sort_order = ? WHERE id = ?',
            [(int) $neighbor['sort_order'], (int) $current['id']]
        );
        $this->run(
            'UPDATE hero_carousel_items SET sort_order = ? WHERE id = ?',
            [(int) $current['sort_order'], (int) $neighbor['id']]
        );

        return true;
    }
}
