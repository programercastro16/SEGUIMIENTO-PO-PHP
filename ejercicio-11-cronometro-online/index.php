<?php
define('BASE_PATH', __DIR__);
define('APP_PATH', BASE_PATH . '/app');
session_start();
require_once APP_PATH . '/core/App.php';
require_once APP_PATH . '/core/Controller.php';
require_once APP_PATH . '/core/Model.php';
$app = new App();
