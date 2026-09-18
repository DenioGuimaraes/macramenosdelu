<?php

/**
 * ============================================================
 * Auth
 * Projeto: Macramê Nós de Lu
 * ============================================================
 *
 * Sessão do administrador do painel (/admin).
 * O site público não possui autenticação.
 * ============================================================
 */

class Auth
{
    private const SESSION_KEY = 'admin_user';

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(array $user): void
    {
        self::start();
        session_regenerate_id(true);

        $_SESSION[self::SESSION_KEY] = [
            'id'    => (int) $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
        ];
    }

    public static function logout(): void
    {
        self::start();
        unset($_SESSION[self::SESSION_KEY]);
        session_regenerate_id(true);
    }

    public static function check(): bool
    {
        self::start();

        return isset($_SESSION[self::SESSION_KEY]['id']);
    }

    public static function user(): ?array
    {
        self::start();

        return $_SESSION[self::SESSION_KEY] ?? null;
    }

    public static function id(): ?int
    {
        $user = self::user();

        return $user === null ? null : (int) $user['id'];
    }

    /**
     * Token CSRF simples para os formulários do painel.
     */
    public static function csrfToken(): string
    {
        self::start();

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function csrfValid(?string $token): bool
    {
        self::start();

        return is_string($token)
            && !empty($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $token);
    }

    /**
     * Mensagem de status entre redirecionamentos.
     */
    public static function flash(?string $message = null, string $type = 'success'): ?array
    {
        self::start();

        if ($message !== null) {
            $_SESSION['flash'] = ['message' => $message, 'type' => $type];

            return null;
        }

        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        return $flash;
    }
}
