<?php
class App {
    protected string $defaultController = 'RecetaController';
    protected string $defaultMethod     = 'index';

    public function __construct() {
        $url = $this->parseUrl();
        $ctrlName = !empty($url[0])
            ? ucfirst(strtolower($url[0])) . 'Controller'
            : $this->defaultController;
        $ctrlFile = APP_PATH . '/controllers/' . $ctrlName . '.php';
        if (file_exists($ctrlFile)) {
            require_once $ctrlFile;
            $ctrl = new $ctrlName();
        } else {
            require_once APP_PATH . '/controllers/' . $this->defaultController . '.php';
            $ctrl = new $this->defaultController();
        }
        $method = $url[1] ?? $this->defaultMethod;
        if (!method_exists($ctrl, $method)) $method = $this->defaultMethod;
        call_user_func_array([$ctrl, $method], array_slice($url, 2));
    }

    private function parseUrl(): array {
        return isset($_GET['url'])
            ? explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL))
            : [];
    }
}
