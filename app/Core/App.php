<?php

/**
 * ============================================================
 * App
 * Projeto: Macramê Nós de Lu
 * ============================================================
 *
 * Responsável por:
 *  - Interpretar a URL
 *  - Definir qual Controller será usado
 *  - Definir qual método será executado
 *  - Enviar parâmetros para o método, quando existirem
 * ============================================================
 */

class App
{
    /**
     * Controller padrão
     */
    private string $controller = 'HomeController';

    /**
     * Método padrão
     */
    private string $method = 'index';

    /**
     * Parâmetros da URL
     */
    private array $params = [];

    /**
     * Inicializa a aplicação
     */
    public function run(): void
    {
        $url = $this->getUrl();

        // ----------------------------------------------------
        // Controller
        // ----------------------------------------------------

        if (!empty($url[0])) {

            $controllerName = ucfirst($url[0]) . 'Controller';
            $controllerFile = CONTROLLER_PATH . '/' . $controllerName . '.php';

            if (file_exists($controllerFile)) {

                $this->controller = $controllerName;
                unset($url[0]);
            } else {

                // Endereço inexistente: página 404.
                http_response_code(404);

                $this->controller = 'ErroController';
                $url = [];
            }
        }

        // Carrega o arquivo do Controller
        require_once CONTROLLER_PATH . '/' . $this->controller . '.php';

        // Verifica se a classe do Controller existe
        if (!class_exists($this->controller)) {
            die("Erro: Classe '{$this->controller}' não encontrada.");
        }

        // Instancia o Controller
        $controllerObject = new $this->controller();

        // ----------------------------------------------------
        // Método
        // ----------------------------------------------------

        // Quando o segmento corresponde a um método público, ele define a
        // ação. Caso contrário, segue como parâmetro de index()
        // — é o que permite endereços como /produto/nome-da-peca.

        if (!empty($url[1])) {

            $methodName = $url[1];

            if ($methodName !== 'index' && is_callable([$controllerObject, $methodName])) {

                $this->method = $methodName;
                unset($url[1]);
            }
        }

        // ----------------------------------------------------
        // Parâmetros
        // ----------------------------------------------------

        $this->params = $url ? array_values($url) : [];

        // Executa o método do Controller
        call_user_func_array(
            [$controllerObject, $this->method],
            $this->params
        );
    }

    /**
     * Obtém a URL informada pelo navegador
     */
    private function getUrl(): array
    {
        if (!isset($_GET['url'])) {
            return [];
        }

        $url = trim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);

        return explode('/', $url);
    }
}
