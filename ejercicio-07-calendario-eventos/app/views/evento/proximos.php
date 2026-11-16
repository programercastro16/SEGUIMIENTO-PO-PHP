<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Próximos Eventos</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #fdf4ff;
            color: #1e1b4b;
            min-height: 100vh;
        }
        header {
            background: linear-gradient(135deg, #581c87 0%, #7e22ce 60%, #9333ea 100%);
            color: #fff;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(126, 34, 206, .35);
        }
        header h1 { font-size: 1.6rem; font-weight: 700; }
        .header-nav { display: flex; gap: .75rem; }
        .btn-header {
            background: rgba(255,255,255,.18);
            color: #fff;
            border: 1.5px solid rgba(255,255,255,.35);
            padding: .5rem 1.1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: .88rem;
            font-weight: 600;
        }
        .btn-header:hover { background: rgba(255,255,255,.32); }
        main { max-width: 800px; margin: 2rem auto; padding: 0 1.5rem; }
        .event-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
            border-left: 6px solid #9333ea;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .event-title { font-size: 1.1rem; font-weight: 700; margin-bottom: .3rem; }
        .event-meta { font-size: .85rem; color: #64748b; }
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #94a3b8;
            background: #fff;
            border-radius: 12px;
        }
    </style>
</head>
<body>
<header>
    <div>
        <h1>Próximos Eventos (7 días)</h1>
        <p style="font-size: .85rem; opacity: .85; margin-top: .2rem;">Compromisos agendados para la próxima semana</p>
    </div>
    <nav class="header-nav">
        <a href="<?= BASE_URL ?>/evento/nuevo" class="btn-header">Nuevo Evento</a>
        <a href="<?= BASE_URL ?>/evento/index" class="btn-header">Calendario</a>
    </nav>
</header>
<main>
    <?php if (!empty($proximos)): ?>
        <?php foreach ($proximos as $ev): ?>
            <div class="event-card" style="border-left-color: <?= htmlspecialchars($ev['color'] ?? '#9333ea') ?>;">
                <div>
                    <div class="event-title"><?= htmlspecialchars($ev['titulo']) ?></div>
                    <div class="event-meta">
                        Fecha: <?= htmlspecialchars($ev['fecha']) ?> | Horario: <?= htmlspecialchars($ev['hora_inicio']) ?> - <?= htmlspecialchars($ev['hora_fin']) ?> | Categoría: <?= htmlspecialchars($ev['categoria']) ?>
                    </div>
                </div>
                <div>
                    <a href="<?= BASE_URL ?>/evento/dia/<?= urlencode($ev['fecha']) ?>" style="color: #7e22ce; font-weight: 600; text-decoration: none; font-size: .9rem;">Ver día &rarr;</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <p>No hay eventos programados para los próximos 7 días.</p>
        </div>
    <?php endif; ?>
</main>
</body>
</html>
