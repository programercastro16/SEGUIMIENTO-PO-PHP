<?php

require_once APP_PATH . '/core/Controller.php';

class GastoController extends Controller
{
    private GastoModel $model;

    public function __construct()
    {
        $this->model = $this->model('GastoModel');
    }

    // ------------------------------------------------------------------ //
    //  index – list with optional monthly filter
    // ------------------------------------------------------------------ //

    public function index(): void
    {
        $mes  = isset($_GET['mes'])  ? (int) $_GET['mes']  : (int) date('n');
        $anio = isset($_GET['anio']) ? (int) $_GET['anio'] : (int) date('Y');

        // Clamp values
        $mes  = max(1, min(12, $mes));
        $anio = max(2000, min(2100, $anio));

        $gastos  = $this->model->getAll(['mes' => $mes, 'anio' => $anio]);
        $meses   = $this->model->getMeses();
        $resumen = $this->model->getResumenMensual($mes, $anio);

        // Flash messages
        $mensaje = $_SESSION['mensaje'] ?? null;
        $tipo    = $_SESSION['tipo']    ?? 'exito';
        unset($_SESSION['mensaje'], $_SESSION['tipo']);

        $this->view('gasto/index', compact('gastos', 'mes', 'anio', 'meses', 'resumen', 'mensaje', 'tipo'));
    }

    // ------------------------------------------------------------------ //
    //  agregar – add new expense
    // ------------------------------------------------------------------ //

    public function agregar(): void
    {
        $categorias = $this->model->getCategorias();
        $errores    = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'monto'       => $_POST['monto'] ?? '',
                'categoria'   => $_POST['categoria'] ?? '',
                'fecha'       => $_POST['fecha'] ?? '',
            ];

            // Validations
            if (empty($datos['descripcion'])) {
                $errores[] = 'La descripción es obligatoria.';
            } elseif (mb_strlen($datos['descripcion']) > 200) {
                $errores[] = 'La descripción no puede superar 200 caracteres.';
            }

            if ($datos['monto'] === '' || !is_numeric($datos['monto'])) {
                $errores[] = 'El monto debe ser un número válido.';
            } elseif ((float) $datos['monto'] <= 0) {
                $errores[] = 'El monto debe ser mayor que cero.';
            }

            if (!in_array($datos['categoria'], $categorias, true)) {
                $errores[] = 'Selecciona una categoría válida.';
            }

            if (empty($datos['fecha'])) {
                $errores[] = 'La fecha es obligatoria.';
            } elseif (\DateTimeImmutable::createFromFormat('Y-m-d', $datos['fecha']) === false) {
                $errores[] = 'El formato de fecha no es válido.';
            }

            if (empty($errores)) {
                if ($this->model->agregar($datos)) {
                    $_SESSION['mensaje'] = '✅ Gasto agregado correctamente.';
                    $_SESSION['tipo']    = 'exito';
                } else {
                    $_SESSION['mensaje'] = '❌ Error al guardar el gasto. Inténtalo de nuevo.';
                    $_SESSION['tipo']    = 'error';
                }
                $this->redirect('url=gasto/index');
            }

            $this->view('gasto/form', compact('categorias', 'errores', 'datos'));
            return;
        }

        // GET – show blank form
        $datos = [
            'descripcion' => '',
            'monto'       => '',
            'categoria'   => '',
            'fecha'       => date('Y-m-d'),
        ];

        $this->view('gasto/form', compact('categorias', 'errores', 'datos'));
    }

    // ------------------------------------------------------------------ //
    //  editar – edit existing expense
    // ------------------------------------------------------------------ //

    public function editar(string $id = ''): void
    {
        if (empty($id)) {
            $_SESSION['mensaje'] = '❌ ID de gasto no proporcionado.';
            $_SESSION['tipo']    = 'error';
            $this->redirect('url=gasto/index');
        }

        $gasto = $this->model->getById($id);

        if ($gasto === null) {
            $_SESSION['mensaje'] = '❌ Gasto no encontrado.';
            $_SESSION['tipo']    = 'error';
            $this->redirect('url=gasto/index');
        }

        $categorias = $this->model->getCategorias();
        $errores    = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'descripcion' => trim($_POST['descripcion'] ?? ''),
                'monto'       => $_POST['monto'] ?? '',
                'categoria'   => $_POST['categoria'] ?? '',
                'fecha'       => $_POST['fecha'] ?? '',
            ];

            // Validations
            if (empty($datos['descripcion'])) {
                $errores[] = 'La descripción es obligatoria.';
            } elseif (mb_strlen($datos['descripcion']) > 200) {
                $errores[] = 'La descripción no puede superar 200 caracteres.';
            }

            if ($datos['monto'] === '' || !is_numeric($datos['monto'])) {
                $errores[] = 'El monto debe ser un número válido.';
            } elseif ((float) $datos['monto'] <= 0) {
                $errores[] = 'El monto debe ser mayor que cero.';
            }

            if (!in_array($datos['categoria'], $categorias, true)) {
                $errores[] = 'Selecciona una categoría válida.';
            }

            if (empty($datos['fecha'])) {
                $errores[] = 'La fecha es obligatoria.';
            } elseif (\DateTimeImmutable::createFromFormat('Y-m-d', $datos['fecha']) === false) {
                $errores[] = 'El formato de fecha no es válido.';
            }

            if (empty($errores)) {
                if ($this->model->editar($id, $datos)) {
                    $_SESSION['mensaje'] = '✅ Gasto actualizado correctamente.';
                    $_SESSION['tipo']    = 'exito';
                } else {
                    $_SESSION['mensaje'] = '❌ Error al actualizar el gasto.';
                    $_SESSION['tipo']    = 'error';
                }
                $this->redirect('url=gasto/index');
            }

            $datos['id'] = $id;
            $this->view('gasto/form', compact('categorias', 'errores', 'datos', 'id'));
            return;
        }

        // GET – populate form with existing data
        $datos = $gasto;

        $this->view('gasto/form', compact('categorias', 'errores', 'datos', 'id'));
    }

    // ------------------------------------------------------------------ //
    //  eliminar – delete expense (POST only)
    // ------------------------------------------------------------------ //

    public function eliminar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('url=gasto/index');
        }

        $id = trim($_POST['id'] ?? '');

        if (empty($id)) {
            $_SESSION['mensaje'] = '❌ ID de gasto no proporcionado.';
            $_SESSION['tipo']    = 'error';
            $this->redirect('url=gasto/index');
        }

        if ($this->model->eliminar($id)) {
            $_SESSION['mensaje'] = '🗑️ Gasto eliminado correctamente.';
            $_SESSION['tipo']    = 'exito';
        } else {
            $_SESSION['mensaje'] = '❌ No se pudo eliminar el gasto.';
            $_SESSION['tipo']    = 'error';
        }

        $this->redirect('url=gasto/index');
    }

    // ------------------------------------------------------------------ //
    //  resumen – monthly summary with category breakdown
    // ------------------------------------------------------------------ //

    public function resumen(): void
    {
        $mes  = isset($_GET['mes'])  ? (int) $_GET['mes']  : (int) date('n');
        $anio = isset($_GET['anio']) ? (int) $_GET['anio'] : (int) date('Y');

        $mes  = max(1, min(12, $mes));
        $anio = max(2000, min(2100, $anio));

        $meses   = $this->model->getMeses();
        $resumen = $this->model->getResumenMensual($mes, $anio);

        $this->view('gasto/resumen', compact('mes', 'anio', 'meses', 'resumen'));
    }
}
