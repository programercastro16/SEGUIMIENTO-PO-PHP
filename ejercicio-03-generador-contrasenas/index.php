<?php
/**
 * Front Controller - Generador de Contraseñas Seguras
 * Ejercicio 03 - PHP MVC
 */

declare(strict_types=1);

// ── Constantes ────────────────────────────────────────────────────────────────
define('BASE_PATH', __DIR__);
define('APP_PATH',  BASE_PATH . '/app');

// ── Sesión ────────────────────────────────────────────────────────────────────
session_start();

// ── Autoload del núcleo MVC ───────────────────────────────────────────────────
require_once APP_PATH . '/core/Model.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/App.php';

// ── Arrancar la aplicación ────────────────────────────────────────────────────
$app = new App();
