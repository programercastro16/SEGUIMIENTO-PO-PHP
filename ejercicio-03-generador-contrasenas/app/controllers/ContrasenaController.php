<?php
/**
 * ContrasenaController.php — Controlador del generador de contraseñas
 */

declare(strict_types=1);

class ContrasenaController extends Controller
{
    private ContrasenaModel $model;

    public function __construct()
    {
        /** @var ContrasenaModel $model */
        $this->model = $this->model('ContrasenaModel');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // index() — Muestra el formulario con valores por defecto
    // ─────────────────────────────────────────────────────────────────────────

    public function index(): void
    {
        $data = [
            'titulo'    => 'Generador de Contraseñas Seguras',
            'resultado' => null,
            'errores'   => [],
            'historial' => $this->model->getHistorial(),
            // Valores por defecto del formulario
            'longitud'    => 16,
            'mayusculas'  => true,
            'minusculas'  => true,
            'numeros'     => true,
            'especiales'  => false,
        ];

        $this->view('contrasena/index', $data);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // generar() — POST: valida, genera y muestra resultado
    // ─────────────────────────────────────────────────────────────────────────

    public function generar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('contrasena/index');
            return;
        }

        $errores = [];

        // ── Validar longitud ─────────────────────────────────────────────────
        $longitud = filter_input(INPUT_POST, 'longitud', FILTER_VALIDATE_INT);

        if ($longitud === false || $longitud === null) {
            $errores[] = 'La longitud debe ser un número entero.';
            $longitud  = 16;
        } elseif ($longitud < 8 || $longitud > 128) {
            $errores[] = 'La longitud debe estar entre 8 y 128 caracteres.';
            $longitud  = max(8, min(128, $longitud));
        }

        // ── Validar tipos de caracteres ──────────────────────────────────────
        $opciones = [
            'mayusculas' => isset($_POST['mayusculas']),
            'minusculas' => isset($_POST['minusculas']),
            'numeros'    => isset($_POST['numeros']),
            'especiales' => isset($_POST['especiales']),
        ];

        $algunaActiva = array_filter($opciones);
        if (empty($algunaActiva)) {
            $errores[] = 'Debes seleccionar al menos un tipo de carácter.';
        }

        // ── Generar si no hay errores ────────────────────────────────────────
        $resultado = null;

        if (empty($errores)) {
            $resultado = $this->model->generar($longitud, $opciones);
            $this->model->guardarHistorial($resultado);

            // Guardar en sesión para "regenerar" sin reenviar el formulario
            $_SESSION['ultima_contrasena'] = $resultado;
        }

        $data = [
            'titulo'    => 'Generador de Contraseñas Seguras',
            'resultado' => $resultado,
            'errores'   => $errores,
            'historial' => $this->model->getHistorial(),
            // Repoblar el formulario con los valores enviados
            'longitud'   => $longitud,
            'mayusculas' => $opciones['mayusculas'],
            'minusculas' => $opciones['minusculas'],
            'numeros'    => $opciones['numeros'],
            'especiales' => $opciones['especiales'],
        ];

        $this->view('contrasena/index', $data);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // historial() — Muestra sólo el historial
    // ─────────────────────────────────────────────────────────────────────────

    public function historial(): void
    {
        $data = [
            'titulo'    => 'Historial de Contraseñas',
            'resultado' => null,
            'errores'   => [],
            'historial' => $this->model->getHistorial(),
            'longitud'   => 16,
            'mayusculas' => true,
            'minusculas' => true,
            'numeros'    => true,
            'especiales' => false,
        ];

        $this->view('contrasena/index', $data);
    }
}
