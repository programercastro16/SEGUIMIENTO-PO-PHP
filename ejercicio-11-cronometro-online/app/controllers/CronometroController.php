<?php
class CronometroController extends Controller {
    private CronometroModel $model;

    public function __construct() {
        require_once APP_PATH . '/models/CronometroModel.php';
        $this->model = new CronometroModel();
    }

    public function index(): void {
        $this->view('cronometro/index');
    }

    public function guardar(): void {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['ok'=>false,'error'=>'Método no permitido']); exit;
        }
        $body = json_decode(file_get_contents('php://input'), true) ?? [];
        if (empty($body)) $body = $_POST;
        $datos = [
            'nombre_sesion'      => htmlspecialchars(trim($body['nombre_sesion'] ?? 'Sin nombre')),
            'tiempo_total_ms'    => (int)($body['tiempo_total_ms'] ?? 0),
            'tiempo_total_fmt'   => CronometroModel::formatearTiempo((int)($body['tiempo_total_ms'] ?? 0)),
            'vueltas'            => array_map(function($v) {
                return [
                    'numero'     => (int)($v['numero'] ?? 0),
                    'vuelta_ms'  => (int)($v['vuelta_ms'] ?? 0),
                    'total_ms'   => (int)($v['total_ms'] ?? 0),
                    'vuelta_fmt' => CronometroModel::formatearTiempo((int)($v['vuelta_ms'] ?? 0)),
                    'total_fmt'  => CronometroModel::formatearTiempo((int)($v['total_ms'] ?? 0)),
                ];
            }, $body['vueltas'] ?? []),
        ];
        $sesion = $this->model->guardarSesion($datos);
        echo json_encode(['ok'=>true,'id'=>$sesion['id']]);
        exit;
    }

    public function historial(): void {
        $sesiones = $this->model->getSesiones();
        $this->view('cronometro/historial', compact('sesiones'));
    }

    public function verSesion(string $id = ''): void {
        $sesion = $this->model->getById($id);
        if (!$sesion) { header('Location: /?url=cronometro/historial'); exit; }
        $this->view('cronometro/sesion', compact('sesion'));
    }

    public function eliminar(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->model->eliminar($_POST['id'] ?? '');
        }
        header('Location: /?url=cronometro/historial');
        exit;
    }
}

