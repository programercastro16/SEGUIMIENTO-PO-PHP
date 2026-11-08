<?php
class JuegoController extends Controller {
    private JuegoModel $model;

    public function __construct() {
        require_once APP_PATH . '/models/JuegoModel.php';
        $this->model = new JuegoModel();
    }

    public function index(): void {
        $niveles  = $this->model->getNiveles();
        $puntajes = [];
        foreach (array_keys($niveles) as $n) {
            $puntajes[$n] = $this->model->getPuntajes($n);
        }
        $this->view('juego/index', compact('niveles','puntajes'));
    }

    public function jugar(string $nivel = 'facil'): void {
        $niveles = $this->model->getNiveles();
        if (!isset($niveles[$nivel])) $nivel = 'facil';
        $tablero = $this->model->generarTablero($nivel);
        $nivelInfo = $niveles[$nivel];
        $this->view('juego/jugar', compact('tablero','nivel','nivelInfo'));
    }

    public function guardarPuntaje(): void {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['ok'=>false]); exit;
        }
        $body = json_decode(file_get_contents('php://input'), true);
        if (!$body) $body = $_POST;
        $datos = [
            'nombre'           => htmlspecialchars(trim($body['nombre'] ?? 'Anónimo')),
            'nivel'            => $body['nivel'] ?? 'facil',
            'movimientos'      => (int)($body['movimientos'] ?? 0),
            'tiempo_segundos'  => (int)($body['tiempo_segundos'] ?? 0),
        ];
        $ok = $this->model->guardarPuntaje($datos);
        echo json_encode(['ok'=>$ok]);
        exit;
    }

    public function puntajes(): void {
        $niveles  = $this->model->getNiveles();
        $puntajes = [];
        foreach (array_keys($niveles) as $n) {
            $puntajes[$n] = $this->model->getPuntajes($n);
        }
        $this->view('juego/puntajes', compact('niveles','puntajes'));
    }
}

