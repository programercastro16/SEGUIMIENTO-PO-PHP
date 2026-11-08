<?php
class Controller {
    public function view(string $name, array $data = []): void {
        extract($data);
        $f = APP_PATH . '/views/' . $name . '.php';
        if (file_exists($f)) require_once $f;
        else die("Vista no encontrada: $name");
    }
    public function model(string $name): object {
        $f = APP_PATH . '/models/' . $name . '.php';
        if (file_exists($f)) { require_once $f; return new $name(); }
        die("Modelo no encontrado: $name");
    }
}
