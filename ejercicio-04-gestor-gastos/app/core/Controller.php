<?php

/**
 * Base Controller
 */
class Controller
{
    /**
     * Render a view file, injecting $data variables into scope.
     */
    protected function view(string $name, array $data = []): void
    {
        // Make each key a variable in this scope
        extract($data);

        $viewFile = APP_PATH . '/views/' . $name . '.php';

        if (!file_exists($viewFile)) {
            die("Vista <strong>$name</strong> no encontrada en $viewFile");
        }

        require_once $viewFile;
    }

    /**
     * Instantiate and return a model.
     */
    protected function model(string $name): object
    {
        $modelFile = APP_PATH . '/models/' . $name . '.php';

        if (!file_exists($modelFile)) {
            die("Modelo <strong>$name</strong> no encontrado.");
        }

        require_once $modelFile;

        if (!class_exists($name)) {
            die("Clase de modelo <strong>$name</strong> no existe.");
        }

        return new $name();
    }

    /**
     * Redirect to a URL relative to the app root.
     */
    protected function redirect(string $url): void
    {
        header('Location: index.php?' . ltrim($url, '?'));
        exit;
    }
}
