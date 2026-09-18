<?php

/**
 * ============================================================
 * Database
 * Projeto: Macramê Nós de Lu
 * ============================================================
 *
 * Conexão PDO única com o MySQL do XAMPP.
 * Todas as consultas da aplicação usam prepared statements.
 * ============================================================
 */

class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $config = require CONFIG_PATH . '/config.php';
        $db = $config['database'];

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $db['host'],
            $db['database'],
            $db['charset']
        );

        try {
            self::$connection = new PDO($dsn, $db['user'], $db['password'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('Erro de conexão com o banco de dados: ' . $e->getMessage());
        }

        return self::$connection;
    }
}
