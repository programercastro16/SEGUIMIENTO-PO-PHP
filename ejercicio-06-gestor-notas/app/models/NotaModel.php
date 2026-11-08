<?php
require_once BASE_PATH . '/app/core/Model.php';

class NotaModel extends Model
{
    protected string $dataFile;

    public function __construct()
    {
        $this->dataFile = BASE_PATH . '/data/notas.json';
    }

    // ── Retrieval ──────────────────────────────────────────────────────────────

    public function getAll(array $filtros = []): array
    {
        $notas = $this->readData();

        // Filtro por categoría
        if (!empty($filtros['categoria'])) {
            $notas = array_filter($notas, fn($n) =>
                strtolower($n['categoria']) === strtolower($filtros['categoria'])
            );
        }

        // Búsqueda por término
        if (!empty($filtros['q'])) {
            $termino = strtolower($filtros['q']);
            $notas = array_filter($notas, fn($n) =>
                str_contains(strtolower($n['titulo']), $termino) ||
                str_contains(strtolower($n['contenido']), $termino)
            );
        }

        // Ordenar por fecha de creación descendente
        usort($notas, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));

        return array_values($notas);
    }

    public function getById(string $id): ?array
    {
        $notas = $this->readData();
        foreach ($notas as $nota) {
            if ($nota['id'] === $id) {
                return $nota;
            }
        }
        return null;
    }

    public function buscar(string $termino): array
    {
        return $this->getAll(['q' => $termino]);
    }

    // ── Mutations ──────────────────────────────────────────────────────────────

    public function crear(array $datos): array
    {
        $notas = $this->readData();
        $ahora = date('Y-m-d H:i:s');

        $nueva = [
            'id'         => $this->generateId(),
            'titulo'     => trim($datos['titulo']),
            'contenido'  => trim($datos['contenido']),
            'categoria'  => $datos['categoria'] ?? 'Otros',
            'color'      => $datos['color']     ?? 'amarillo',
            'created_at' => $ahora,
            'updated_at' => $ahora,
        ];

        $notas[] = $nueva;
        $this->writeData($notas);

        return $nueva;
    }

    public function editar(string $id, array $datos): bool
    {
        $notas = $this->readData();

        foreach ($notas as &$nota) {
            if ($nota['id'] === $id) {
                $nota['titulo']     = trim($datos['titulo']);
                $nota['contenido']  = trim($datos['contenido']);
                $nota['categoria']  = $datos['categoria'] ?? $nota['categoria'];
                $nota['color']      = $datos['color']     ?? $nota['color'];
                $nota['updated_at'] = date('Y-m-d H:i:s');
                $this->writeData($notas);
                return true;
            }
        }

        return false;
    }

    public function eliminar(string $id): bool
    {
        $notas = $this->readData();
        $filtradas = array_filter($notas, fn($n) => $n['id'] !== $id);

        if (count($filtradas) === count($notas)) {
            return false; // no encontrado
        }

        $this->writeData($filtradas);
        return true;
    }

    // ── Catalogues ─────────────────────────────────────────────────────────────

    public function getCategorias(): array
    {
        return [
            'Personal',
            'Trabajo',
            'Ideas',
            'Recordatorios',
            'Estudio',
            'Proyectos',
            'Otros',
        ];
    }

    public function getColores(): array
    {
        return [
            'amarillo',
            'azul',
            'verde',
            'rosa',
            'morado',
            'naranja',
            'gris',
        ];
    }
}
