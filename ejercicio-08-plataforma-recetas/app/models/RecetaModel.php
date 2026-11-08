<?php
class RecetaModel extends Model {
    protected string $dataFile = '';

    public function __construct() {
        $this->dataFile = BASE_PATH . '/data/recetas.json';
    }

    private function defaultRecetas(): array {
        return [
            ['id'=>'r1','titulo'=>'Arroz con Pollo','descripcion'=>'Plato tradicional de arroz con trozos de pollo, verduras y especias.',
             'ingredientes'=>['2 tazas de arroz','500g de pollo','1 cebolla','2 dientes de ajo','1 pimiento rojo','sal y pimienta al gusto'],
             'instrucciones'=>['Sofreír el pollo salpimentado hasta dorar.','Agregar cebolla, ajo y pimiento picados.','Añadir arroz y tostar 2 minutos.','Agregar 4 tazas de caldo caliente.','Cocinar a fuego bajo 20 minutos tapado.'],
             'tipo_comida'=>'Almuerzo','tiempo_preparacion'=>35,'porciones'=>4,'dificultad'=>'Media',
             'autor'=>'Cocina Latina','created_at'=>'2026-01-01 10:00:00'],
            ['id'=>'r2','titulo'=>'Ensalada César','descripcion'=>'Clásica ensalada César con crutones, queso parmesano y aderezo cremoso.',
             'ingredientes'=>['1 lechuga romana','100g de queso parmesano','1 taza de crutones','4 cucharadas de aderezo César','2 filetes de anchoa (opcional)'],
             'instrucciones'=>['Lavar y trocear la lechuga romana.','Mezclar con el aderezo César.','Agregar crutones y parmesano rallado.','Decorar con anchoas si se desea.'],
             'tipo_comida'=>'Almuerzo','tiempo_preparacion'=>15,'porciones'=>2,'dificultad'=>'Fácil',
             'autor'=>'Chef Clásico','created_at'=>'2026-01-02 10:00:00'],
            ['id'=>'r3','titulo'=>'Brownie de Chocolate','descripcion'=>'Brownie húmedo y denso de chocolate con centro suave.',
             'ingredientes'=>['200g de chocolate negro','150g de mantequilla','200g de azúcar','3 huevos','100g de harina','1 cdta vainilla','pizca de sal'],
             'instrucciones'=>['Derretir chocolate y mantequilla al baño María.','Batir huevos con azúcar hasta espumar.','Mezclar ambas preparaciones.','Incorporar harina tamizada y sal.','Hornear 25 min a 180°C.'],
             'tipo_comida'=>'Postre','tiempo_preparacion'=>40,'porciones'=>8,'dificultad'=>'Media',
             'autor'=>'Repostería Dulce','created_at'=>'2026-01-03 10:00:00'],
            ['id'=>'r4','titulo'=>'Limonada Natural','descripcion'=>'Refrescante limonada casera con menta y un toque de jengibre.',
             'ingredientes'=>['6 limones','1 litro de agua fría','4 cucharadas de azúcar','hojas de menta','hielo al gusto','1cm de jengibre fresco (opcional)'],
             'instrucciones'=>['Exprimir los limones.','Mezclar jugo con agua y azúcar.','Agregar menta y jengibre.','Servir con hielo abundante.'],
             'tipo_comida'=>'Bebida','tiempo_preparacion'=>10,'porciones'=>4,'dificultad'=>'Fácil',
             'autor'=>'Drinks House','created_at'=>'2026-01-04 10:00:00'],
            ['id'=>'r5','titulo'=>'Tacos de Frijoles','descripcion'=>'Tacos vegetarianos rellenos de frijoles refritos, aguacate y pico de gallo.',
             'ingredientes'=>['8 tortillas de maíz','1 lata de frijoles refritos','2 aguacates','3 jitomates','1 cebolla morada','cilantro','limón','sal'],
             'instrucciones'=>['Calentar los frijoles refritos.','Preparar pico de gallo con jitomate, cebolla, cilantro y limón.','Machacar aguacates con sal y limón.','Calentar las tortillas.','Armar tacos con frijoles, guacamole y pico de gallo.'],
             'tipo_comida'=>'Vegana','tiempo_preparacion'=>20,'porciones'=>4,'dificultad'=>'Fácil',
             'autor'=>'Cocina Verde','created_at'=>'2026-01-05 10:00:00'],
        ];
    }

    protected function readData(): array {
        if (!file_exists($this->dataFile)) {
            $defaults = $this->defaultRecetas();
            $this->writeData($defaults);
            return $defaults;
        }
        return json_decode(file_get_contents($this->dataFile), true) ?? [];
    }

    public function getAll(array $filtros = []): array {
        $recetas = $this->readData();
        if (!empty($filtros['tipo'])) {
            $recetas = array_filter($recetas, fn($r) => $r['tipo_comida'] === $filtros['tipo']);
        }
        if (!empty($filtros['dificultad'])) {
            $recetas = array_filter($recetas, fn($r) => $r['dificultad'] === $filtros['dificultad']);
        }
        if (!empty($filtros['tiempo_max'])) {
            $recetas = array_filter($recetas, fn($r) => $r['tiempo_preparacion'] <= (int)$filtros['tiempo_max']);
        }
        if (!empty($filtros['busqueda'])) {
            $q = mb_strtolower($filtros['busqueda']);
            $recetas = array_filter($recetas, function($r) use ($q) {
                $haystack = mb_strtolower($r['titulo'] . ' ' . $r['descripcion'] . ' ' . implode(' ', $r['ingredientes']));
                return str_contains($haystack, $q);
            });
        }
        return array_values($recetas);
    }

    public function getById(string $id): ?array {
        foreach ($this->readData() as $r) {
            if ($r['id'] === $id) return $r;
        }
        return null;
    }

    public function crear(array $datos): bool {
        $recetas = $this->readData();
        $datos['id']         = uniqid('r');
        $datos['created_at'] = date('Y-m-d H:i:s');
        $recetas[]           = $datos;
        return $this->writeData($recetas);
    }

    public function editar(string $id, array $datos): bool {
        $recetas = $this->readData();
        foreach ($recetas as &$r) {
            if ($r['id'] === $id) {
                $datos['id']         = $id;
                $datos['created_at'] = $r['created_at'];
                $datos['updated_at'] = date('Y-m-d H:i:s');
                $r = $datos;
                break;
            }
        }
        return $this->writeData($recetas);
    }

    public function eliminar(string $id): bool {
        $recetas = array_filter($this->readData(), fn($r) => $r['id'] !== $id);
        return $this->writeData(array_values($recetas));
    }

    public function getTiposComida(): array {
        return ['Desayuno','Almuerzo','Cena','Snack','Postre','Bebida','Vegetariana','Vegana'];
    }

    public function getDificultades(): array {
        return ['Fácil','Media','Difícil'];
    }
}

