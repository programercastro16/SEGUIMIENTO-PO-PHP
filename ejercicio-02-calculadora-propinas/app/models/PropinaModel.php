<?php

/**
 * PropinaModel.php - Modelo de Calculadora de Propinas
 * Gestiona cálculos y persistencia del historial en JSON
 */

class PropinaModel extends Model
{
    protected string $dataFile = '';

    public function __construct()
    {
        $this->dataFile = BASE_PATH . '/data/historial.json';
    }

    /**
     * Calcula la propina y los totales según los parámetros dados
     *
     * @param float $monto      Monto total de la cuenta
     * @param int   $porcentaje Porcentaje de propina (5,10,15,18,20,25)
     * @param int   $personas   Número de personas
     * @return array            Array con todos los valores calculados
     */
    public function calcular(float $monto, int $porcentaje, int $personas): array
    {
        $propina_total       = round($monto * ($porcentaje / 100), 2);
        $total_general       = round($monto + $propina_total, 2);
        $propina_por_persona = round($propina_total / $personas, 2);
        $total_por_persona   = round($total_general / $personas, 2);

        return [
            'monto_total'         => round($monto, 2),
            'porcentaje'          => $porcentaje,
            'personas'            => $personas,
            'propina_total'       => $propina_total,
            'propina_por_persona' => $propina_por_persona,
            'total_por_persona'   => $total_por_persona,
            'total_general'       => $total_general,
        ];
    }

    /**
     * Guarda un cálculo en el historial JSON con timestamp
     *
     * @param array $calculo  Array de cálculo a persistir
     * @return bool
     */
    public function guardarHistorial(array $calculo): bool
    {
        $historial = $this->readData();

        $calculo['timestamp']     = date('Y-m-d H:i:s');
        $calculo['timestamp_unix'] = time();

        // Insertar al inicio
        array_unshift($historial, $calculo);

        // Mantener máximo 50 registros
        $historial = array_slice($historial, 0, 50);

        return $this->writeData($historial);
    }

    /**
     * Retorna los últimos 10 cálculos del historial
     *
     * @return array
     */
    public function getHistorial(): array
    {
        $historial = $this->readData();
        return array_slice($historial, 0, 10);
    }
}
