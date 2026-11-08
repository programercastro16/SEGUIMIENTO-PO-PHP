<?php

/**
 * Ejercicio 04 - Gestor de Gastos
 * Front Controller
 */

define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');

session_start();

// Autoload core files
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/App.php';

// Bootstrap
$app = new App();
