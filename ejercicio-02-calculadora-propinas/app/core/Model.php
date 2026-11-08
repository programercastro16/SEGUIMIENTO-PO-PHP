<?php

/**
 * Model.php - Modelo base
 * Proporciona persistencia mediante archivos JSON
 */

class Model
{
    protected string $dataFile = '';

    /**
     * Lee los datos del archivo JSON
     *
     * @return array  Datos decodificados, o array vacío si no existe
     */
    protected function readData(): array
    {
        if (!file_exists($this->dataFile) || filesize($this->dataFile) === 0) {
            return [];
        }

        $json = file_get_contents($this->dataFile);
        $data = json_decode($json, true);

        return is_array($data) ? $data : [];
    }

    /**
     * Escribe datos en el archivo JSON
     *
     * @param array $data  Datos a serializar y guardar
     * @return bool        true si se guardó correctamente
     */
    protected function writeData(array $data): bool
    {
        $dir = dirname($this->dataFile);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return file_put_contents($this->dataFile, $json) !== false;
    }
}
