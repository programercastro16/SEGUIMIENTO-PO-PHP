<?php
class EncuestaModel extends Model {
    protected string $dataFile     = '';
    protected string $respFile     = '';

    public function __construct() {
        $this->dataFile = BASE_PATH . '/data/encuestas.json';
        $this->respFile = BASE_PATH . '/data/respuestas.json';
    }

    private function defaultEncuestas(): array {
        return [
            ['id'=>'e1','titulo'=>'Satisfacción con el curso','descripcion'=>'Ayúdanos a mejorar respondiendo esta breve encuesta sobre tu experiencia.',
             'estado'=>'activa',
             'preguntas'=>[
                 ['id'=>'q1','texto'=>'¿Cómo calificarías el curso en general?','tipo'=>'escala','opciones'=>[]],
                 ['id'=>'q2','texto'=>'¿El material de estudio fue claro?','tipo'=>'verdadero_falso','opciones'=>[]],
                 ['id'=>'q3','texto'=>'¿Qué aspecto mejorarías?','tipo'=>'opcion_multiple','opciones'=>['Las explicaciones','Los ejercicios prácticos','La duración','Los recursos adicionales']],
             ],'created_at'=>'2026-01-10 08:00:00'],
            ['id'=>'e2','titulo'=>'Preferencias tecnológicas','descripcion'=>'Encuesta sobre tus herramientas de desarrollo favoritas.',
             'estado'=>'activa',
             'preguntas'=>[
                 ['id'=>'q1','texto'=>'¿Cuál es tu lenguaje favorito?','tipo'=>'opcion_multiple','opciones'=>['PHP','JavaScript','Python','Java','C#']],
                 ['id'=>'q2','texto'=>'¿Usas control de versiones (Git)?','tipo'=>'verdadero_falso','opciones'=>[]],
                 ['id'=>'q3','texto'=>'¿Cuánto disfrutas programar?','tipo'=>'escala','opciones'=>[]],
             ],'created_at'=>'2026-01-11 09:00:00'],
        ];
    }

    protected function readData(): array {
        if (!file_exists($this->dataFile)) {
            $d = $this->defaultEncuestas();
            file_put_contents($this->dataFile, json_encode($d, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $d;
        }
        return json_decode(file_get_contents($this->dataFile), true) ?? [];
    }

    private function readRespuestas(): array {
        if (!file_exists($this->respFile)) return [];
        return json_decode(file_get_contents($this->respFile), true) ?? [];
    }

    private function writeRespuestas(array $data): bool {
        $dir = dirname($this->respFile);
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        return file_put_contents($this->respFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
    }

    public function getEncuestas(string $estado = ''): array {
        $enc = $this->readData();
        if ($estado) $enc = array_filter($enc, fn($e) => $e['estado'] === $estado);
        return array_values($enc);
    }

    public function getById(string $id): ?array {
        foreach ($this->readData() as $e) if ($e['id'] === $id) return $e;
        return null;
    }

    public function crear(array $datos): bool {
        $enc = $this->readData();
        $datos['id']         = uniqid('e');
        $datos['estado']     = 'activa';
        $datos['created_at'] = date('Y-m-d H:i:s');
        $enc[] = $datos;
        return $this->writeData($enc);
    }

    public function cambiarEstado(string $id, string $estado): bool {
        $enc = $this->readData();
        foreach ($enc as &$e) if ($e['id'] === $id) { $e['estado'] = $estado; break; }
        return $this->writeData($enc);
    }

    public function eliminar(string $id): bool {
        $enc  = array_filter($this->readData(), fn($e) => $e['id'] !== $id);
        $resp = array_filter($this->readRespuestas(), fn($r) => $r['encuesta_id'] !== $id);
        $this->writeRespuestas(array_values($resp));
        return $this->writeData(array_values($enc));
    }

    public function guardarRespuesta(string $encuestaId, array $respuestas): bool {
        $resp = $this->readRespuestas();
        $resp[] = ['id'=>uniqid('r'),'encuesta_id'=>$encuestaId,'respuestas'=>$respuestas,'created_at'=>date('Y-m-d H:i:s')];
        return $this->writeRespuestas($resp);
    }

    public function yaRespondio(string $encuestaId): bool {
        return !empty($_SESSION['respondio_' . $encuestaId]);
    }

    public function getResultados(string $encuestaId): array {
        $enc  = $this->getById($encuestaId);
        if (!$enc) return [];
        $resp = array_filter($this->readRespuestas(), fn($r) => $r['encuesta_id'] === $encuestaId);
        $total = count($resp);
        $resultados = [];
        foreach ($enc['preguntas'] as $preg) {
            $conteo = [];
            foreach ($resp as $r) {
                $val = $r['respuestas'][$preg['id']] ?? null;
                if ($val !== null) $conteo[$val] = ($conteo[$val] ?? 0) + 1;
            }
            arsort($conteo);
            $resultados[] = ['pregunta'=>$preg,'conteo'=>$conteo,'total'=>$total];
        }
        return $resultados;
    }

    public function totalRespuestas(string $encuestaId): int {
        return count(array_filter($this->readRespuestas(), fn($r) => $r['encuesta_id'] === $encuestaId));
    }
}

