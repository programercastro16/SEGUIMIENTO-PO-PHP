<?php

/**
 * Controller.php - Controlador base
 * Proporciona métodos helper: view() y model()
 */

class Controller
{
    /**
     * Carga una vista con datos opcionales
     *
     * @param string $view  Ruta de la vista relativa a app/views/ (ej: 'propina/index')
     * @param array  $data  Variables a extraer en la vista
     */
    protected function view(string $view, array $data = []): void
    {
        // Extraer las variables para que estén disponibles en la vista
        extract($data);

        $viewFile = APP_PATH . '/views/' . $view . '.php';

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("Vista no encontrada: {$viewFile}");
        }
    }

    /**
     * Instancia y retorna un modelo
     *
     * @param string $model  Nombre de la clase del modelo
     * @return object        Instancia del modelo
     */
    protected function model(string $model): object
    {
        $modelFile = APP_PATH . '/models/' . $model . '.php';

        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }

        die("Modelo no encontrado: {$modelFile}");
    }

    /**
     * Redirige a una URL relativa a la base del proyecto
     *
     * @param string $path  Ruta a la que redirigir (ej: 'propina/historial')
     */
    protected function redirect(string $path = ''): void
    {
        $base = '/ejercicio-02-calculadora-propinas/';
        header('Location: ' . $base . ltrim($path, '/'));
        exit;
    }
}
