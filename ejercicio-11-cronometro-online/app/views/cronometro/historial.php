<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📋 Historial de Sesiones</title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:#0a0a0f;color:#e2e8f0;min-height:100vh}
        header{padding:1.25rem 2rem;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,.07)}
        header h1{font-size:1.3rem;font-weight:800;color:#34d399}
        .btn-h{background:rgba(52,211,153,.12);color:#34d399;padding:.5rem 1.1rem;border-radius:8px;text-decoration:none;font-size:.85rem;font-weight:700;border:1px solid rgba(52,211,153,.3)}
        .btn-h:hover{background:rgba(52,211,153,.22)}
        .container{max-width:900px;margin:0 auto;padding:2rem 1rem}
        .table-wrap{background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:16px;overflow:hidden}
        table{width:100%;border-collapse:collapse}
        th{font-size:.72rem;text-transform:uppercase;letter-spacing:.07em;color:rgba(255,255,255,.35);padding:.75rem 1rem;text-align:left;border-bottom:1px solid rgba(255,255,255,.07)}
        td{padding:.85rem 1rem;border-bottom:1px solid rgba(255,255,255,.05);font-size:.9rem}
        tr:last-child td{border-bottom:none}
        tr:hover{background:rgba(255,255,255,.03)}
        .time-val{font-family:'Courier New',monospace;color:#34d399;font-weight:700}
        .btn-sm{padding:.35rem .8rem;border-radius:7px;font-size:.78rem;font-weight:700;border:none;cursor:pointer;text-decoration:none}
        .btn-ver{background:rgba(99,102,241,.18);color:#818cf8}
        .btn-del{background:rgba(239,68,68,.12);color:#f87171}
        .btn-sm:hover{opacity:.8}
        .actions{display:flex;gap:.5rem}
        .empty{text-align:center;padding:4rem;color:rgba(255,255,255,.25)}
        .empty .icon{font-size:3rem;display:block;margin-bottom:.75rem}
    </style>
</head>
<body>
<header>
    <h1>📋 Historial de Sesiones</h1>
    <a href="/?url=cronometro" class="btn-h">⏱️ Cronómetro</a>
</header>
<div class="container">
    <?php if (empty($sesiones)): ?>
        <div class="empty">
            <span class="icon">📭</span>
            No hay sesiones guardadas aún.<br>
            <a href="/?url=cronometro" style="color:#34d399;margin-top:1rem;display:inline-block;">← Ir al cronómetro</a>
        </div>
    <?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Nombre</th><th>Tiempo Total</th><th>Vueltas</th><th>Fecha</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                <?php foreach ($sesiones as $s): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($s['nombre_sesion']) ?></strong></td>
                    <td><span class="time-val"><?= htmlspecialchars($s['tiempo_total_fmt'] ?? '00:00.00') ?></span></td>
                    <td><?= count($s['vueltas'] ?? []) ?> vuelta(s)</td>
                    <td style="color:rgba(255,255,255,.4);font-size:.82rem;"><?= date('d/m/Y H:i', strtotime($s['fecha'])) ?></td>
                    <td>
                        <div class="actions">
                            <a href="/?url=cronometro/verSesion/<?= $s['id'] ?>" class="btn-sm btn-ver">👁️ Ver</a>
                            <form action="/?url=cronometro/eliminar" method="POST" onsubmit="return confirm('¿Eliminar esta sesión?')">
                                <input type="hidden" name="id" value="<?= $s['id'] ?>">
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
