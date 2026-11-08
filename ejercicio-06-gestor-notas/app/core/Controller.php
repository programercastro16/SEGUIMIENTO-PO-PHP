<?php
class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = BASE_PATH . '/app/views/' . str_replace('.', '/', $view) . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("Vista no encontrada: {$viewFile}");
        }
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . '/' . ltrim($path, '/'));
        exit;
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
