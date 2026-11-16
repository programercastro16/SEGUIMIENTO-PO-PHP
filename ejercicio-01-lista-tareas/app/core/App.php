<?php
class App
{
    protected string $defaultController = 'TareasController';
    protected string $defaultMethod     = 'index';

    public function __construct()
    {
        $url = $this->parseUrl();

        // --- Controller ---
        $controllerName = $this->defaultController;
        if (!empty($url[0])) {
            $candidate = ucfirst(strtolower($url[0])) . 'Controller';
            if (file_exists(APP_PATH . '/controllers/' . $candidate . '.php')) {
                $controllerName = $candidate;
            }
        }

        require_once APP_PATH . '/controllers/' . $controllerName . '.php';
        $controller = new $controllerName();

        // --- Method ---
        $method = $this->defaultMethod;
        if (!empty($url[1])) {
            $candidateMethod = strtolower($url[1]);
            if (method_exists($controller, $candidateMethod)) {
                $method = $candidateMethod;
            }
        }

        // --- Params ---
        $params = array_values(array_slice($url, 2));

        // --- Dispatch ---
        call_user_func_array([$controller, $method], $params);
    }

    protected function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
