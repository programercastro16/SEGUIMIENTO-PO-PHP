<?php
class RecetaController extends Controller {
    private RecetaModel $model;

    public function __construct() {
        require_once APP_PATH . '/models/RecetaModel.php';
        $this->model = new RecetaModel();
    }

    public function index(): void {
        $filtros = [
            'tipo'       => $_GET['tipo'] ?? '',
            'dificultad' => $_GET['dificultad'] ?? '',
            'tiempo_max' => $_GET['tiempo_max'] ?? '',
            'busqueda'   => $_GET['busqueda'] ?? '',
        ];
        $recetas     = $this->model->getAll(array_filter($filtros));
        $tipos        = $this->model->getTiposComida();
        $dificultades = $this->model->getDificultades();
        $this->view('receta/index', compact('recetas','tipos','dificultades','filtros'));
    }

    public function ver(string $id = ''): void {
        $receta = $this->model->getById($id);
        if (!$receta) { header('Location: /?url=receta'); exit; }
        $this->view('receta/ver', compact('receta'));
    }

    public function nueva(): void {
        $tipos        = $this->model->getTiposComida();
        $dificultades = $this->model->getDificultades();
        $errores = [];
        $receta  = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $receta = [
                'titulo'             => trim($_POST['titulo'] ?? ''),
                'descripcion'        => trim($_POST['descripcion'] ?? ''),
                'tipo_comida'        => $_POST['tipo_comida'] ?? '',
                'tiempo_preparacion' => (int)($_POST['tiempo_preparacion'] ?? 0),
                'porciones'          => (int)($_POST['porciones'] ?? 1),
                'dificultad'         => $_POST['dificultad'] ?? '',
                'autor'              => trim($_POST['autor'] ?? ''),
                'ingredientes'       => array_filter(array_map('trim', explode("\n", $_POST['ingredientes'] ?? ''))),
                'instrucciones'      => array_filter(array_map('trim', explode("\n", $_POST['instrucciones'] ?? ''))),
            ];

            if (empty($receta['titulo'])) $errores[] = 'El título es obligatorio.';
            if (empty($receta['ingredientes'])) $errores[] = 'Debes agregar al menos un ingrediente.';
            if (empty($receta['instrucciones'])) $errores[] = 'Debes agregar al menos una instrucción.';

            if (empty($errores)) {
                $receta['ingredientes']  = array_values($receta['ingredientes']);
                $receta['instrucciones'] = array_values($receta['instrucciones']);
                $this->model->crear($receta);
                $_SESSION['flash'] = '✅ Receta creada correctamente.';
                header('Location: /?url=receta');
                exit;
            }
        }
        $this->view('receta/form', compact('receta','tipos','dificultades','errores'));
    }

    public function editar(string $id = ''): void {
        $receta = $this->model->getById($id);
        if (!$receta) { header('Location: /?url=receta'); exit; }

        $tipos        = $this->model->getTiposComida();
        $dificultades = $this->model->getDificultades();
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'titulo'             => trim($_POST['titulo'] ?? ''),
                'descripcion'        => trim($_POST['descripcion'] ?? ''),
                'tipo_comida'        => $_POST['tipo_comida'] ?? '',
                'tiempo_preparacion' => (int)($_POST['tiempo_preparacion'] ?? 0),
                'porciones'          => (int)($_POST['porciones'] ?? 1),
                'dificultad'         => $_POST['dificultad'] ?? '',
                'autor'              => trim($_POST['autor'] ?? ''),
                'ingredientes'       => array_values(array_filter(array_map('trim', explode("\n", $_POST['ingredientes'] ?? '')))),
                'instrucciones'      => array_values(array_filter(array_map('trim', explode("\n", $_POST['instrucciones'] ?? '')))),
            ];
            if (empty($datos['titulo'])) $errores[] = 'El título es obligatorio.';
            if (empty($errores)) {
                $this->model->editar($id, $datos);
                header('Location: /?url=receta/ver/' . $id);
                exit;
            }
            $receta = array_merge($receta, $datos);
        }
        $this->view('receta/form', compact('receta','tipos','dificultades','errores'));
    }

    public function eliminar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->eliminar($_POST['id'] ?? '');
        }
        header('Location: /?url=receta');
        exit;
    }
}

