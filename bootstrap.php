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
// Core da aplicação
// ------------------------------------------------------------

require_once CORE_PATH . '/Controller.php';
require_once CORE_PATH . '/Model.php';
require_once CORE_PATH . '/App.php';
