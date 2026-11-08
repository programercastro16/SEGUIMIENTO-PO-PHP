<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🏆 Puntajes — Juego de Memoria</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: linear-gradient(135deg, #0f172a, #1e1b4b); min-height: 100vh; color: #fff; padding: 2rem 1rem; }
        .container { max-width: 760px; margin: 0 auto; }
        h1 { font-size: 2.2rem; font-weight: 900; margin-bottom: 1.75rem; text-align: center; }
        .back { display: inline-block; margin-bottom: 1.5rem; padding: .55rem 1.2rem; background: rgba(255,255,255,.1); border-radius: 10px; text-decoration: none; color: #fff; font-weight: 600; }
        .level-section { margin-bottom: 2rem; }
        .level-title { font-size: 1.3rem; font-weight: 800; margin-bottom: .75rem; color: #a78bfa; }
        table { width: 100%; border-collapse: collapse; background: rgba(255,255,255,.07); border-radius: 14px; overflow: hidden; }
        th { background: rgba(255,255,255,.1); padding: .75rem 1rem; text-align: left; font-size: .78rem; text-transform: uppercase; opacity: .6; }
        td { padding: .7rem 1rem; border-bottom: 1px solid rgba(255,255,255,.07); }
        tr:last-child td { border-bottom: none; }
        .empty { opacity: .5; padding: 1.5rem; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <a href="/?url=juego" class="back">← Inicio</a>
    <h1>🏆 Tabla de Puntajes</h1>
    <?php foreach ($niveles as $key => $n): ?>
    <div class="level-section">
        <div class="level-title"><?= $n['nombre'] ?> (<?= $n['pares'] ?> pares)</div>
        <?php if (empty($puntajes[$key])): ?>
            <div class="empty">Sin puntajes aún.</div>
        <?php else: ?>
        <table>
            <thead><tr><th>#</th><th>Jugador</th><th>Movimientos</th><th>Tiempo</th><th>Fecha</th></tr></thead>
            <tbody>
                <?php foreach ($puntajes[$key] as $i => $p): ?>
                <tr>
                    <td><?= ['🥇','🥈','🥉'][$i] ?? ($i+1) ?></td>
                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                    <td><?= $p['movimientos'] ?> movs</td>
                    <td><?= gmdate('i:s', $p['tiempo_segundos']) ?></td>
                    <td style="opacity:.6;font-size:.8rem;"><?= date('d/m/Y', strtotime($p['fecha'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
</div>
</body>
</html>

