<?php

/**
 * Front Controller - Calculadora de Propinas
 * Ejercicio 02 - PHP MVC
 */

define('BASE_PATH', dirname(__FILE__));
define('APP_PATH', BASE_PATH . '/app');

session_start();

// Cargar archivos del núcleo
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/App.php';

// Iniciar la aplicación
$app = new App();
