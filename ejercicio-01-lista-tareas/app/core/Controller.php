<?php
class Controller
{
    /**
     * Renderiza una vista, extrayendo las variables del array $data.
     */
    protected function view(string $name, array $data = []): void
    {
        extract($data);
        $viewFile = APP_PATH . '/views/' . $name . '.php';
        if (!file_exists($viewFile)) {
            die("Vista no encontrada: {$viewFile}");
        }
        require_once $viewFile;
    }

    /**
     * Instancia y devuelve un modelo.
     */
    protected function model(string $name): object
    {
        $file = APP_PATH . '/models/' . $name . '.php';
        if (!file_exists($file)) {
            die("Modelo no encontrado: {$file}");
        }
        require_once $file;
        return new $name();
    }
}
