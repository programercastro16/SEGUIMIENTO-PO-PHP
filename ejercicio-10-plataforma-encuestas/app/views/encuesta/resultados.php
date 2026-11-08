<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Resultados — <?= htmlspecialchars($encuesta['titulo']) ?></title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:#f0f4ff;min-height:100vh}
        header{background:linear-gradient(135deg,#1e1b4b,#4338ca);color:#fff;padding:1.5rem 2rem;display:flex;justify-content:space-between;align-items:center}
        header h1{font-size:1.3rem;font-weight:800}
        .btn-b{background:rgba(255,255,255,.18);color:#fff;padding:.5rem 1rem;border-radius:8px;text-decoration:none;font-weight:600}
        .container{max-width:800px;margin:0 auto;padding:2rem 1rem}
        .stats-row{display:flex;gap:1rem;margin-bottom:2rem;flex-wrap:wrap}
        .stat{background:#fff;border-radius:12px;padding:1.25rem 1.5rem;flex:1;min-width:140px;box-shadow:0 4px 12px rgba(0,0,0,.07);text-align:center}
        .stat .v{font-size:2rem;font-weight:800;color:#4338ca}
        .stat .l{font-size:.75rem;color:#94a3b8;text-transform:uppercase;font-weight:700;margin-top:.2rem}
        .preg-card{background:#fff;border-radius:16px;padding:1.75rem;box-shadow:0 4px 16px rgba(0,0,0,.08);margin-bottom:1.25rem}
        .preg-num{font-size:.72rem;font-weight:800;color:#6366f1;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.3rem}
        .preg-text{font-size:1.05rem;font-weight:700;color:#1e293b;margin-bottom:1.25rem}
        .bar-row{margin-bottom:.85rem}
        .bar-label-row{display:flex;justify-content:space-between;margin-bottom:.25rem;font-size:.85rem}
        .bar-label{font-weight:600;color:#374151}
        .bar-count{color:#94a3b8;font-size:.8rem}
        .bar-track{height:24px;background:#e2e8f0;border-radius:50px;overflow:hidden}
        .bar-fill{height:100%;border-radius:50px;background:linear-gradient(135deg,#6366f1,#8b5cf6);transition:width .6s ease}
        .bar-row.top .bar-fill{background:linear-gradient(135deg,#059669,#10b981)}
        .no-resp{color:#94a3b8;font-style:italic}
    </style>
</head>
<body>
<header>
    <div>
        <h1>📊 Resultados: <?= htmlspecialchars($encuesta['titulo']) ?></h1>
    </div>
    <a href="/?url=encuesta/administrar" class="btn-b">← Administrar</a>
</header>
<div class="container">
    <div class="stats-row">
        <div class="stat"><div class="v"><?= $total ?></div><div class="l">Respuestas totales</div></div>
        <div class="stat"><div class="v"><?= count($encuesta['preguntas']) ?></div><div class="l">Preguntas</div></div>
        <div class="stat"><div class="v"><?= ucfirst($encuesta['estado']) ?></div><div class="l">Estado</div></div>
    </div>

    <?php if ($total === 0): ?>
        <div style="text-align:center;padding:3rem;color:#94a3b8">📭 Esta encuesta aún no tiene respuestas.</div>
    <?php else: ?>
        <?php foreach ($resultados as $i => $r):
            $topKey = !empty($r['conteo']) ? array_key_first($r['conteo']) : null;
        ?>
        <div class="preg-card">
            <div class="preg-num">Pregunta <?= $i+1 ?></div>
            <div class="preg-text"><?= htmlspecialchars($r['pregunta']['texto']) ?></div>
            <?php if (empty($r['conteo'])): ?>
                <p class="no-resp">Sin respuestas registradas.</p>
            <?php else: ?>
                <?php foreach ($r['conteo'] as $opcion => $cuenta):
                    $pct = $r['total'] > 0 ? round($cuenta / $r['total'] * 100) : 0;
                    $isTop = $opcion === $topKey;
                ?>
                <div class="bar-row <?= $isTop ? 'top' : '' ?>">
                    <div class="bar-label-row">
                        <span class="bar-label"><?= $isTop ? '🏆 ' : '' ?><?= htmlspecialchars($opcion) ?></span>
                        <span class="bar-count"><?= $cuenta ?> resp · <?= $pct ?>%</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:<?= $pct ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>

