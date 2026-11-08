<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Plataforma de Encuestas</title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:#f0f4ff;color:#1e293b;min-height:100vh}
        header{background:linear-gradient(135deg,#1e1b4b,#4338ca,#6366f1);color:#fff;padding:1.5rem 2rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem}
        header h1{font-size:1.7rem;font-weight:800}
        header p{font-size:.85rem;opacity:.8;margin-top:.2rem}
        .btn-admin{background:rgba(255,255,255,.18);color:#fff;padding:.6rem 1.2rem;border-radius:10px;text-decoration:none;font-weight:700;font-size:.9rem}
        .btn-admin:hover{background:rgba(255,255,255,.3)}
        .container{max-width:900px;margin:0 auto;padding:2rem 1rem}
        .flash{background:#f0fdf4;border-left:4px solid #22c55e;border-radius:10px;padding:.9rem 1.25rem;margin-bottom:1.5rem;font-weight:600;color:#166534}
        .grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem}
        .card{background:#fff;border-radius:16px;padding:1.75rem;box-shadow:0 4px 16px rgba(0,0,0,.08);border-top:4px solid #6366f1;transition:transform .2s,box-shadow .2s}
        .card:hover{transform:translateY(-4px);box-shadow:0 12px 30px rgba(0,0,0,.12)}
        .card-title{font-size:1.15rem;font-weight:800;color:#1e293b;margin-bottom:.5rem}
        .card-desc{font-size:.875rem;color:#64748b;line-height:1.6;margin-bottom:1rem}
        .card-meta{font-size:.78rem;color:#94a3b8;margin-bottom:1rem}
        .badge-ya{display:inline-block;padding:.3rem .9rem;background:#fef3c7;color:#92400e;border-radius:20px;font-size:.78rem;font-weight:700;margin-bottom:1rem}
        .btn-responder{display:block;text-align:center;padding:.7rem;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;border-radius:10px;text-decoration:none;font-weight:700;font-size:.9rem;transition:opacity .2s}
        .btn-responder:hover{opacity:.88}
        .btn-disabled{background:#e2e8f0;color:#94a3b8;cursor:not-allowed}
        .empty{text-align:center;padding:4rem;color:#94a3b8}
        .empty .icon{font-size:4rem}
    </style>
</head>
<body>
<header>
    <div><h1>📊 Plataforma de Encuestas</h1><p>Responde encuestas y comparte tu opinión</p></div>
    <a href="/?url=encuesta/administrar" class="btn-admin">⚙️ Administrar</a>
</header>
<div class="container">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash"><?= htmlspecialchars($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php if (empty($encuestas)): ?>
        <div class="empty"><div class="icon">📭</div><p style="margin-top:.75rem">No hay encuestas activas por ahora.</p></div>
    <?php else: ?>
    <div class="grid">
        <?php foreach ($encuestas as $e):
            $yaResp = !empty($_SESSION['respondio_' . $e['id']]);
        ?>
        <div class="card">
            <div class="card-title"><?= htmlspecialchars($e['titulo']) ?></div>
            <div class="card-desc"><?= htmlspecialchars($e['descripcion']) ?></div>
            <div class="card-meta">📋 <?= count($e['preguntas']) ?> preguntas · 📅 <?= date('d/m/Y', strtotime($e['created_at'])) ?></div>
            <?php if ($yaResp): ?>
                <span class="badge-ya">✅ Ya respondiste esta encuesta</span>
                <div class="btn-responder btn-disabled">Ya respondida</div>
            <?php else: ?>
                <a href="/?url=encuesta/responder/<?= $e['id'] ?>" class="btn-responder">📝 Responder Encuesta</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
</body>
</html>

