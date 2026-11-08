<?php
require_once BASE_PATH . '/app/core/Model.php';

class EventoModel extends Model
{
    protected string $dataFile;

    public function __construct()
    {
        $this->dataFile = BASE_PATH . '/data/eventos.json';
    }

    public function getAll(): array
    {
        $data = $this->readData();
        usort($data, fn($a, $b) => strcmp($a['fecha'] . $a['hora_inicio'], $b['fecha'] . $b['hora_inicio']));
        return $data;
    }

    public function getById(string $id): ?array
    {
        foreach ($this->readData() as $evento) {
            if ($evento['id'] === $id) {
                return $evento;
            }
        }
        return null;
    }

    public function getPorMes(int $mes, int $anio): array
    {
        $inicio = sprintf('%04d-%02d-01', $anio, $mes);
        $dias   = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
        $fin    = sprintf('%04d-%02d-%02d', $anio, $mes, $dias);

        $result = array_filter(
            $this->readData(),
            fn($e) => $e['fecha'] >= $inicio && $e['fecha'] <= $fin
        );

        usort($result, fn($a, $b) => strcmp($a['fecha'] . $a['hora_inicio'], $b['fecha'] . $b['hora_inicio']));
        return array_values($result);
    }

    public function getPorFecha(string $fecha): array
    {
        $result = array_filter(
            $this->readData(),
            fn($e) => $e['fecha'] === $fecha
        );
        usort($result, fn($a, $b) => strcmp($a['hora_inicio'], $b['hora_inicio']));
        return array_values($result);
    }

    public function crear(array $datos): string
    {
        $data   = $this->readData();
        $id     = $this->generateId();
        $nuevo  = [
            'id'           => $id,
            'titulo'       => trim($datos['titulo'] ?? ''),
            'descripcion'  => trim($datos['descripcion'] ?? ''),
            'fecha'        => $datos['fecha'] ?? date('Y-m-d'),
            'hora_inicio'  => $datos['hora_inicio'] ?? '09:00',
            'hora_fin'     => $datos['hora_fin'] ?? '10:00',
            'categoria'    => $datos['categoria'] ?? 'Otro',
            'color'        => $datos['color'] ?? '#7c3aed',
            'recordatorio' => !empty($datos['recordatorio']),
            'created_at'   => date('Y-m-d H:i:s'),
        ];
        $data[] = $nuevo;
        $this->writeData($data);
        return $id;
    }

    public function editar(string $id, array $datos): bool
    {
        $data  = $this->readData();
        $found = false;

        foreach ($data as &$evento) {
            if ($evento['id'] === $id) {
                $evento['titulo']       = trim($datos['titulo'] ?? $evento['titulo']);
                $evento['descripcion']  = trim($datos['descripcion'] ?? $evento['descripcion']);
                $evento['fecha']        = $datos['fecha'] ?? $evento['fecha'];
                $evento['hora_inicio']  = $datos['hora_inicio'] ?? $evento['hora_inicio'];
                $evento['hora_fin']     = $datos['hora_fin'] ?? $evento['hora_fin'];
                $evento['categoria']    = $datos['categoria'] ?? $evento['categoria'];
                $evento['color']        = $datos['color'] ?? $evento['color'];
                $evento['recordatorio'] = !empty($datos['recordatorio']);
                $found = true;
                break;
            }
        }
        unset($evento);

        if ($found) {
            $this->writeData($data);
        }
        return $found;
    }

    public function eliminar(string $id): bool
    {
        $data    = $this->readData();
        $filtred = array_filter($data, fn($e) => $e['id'] !== $id);
        if (count($filtred) === count($data)) {
            return false;
        }
        $this->writeData(array_values($filtred));
        return true;
    }

    public function getProximos(int $dias = 7): array
    {
        $hoy   = date('Y-m-d');
        $limite = date('Y-m-d', strtotime("+{$dias} days"));

        $result = array_filter(
            $this->readData(),
            fn($e) => $e['fecha'] >= $hoy && $e['fecha'] <= $limite
        );
        usort($result, fn($a, $b) => strcmp($a['fecha'] . $a['hora_inicio'], $b['fecha'] . $b['hora_inicio']));
        return array_values($result);
    }

    public function getCategorias(): array
    {
        return ['Trabajo', 'Personal', 'Cumpleaños', 'Reunión', 'Recordatorio', 'Festivo', 'Otro'];
    }
}
