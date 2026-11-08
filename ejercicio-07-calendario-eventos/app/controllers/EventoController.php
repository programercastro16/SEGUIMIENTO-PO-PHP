<?php
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/EventoModel.php';

class EventoController extends Controller
{
    private EventoModel $model;

    public function __construct()
    {
        $this->model = new EventoModel();
    }

    // GET /evento/index  — calendar grid for a month
    public function index(): void
    {
        $mes  = (int) $this->get('mes',  date('n'));
        $anio = (int) $this->get('anio', date('Y'));

        // clamp valid values
        if ($mes < 1)  { $mes = 12; $anio--; }
        if ($mes > 12) { $mes = 1;  $anio++; }

        $eventosMes   = $this->model->getPorMes($mes, $anio);
        $proximos     = $this->model->getProximos(7);

        // Index events by date for fast lookup
        $eventosPorDia = [];
        foreach ($eventosMes as $ev) {
            $eventosPorDia[$ev['fecha']][] = $ev;
        }

        $this->view('evento.index', compact('mes', 'anio', 'eventosPorDia', 'proximos'));
    }

    // GET  /evento/nuevo?fecha=YYYY-MM-DD  — form
    // POST /evento/nuevo                   — create
    public function nuevo(): void
    {
        $categorias = $this->model->getCategorias();
        $errores    = [];
        $datos      = [
            'titulo'       => '',
            'descripcion'  => '',
            'fecha'        => $this->get('fecha', date('Y-m-d')),
            'hora_inicio'  => '09:00',
            'hora_fin'     => '10:00',
            'categoria'    => 'Personal',
            'color'        => '#7c3aed',
            'recordatorio' => false,
        ];

        if ($this->isPost()) {
            $datos = [
                'titulo'       => $this->post('titulo'),
                'descripcion'  => $this->post('descripcion'),
                'fecha'        => $this->post('fecha'),
                'hora_inicio'  => $this->post('hora_inicio'),
                'hora_fin'     => $this->post('hora_fin'),
                'categoria'    => $this->post('categoria'),
                'color'        => $this->post('color', '#7c3aed'),
                'recordatorio' => $this->post('recordatorio', false),
            ];

            if (empty($datos['titulo'])) {
                $errores[] = 'El título es obligatorio.';
            }
            if (empty($datos['fecha']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $datos['fecha'])) {
                $errores[] = 'La fecha es obligatoria y debe tener el formato correcto.';
            }
            if (!empty($datos['hora_fin']) && !empty($datos['hora_inicio']) && $datos['hora_fin'] < $datos['hora_inicio']) {
                $errores[] = 'La hora de fin no puede ser anterior a la hora de inicio.';
            }

            if (empty($errores)) {
                $this->model->crear($datos);
                $mes  = date('n', strtotime($datos['fecha']));
                $anio = date('Y', strtotime($datos['fecha']));
                $this->redirect("evento/index?mes={$mes}&anio={$anio}");
            }
        }

        $accion = 'Crear';
        $this->view('evento.form', compact('datos', 'categorias', 'errores', 'accion'));
    }

    // GET  /evento/editar/{id}  — form pre-filled
    // POST /evento/editar/{id}  — update
    public function editar(string $id = ''): void
    {
        $evento = $this->model->getById($id);
        if (!$evento) {
            $this->redirect('evento/index');
        }

        $categorias = $this->model->getCategorias();
        $errores    = [];
        $datos      = $evento;

        if ($this->isPost()) {
            $datos = [
                'titulo'       => $this->post('titulo'),
                'descripcion'  => $this->post('descripcion'),
                'fecha'        => $this->post('fecha'),
                'hora_inicio'  => $this->post('hora_inicio'),
                'hora_fin'     => $this->post('hora_fin'),
                'categoria'    => $this->post('categoria'),
                'color'        => $this->post('color', '#7c3aed'),
                'recordatorio' => $this->post('recordatorio', false),
            ];

            if (empty($datos['titulo'])) {
                $errores[] = 'El título es obligatorio.';
            }
            if (empty($datos['fecha']) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $datos['fecha'])) {
                $errores[] = 'La fecha es obligatoria y debe tener el formato correcto.';
            }
            if (!empty($datos['hora_fin']) && !empty($datos['hora_inicio']) && $datos['hora_fin'] < $datos['hora_inicio']) {
                $errores[] = 'La hora de fin no puede ser anterior a la hora de inicio.';
            }

            if (empty($errores)) {
                $this->model->editar($id, $datos);
                $mes  = date('n', strtotime($datos['fecha']));
                $anio = date('Y', strtotime($datos['fecha']));
                $this->redirect("evento/index?mes={$mes}&anio={$anio}");
            }
        }

        $accion = 'Editar';
        $this->view('evento.form', compact('datos', 'categorias', 'errores', 'accion', 'id'));
    }

    // POST /evento/eliminar
    public function eliminar(): void
    {
        if ($this->isPost()) {
            $id     = $this->post('id');
            $redir  = $this->post('redirect', 'evento/index');
            $this->model->eliminar($id);
            $this->redirect($redir);
        }
        $this->redirect('evento/index');
    }

    // GET /evento/dia/YYYY-MM-DD
    public function dia(string $fecha = ''): void
    {
        if (empty($fecha) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            $fecha = date('Y-m-d');
        }
        $eventos = $this->model->getPorFecha($fecha);
        $this->view('evento.dia', compact('fecha', 'eventos'));
    }

    // GET /evento/proximos
    public function proximos(): void
    {
        $proximos = $this->model->getProximos(7);
        $this->view('evento.proximos', compact('proximos'));
    }
}
