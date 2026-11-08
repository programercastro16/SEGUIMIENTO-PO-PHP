<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⏱️ <?= htmlspecialchars($sesion['nombre_sesion']) ?></title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:#0a0a0f;color:#e2e8f0;min-height:100vh}
        header{padding:1.25rem 2rem;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,.07)}
        header h1{font-size:1.1rem;font-weight:800;color:#34d399}
        .btn-h{background:rgba(52,211,153,.12);color:#34d399;padding:.5rem 1.1rem;border-radius:8px;text-decoration:none;font-size:.85rem;font-weight:700;border:1px solid rgba(52,211,153,.3)}
        .container{max-width:760px;margin:0 auto;padding:2rem 1rem}
        /* Stats cards */
        .stats{display:flex;gap:1rem;margin-bottom:2rem;flex-wrap:wrap}
        .stat{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.09);border-radius:14px;padding:1.25rem 1.5rem;flex:1;min-width:140px;text-align:center}
        .stat .v{font-family:'Courier New',monospace;font-size:1.6rem;font-weight:800;color:#34d399}
        .stat .l{font-size:.7rem;color:rgba(255,255,255,.35);text-transform:uppercase;font-weight:700;letter-spacing:.06em;margin-top:.25rem}
        /* Laps table */
        .laps-wrap{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:16px;overflow:hidden}
        table{width:100%;border-collapse:collapse}
        th{font-size:.72rem;text-transform:uppercase;letter-spacing:.07em;color:rgba(255,255,255,.3);padding:.75rem 1rem;text-align:left;border-bottom:1px solid rgba(255,255,255,.07)}
        td{padding:.75rem 1rem;border-bottom:1px solid rgba(255,255,255,.05);font-family:'Courier New',monospace;font-size:.9rem}
        tr:last-child td{border-bottom:none}
        tr.fastest td{color:#34d399}
        tr.fastest td:first-child::after{content:' 🏆';font-family:sans-serif}
        tr.slowest td{color:#f87171}
        tr.slowest td:first-child::after{content:' 🐌';font-family:sans-serif}
        .legend{display:flex;gap:1.5rem;margin-top:.75rem;font-size:.78rem;color:rgba(255,255,255,.35)}
        .legend span{display:flex;align-items:center;gap:.35rem}
        .dot{width:10px;height:10px;border-radius:50%;flex-shrink:0}
    </style>
</head>
<body>
<header>
    <h1>⏱️ <?= htmlspecialchars($sesion['nombre_sesion']) ?></h1>
    <a href="/?url=cronometro/historial" class="btn-h">← Historial</a>
</header>
<div class="container">
    <div class="stats">
        <div class="stat">
            <div class="v"><?= htmlspecialchars($sesion['tiempo_total_fmt'] ?? '00:00.00') ?></div>
            <div class="l">Tiempo Total</div>
        </div>
        <div class="stat">
            <div class="v"><?= count($sesion['vueltas'] ?? []) ?></div>
            <div class="l">Vueltas</div>
        </div>
        <div class="stat">
            <div class="v"><?= date('d/m/Y', strtotime($sesion['fecha'])) ?></div>
            <div class="l">Fecha</div>
        </div>
        <div class="stat">
            <div class="v"><?= date('H:i', strtotime($sesion['fecha'])) ?></div>
            <div class="l">Hora</div>
        </div>
    </div>

    <?php if (!empty($sesion['vueltas'])): ?>
    <?php
        $vueltas = $sesion['vueltas'];
        $tiempos = array_column($vueltas, 'vuelta_ms');
        $minMs   = count($tiempos) > 1 ? min($tiempos) : null;
        $maxMs   = count($tiempos) > 1 ? max($tiempos) : null;
    ?>
    <div class="laps-wrap">
        <table>
            <thead><tr><th>#</th><th>Tiempo Vuelta</th><th>Tiempo Total</th></tr></thead>
            <tbody>
                <?php foreach (array_reverse($vueltas) as $lap):
                    $isFastest = $minMs !== null && $lap['vuelta_ms'] === $minMs;
                    $isSlowest = $maxMs !== null && $lap['vuelta_ms'] === $maxMs;
                    $cls = $isFastest ? 'fastest' : ($isSlowest ? 'slowest' : '');
                ?>
                <tr class="<?= $cls ?>">
                    <td>#<?= $lap['numero'] ?></td>
                    <td><?= htmlspecialchars($lap['vuelta_fmt'] ?? '--') ?></td>
                    <td><?= htmlspecialchars($lap['total_fmt'] ?? '--') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="legend">
        <span><div class="dot" style="background:#34d399"></div> Vuelta más rápida</span>
        <span><div class="dot" style="background:#f87171"></div> Vuelta más lenta</span>
    </div>
    <?php else: ?>
        <p style="text-align:center;color:rgba(255,255,255,.3);padding:2rem;">No se registraron vueltas en esta sesión.</p>
    <?php endif; ?>
</div>
</body>
</html>

