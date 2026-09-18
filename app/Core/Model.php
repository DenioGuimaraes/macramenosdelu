<?php

/**
 * ============================================================
 * Classe Base dos Models
 * Projeto: Macramê Nós de Lu
 * ============================================================
 *
 * Fornece atalhos de consulta sobre a conexão PDO.
 * Todos os métodos usam prepared statements.
 * ============================================================
 */

abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    /**
     * Executa uma instrução e devolve o statement.
     */
    protected function run(string $sql, array $params = []): PDOStatement
    {
        $statement = $this->db->prepare($sql);
        $statement->execute($params);

        return $statement;
    }

    /**
     * Retorna todas as linhas de uma consulta.
     */
    protected function fetchAll(string $sql, array $params = []): array
    {
        return $this->run($sql, $params)->fetchAll();
    }

    /**
     * Retorna a primeira linha de uma consulta.
     */
    protected function fetchOne(string $sql, array $params = []): ?array
    {
        $row = $this->run($sql, $params)->fetch();

        return $row === false ? null : $row;
    }

    /**
     * Retorna o valor da primeira coluna da primeira linha.
     */
    protected function fetchValue(string $sql, array $params = [])
    {
        $value = $this->run($sql, $params)->fetchColumn();

        return $value === false ? null : $value;
    }

    /**
     * Último ID inserido.
     */
    protected function lastId(): int
    {
        return (int) $this->db->lastInsertId();
    }

    /**
     * Gera um slug simples a partir de um texto.
     */
    public static function slugify(string $text): string
    {
        $map = [
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n',
        ];

        $text = strtr(mb_strtolower(trim($text), 'UTF-8'), $map);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);

        return trim((string) $text, '-');
    }
}
