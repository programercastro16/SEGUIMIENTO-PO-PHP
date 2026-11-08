<?php
/**
 * Controller.php — Clase base para todos los controladores
 */

declare(strict_types=1);

class Controller
{
    /**
     * Carga un modelo y devuelve su instancia.
     */
    protected function model(string $model): object
    {
        $file = APP_PATH . '/models/' . $model . '.php';
        require_once $file;
        return new $model();
    }

    /**
     * Renderiza una vista pasándole variables.
     *
     * @param string $view   Ruta relativa a app/views/ (sin .php), usando / como separador.
     * @param array  $data   Variables que estarán disponibles dentro de la vista.
     */
    protected function view(string $view, array $data = []): void
    {
        // Extrae el array para que las claves sean variables locales en la vista
        extract($data, EXTR_SKIP);

        $viewFile = APP_PATH . '/views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(404);
            echo "<h1>Vista no encontrada: {$view}</h1>";
            return;
        }

        require_once $viewFile;
    }

    /**
     * Redirige a una URL relativa dentro de la aplicación.
     */
    protected function redirect(string $url): void
    {
        $base = dirname($_SERVER['SCRIPT_NAME']);
        $base = rtrim($base, '/');
        header("Location: {$base}/{$url}");
        exit;
    }
}
