<?php

/**
 * PropinaController.php - Controlador principal de la Calculadora de Propinas
 */

class PropinaController extends Controller
{
    private object $model;

    /** Porcentajes de propina permitidos */
    private const PORCENTAJES_VALIDOS = [5, 10, 15, 18, 20, 25];

    public function __construct()
    {
        $this->model = $this->model('PropinaModel');
    }

    /**
     * Acción index: muestra el formulario y el último resultado de sesión
     */
    public function index(): void
    {
        $resultado = $_SESSION['ultimo_resultado'] ?? null;
        $errores   = $_SESSION['errores'] ?? [];
        $input     = $_SESSION['input'] ?? [];

        // Limpiar sesión
        unset($_SESSION['ultimo_resultado'], $_SESSION['errores'], $_SESSION['input']);

        $historial = $this->model->getHistorial();

        $this->view('propina/index', [
            'resultado' => $resultado,
            'errores'   => $errores,
            'input'     => $input,
            'historial' => array_slice($historial, 0, 5),
        ]);
    }

    /**
     * Acción calcular: procesa el POST del formulario
     */
    public function calcular(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect();
            return;
        }

        $errores = [];

        // Leer y sanear inputs
        $monto      = isset($_POST['monto'])      ? filter_var($_POST['monto'],      FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
        $porcentaje = isset($_POST['porcentaje']) ? filter_var($_POST['porcentaje'], FILTER_SANITIZE_NUMBER_INT)   : '';
        $personas   = isset($_POST['personas'])   ? filter_var($_POST['personas'],   FILTER_SANITIZE_NUMBER_INT)   : '';

        // Guardar input para repoblar el formulario
        $_SESSION['input'] = compact('monto', 'porcentaje', 'personas');

        // Validaciones
        $monto = (float) $monto;
        if ($monto <= 0) {
            $errores[] = 'El monto de la cuenta debe ser mayor a 0.';
        }

        $porcentaje = (int) $porcentaje;
        if (!in_array($porcentaje, self::PORCENTAJES_VALIDOS, true)) {
            $errores[] = 'Selecciona un porcentaje de propina válido (5, 10, 15, 18, 20 o 25%).';
        }

        $personas = (int) $personas;
        if ($personas < 1) {
            $errores[] = 'El número de personas debe ser al menos 1.';
        }

        if (!empty($errores)) {
            $_SESSION['errores'] = $errores;
            $this->redirect();
            return;
        }

        // Calcular
        $resultado = $this->model->calcular($monto, $porcentaje, $personas);

        // Guardar en historial
        $this->model->guardarHistorial($resultado);

        // Pasar resultado a la siguiente vista via sesión
        $_SESSION['ultimo_resultado'] = $resultado;

        $this->redirect();
    }

    /**
     * Acción historial: muestra todos los cálculos guardados
     */
    public function historial(): void
    {
        $historial = $this->model->getHistorial();

        $this->view('propina/historial', [
            'historial' => $historial,
        ]);
    }
}
