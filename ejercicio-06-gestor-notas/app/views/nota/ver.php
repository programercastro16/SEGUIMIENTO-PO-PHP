<?php
/**
 * View: nota/ver.php - Vista completa de una nota
 */
$bgColors = [
    'amarillo'=>'#fff9c4','azul'=>'#bbdefb','verde'=>'#c8e6c9',
    'rosa'=>'#f8bbd0','morado'=>'#e1bee7','naranja'=>'#ffe0b2','gris'=>'#f5f5f5',
];
$borderColors = [
    'amarillo'=>'#f9a825','azul'=>'#1565c0','verde'=>'#2e7d32',
    'rosa'=>'#c2185b','morado'=>'#6a1b9a','naranja'=>'#e65100','gris'=>'#424242',
];
$bg     = $bgColors[$nota['color'] ?? 'amarillo'] ?? '#fff9c4';
$border = $borderColors[$nota['color'] ?? 'amarillo'] ?? '#f9a825';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($nota['titulo']) ?> — Gestor de Notas</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #faf7f2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .nota-card {
            background: <?= $bg ?>;
            border-left: 6px solid <?= $border ?>;
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            max-width: 680px;
            box-shadow: 0 20px 50px rgba(0,0,0,.12);
        }
        .nota-meta {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .badge {
            display: inline-block;
            padding: .25rem .75rem;
            background: rgba(0,0,0,.08);
            border-radius: 20px;
            font-size: .78rem;
            font-weight: 700;
            color: #374151;
        }
        .nota-fecha { font-size: .78rem; color: #6b7280; margin-left: auto; }
        .nota-titulo {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        .nota-contenido {
            font-size: 1.05rem;
            color: #374151;
            line-height: 1.8;
            white-space: pre-wrap;
            margin-bottom: 2rem;
        }
        .btn-row { display: flex; gap: .75rem; flex-wrap: wrap; }
        .btn {
            padding: .6rem 1.25rem;
            border-radius: 10px;
            font-size: .9rem;
            font-weight: 700;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-edit {
            background: #6366f1;
            color: #fff;
        }
        .btn-edit:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,102,241,.4); }
        .btn-delete {
            background: #ef4444;
            color: #fff;
        }
        .btn-delete:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(239,68,68,.4); }
        .btn-back {
            background: rgba(0,0,0,.08);
            color: #374151;
        }
        .btn-back:hover { background: rgba(0,0,0,.14); }
    </style>
</head>
<body>
<div class="nota-card">
    <div class="nota-meta">
        <span class="badge">📂 <?= htmlspecialchars($nota['categoria']) ?></span>
        <span class="badge">🎨 <?= htmlspecialchars($nota['color'] ?? 'amarillo') ?></span>
        <span class="nota-fecha">
            📅 <?= date('d/m/Y H:i', strtotime($nota['created_at'])) ?>
            <?php if (!empty($nota['updated_at']) && $nota['updated_at'] !== $nota['created_at']): ?>
                · ✏️ Editada: <?= date('d/m/Y H:i', strtotime($nota['updated_at'])) ?>
            <?php endif; ?>
        </span>
    </div>

    <h1 class="nota-titulo"><?= htmlspecialchars($nota['titulo']) ?></h1>

    <div class="nota-contenido"><?= htmlspecialchars($nota['contenido']) ?></div>

    <div class="btn-row">
        <a href="/?url=nota" class="btn btn-back">← Volver</a>
        <a href="/?url=nota/editar/<?= $nota['id'] ?>" class="btn btn-edit">✏️ Editar</a>
        <form action="/?url=nota/eliminar" method="POST" style="display:inline;"
              onsubmit="return confirm('¿Eliminar esta nota?')">
            <input type="hidden" name="id" value="<?= htmlspecialchars($nota['id']) ?>">
            <button type="submit" class="btn btn-delete">🗑️ Eliminar</button>
        </form>
    </div>
</div>
</body>
</html>

