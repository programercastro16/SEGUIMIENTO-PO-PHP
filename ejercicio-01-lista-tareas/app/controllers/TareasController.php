<?php
class TareasController extends Controller
{
    private object $tareasModel;

    public function __construct()
    {
        $this->tareasModel = $this->model('TareasModel');
    }

    /**
     * Muestra la lista de tareas (con filtro opcional).
     */
    public function index(): void
    {
        $todasLasTareas = $this->tareasModel->getAll();
        $filter = $_GET['filter'] ?? 'todas';

        $tareas = match ($filter) {
            'pendientes'  => array_values(array_filter($todasLasTareas, fn($t) => !$t['completed'])),
            'completadas' => array_values(array_filter($todasLasTareas, fn($t) => $t['completed'])),
            default       => $todasLasTareas,
        };

        $totalTareas     = count($todasLasTareas);
        $completadas     = count(array_filter($todasLasTareas, fn($t) => $t['completed']));
        $pendientes      = $totalTareas - $completadas;
        $filterActual    = $filter;

        // Mensaje flash
        $mensaje = $_SESSION['mensaje'] ?? null;
        $tipoMensaje = $_SESSION['tipo_mensaje'] ?? 'success';
        unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']);

        $this->view('tareas/index', compact(
            'tareas',
            'totalTareas',
            'completadas',
            'pendientes',
            'filterActual',
            'mensaje',
            'tipoMensaje'
        ));
    }

    /**
     * POST: agrega una nueva tarea y redirige al índice.
     */
    public function agregar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('');
            return;
        }

        $titulo = trim($_POST['titulo'] ?? '');

        if (empty($titulo)) {
            $_SESSION['mensaje']      = 'El título de la tarea no puede estar vacío.';
            $_SESSION['tipo_mensaje'] = 'error';
            $this->redirect('');
            return;
        }

        if (strlen($titulo) > 200) {
            $_SESSION['mensaje']      = 'El título no puede superar los 200 caracteres.';
            $_SESSION['tipo_mensaje'] = 'error';
            $this->redirect('');
            return;
        }

        $this->tareasModel->add($titulo);
        $_SESSION['mensaje']      = '✅ Tarea agregada correctamente.';
        $_SESSION['tipo_mensaje'] = 'success';
        $this->redirect('');
    }

    /**
     * POST: elimina una tarea y redirige al índice.
     */
    public function eliminar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('');
            return;
        }

        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            $this->tareasModel->delete($id);
            $_SESSION['mensaje']      = '🗑️ Tarea eliminada.';
            $_SESSION['tipo_mensaje'] = 'info';
        }
        $this->redirect('');
    }

    /**
     * POST: alterna el estado de completada de una tarea.
     */
    public function completar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('');
            return;
        }

        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            $this->tareasModel->toggle($id);
        }
        // Preservar el filtro activo al redirigir
        $filter = $_POST['filter'] ?? 'todas';
        $this->redirect('?filter=' . urlencode($filter));
    }

    /**
     * Helper para redirigir con la URL base del script.
     */
    private function redirect(string $suffix = ''): void
    {
        $base = dirname($_SERVER['SCRIPT_NAME']);
        // Normalizar barra al final
        $base = rtrim($base, '/');
        header('Location: ' . $base . '/index.php' . $suffix);
        exit;
    }
}
