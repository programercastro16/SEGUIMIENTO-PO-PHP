<?php
/**
 * ContrasenaModel.php — Lógica de negocio del generador de contraseñas
 */

declare(strict_types=1);

class ContrasenaModel extends Model
{
    protected string $dataFile = '';

    // Juegos de caracteres disponibles
    private const MAYUSCULAS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private const MINUSCULAS = 'abcdefghijklmnopqrstuvwxyz';
    private const NUMEROS    = '0123456789';
    private const ESPECIALES = '!@#$%^&*()-_=+[]{}|;:,.<>?/~`';

    public function __construct()
    {
        $this->dataFile = BASE_PATH . '/data/historial.json';
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Generación
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Genera una contraseña criptográficamente segura.
     *
     * @param int   $longitud Longitud deseada (8–128).
     * @param array $opciones ['mayusculas'=>bool, 'minusculas'=>bool,
     *                         'numeros'=>bool, 'especiales'=>bool]
     * @return array{password:string, longitud:int, fortaleza:string, puntuacion:int, color:string}
     */
    public function generar(int $longitud, array $opciones): array
    {
        // Construir pool de caracteres
        $pool = '';
        $garantizados = [];   // Al menos 1 carácter de cada tipo activo

        if (!empty($opciones['mayusculas'])) {
            $pool .= self::MAYUSCULAS;
            $garantizados[] = self::MAYUSCULAS[random_int(0, strlen(self::MAYUSCULAS) - 1)];
        }
        if (!empty($opciones['minusculas'])) {
            $pool .= self::MINUSCULAS;
            $garantizados[] = self::MINUSCULAS[random_int(0, strlen(self::MINUSCULAS) - 1)];
        }
        if (!empty($opciones['numeros'])) {
            $pool .= self::NUMEROS;
            $garantizados[] = self::NUMEROS[random_int(0, strlen(self::NUMEROS) - 1)];
        }
        if (!empty($opciones['especiales'])) {
            $pool .= self::ESPECIALES;
            $garantizados[] = self::ESPECIALES[random_int(0, strlen(self::ESPECIALES) - 1)];
        }

        // Si el pool está vacío (ninguna opción activa), usar minúsculas por defecto
        if ($pool === '') {
            $pool = self::MINUSCULAS;
            $garantizados[] = self::MINUSCULAS[random_int(0, strlen(self::MINUSCULAS) - 1)];
        }

        $poolLen  = strlen($pool);
        $password = $garantizados;

        // Rellenar el resto de forma aleatoria
        $restantes = $longitud - count($garantizados);
        for ($i = 0; $i < $restantes; $i++) {
            $password[] = $pool[random_int(0, $poolLen - 1)];
        }

        // Mezclar para que los garantizados no queden siempre al inicio
        shuffle($password);
        $passwordStr = implode('', $password);

        $fortaleza = $this->calcularFortaleza($passwordStr);

        return [
            'password'  => $passwordStr,
            'longitud'  => $longitud,
            'fortaleza' => $fortaleza['nivel'],
            'puntuacion'=> $fortaleza['puntuacion'],
            'color'     => $fortaleza['color'],
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Cálculo de fortaleza
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Evalúa la fortaleza de una contraseña.
     *
     * @return array{nivel:string, puntuacion:int, color:string}
     */
    public function calcularFortaleza(string $password): array
    {
        $puntuacion = 0;
        $len = strlen($password);

        // Longitud (máx 40 pts)
        $puntuacion += match (true) {
            $len >= 20 => 40,
            $len >= 16 => 30,
            $len >= 12 => 20,
            $len >= 8  => 10,
            default    => 0,
        };

        // Variedad de caracteres (máx 40 pts)
        if (preg_match('/[A-Z]/', $password)) $puntuacion += 10;
        if (preg_match('/[a-z]/', $password)) $puntuacion += 10;
        if (preg_match('/[0-9]/', $password)) $puntuacion += 10;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $puntuacion += 10;

        // Combinaciones mixtas (máx 20 pts extra)
        $tipos = 0;
        if (preg_match('/[A-Z]/', $password)) $tipos++;
        if (preg_match('/[a-z]/', $password)) $tipos++;
        if (preg_match('/[0-9]/', $password)) $tipos++;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $tipos++;

        $puntuacion += match ($tipos) {
            4       => 20,
            3       => 10,
            default => 0,
        };

        // Penalización por caracteres repetidos consecutivos
        if (preg_match('/(.)\1{2,}/', $password)) {
            $puntuacion = max(0, $puntuacion - 15);
        }

        $puntuacion = min(100, $puntuacion);

        [$nivel, $color] = match (true) {
            $puntuacion >= 80 => ['Muy Fuerte', '#00bcd4'],
            $puntuacion >= 60 => ['Fuerte',     '#4caf50'],
            $puntuacion >= 40 => ['Media',      '#ff9800'],
            default           => ['Débil',      '#f44336'],
        };

        return compact('nivel', 'puntuacion', 'color');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Historial
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Guarda una entrada en el historial (password parcialmente enmascarada).
     */
    public function guardarHistorial(array $entry): void
    {
        $historial = $this->readJson();

        // Enmascarar: mostrar primeros 3 y últimos 3 caracteres
        $pwd = $entry['password'];
        $len = strlen($pwd);

        if ($len <= 6) {
            $mascara = str_repeat('*', $len);
        } else {
            $visible  = 3;
            $mascara  = substr($pwd, 0, $visible)
                      . str_repeat('*', $len - $visible * 2)
                      . substr($pwd, -$visible);
        }

        $historial[] = [
            'password_mascara' => $mascara,
            'longitud'         => $entry['longitud'],
            'fortaleza'        => $entry['fortaleza'],
            'puntuacion'       => $entry['puntuacion'],
            'color'            => $entry['color'],
            'fecha'            => date('d/m/Y H:i:s'),
        ];

        // Mantener sólo las últimas 10 entradas
        if (count($historial) > 10) {
            $historial = array_slice($historial, -10);
        }

        $this->writeJson($historial);
    }

    /**
     * Devuelve las últimas 10 entradas del historial (más reciente primero).
     */
    public function getHistorial(): array
    {
        $historial = $this->readJson();
        return array_reverse($historial);
    }
}
