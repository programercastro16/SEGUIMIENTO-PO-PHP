<?php
class Model
{
    protected string $dataFile = '';

    protected function readData(): array
    {
        if (!file_exists($this->dataFile)) {
            return [];
        }
        $json = file_get_contents($this->dataFile);
        return json_decode($json, true) ?? [];
    }

    protected function writeData(array $data): void
    {
        $dir = dirname($this->dataFile);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        file_put_contents($this->dataFile, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    protected function generateId(): string
    {
        return uniqid('', true);
    }
}
