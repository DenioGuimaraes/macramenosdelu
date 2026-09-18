<?php

/**
 * Pedidos registrados manualmente pelo painel.
 */
class Order extends Model
{
    public function all(): array
    {
        return $this->fetchAll(
            'SELECT id, customer_name, contact, channel, status, total, notes, created_at
             FROM orders
             ORDER BY created_at DESC, id DESC'
        );
    }

    public function countByStatus(string $status): int
    {
        return (int) $this->fetchValue('SELECT COUNT(*) FROM orders WHERE status = ?', [$status]);
    }

    public function create(array $data): int
    {
        $this->run(
            'INSERT INTO orders (customer_name, contact, channel, status, total, notes)
             VALUES (?, ?, ?, ?, ?, ?)',
            [
                $data['customer_name'],
                $data['contact'] ?: null,
                $data['channel'],
                $data['status'],
                $data['total'],
                $data['notes'] ?: null,
            ]
        );

        return $this->lastId();
    }

    public function updateStatus(int $id, string $status): bool
    {
        $allowed = ['pendente', 'concluido', 'cancelado'];

        if (!in_array($status, $allowed, true)) {
            return false;
        }

        $this->run('UPDATE orders SET status = ? WHERE id = ?', [$status, $id]);

        return true;
    }

    public function delete(int $id): bool
    {
        $this->run('DELETE FROM orders WHERE id = ?', [$id]);

        return true;
    }
}
