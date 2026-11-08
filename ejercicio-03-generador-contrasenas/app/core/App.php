<?php
/**
 * App.php — Router principal del MVC
 *
 * Parsea la URL ?url=controller/method/param y despacha al controlador
 * correspondiente. Si no hay URL, usa el controlador por defecto.
 */

declare(strict_types=1);

class App
{
    protected string $defaultController = 'ContrasenaController';
    protected string $defaultMethod     = 'index';
    protected array  $params            = [];

    private string $controller;
    private string $method;

    public function __construct()
    {
        [$this->controller, $this->method, $this->params] = $this->parseUrl();

        $controllerFile = APP_PATH . '/controllers/' . $this->controller . '.php';

        if (!file_exists($controllerFile)) {
            $this->controller = $this->defaultController;
            $this->method     = $this->defaultMethod;
            $controllerFile   = APP_PATH . '/controllers/' . $this->controller . '.php';
        }

        require_once $controllerFile;

        $controllerInstance = new $this->controller();

        if (!method_exists($controllerInstance, $this->method)) {
            $this->method = $this->defaultMethod;
        }

        call_user_func_array([$controllerInstance, $this->method], $this->params);
    }

    /**
     * Parsea $_GET['url'] y devuelve [controller, method, params].
     *
     * @return array{string, string, array}
     */
    private function parseUrl(): array
    {
        $url = trim($_GET['url'] ?? '', '/');

        if ($url === '') {
            return [$this->defaultController, $this->defaultMethod, []];
        }

        $segments = array_filter(explode('/', $url));
        $segments = array_values($segments);

        // Convierte primer segmento a PascalCase + "Controller"
        $controllerName = ucfirst(strtolower($segments[0] ?? 'contrasena')) . 'Controller';
        $methodName     = strtolower($segments[1] ?? $this->defaultMethod);
        $params         = array_slice($segments, 2);

        return [$controllerName, $methodName, $params];
    }
}
