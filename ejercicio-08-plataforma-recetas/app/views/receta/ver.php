<?php $difColors = ['Fácil'=>'#22c55e','Media'=>'#f59e0b','Difícil'=>'#ef4444']; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($receta['titulo']) ?> — Recetas</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #fff8f0; color: #1f2937; }
        header {
            background: linear-gradient(135deg, #7c2d12, #ea580c);
            color: #fff;
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .btn-back { background: rgba(255,255,255,.2); color: #fff; padding: .5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; }
        .container { max-width: 860px; margin: 0 auto; padding: 2rem 1rem; }
        .meta-row { display: flex; gap: .6rem; flex-wrap: wrap; margin-bottom: 1.5rem; }
        .badge { display: inline-block; padding: .25rem .75rem; border-radius: 20px; font-size: .78rem; font-weight: 700; }
        .title { font-size: 2.2rem; font-weight: 800; line-height: 1.2; margin-bottom: .75rem; }
        .desc { font-size: 1rem; color: #6b7280; line-height: 1.7; margin-bottom: 1.5rem; }
        .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: .75rem; margin-bottom: 2rem; }
        .info-card { background: #fff; border-radius: 12px; padding: 1rem; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,.07); }
        .info-card .val { font-size: 1.5rem; font-weight: 800; color: #c2410c; }
        .info-card .lbl { font-size: .72rem; color: #9ca3af; text-transform: uppercase; font-weight: 700; margin-top: .2rem; }
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
        @media (max-width: 600px) { .two-col { grid-template-columns: 1fr; } }
        .section { background: #fff; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 16px rgba(0,0,0,.08); margin-bottom: 1.5rem; }
        .section h2 { font-size: 1.1rem; font-weight: 800; color: #7c2d12; margin-bottom: 1rem; }
        ul.ing-list { list-style: none; }
        ul.ing-list li { padding: .5rem 0; border-bottom: 1px solid #fed7aa; font-size: .9rem; }
        ul.ing-list li::before { content: '• '; color: #ea580c; font-weight: 700; }
        ul.ing-list li:last-child { border-bottom: none; }
        ol.inst-list { padding-left: 1.5rem; }
        ol.inst-list li { padding: .5rem 0; border-bottom: 1px solid #fed7aa; font-size: .9rem; line-height: 1.6; }
        ol.inst-list li:last-child { border-bottom: none; }
        .author { font-size: .82rem; color: #9ca3af; margin-top: 1.5rem; }
        .actions { display: flex; gap: .75rem; flex-wrap: wrap; margin-top: 1.5rem; }
        .btn { padding: .6rem 1.25rem; border-radius: 10px; font-size: .9rem; font-weight: 700; border: none; cursor: pointer; text-decoration: none; }
        .btn-edit { background: #6366f1; color: #fff; }
        .btn-delete { background: #ef4444; color: #fff; }
        .btn-back-sm { background: #f3f4f6; color: #374151; border: 2px solid #d1d5db; }
    </style>
</head>
<body>
<header>
    <a href="/?url=receta" class="btn-back">← Recetas</a>
    <h1 style="font-size:1.3rem;font-weight:800;"><?= htmlspecialchars($receta['titulo']) ?></h1>
</header>
<div class="container">
    <div class="meta-row">
        <span class="badge" style="background:#ffedd5;color:#9a3412;"><?= htmlspecialchars($receta['tipo_comida']) ?></span>
        <span class="badge" style="background:<?= $difColors[$receta['dificultad']] ?? '#78716c' ?>;color:#fff;"><?= htmlspecialchars($receta['dificultad']) ?></span>
    </div>
    <h1 class="title"><?= htmlspecialchars($receta['titulo']) ?></h1>
    <p class="desc"><?= htmlspecialchars($receta['descripcion']) ?></p>

    <div class="info-grid">
        <div class="info-card"><div class="val">⏱️<?= $receta['tiempo_preparacion'] ?></div><div class="lbl">Minutos</div></div>
        <div class="info-card"><div class="val">👥<?= $receta['porciones'] ?></div><div class="lbl">Porciones</div></div>
        <div class="info-card"><div class="val">🧪<?= count($receta['ingredientes']) ?></div><div class="lbl">Ingredientes</div></div>
        <div class="info-card"><div class="val">📋<?= count($receta['instrucciones']) ?></div><div class="lbl">Pasos</div></div>
    </div>

    <div class="two-col">
        <div class="section">
            <h2>🧪 Ingredientes</h2>
            <ul class="ing-list">
                <?php foreach ($receta['ingredientes'] as $ing): ?>
                    <li><?= htmlspecialchars($ing) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="section">
            <h2>📋 Instrucciones</h2>
            <ol class="inst-list">
                <?php foreach ($receta['instrucciones'] as $paso): ?>
                    <li><?= htmlspecialchars($paso) ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>

    <p class="author">👨‍🍳 Autor: <strong><?= htmlspecialchars($receta['autor'] ?? 'Anónimo') ?></strong>
        · 📅 <?= date('d/m/Y', strtotime($receta['created_at'])) ?></p>

    <div class="actions">
        <a href="/?url=receta" class="btn btn-back-sm">← Volver</a>
        <a href="/?url=receta/editar/<?= $receta['id'] ?>" class="btn btn-edit">✏️ Editar</a>
        <form action="/?url=receta/eliminar" method="POST" onsubmit="return confirm('¿Eliminar esta receta?')">
            <input type="hidden" name="id" value="<?= $receta['id'] ?>">
            <button type="submit" class="btn btn-delete">🗑️ Eliminar</button>
        </form>
    </div>
</div>
</body>
</html>

