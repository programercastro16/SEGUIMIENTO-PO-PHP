<?php
class Model
{
    protected string $dataFile;

    public function __construct()
    {
        $this->dataFile = BASE_PATH . '/data/tareas.json';
    }

    /**
     * Lee y decodifica el archivo JSON de datos.
     * Retorna un array vacío si el archivo no existe o está vacío.
     */
    protected function readData(): array
    {
        if (!file_exists($this->dataFile)) {
            return [];
        }
        $content = file_get_contents($this->dataFile);
        if (empty($content)) {
            return [];
        }
        $decoded = json_decode($content, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Codifica y escribe los datos en el archivo JSON.
     */
    protected function writeData(array $data): bool
    {
        $dir = dirname($this->dataFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return file_put_contents(
            $this->dataFile,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        ) !== false;
    }
}
