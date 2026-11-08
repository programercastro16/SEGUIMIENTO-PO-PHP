<?php

/**
 * App.php - Router principal de la aplicación
 * Lee la URL y despacha al controlador y método correspondiente
 */

class App
{
    protected string $defaultController = 'PropinaController';
    protected string $defaultMethod     = 'index';
    protected array  $url               = [];

    public function __construct()
    {
        $this->url = $this->parseUrl();
        $this->dispatch();
    }

    /**
     * Parsea la URL limpiando y separando los segmentos
     */
    protected function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }

    /**
     * Despacha la petición al controlador y método adecuados
     */
    protected function dispatch(): void
    {
        // Determinar controlador
        $controllerName = $this->defaultController;
        if (!empty($this->url[0])) {
            $segment = ucfirst(strtolower($this->url[0])) . 'Controller';
            $file    = APP_PATH . '/controllers/' . $segment . '.php';
            if (file_exists($file)) {
                $controllerName = $segment;
            }
        }

        $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';
        if (!file_exists($controllerFile)) {
            $this->notFound();
            return;
        }

        require_once $controllerFile;
        $controller = new $controllerName();

        // Determinar método
        $method = $this->defaultMethod;
        if (!empty($this->url[1]) && method_exists($controller, $this->url[1])) {
            $method = $this->url[1];
        }

        // Parámetros adicionales
        $params = array_slice($this->url, 2);

        // Llamar al método
        call_user_func_array([$controller, $method], $params);
    }

    /**
     * Página 404 simple
     */
    protected function notFound(): void
    {
        http_response_code(404);
        echo '<h1>404 - Página no encontrada</h1>';
    }
}
