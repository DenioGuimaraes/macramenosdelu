<?php

/**
 * Produtos do catálogo.
 */
class Product extends Model
{
    /**
     * Campos aceitos no cadastro/edição.
     */
    private const FIELDS = [
        'name',
        'category_id',
        'price',
        'status',
        'stock_qty',
        'shopee_url',
        'short_description',
        'description',
        'material',
        'dimensions',
        'colors',
        'production_time',
        'artisan_note',
        'care_instructions',
    ];

    /**
     * Listagem do painel, com filtros opcionais.
     */
    public function search(string $term = '', ?int $categoryId = null): array
    {
        $sql = 'SELECT p.*, c.name AS category_name,
                       (SELECT m.file_path FROM product_media m
                         WHERE m.product_id = p.id AND m.media_type = "image"
                         ORDER BY m.sort_order ASC, m.id ASC LIMIT 1) AS cover_image
                FROM products p
                LEFT JOIN categories c ON c.id = p.category_id
                WHERE 1 = 1';

        $params = [];

        if ($term !== '') {
            $sql .= ' AND p.name LIKE ?';
            $params[] = '%' . $term . '%';
        }

        if ($categoryId !== null) {
            $sql .= ' AND p.category_id = ?';
            $params[] = $categoryId;
        }

        $sql .= ' ORDER BY p.name ASC';

        return $this->fetchAll($sql, $params);
    }

    /**
     * Produtos publicados na loja.
     */
    public function published(?string $categorySlug = null): array
    {
        $sql = 'SELECT p.*, c.name AS category_name, c.slug AS category_slug,
                       (SELECT m.file_path FROM product_media m
                         WHERE m.product_id = p.id AND m.media_type = "image"
                         ORDER BY m.sort_order ASC, m.id ASC LIMIT 1) AS cover_image
                FROM products p
                LEFT JOIN categories c ON c.id = p.category_id
                WHERE p.status = "ativo"';

        $params = [];

        if ($categorySlug !== null && $categorySlug !== '') {
            $sql .= ' AND c.slug = ?';
            $params[] = $categorySlug;
        }

        $sql .= ' ORDER BY p.name ASC';

        return $this->fetchAll($sql, $params);
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.id = ? LIMIT 1',
            [$id]
        );
    }

    public function findBySlug(string $slug): ?array
    {
        return $this->fetchOne(
            'SELECT p.*, c.name AS category_name, c.slug AS category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.slug = ? LIMIT 1',
            [$slug]
        );
    }

    public function media(int $productId): array
    {
        return $this->fetchAll(
            'SELECT id, media_type, file_path, sort_order
             FROM product_media
             WHERE product_id = ?
             ORDER BY sort_order ASC, id ASC',
            [$productId]
        );
    }

    public function create(array $data): int
    {
        $slug = $this->uniqueSlug($data['slug'] ?? '', $data['name'] ?? '');

        $this->run(
            'INSERT INTO products
                (name, slug, category_id, price, status, stock_qty, shopee_url,
                 short_description, description, material, dimensions, colors,
                 production_time, artisan_note, care_instructions)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $data['name'],
                $slug,
                $data['category_id'] ?: null,
                $data['price'],
                $data['status'],
                $data['stock_qty'],
                $data['shopee_url'] ?: null,
                $data['short_description'] ?: null,
                $data['description'] ?: null,
                $data['material'] ?: null,
                $data['dimensions'] ?: null,
                $data['colors'] ?: null,
                $data['production_time'] ?: null,
                $data['artisan_note'] ?: null,
                $data['care_instructions'] ?: null,
            ]
        );

        return $this->lastId();
    }

    public function update(int $id, array $data): bool
    {
        $slug = $this->uniqueSlug($data['slug'] ?? '', $data['name'] ?? '', $id);

        $this->run(
            'UPDATE products SET
                name = ?, slug = ?, category_id = ?, price = ?, status = ?, stock_qty = ?,
                shopee_url = ?, short_description = ?, description = ?, material = ?,
                dimensions = ?, colors = ?, production_time = ?, artisan_note = ?,
                care_instructions = ?
             WHERE id = ?',
            [
                $data['name'],
                $slug,
                $data['category_id'] ?: null,
                $data['price'],
                $data['status'],
                $data['stock_qty'],
                $data['shopee_url'] ?: null,
                $data['short_description'] ?: null,
                $data['description'] ?: null,
                $data['material'] ?: null,
                $data['dimensions'] ?: null,
                $data['colors'] ?: null,
                $data['production_time'] ?: null,
                $data['artisan_note'] ?: null,
                $data['care_instructions'] ?: null,
                $id,
            ]
        );

        return true;
    }

    public function toggleStatus(int $id): string
    {
        $current = $this->fetchValue('SELECT status FROM products WHERE id = ? LIMIT 1', [$id]);
        $next = $current === 'ativo' ? 'pausado' : 'ativo';

        $this->run('UPDATE products SET status = ? WHERE id = ?', [$next, $id]);

        return $next;
    }

    public function updateStock(int $id, int $quantity): bool
    {
        $this->run('UPDATE products SET stock_qty = ? WHERE id = ?', [max(0, $quantity), $id]);

        return true;
    }

    public function delete(int $id): bool
    {
        $this->run('DELETE FROM products WHERE id = ?', [$id]);

        return true;
    }

    public function addMedia(int $productId, string $type, string $path, int $sortOrder = 0): int
    {
        $this->run(
            'INSERT INTO product_media (product_id, media_type, file_path, sort_order)
             VALUES (?, ?, ?, ?)',
            [$productId, $type, $path, $sortOrder]
        );

        return $this->lastId();
    }

    /**
     * Mídias de todos os produtos, agrupadas por produto.
     */
    public function allMediaGrouped(): array
    {
        $rows = $this->fetchAll(
            'SELECT id, product_id, media_type, file_path, sort_order
             FROM product_media
             ORDER BY product_id ASC, sort_order ASC, id ASC'
        );

        $grouped = [];

        foreach ($rows as $row) {
            $grouped[(int) $row['product_id']][] = $row;
        }

        return $grouped;
    }

    public function findMedia(int $mediaId): ?array
    {
        return $this->fetchOne('SELECT * FROM product_media WHERE id = ? LIMIT 1', [$mediaId]);
    }

    public function deleteMedia(int $mediaId): bool
    {
        $this->run('DELETE FROM product_media WHERE id = ?', [$mediaId]);

        return true;
    }

    public function nextMediaOrder(int $productId): int
    {
        $max = $this->fetchValue(
            'SELECT MAX(sort_order) FROM product_media WHERE product_id = ?',
            [$productId]
        );

        return $max === null ? 0 : ((int) $max) + 1;
    }

    // --------------------------------------------------------
    // Métricas do painel
    // --------------------------------------------------------

    public function countAll(): int
    {
        return (int) $this->fetchValue('SELECT COUNT(*) FROM products');
    }

    public function countByStatus(string $status): int
    {
        return (int) $this->fetchValue('SELECT COUNT(*) FROM products WHERE status = ?', [$status]);
    }

    public function lowStock(int $threshold = 3): array
    {
        return $this->fetchAll(
            'SELECT p.id, p.name, p.stock_qty, c.name AS category_name,
                    (SELECT m.file_path FROM product_media m
                      WHERE m.product_id = p.id AND m.media_type = "image"
                      ORDER BY m.sort_order ASC, m.id ASC LIMIT 1) AS cover_image
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.stock_qty <= ?
             ORDER BY p.stock_qty ASC, p.name ASC',
            [$threshold]
        );
    }

    public function stockList(): array
    {
        return $this->fetchAll(
            'SELECT p.id, p.name, p.stock_qty, p.status, c.name AS category_name
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             ORDER BY p.stock_qty ASC, p.name ASC'
        );
    }

    /**
     * Normaliza os dados vindos do formulário do painel.
     */
    public static function sanitizeInput(array $input): array
    {
        $data = [];

        foreach (self::FIELDS as $field) {
            $data[$field] = isset($input[$field]) ? trim((string) $input[$field]) : '';
        }

        $data['slug'] = isset($input['slug']) ? trim((string) $input['slug']) : '';
        $data['category_id'] = $data['category_id'] === '' ? null : (int) $data['category_id'];
        $data['price'] = self::parsePrice($data['price']);
        $data['stock_qty'] = (int) ($data['stock_qty'] !== '' ? $data['stock_qty'] : 0);
        $data['status'] = $data['status'] === 'pausado' ? 'pausado' : 'ativo';

        return $data;
    }

    /**
     * Aceita "180", "180,00" e "1.180,50".
     */
    private static function parsePrice(string $raw): float
    {
        if ($raw === '') {
            return 0.0;
        }

        $normalized = str_replace(' ', '', $raw);

        if (str_contains($normalized, ',')) {
            $normalized = str_replace('.', '', $normalized);
            $normalized = str_replace(',', '.', $normalized);
        }

        return round((float) $normalized, 2);
    }

    private function uniqueSlug(string $slug, string $name, ?int $ignoreId = null): string
    {
        $base = self::slugify($slug !== '' ? $slug : $name);
        $base = $base === '' ? 'produto' : $base;

        $candidate = $base;
        $suffix = 2;

        while (true) {
            $sql = 'SELECT id FROM products WHERE slug = ?';
            $params = [$candidate];

            if ($ignoreId !== null) {
                $sql .= ' AND id <> ?';
                $params[] = $ignoreId;
            }

            if ($this->fetchValue($sql . ' LIMIT 1', $params) === null) {
                return $candidate;
            }

            $candidate = $base . '-' . $suffix;
            $suffix++;
        }
    }
}
