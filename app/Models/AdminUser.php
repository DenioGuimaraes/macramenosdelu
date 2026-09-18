<?php

/**
 * Administradores do painel.
 */
class AdminUser extends Model
{
    public function findByEmail(string $email): ?array
    {
        return $this->fetchOne(
            'SELECT id, name, email, password_hash FROM admin_users WHERE email = ? LIMIT 1',
            [$email]
        );
    }

    public function find(int $id): ?array
    {
        return $this->fetchOne(
            'SELECT id, name, email, created_at FROM admin_users WHERE id = ? LIMIT 1',
            [$id]
        );
    }

    public function all(): array
    {
        return $this->fetchAll(
            'SELECT id, name, email, created_at, updated_at FROM admin_users ORDER BY name ASC'
        );
    }

    /**
     * Valida credenciais. Consulta parametrizada — imune a SQL injection.
     */
    public function verifyPassword(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        if ($user === null || !password_verify($password, $user['password_hash'])) {
            return null;
        }

        unset($user['password_hash']);

        return $user;
    }

    public function updatePassword(int $id, string $newPassword): bool
    {
        $hash = password_hash($newPassword, PASSWORD_DEFAULT);

        $this->run('UPDATE admin_users SET password_hash = ? WHERE id = ?', [$hash, $id]);

        return true;
    }

    public function updateName(int $id, string $name): bool
    {
        $this->run('UPDATE admin_users SET name = ? WHERE id = ?', [$name, $id]);

        return true;
    }
}
