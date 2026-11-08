<?php
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/ReservaModel.php';

class ReservaController extends Controller
{
    private ReservaModel $model;

    public function __construct()
    {
        $this->model = new ReservaModel();
    }

    public function index(): void
    {
        $filtroEstado = $_GET['estado'] ?? 'todas';

        $todasLasReservas = $this->model->getAll();

        if ($filtroEstado !== 'todas') {
            $reservas = array_values(array_filter(
                $todasLasReservas,
                fn($r) => $r['estado'] === $filtroEstado
            ));
        } else {
            $reservas = $todasLasReservas;
        }

        $servicios = $this->model->getServicios();
        $serviciosMap = [];
        foreach ($servicios as $s) {
            $serviciosMap[$s['id']] = $s;
        }

        $mensaje   = $_GET['mensaje']   ?? null;
        $tipoMsg   = $_GET['tipo']      ?? 'exito';

        $this->view('reserva.index', compact(
            'reservas',
            'serviciosMap',
            'filtroEstado',
            'mensaje',
            'tipoMsg'
        ));
    }

    public function nueva(): void
    {
        $servicios = $this->model->getServicios();
        $errores   = [];
        $datos     = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre_cliente' => trim($_POST['nombre_cliente'] ?? ''),
                'email'          => trim($_POST['email'] ?? ''),
                'telefono'       => trim($_POST['telefono'] ?? ''),
                'servicio_id'    => (int) ($_POST['servicio_id'] ?? 0),
                'fecha'          => $_POST['fecha'] ?? '',
                'hora'           => $_POST['hora'] ?? '',
            ];

            // Validaciones
            if (empty($datos['nombre_cliente'])) {
                $errores[] = 'El nombre del cliente es obligatorio.';
            }
            if (empty($datos['email']) || !filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
                $errores[] = 'El correo electrónico no es válido.';
            }
            if (empty($datos['telefono'])) {
                $errores[] = 'El teléfono es obligatorio.';
            }
            if ($datos['servicio_id'] <= 0) {
                $errores[] = 'Debe seleccionar un servicio.';
            }
            if (empty($datos['fecha'])) {
                $errores[] = 'La fecha es obligatoria.';
            } elseif ($datos['fecha'] < date('Y-m-d')) {
                $errores[] = 'La fecha no puede ser anterior a hoy.';
            }
            if (empty($datos['hora'])) {
                $errores[] = 'La hora es obligatoria.';
            }

            // Verificar disponibilidad si no hay errores previos
            if (empty($errores)) {
                if (!$this->model->estaDisponible($datos['fecha'], $datos['hora'], $datos['servicio_id'])) {
                    $errores[] = 'El horario seleccionado no está disponible. Por favor elige otro.';
                }
            }

            if (empty($errores)) {
                $reserva = $this->model->crear($datos);
                if ($reserva) {
                    $this->redirect('reserva?mensaje=' . urlencode('¡Reserva creada con éxito!') . '&tipo=exito');
                } else {
                    $errores[] = 'Error al guardar la reserva. Intente nuevamente.';
                }
            }

            // Si hay errores se renderiza el formulario con datos prellenados
        }

        $this->view('reserva.form', compact('servicios', 'errores', 'datos'));
    }

    public function confirmar(string $id = ''): void
    {
        if (!$id) {
            $this->redirect('reserva?mensaje=' . urlencode('ID de reserva no válido.') . '&tipo=error');
        }

        $reserva = $this->model->getById($id);
        if (!$reserva) {
            $this->redirect('reserva?mensaje=' . urlencode('Reserva no encontrada.') . '&tipo=error');
        }

        if ($this->model->confirmar($id)) {
            $this->redirect('reserva?mensaje=' . urlencode('Reserva confirmada correctamente.') . '&tipo=exito');
        } else {
            $this->redirect('reserva?mensaje=' . urlencode('Error al confirmar la reserva.') . '&tipo=error');
        }
    }

    public function cancelar(string $id = ''): void
    {
        if (!$id) {
            $this->redirect('reserva?mensaje=' . urlencode('ID de reserva no válido.') . '&tipo=error');
        }

        $reserva = $this->model->getById($id);
        if (!$reserva) {
            $this->redirect('reserva?mensaje=' . urlencode('Reserva no encontrada.') . '&tipo=error');
        }

        if ($this->model->cancelar($id)) {
            $this->redirect('reserva?mensaje=' . urlencode('Reserva cancelada correctamente.') . '&tipo=exito');
        } else {
            $this->redirect('reserva?mensaje=' . urlencode('Error al cancelar la reserva.') . '&tipo=error');
        }
    }

    public function disponibilidad(): void
    {
        $servicios  = $this->model->getServicios();
        $slots      = [];
        $fechaSel   = $_GET['fecha']       ?? $_POST['fecha']       ?? date('Y-m-d');
        $servicioSel = (int) ($_GET['servicio_id'] ?? $_POST['servicio_id'] ?? 0);
        $buscado    = false;

        if (!empty($fechaSel) && $servicioSel > 0) {
            $slots   = $this->model->getHorasDisponibles($fechaSel, $servicioSel);
            $buscado = true;
        }

        $this->view('reserva.disponibilidad', compact('servicios', 'slots', 'fechaSel', 'servicioSel', 'buscado'));
    }
}
