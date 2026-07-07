<?php

/**
 * ============================================================
 * Classe Base dos Controllers
 * Projeto: Macramê Nós de Lu
 * ============================================================
 *
 * Responsável por:
 *  - Servir como classe base para todos os Controllers
 *  - Carregar Models
 *  - Carregar Views através do template principal
 * ============================================================
 */

class Controller
{
    /**
     * Carrega um Model da aplicação
     */
    protected function model(string $model): Model
    {
        // Monta o caminho físico do Model solicitado
        $modelFile = MODEL_PATH . '/' . $model . '.php';

        // Verifica se o arquivo do Model existe
        if (!file_exists($modelFile)) {
            die("Erro: Model '{$model}' não encontrado.");
        }

        // Carrega o arquivo do Model
        require_once $modelFile;

        // Verifica se a classe existe
        if (!class_exists($model)) {
            die("Erro: Classe do Model '{$model}' não encontrada.");
        }

        // Retorna uma instância do Model
        return new $model();
    }

    /**
     * Carrega uma View através do template principal
     */
    protected function view(string $view, array $data = []): void
    {
        // Disponibiliza os dados para a View
        extract($data);

        // Monta o caminho físico da View solicitada
        $viewFile = VIEW_PATH . '/' . $view . '.php';

        // Verifica se a View existe
        if (!file_exists($viewFile)) {
            die("Erro: View '{$view}' não encontrada.");
        }

        // Carrega o template principal
        require_once VIEW_PATH . '/layout/template.php';
    }
}
