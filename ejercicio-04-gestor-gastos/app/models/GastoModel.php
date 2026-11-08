<?php

require_once APP_PATH . '/core/Model.php';

class GastoModel extends Model
{
    protected string $dataFile = '';

    public function __construct()
    {
        $this->dataFile = BASE_PATH . '/data/gastos.json';
    }

    // ------------------------------------------------------------------ //
    //  CRUD
    // ------------------------------------------------------------------ //

    /**
     * Return all expenses, optionally filtered by mes/anio/categoria.
     */
    public function getAll(array $filtros = []): array
    {
        $gastos = $this->readData();

        if (!empty($filtros['mes']) && !empty($filtros['anio'])) {
            $mes  = (int) $filtros['mes'];
            $anio = (int) $filtros['anio'];
            $gastos = array_filter($gastos, function (array $g) use ($mes, $anio): bool {
                $fecha = \DateTimeImmutable::createFromFormat('Y-m-d', $g['fecha']);
                if ($fecha === false) return false;
                return (int) $fecha->format('n') === $mes
                    && (int) $fecha->format('Y') === $anio;
            });
        }

        if (!empty($filtros['categoria'])) {
            $cat = $filtros['categoria'];
            $gastos = array_filter($gastos, fn(array $g): bool => $g['categoria'] === $cat);
        }

        // Sort descending by fecha
        usort($gastos, fn(array $a, array $b): int => strcmp($b['fecha'], $a['fecha']));

        return array_values($gastos);
    }

    /**
     * Find a single expense by id.
     */
    public function getById(string $id): ?array
    {
        foreach ($this->readData() as $gasto) {
            if ($gasto['id'] === $id) {
                return $gasto;
            }
        }
        return null;
    }

    /**
     * Add a new expense record.
     */
    public function agregar(array $datos): bool
    {
        $gastos   = $this->readData();
        $gastos[] = [
            'id'          => uniqid('gasto_', true),
            'descripcion' => htmlspecialchars(trim($datos['descripcion']), ENT_QUOTES),
            'monto'       => (float) $datos['monto'],
            'categoria'   => $datos['categoria'],
            'fecha'       => $datos['fecha'],
            'created_at'  => date('Y-m-d H:i:s'),
        ];
        return $this->writeData($gastos);
    }

    /**
     * Delete an expense by id.
     */
    public function eliminar(string $id): bool
    {
        $gastos = $this->readData();
        $gastos = array_filter($gastos, fn(array $g): bool => $g['id'] !== $id);
        return $this->writeData(array_values($gastos));
    }

    /**
     * Update an existing expense.
     */
    public function editar(string $id, array $datos): bool
    {
        $gastos = $this->readData();
        $found  = false;

        foreach ($gastos as &$gasto) {
            if ($gasto['id'] === $id) {
                $gasto['descripcion'] = htmlspecialchars(trim($datos['descripcion']), ENT_QUOTES);
                $gasto['monto']       = (float) $datos['monto'];
                $gasto['categoria']   = $datos['categoria'];
                $gasto['fecha']       = $datos['fecha'];
                $found = true;
                break;
            }
        }
        unset($gasto);

        if (!$found) return false;

        return $this->writeData($gastos);
    }

    // ------------------------------------------------------------------ //
    //  Analytics
    // ------------------------------------------------------------------ //

    /**
     * Returns total by category, grand total, and expense count for a given month/year.
     */
    public function getResumenMensual(int $mes, int $anio): array
    {
        $gastos = $this->getAll(['mes' => $mes, 'anio' => $anio]);

        $totalGeneral  = 0.0;
        $porCategoria  = [];

        foreach ($gastos as $g) {
            $cat = $g['categoria'];
            $porCategoria[$cat] = ($porCategoria[$cat] ?? 0.0) + $g['monto'];
            $totalGeneral += $g['monto'];
        }

        arsort($porCategoria);

        return [
            'mes'           => $mes,
            'anio'          => $anio,
            'total'         => $totalGeneral,
            'count'         => count($gastos),
            'por_categoria' => $porCategoria,
        ];
    }

    // ------------------------------------------------------------------ //
    //  Reference data
    // ------------------------------------------------------------------ //

    public function getCategorias(): array
    {
        return [
            'Alimentación',
            'Transporte',
            'Entretenimiento',
            'Salud',
            'Educación',
            'Hogar',
            'Ropa',
            'Tecnología',
            'Otros',
        ];
    }

    public function getMeses(): array
    {
        return [
            1  => 'Enero',
            2  => 'Febrero',
            3  => 'Marzo',
            4  => 'Abril',
            5  => 'Mayo',
            6  => 'Junio',
            7  => 'Julio',
            8  => 'Agosto',
            9  => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];
    }
}
