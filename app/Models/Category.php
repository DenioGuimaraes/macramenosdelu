<?php

/**
 * Categorias de produtos.
 */
class Category extends Model
{
    public function all(): array
    {
        return $this->fetchAll(
            'SELECT id, name, slug, sort_order, is_active
             FROM categories
             ORDER BY sort_order ASC, name ASC'
        );
    }

    public function active(): array
    {
        return $this->fetchAll(
            'SELECT id, name, slug
             FROM categories
             WHERE is_active = 1
             ORDER BY sort_order ASC, name ASC'
        );
    }

    public function withProductCount(): array
    {
        return $this->fetchAll(
            'SELECT c.id, c.name, c.slug, c.sort_order, c.is_active,
                    COUNT(p.id) AS total_products
             FROM categories c
             LEFT JOIN products p ON p.category_id = c.id
             GROUP BY c.id, c.name, c.slug, c.sort_order, c.is_active
             ORDER BY c.sort_order ASC, c.name ASC'
        );
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne('SELECT * FROM categories WHERE id = ? LIMIT 1', [$id]);
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->fetchOne('SELECT * FROM categories WHERE slug = ? LIMIT 1', [$slug]);
    }

    public function create(string $name, int $sortOrder = 0): int
    {
        $slug = $this->uniqueSlug(self::slugify($name));

        $this->run(
            'INSERT INTO categories (name, slug, sort_order) VALUES (?, ?, ?)',
            [$name, $slug, $sortOrder]
        );

        return $this->lastId();
    }

    public function update(int $id, string $name, int $sortOrder, int $isActive): bool
    {
        $this->run(
            'UPDATE categories SET name = ?, sort_order = ?, is_active = ? WHERE id = ?',
            [$name, $sortOrder, $isActive, $id]
        );

        return true;
    }

    public function delete(int $id): bool
    {
        $this->run('DELETE FROM categories WHERE id = ?', [$id]);

        return true;
    }

    public function count(): int
    {
        return (int) $this->fetchValue('SELECT COUNT(*) FROM categories');
    }

    private function uniqueSlug(string $base): string
    {
        $slug = $base === '' ? 'categoria' : $base;
        $candidate = $slug;
        $suffix = 2;

        while ($this->fetchValue('SELECT id FROM categories WHERE slug = ? LIMIT 1', [$candidate]) !== null) {
            $candidate = $slug . '-' . $suffix;
            $suffix++;
        }

        return $candidate;
    }
}
