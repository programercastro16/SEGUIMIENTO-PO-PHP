<?php

/**
 * Base Model – JSON file persistence.
 */
class Model
{
    protected string $dataFile = '';

    /**
     * Read all records from the JSON data file.
     */
    protected function readData(): array
    {
        if (!file_exists($this->dataFile)) {
            return [];
        }

        $json = file_get_contents($this->dataFile);

        if ($json === false || trim($json) === '') {
            return [];
        }

        $data = json_decode($json, true);

        return is_array($data) ? $data : [];
    }

    /**
     * Write records to the JSON data file.
     */
    protected function writeData(array $data): bool
    {
        $dir = dirname($this->dataFile);

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $result = file_put_contents(
            $this->dataFile,
            json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return $result !== false;
    }
}
