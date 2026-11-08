<?php
/**
 * View: evento/dia.php — Lista de eventos de un día específico
 */
$catColors = [
    'Trabajo'=>'#3b82f6','Personal'=>'#10b981','Cumpleaños'=>'#f59e0b',
    'Reunión'=>'#6366f1','Recordatorio'=>'#ef4444','Festivo'=>'#ec4899','Otro'=>'#78716c',
];
$fechaFormateada = date('d \d\e F \d\e Y', strtotime($fecha));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📋 Eventos del <?= $fechaFormateada ?></title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f5f3ff;
            min-height: 100vh;
        }
        header {
            background: linear-gradient(135deg, #5b21b6, #7c3aed);
            color: #fff;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header h1 { font-size: 1.5rem; font-weight: 800; }
        .btn-header {
            background: rgba(255,255,255,.2);
            color: #fff;
            padding: .5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: .875rem;
            font-weight: 600;
        }
        .btn-header:hover { background: rgba(255,255,255,.35); }
        .container { max-width: 760px; margin: 0 auto; padding: 2rem 1rem; }
        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            color: #fff;
            padding: .65rem 1.4rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: .9rem;
            margin-bottom: 1.5rem;
            transition: transform .15s;
        }
        .btn-add:hover { transform: translateY(-2px); }
        .event-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,.08);
            margin-bottom: 1rem;
            border-left: 5px solid #7c3aed;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }
        .event-time { font-size: .82rem; font-weight: 700; color: #9ca3af; white-space: nowrap; }
        .event-titulo { font-size: 1.1rem; font-weight: 700; color: #1f2937; }
        .event-desc { font-size: .875rem; color: #6b7280; margin-top: .3rem; }
        .badge {
            display: inline-block;
            padding: .2rem .65rem;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 700;
            color: #fff;
            margin-top: .4rem;
        }
        .bell { font-size: .85rem; color: #f59e0b; }
        .actions { display: flex; gap: .5rem; flex-shrink: 0; }
        .btn-sm {
            padding: .4rem .8rem;
            border-radius: 8px;
            font-size: .8rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .2s;
        }
        .btn-edit { background: #ede9fe; color: #5b21b6; }
        .btn-delete { background: #fee2e2; color: #dc2626; }
        .btn-sm:hover { opacity: .8; }
        .empty { text-align: center; padding: 3rem; color: #9ca3af; }
        .empty .icon { font-size: 3rem; }
    </style>
</head>
<body>
<header>
    <div>
        <h1>📋 Eventos del día</h1>
        <p style="font-size:.85rem;opacity:.85;"><?= $fechaFormateada ?></p>
    </div>
    <div style="display:flex;gap:.75rem;">
        <a href="/?url=evento/nuevo&fecha=<?= $fecha ?>" class="btn-header">➕ Nuevo</a>
        <a href="/?url=evento" class="btn-header">← Calendario</a>
    </div>
</header>

<div class="container">
    <?php if (empty($eventos)): ?>
        <div class="empty">
            <div class="icon">📭</div>
            <p style="margin-top:.5rem;">No hay eventos para este día.</p>
            <a href="/?url=evento/nuevo&fecha=<?= $fecha ?>" style="
                display:inline-block;margin-top:1rem;padding:.65rem 1.4rem;
                background:#7c3aed;color:#fff;border-radius:10px;text-decoration:none;font-weight:700;">
                ➕ Agregar evento
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($eventos as $ev):
            $color = $catColors[$ev['categoria'] ?? 'Otro'] ?? '#78716c';
        ?>
        <div class="event-card" style="border-color:<?= $color ?>;">
            <div style="flex:1;">
                <div class="event-time">
                    <?= htmlspecialchars($ev['hora_inicio'] ?? '') ?>
                    <?= !empty($ev['hora_fin']) ? ' → ' . htmlspecialchars($ev['hora_fin']) : '' ?>
                </div>
                <div class="event-titulo"><?= htmlspecialchars($ev['titulo']) ?></div>
                <?php if (!empty($ev['descripcion'])): ?>
                    <div class="event-desc"><?= htmlspecialchars($ev['descripcion']) ?></div>
                <?php endif; ?>
                <span class="badge" style="background:<?= $color ?>;">
                    <?= htmlspecialchars($ev['categoria'] ?? 'Otro') ?>
                </span>
                <?php if (!empty($ev['recordatorio'])): ?>
                    <span class="bell"> 🔔</span>
                <?php endif; ?>
            </div>
            <div class="actions">
                <a href="/?url=evento/editar/<?= $ev['id'] ?>" class="btn-sm btn-edit">✏️</a>
                <form action="/?url=evento/eliminar" method="POST"
                      onsubmit="return confirm('¿Eliminar este evento?')">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($ev['id']) ?>">
                    <button type="submit" class="btn-sm btn-delete">🗑️</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>

