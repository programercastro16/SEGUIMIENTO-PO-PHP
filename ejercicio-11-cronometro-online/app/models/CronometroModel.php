<?php
class CronometroModel extends Model {
    protected string $dataFile = '';

    public function __construct() {
        $this->dataFile = BASE_PATH . '/data/sesiones.json';
    }

    public function guardarSesion(array $datos): array {
        $sesiones = $this->readData();
        $datos['id']    = uniqid('s');
        $datos['fecha'] = date('Y-m-d H:i:s');
        array_unshift($sesiones, $datos);
        $sesiones = array_slice($sesiones, 0, 100);
        $this->writeData($sesiones);
        return $datos;
    }

    public function getSesiones(): array {
        return $this->readData();
    }

    public function getById(string $id): ?array {
        foreach ($this->readData() as $s) if ($s['id'] === $id) return $s;
        return null;
    }

    public function eliminar(string $id): bool {
        $sesiones = array_filter($this->readData(), fn($s) => $s['id'] !== $id);
        return $this->writeData(array_values($sesiones));
    }

    public static function formatearTiempo(int $ms): string {
        $centiseconds = intval($ms / 10) % 100;
        $seconds      = intval($ms / 1000) % 60;
        $minutes      = intval($ms / 60000) % 60;
        $hours        = intval($ms / 3600000);
        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d.%02d', $hours, $minutes, $seconds, $centiseconds);
        }
        return sprintf('%02d:%02d.%02d', $minutes, $seconds, $centiseconds);
    }
}
