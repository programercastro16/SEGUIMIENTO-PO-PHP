<?php

/**
 * App Router
 * Parses $_GET['url'] and dispatches to the right controller/method.
 */
class App
{
    protected string $defaultController = 'GastoController';
    protected string $defaultMethod     = 'index';

    public function __construct()
    {
        $url = $this->parseUrl();

        // Determine controller
        $controllerName = $this->defaultController;
        if (!empty($url[0])) {
            $controllerName = ucfirst(strtolower($url[0])) . 'Controller';
            unset($url[0]);
        }

        $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            $this->notFound("Controlador <strong>$controllerName</strong> no encontrado.");
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            $this->notFound("Clase <strong>$controllerName</strong> no existe.");
            return;
        }

        $controller = new $controllerName();

        // Determine method
        $method = $this->defaultMethod;
        if (!empty($url[1])) {
            $method = strtolower($url[1]);
            unset($url[1]);
        }

        if (!method_exists($controller, $method)) {
            $this->notFound("Método <strong>$method</strong> no encontrado en $controllerName.");
            return;
        }

        // Call with any remaining URL segments as parameters
        $params = array_values($url);
        call_user_func_array([$controller, $method], $params);
    }

    protected function parseUrl(): array
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }

    protected function notFound(string $message): void
    {
        http_response_code(404);
        echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>
              <title>404 – No encontrado</title>
              <style>body{font-family:sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;background:#fff8f0;}
              .box{text-align:center;padding:2rem;border-radius:1rem;background:#fff;box-shadow:0 4px 20px rgba(0,0,0,.1);}
              h1{color:#f59e0b;font-size:4rem;margin:0;}p{color:#666;}</style></head>
              <body><div class='box'><h1>404</h1><p>$message</p>
              <a href='index.php' style='color:#f59e0b;'>← Volver al inicio</a></div></body></html>";
    }
}
