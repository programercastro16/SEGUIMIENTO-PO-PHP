<?php
/**
 * Model.php — Clase base para todos los modelos
 *
 * Provee persistencia sencilla mediante archivos JSON.
 */

declare(strict_types=1);

class Model
{
    protected string $dataFile = '';

    // ── Lectura / Escritura JSON ───────────────────────────────────────────────

    /**
     * Lee el archivo JSON y devuelve un array.
     */
    protected function readJson(): array
    {
        if (!file_exists($this->dataFile)) {
            return [];
        }

        $raw = file_get_contents($this->dataFile);

        if ($raw === false || trim($raw) === '') {
            return [];
        }

        $data = json_decode($raw, associative: true);

        return is_array($data) ? $data : [];
    }

    /**
     * Escribe un array en el archivo JSON.
     */
    protected function writeJson(array $data): bool
    {
        $dir = dirname($this->dataFile);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, recursive: true);
        }

        $result = file_put_contents(
            $this->dataFile,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return $result !== false;
    }
}
