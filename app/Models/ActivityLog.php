<?php

/**
 * Registro de alterações recentes exibido no dashboard.
 */
class ActivityLog extends Model
{
    public function record(string $entityType, ?int $entityId, string $action, string $description): void
    {
        $this->run(
            'INSERT INTO activity_log (entity_type, entity_id, action, description)
             VALUES (?, ?, ?, ?)',
            [$entityType, $entityId, $action, $description]
        );
    }

    public function recent(int $limit = 6): array
    {
        $limit = max(1, min(50, $limit));

        return $this->fetchAll(
            'SELECT entity_type, entity_id, action, description, created_at
             FROM activity_log
             ORDER BY created_at DESC, id DESC
             LIMIT ' . $limit
        );
    }
}
