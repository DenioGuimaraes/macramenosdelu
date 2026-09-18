<?php

/**
 * ============================================================
 * Bootstrap da Aplicação
 * Projeto: Macramê Nós de Lu
 * ============================================================
 * Responsável por:
 *  - Definir caminhos da aplicação
 *  - Carregar configurações
 *  - Carregar as classes principais do Core
 * ============================================================
 */

// ------------------------------------------------------------
// Caminho raiz do projeto
// ------------------------------------------------------------

defined('ROOT_PATH') || define('ROOT_PATH', __DIR__);

// ------------------------------------------------------------
// Diretórios principais
// ------------------------------------------------------------

define('APP_PATH', ROOT_PATH . '/app');
define('PUBLIC_PATH', ROOT_PATH . '/public');

define('CONTROLLER_PATH', APP_PATH . '/Controllers');
define('MODEL_PATH', APP_PATH . '/Models');
define('VIEW_PATH', APP_PATH . '/Views');
define('CORE_PATH', APP_PATH . '/Core');
define('CONFIG_PATH', APP_PATH . '/Config');

// ------------------------------------------------------------
// Configurações da aplicação
// ------------------------------------------------------------

$config = require CONFIG_PATH . '/config.php';

// ------------------------------------------------------------
// Timezone
// ------------------------------------------------------------

date_default_timezone_set($config['timezone']);

// ------------------------------------------------------------
// Modo Debug
// ------------------------------------------------------------

if ($config['debug']) {

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {

    ini_set('display_errors', 0);
}

// ------------------------------------------------------------
// Endereço base da aplicação
// ------------------------------------------------------------
// Funciona tanto em subpasta local (/macramenosdelu/) quanto com
// o domínio apontando para a raiz do projeto ou para /public.

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));

if (substr($scriptDir, -7) === '/public') {
    $scriptDir = substr($scriptDir, 0, -7);
}

define('BASE_URL', rtrim($scriptDir, '/') . '/');

/**
 * Monta um endereço interno a partir da raiz da aplicação.
 */
function url(string $path = ''): string
{
    return BASE_URL . ltrim($path, '/');
}

// ------------------------------------------------------------
// Sessão (necessária para o painel administrativo)
// ------------------------------------------------------------

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ------------------------------------------------------------
// Core da aplicação
// ------------------------------------------------------------

require_once CORE_PATH . '/Database.php';
require_once CORE_PATH . '/Auth.php';
require_once CORE_PATH . '/SiteData.php';
require_once CORE_PATH . '/Controller.php';
require_once CORE_PATH . '/Model.php';
require_once CORE_PATH . '/App.php';
