<?php
/**
 * Router para el servidor integrado de PHP (php -S localhost:8000 router.php)
 * Permite navegar por el portal principal (index.php) y ejecutar
 * cualquiera de los 11 ejercicios con sus rutas internas, assets y archivos JSON.
 */

$rawUri = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($rawUri);
$path = urldecode($parsedUrl['path'] ?? '/');

// Si se solicita un archivo estático real en la raíz o subdirectorios
$targetFile = __DIR__ . $path;
if ($path !== '/' && file_exists($targetFile) && !is_dir($targetFile)) {
    return false; // El servidor interno de PHP entrega el archivo estático
}

// Comprobar si la petición va dirigida a la carpeta de un ejercicio
if (preg_match('#^/(ejercicio-[^/]+)(/.*)?$#', $path, $matches)) {
    $dirName = $matches[1];
    $subPath = isset($matches[2]) ? $matches[2] : '';
    $exerciseDir = __DIR__ . '/' . $dirName;

    if (is_dir($exerciseDir)) {
        // Si solicita un archivo estático dentro del ejercicio (ej. CSS, JS, imágenes)
        $assetFile = $exerciseDir . $subPath;
        if ($subPath !== '' && $subPath !== '/' && file_exists($assetFile) && !is_dir($assetFile)) {
            return false;
        }

        // Configurar el contexto de ejecución del ejercicio
        chdir($exerciseDir);

        // Si la URL amigable contiene la ruta interna (ej. /ejercicio-01-lista-tareas/tareas/agregar)
        $cleanSub = trim($subPath, '/');
        if (!isset($_GET['url']) && $cleanSub !== '' && $cleanSub !== 'index.php') {
            $_GET['url'] = $cleanSub;
        }

        $_SERVER['SCRIPT_NAME'] = '/' . $dirName . '/index.php';
        $_SERVER['PHP_SELF'] = '/' . $dirName . '/index.php';

        require $exerciseDir . '/index.php';
        return true;
    }
}

// Portal general de la raíz
chdir(__DIR__);
require __DIR__ . '/index.php';
return true;
