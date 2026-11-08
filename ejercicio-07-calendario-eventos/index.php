<?php
define('BASE_PATH', __DIR__);
define('BASE_URL', '/ejercicio-07-calendario-eventos');

spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/app/core/' . $class . '.php',
        BASE_PATH . '/app/controllers/' . $class . '.php',
        BASE_PATH . '/app/models/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

require_once BASE_PATH . '/app/core/App.php';

$app = new App();
$app->run();
