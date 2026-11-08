<?php
class JuegoModel extends Model {
    protected string $dataFile = '';

    public function __construct() {
        $this->dataFile = BASE_PATH . '/data/puntajes.json';
    }

    private array $emojis = [
        'facil'  => ['🐶','🐱','🐭','🐹','🐰','🦊'],
        'medio'  => ['🐶','🐱','🐭','🐹','🐰','🦊','🐻','🐼','🐨','🐯'],
        'dificil'=> ['🐶','🐱','🐭','🐹','🐰','🦊','🐻','🐼','🐨','🐯','🦁','🐮','🐷','🐸','🐵','🦅'],
    ];

    public function getNiveles(): array {
        return [
            'facil'  => ['nombre'=>'Fácil',  'pares'=>6,  'cols'=>4],
            'medio'  => ['nombre'=>'Medio',  'pares'=>10, 'cols'=>5],
            'dificil'=> ['nombre'=>'Difícil','pares'=>16, 'cols'=>8],
        ];
    }

    public function generarTablero(string $nivel): array {
        $emojis = $this->emojis[$nivel] ?? $this->emojis['facil'];
        $cards  = [];
        $id     = 0;
        foreach ($emojis as $emoji) {
            $cards[] = ['id'=>$id++, 'emoji'=>$emoji, 'par'=>$emoji];
            $cards[] = ['id'=>$id++, 'emoji'=>$emoji, 'par'=>$emoji];
        }
        shuffle($cards);
        return $cards;
    }

    public function guardarPuntaje(array $datos): bool {
        $puntajes = $this->readData();
        $datos['fecha'] = date('Y-m-d H:i:s');
        $datos['id']    = uniqid('p');
        array_unshift($puntajes, $datos);
        $puntajes = array_slice($puntajes, 0, 200);
        return $this->writeData($puntajes);
    }

    public function getPuntajes(string $nivel = ''): array {
        $puntajes = $this->readData();
        if ($nivel) {
            $puntajes = array_filter($puntajes, fn($p) => $p['nivel'] === $nivel);
        }
        usort($puntajes, fn($a,$b) => $a['movimientos'] <=> $b['movimientos']);
        return array_values(array_slice($puntajes, 0, 10));
    }
}

