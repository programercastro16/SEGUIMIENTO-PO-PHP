<?php
class App
{
    protected string $controller;
    protected string $method;
    protected array $params;

    public function __construct()
    {
        $url = $this->parseUrl();

        $controllerName = isset($url[0]) && $url[0] !== ''
            ? ucfirst(strtolower($url[0])) . 'Controller'
            : 'ReservaController';

        $controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            $this->controller = $controllerName;
        } else {
            require_once BASE_PATH . '/app/controllers/ReservaController.php';
            $this->controller = 'ReservaController';
        }

        $this->controller = new $this->controller();

        $this->method = isset($url[1]) && $url[1] !== '' ? $url[1] : 'index';

        if (!method_exists($this->controller, $this->method)) {
            $this->method = 'index';
        }

        $this->params = array_values(array_slice($url, 2));

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
