<?php
class App
{
    protected string $controller = 'TareasController';
    protected string $method    = 'index';
    protected array  $params    = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // --- Controller ---
        if (!empty($url[0])) {
            $controllerName = ucfirst(strtolower($url[0])) . 'Controller';
            $file = APP_PATH . '/controllers/' . $controllerName . '.php';
            if (file_exists($file)) {
                $this->controller = $controllerName;
                unset($url[0]);
            }
        }

        require_once APP_PATH . '/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller();

        // --- Method ---
        if (!empty($url[1])) {
            $methodName = strtolower($url[1]);
            if (method_exists($this->controller, $methodName)) {
                $this->method = $methodName;
                unset($url[1]);
            }
        }

        // --- Params ---
        $this->params = !empty($url) ? array_values($url) : [];

        // --- Dispatch ---
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
