<?php
class EncuestaController extends Controller {
    private EncuestaModel $model;

    public function __construct() {
        require_once APP_PATH . '/models/EncuestaModel.php';
        $this->model = new EncuestaModel();
    }

    public function index(): void {
        $encuestas = $this->model->getEncuestas('activa');
        $this->view('encuesta/index', compact('encuestas'));
    }

    public function administrar(): void {
        $encuestas = $this->model->getEncuestas();
        $totales = [];
        foreach ($encuestas as $e) {
            $totales[$e['id']] = $this->model->totalRespuestas($e['id']);
        }
        $this->view('encuesta/administrar', compact('encuestas','totales'));
    }

    public function nueva(): void {
        $errores  = [];
        $encuesta = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo      = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $preguntasRaw = $_POST['preguntas'] ?? '[]';
            $preguntas   = json_decode($preguntasRaw, true) ?? [];
            if (empty($titulo)) $errores[] = 'El título es obligatorio.';
            if (empty($preguntas)) $errores[] = 'Debes agregar al menos una pregunta.';
            if (empty($errores)) {
                // Assign IDs to questions
                foreach ($preguntas as &$p) {
                    $p['id'] = uniqid('q');
                    $p['opciones'] = $p['opciones'] ?? [];
                }
                $this->model->crear(['titulo'=>$titulo,'descripcion'=>$descripcion,'preguntas'=>$preguntas]);
                $_SESSION['flash'] = '✅ Encuesta creada correctamente.';
                header('Location: /?url=encuesta/administrar');
                exit;
            }
        }
        $this->view('encuesta/form', compact('encuesta','errores'));
    }

    public function responder(string $id = ''): void {
        $encuesta = $this->model->getById($id);
        if (!$encuesta || $encuesta['estado'] !== 'activa') {
            header('Location: /?url=encuesta'); exit;
        }
        $yaRespondio = $this->model->yaRespondio($id);
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['respuestas'] ?? [];
            // Validate all questions answered
            foreach ($encuesta['preguntas'] as $p) {
                if (!isset($respuestas[$p['id']]) || $respuestas[$p['id']] === '') {
                    $errores[] = 'Por favor responde todas las preguntas.';
                    break;
                }
            }
            if (empty($errores)) {
                $this->model->guardarRespuesta($id, $respuestas);
                $_SESSION['respondio_' . $id] = true;
                $_SESSION['flash'] = '✅ ¡Gracias por responder la encuesta!';
                header('Location: /?url=encuesta');
                exit;
            }
        }
        $this->view('encuesta/responder', compact('encuesta','yaRespondio','errores'));
    }

    public function resultados(string $id = ''): void {
        $encuesta   = $this->model->getById($id);
        if (!$encuesta) { header('Location: /?url=encuesta/administrar'); exit; }
        $resultados = $this->model->getResultados($id);
        $total      = $this->model->totalRespuestas($id);
        $this->view('encuesta/resultados', compact('encuesta','resultados','total'));
    }

    public function cerrar(string $id = ''): void {
        $this->model->cambiarEstado($id, 'cerrada');
        header('Location: /?url=encuesta/administrar');
        exit;
    }

    public function activar(string $id = ''): void {
        $this->model->cambiarEstado($id, 'activa');
        header('Location: /?url=encuesta/administrar');
        exit;
    }

    public function eliminar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->eliminar($_POST['id'] ?? '');
        }
        header('Location: /?url=encuesta/administrar');
        exit;
    }
}

