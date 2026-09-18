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
 *  - Carregar Views através de um template (público ou admin)
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
     * Carrega uma View através do template público
     */
    protected function view(string $view, array $data = []): void
    {
        $this->render($view, $data, 'layout/template');
    }

    /**
     * Carrega uma View do painel administrativo
     */
    protected function adminView(string $view, array $data = []): void
    {
        $this->render($view, $data, 'admin/layout/template');
    }

    /**
     * Carrega uma View sem template (usada na tela de login)
     */
    protected function bareView(string $view, array $data = []): void
    {
        extract($data);

        $viewFile = VIEW_PATH . '/' . $view . '.php';

        if (!file_exists($viewFile)) {
            die("Erro: View '{$view}' não encontrada.");
        }

        require $viewFile;
    }

    /**
     * Redireciona para uma rota interna da aplicação
     */
    protected function redirect(string $route): void
    {
        header('Location: index.php?url=' . $route);
        exit;
    }

    /**
     * Responde em JSON (usado pelas ações assíncronas do painel)
     */
    protected function json(array $payload, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($payload, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Renderiza a View dentro do template informado
     */
    private function render(string $view, array $data, string $template): void
    {
        // Disponibiliza os dados para a View
        extract($data);

        // Monta o caminho físico da View solicitada
        $viewFile = VIEW_PATH . '/' . $view . '.php';

        // Verifica se a View existe
        if (!file_exists($viewFile)) {
            die("Erro: View '{$view}' não encontrada.");
        }

        // Carrega o template escolhido
        require VIEW_PATH . '/' . $template . '.php';
    }
}
