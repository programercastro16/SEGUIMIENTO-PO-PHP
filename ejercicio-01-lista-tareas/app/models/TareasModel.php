<?php
require_once APP_PATH . '/core/Model.php';

class TareasModel extends Model
{
    /**
     * Retorna todas las tareas ordenadas por fecha de creación (más reciente primero).
     */
    public function getAll(): array
    {
        $tareas = $this->readData();
        usort($tareas, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));
        return $tareas;
    }

    /**
     * Agrega una nueva tarea.
     */
    public function add(string $titulo): bool
    {
        $tareas = $this->readData();
        $tareas[] = [
            'id'         => uniqid('tarea_', true),
            'titulo'     => $titulo,
            'completed'  => false,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        return $this->writeData($tareas);
    }

    /**
     * Elimina una tarea por su ID.
     */
    public function delete(string $id): bool
    {
        $tareas = $this->readData();
        $tareas = array_filter($tareas, fn($t) => $t['id'] !== $id);
        return $this->writeData(array_values($tareas));
    }

    /**
     * Alterna el estado completed de una tarea.
     */
    public function toggle(string $id): bool
    {
        $tareas = $this->readData();
        foreach ($tareas as &$tarea) {
            if ($tarea['id'] === $id) {
                $tarea['completed'] = !$tarea['completed'];
                break;
            }
        }
        unset($tarea);
        return $this->writeData($tareas);
    }
}
