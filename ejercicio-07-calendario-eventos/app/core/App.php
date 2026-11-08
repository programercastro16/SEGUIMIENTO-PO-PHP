<?php
class App
{
    protected string $defaultController = 'EventoController';
    protected string $defaultMethod = 'index';
    protected array $params = [];

    public function run(): void
    {
        $url = $this->parseUrl();

        $controllerName = !empty($url[0])
            ? ucfirst(strtolower($url[0])) . 'Controller'
            : $this->defaultController;

        $controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            $controllerName = $this->defaultController;
        }

        require_once BASE_PATH . '/app/controllers/' . $controllerName . '.php';
        $controller = new $controllerName();

        $method = $url[1] ?? $this->defaultMethod;

        if (!method_exists($controller, $method)) {
            $method = $this->defaultMethod;
        }

        $this->params = array_slice($url, 2);

        call_user_func_array([$controller, $method], $this->params);
    }

    protected function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            $raw = rtrim($_GET['url'], '/');
            $raw = filter_var($raw, FILTER_SANITIZE_URL);
            return explode('/', $raw);
        }
        return [];
    }
}
