<?php
class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = BASE_PATH . '/app/views/' . str_replace('.', '/', $view) . '.php';
        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            die("Vista no encontrada: {$view}");
        }
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . '/' . ltrim($path, '/'));
        exit;
    }

    protected function model(string $model): object
    {
        $modelFile = BASE_PATH . '/app/models/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            return new $model();
        }
        die("Modelo no encontrado: {$model}");
    }
}
