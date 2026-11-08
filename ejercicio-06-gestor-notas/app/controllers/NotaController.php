<?php
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/NotaModel.php';

class NotaController extends Controller
{
    private NotaModel $model;

    public function __construct()
    {
        $this->model = new NotaModel();
    }

    // ── index() ────────────────────────────────────────────────────────────────
    // GET /nota/index  (default)
    // Soporta ?q=término y ?cat=categoria
    public function index(): void
    {
        $filtros = [];
        $busqueda  = '';
        $catActiva = '';

        if (!empty($_GET['q'])) {
            $busqueda      = htmlspecialchars(trim($_GET['q']));
            $filtros['q']  = $busqueda;
        }

        if (!empty($_GET['cat'])) {
            $catActiva           = htmlspecialchars(trim($_GET['cat']));
            $filtros['categoria'] = $catActiva;
        }

        $notas      = $this->model->getAll($filtros);
        $categorias = $this->model->getCategorias();

        $this->view('nota.index', compact('notas', 'categorias', 'busqueda', 'catActiva'));
    }

    // ── nueva() ────────────────────────────────────────────────────────────────
    // GET  /nota/nueva  → formulario vacío
    // POST /nota/nueva  → validar y crear
    public function nueva(): void
    {
        $categorias = $this->model->getCategorias();
        $colores    = $this->model->getColores();
        $errores    = [];
        $datos      = ['titulo' => '', 'contenido' => '', 'categoria' => 'Personal', 'color' => 'amarillo'];

        if ($this->isPost()) {
            $datos['titulo']    = trim($_POST['titulo']    ?? '');
            $datos['contenido'] = trim($_POST['contenido'] ?? '');
            $datos['categoria'] = trim($_POST['categoria'] ?? 'Personal');
            $datos['color']     = trim($_POST['color']     ?? 'amarillo');

            if (empty($datos['titulo'])) {
                $errores[] = 'El título es obligatorio.';
            }
            if (empty($datos['contenido'])) {
                $errores[] = 'El contenido no puede estar vacío.';
            }

            if (empty($errores)) {
                $this->model->crear($datos);
                $this->redirect('nota/index');
            }
        }

        $modoEdicion = false;
        $this->view('nota.form', compact('categorias', 'colores', 'errores', 'datos', 'modoEdicion'));
    }

    // ── editar($id) ────────────────────────────────────────────────────────────
    // GET  /nota/editar/{id}  → formulario con datos
    // POST /nota/editar/{id}  → actualizar
    public function editar(string $id = ''): void
    {
        if (empty($id)) {
            $this->redirect('nota/index');
        }

        $nota = $this->model->getById($id);
        if (!$nota) {
            $this->redirect('nota/index');
        }

        $categorias = $this->model->getCategorias();
        $colores    = $this->model->getColores();
        $errores    = [];
        $datos      = $nota;

        if ($this->isPost()) {
            $datos['titulo']    = trim($_POST['titulo']    ?? '');
            $datos['contenido'] = trim($_POST['contenido'] ?? '');
            $datos['categoria'] = trim($_POST['categoria'] ?? 'Personal');
            $datos['color']     = trim($_POST['color']     ?? 'amarillo');

            if (empty($datos['titulo'])) {
                $errores[] = 'El título es obligatorio.';
            }
            if (empty($datos['contenido'])) {
                $errores[] = 'El contenido no puede estar vacío.';
            }

            if (empty($errores)) {
                $this->model->editar($id, $datos);
                $this->redirect('nota/ver/' . $id);
            }
        }

        $modoEdicion = true;
        $this->view('nota.form', compact('categorias', 'colores', 'errores', 'datos', 'modoEdicion', 'id'));
    }

    // ── eliminar() ─────────────────────────────────────────────────────────────
    // POST /nota/eliminar   (id via POST body)
    public function eliminar(): void
    {
        if ($this->isPost() && !empty($_POST['id'])) {
            $this->model->eliminar($_POST['id']);
        }
        $this->redirect('nota/index');
    }

    // ── ver($id) ───────────────────────────────────────────────────────────────
    // GET /nota/ver/{id}
    public function ver(string $id = ''): void
    {
        if (empty($id)) {
            $this->redirect('nota/index');
        }

        $nota = $this->model->getById($id);
        if (!$nota) {
            $this->redirect('nota/index');
        }

        $this->view('nota.ver', compact('nota'));
    }
}
