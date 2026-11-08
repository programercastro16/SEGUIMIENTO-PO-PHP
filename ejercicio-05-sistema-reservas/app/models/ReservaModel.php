<?php
require_once BASE_PATH . '/app/core/Model.php';

class ReservaModel extends Model
{
    protected string $dataFile;

    private array $servicios = [
        ['id' => 1, 'nombre' => 'Consulta General',   'duracion' => 60, 'precio' => 500.00],
        ['id' => 2, 'nombre' => 'Corte de Cabello',   'duracion' => 30, 'precio' => 250.00],
        ['id' => 3, 'nombre' => 'Masaje',              'duracion' => 90, 'precio' => 800.00],
        ['id' => 4, 'nombre' => 'Manicure',            'duracion' => 45, 'precio' => 350.00],
        ['id' => 5, 'nombre' => 'Pedicure',            'duracion' => 45, 'precio' => 350.00],
    ];

    public function __construct()
    {
        $this->dataFile = BASE_PATH . '/data/reservas.json';
    }

    public function getServicios(): array
    {
        return $this->servicios;
    }

    public function getServicioById(int $id): ?array
    {
        foreach ($this->servicios as $servicio) {
            if ($servicio['id'] === $id) {
                return $servicio;
            }
        }
        return null;
    }

    public function getAll(): array
    {
        $reservas = $this->readData();
        usort($reservas, function ($a, $b) {
            $dateA = $a['fecha'] . ' ' . $a['hora'];
            $dateB = $b['fecha'] . ' ' . $b['hora'];
            return strcmp($dateA, $dateB);
        });
        return $reservas;
    }

    public function getById(string $id): ?array
    {
        $reservas = $this->readData();
        foreach ($reservas as $reserva) {
            if ($reserva['id'] === $id) {
                return $reserva;
            }
        }
        return null;
    }

    public function crear(array $datos): array|false
    {
        $reservas = $this->readData();

        $reserva = [
            'id'             => $this->generateId(),
            'nombre_cliente' => trim($datos['nombre_cliente']),
            'email'          => trim($datos['email']),
            'telefono'       => trim($datos['telefono']),
            'servicio_id'    => (int) $datos['servicio_id'],
            'fecha'          => $datos['fecha'],
            'hora'           => $datos['hora'],
            'estado'         => 'pendiente',
            'created_at'     => date('Y-m-d H:i:s'),
        ];

        $reservas[] = $reserva;

        if ($this->writeData($reservas)) {
            return $reserva;
        }
        return false;
    }

    public function cancelar(string $id): bool
    {
        $reservas = $this->readData();
        $found = false;
        foreach ($reservas as &$reserva) {
            if ($reserva['id'] === $id) {
                $reserva['estado'] = 'cancelado';
                $found = true;
                break;
            }
        }
        unset($reserva);
        return $found && $this->writeData($reservas);
    }

    public function confirmar(string $id): bool
    {
        $reservas = $this->readData();
        $found = false;
        foreach ($reservas as &$reserva) {
            if ($reserva['id'] === $id) {
                $reserva['estado'] = 'confirmado';
                $found = true;
                break;
            }
        }
        unset($reserva);
        return $found && $this->writeData($reservas);
    }

    /**
     * Returns time slots from 09:00 to 18:00 every 30 min.
     * Excludes slots occupied by active reservations on that date.
     */
    public function getHorasDisponibles(string $fecha, int $servicio_id): array
    {
        $servicio = $this->getServicioById($servicio_id);
        $duracion = $servicio ? $servicio['duracion'] : 30;

        // Build all possible slots
        $allSlots = [];
        $start = strtotime('09:00');
        $end   = strtotime('18:00');
        $step  = 30 * 60; // 30 minutes

        for ($t = $start; $t < $end; $t += $step) {
            $allSlots[] = date('H:i', $t);
        }

        $reservasDelDia = $this->getByFecha($fecha);

        // Build list of occupied slot ranges
        $ocupados = [];
        foreach ($reservasDelDia as $r) {
            if ($r['estado'] === 'cancelado') continue;
            $rServicio = $this->getServicioById($r['servicio_id']);
            $rDuracion = $rServicio ? $rServicio['duracion'] : 30;
            $rStart = strtotime($r['hora']);
            $rEnd   = $rStart + ($rDuracion * 60);
            $ocupados[] = ['inicio' => $rStart, 'fin' => $rEnd];
        }

        $disponibles = [];
        foreach ($allSlots as $slot) {
            $slotStart = strtotime($slot);
            $slotEnd   = $slotStart + ($duracion * 60);

            if ($slotEnd > $end) {
                continue; // slot would exceed business hours
            }

            $libre = true;
            foreach ($ocupados as $oc) {
                // Check overlap: slot overlaps if slotStart < ocFin AND slotEnd > ocInicio
                if ($slotStart < $oc['fin'] && $slotEnd > $oc['inicio']) {
                    $libre = false;
                    break;
                }
            }
            $disponibles[] = [
                'hora'       => $slot,
                'disponible' => $libre,
            ];
        }

        return $disponibles;
    }

    public function getByFecha(string $fecha): array
    {
        $reservas = $this->readData();
        return array_values(array_filter($reservas, fn($r) => $r['fecha'] === $fecha));
    }

    public function estaDisponible(string $fecha, string $hora, int $servicio_id): bool
    {
        $slots = $this->getHorasDisponibles($fecha, $servicio_id);
        foreach ($slots as $slot) {
            if ($slot['hora'] === $hora) {
                return $slot['disponible'];
            }
        }
        return false;
    }
}
