<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⚙️ Administrar Encuestas</title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:#f0f4ff;min-height:100vh}
        header{background:linear-gradient(135deg,#1e1b4b,#4338ca);color:#fff;padding:1.5rem 2rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem}
        header h1{font-size:1.5rem;font-weight:800}
        .btn-h{background:rgba(255,255,255,.18);color:#fff;padding:.55rem 1.1rem;border-radius:8px;text-decoration:none;font-weight:700;font-size:.875rem}
        .container{max-width:1000px;margin:0 auto;padding:2rem 1rem}
        .table-wrap{background:#fff;border-radius:16px;box-shadow:0 4px 16px rgba(0,0,0,.08);overflow:hidden}
        table{width:100%;border-collapse:collapse}
        th{background:#1e1b4b;color:#a5b4fc;padding:.75rem 1rem;text-align:left;font-size:.78rem;text-transform:uppercase;letter-spacing:.05em}
        td{padding:.85rem 1rem;border-bottom:1px solid #e2e8f0;vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover{background:#f8f7ff}
        .badge-activa{background:#dcfce7;color:#166534;padding:.25rem .75rem;border-radius:20px;font-size:.75rem;font-weight:700}
        .badge-cerrada{background:#fee2e2;color:#991b1b;padding:.25rem .75rem;border-radius:20px;font-size:.75rem;font-weight:700}
        .actions{display:flex;gap:.5rem;flex-wrap:wrap}
        .btn-sm{padding:.4rem .85rem;border-radius:8px;font-size:.78rem;font-weight:700;border:none;cursor:pointer;text-decoration:none;transition:opacity .2s}
        .btn-sm:hover{opacity:.8}
        .btn-results{background:#ede9fe;color:#5b21b6}
        .btn-close{background:#fef3c7;color:#92400e}
        .btn-open{background:#dcfce7;color:#166534}
        .btn-del{background:#fee2e2;color:#991b1b}
        .empty{text-align:center;padding:3rem;color:#94a3b8}
        @media(max-width:700px){table,thead,tbody,th,td,tr{display:block} th{display:none} td{padding:.5rem 1rem;position:relative;padding-left:40%} td::before{position:absolute;left:1rem;font-weight:700;color:#94a3b8}}
    </style>
</head>
<body>
<header>
    <div><h1>⚙️ Administrar Encuestas</h1></div>
    <div style="display:flex;gap:.75rem;">
        <a href="/?url=encuesta/nueva" class="btn-h">➕ Nueva Encuesta</a>
        <a href="/?url=encuesta" class="btn-h">👁️ Vista Pública</a>
    </div>
</header>
<div class="container">
    <?php if (empty($encuestas)): ?>
        <div class="empty"><p>No hay encuestas creadas. <a href="/?url=encuesta/nueva">Crear primera encuesta</a></p></div>
    <?php else: ?>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Título</th><th>Estado</th><th>Preguntas</th><th>Respuestas</th><th>Fecha</th><th>Acciones</th></tr></thead>
            <tbody>
                <?php foreach ($encuestas as $e): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($e['titulo']) ?></strong><br><small style="color:#94a3b8"><?= htmlspecialchars(mb_substr($e['descripcion'],0,60)) ?>...</small></td>
                    <td><span class="badge-<?= $e['estado'] ?>"><?= ucfirst($e['estado']) ?></span></td>
                    <td><?= count($e['preguntas']) ?></td>
                    <td><?= $totales[$e['id']] ?? 0 ?></td>
                    <td><?= date('d/m/Y', strtotime($e['created_at'])) ?></td>
                    <td>
                        <div class="actions">
                            <a href="/?url=encuesta/resultados/<?= $e['id'] ?>" class="btn-sm btn-results">📊 Resultados</a>
                            <?php if ($e['estado'] === 'activa'): ?>
                                <a href="/?url=encuesta/cerrar/<?= $e['id'] ?>" class="btn-sm btn-close">🔒 Cerrar</a>
                            <?php else: ?>
                                <a href="/?url=encuesta/activar/<?= $e['id'] ?>" class="btn-sm btn-open">🔓 Activar</a>
                            <?php endif; ?>
                            <form action="/?url=encuesta/eliminar" method="POST" onsubmit="return confirm('¿Eliminar esta encuesta y todas sus respuestas?')">
                                <input type="hidden" name="id" value="<?= $e['id'] ?>">
                                <button type="submit" class="btn-sm btn-del">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>
</body>
</html>

