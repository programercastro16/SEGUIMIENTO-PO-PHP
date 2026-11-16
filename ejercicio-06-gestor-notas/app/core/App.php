<?php
class App
{
    protected string $defaultController = 'NotaController';
    protected string $defaultMethod     = 'index';

    public function __construct()
    {
        $url = $this->parseUrl();

        // Controller
        $controllerName = $this->defaultController;
        if (!empty($url[0])) {
            $candidate = ucfirst(strtolower($url[0])) . 'Controller';
            if (file_exists(BASE_PATH . '/app/controllers/' . $candidate . '.php')) {
                $controllerName = $candidate;
            }
        }

        require_once BASE_PATH . '/app/controllers/' . $controllerName . '.php';
        $controller = new $controllerName();

        // Method
        $method = $this->defaultMethod;
        if (!empty($url[1])) {
            $candidateMethod = strtolower($url[1]);
            if (method_exists($controller, $candidateMethod)) {
                $method = $candidateMethod;
            }
        }

        // Params
        $params = array_values(array_slice($url, 2));

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
