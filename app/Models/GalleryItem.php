<?php

/**
 * Itens da galeria do site.
 */
class GalleryItem extends Model
{
    public function all(): array
    {
        return $this->fetchAll(
            'SELECT id, title, file_path, sort_order, is_active, created_at
             FROM gallery_items
             ORDER BY sort_order ASC, id ASC'
        );
    }

    public function active(): array
    {
        return $this->fetchAll(
            'SELECT id, title, file_path
             FROM gallery_items
             WHERE is_active = 1
             ORDER BY sort_order ASC, id ASC'
        );
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne('SELECT * FROM gallery_items WHERE id = ? LIMIT 1', [$id]);
    }

    public function create(string $title, string $path, int $sortOrder = 0): int
    {
        $this->run(
            'INSERT INTO gallery_items (title, file_path, sort_order) VALUES (?, ?, ?)',
            [$title ?: null, $path, $sortOrder]
        );

        return $this->lastId();
    }

    public function delete(int $id): bool
    {
        $this->run('DELETE FROM gallery_items WHERE id = ?', [$id]);

        return true;
    }

    public function count(): int
    {
        return (int) $this->fetchValue('SELECT COUNT(*) FROM gallery_items');
    }

    public function nextOrder(): int
    {
        $max = $this->fetchValue('SELECT MAX(sort_order) FROM gallery_items');

        return $max === null ? 0 : ((int) $max) + 1;
    }
}
