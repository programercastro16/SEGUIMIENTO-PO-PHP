<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 <?= htmlspecialchars($encuesta['titulo']) ?></title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:#f0f4ff;min-height:100vh;padding:2rem 1rem}
        .container{max-width:680px;margin:0 auto}
        .header{background:linear-gradient(135deg,#4338ca,#6366f1);color:#fff;border-radius:16px;padding:2rem;margin-bottom:1.5rem}
        .header h1{font-size:1.5rem;font-weight:800}
        .header p{opacity:.85;margin-top:.4rem;font-size:.9rem}
        .errores{background:#fef2f2;border-left:4px solid #ef4444;border-radius:10px;padding:1rem 1.25rem;margin-bottom:1.5rem}
        .errores li{color:#b91c1c;margin-left:1.2rem;font-size:.875rem}
        .pregunta-card{background:#fff;border-radius:14px;padding:1.5rem;box-shadow:0 4px 16px rgba(0,0,0,.08);margin-bottom:1rem}
        .pregunta-num{font-size:.75rem;font-weight:800;color:#6366f1;text-transform:uppercase;letter-spacing:.07em;margin-bottom:.4rem}
        .pregunta-text{font-size:1rem;font-weight:700;color:#1e293b;margin-bottom:1rem}
        .opcion-row{display:flex;align-items:center;gap:.75rem;padding:.6rem .75rem;border-radius:10px;cursor:pointer;transition:background .15s;border:2px solid transparent}
        .opcion-row:hover{background:#ede9fe}
        .opcion-row input[type="radio"]{accent-color:#6366f1;width:18px;height:18px;flex-shrink:0}
        .opcion-row label{cursor:pointer;font-size:.95rem;color:#374151;font-weight:500}
        /* Escala */
        .escala-row{display:flex;gap:.75rem;flex-wrap:wrap;margin-top:.5rem}
        .escala-opt input[type="radio"]{position:absolute;opacity:0;width:0;height:0}
        .escala-opt{position:relative}
        .escala-btn{display:flex;align-items:center;justify-content:center;width:52px;height:52px;border:2px solid #c7d2fe;border-radius:12px;cursor:pointer;font-size:1.1rem;font-weight:800;color:#4338ca;transition:all .15s;background:#f8f7ff}
        .escala-opt input:checked+.escala-btn{background:#6366f1;border-color:#6366f1;color:#fff}
        .escala-btn:hover{border-color:#6366f1;background:#ede9fe}
        .escala-labels{display:flex;justify-content:space-between;margin-top:.4rem;font-size:.72rem;color:#94a3b8}
        .btn-submit{width:100%;padding:1rem;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-size:1.1rem;font-weight:800;border:none;border-radius:12px;cursor:pointer;transition:transform .15s;margin-top:1.5rem}
        .btn-submit:hover{transform:translateY(-2px)}
        .already{background:#f0fdf4;border-left:4px solid #22c55e;border-radius:10px;padding:1.5rem;text-align:center;font-weight:700;color:#166534}
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1><?= htmlspecialchars($encuesta['titulo']) ?></h1>
        <p><?= htmlspecialchars($encuesta['descripcion']) ?></p>
    </div>

    <?php if ($yaRespondio): ?>
        <div class="already">✅ Ya respondiste esta encuesta. ¡Gracias por tu participación!</div>
        <p style="text-align:center;margin-top:1rem"><a href="/?url=encuesta">← Volver a encuestas</a></p>
    <?php else: ?>
        <?php if (!empty($errores)): ?>
            <div class="errores"><ul><?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
        <?php endif; ?>
        <form action="/?url=encuesta/responder/<?= $encuesta['id'] ?>" method="POST">
            <?php foreach ($encuesta['preguntas'] as $i => $p): ?>
            <div class="pregunta-card">
                <div class="pregunta-num">Pregunta <?= $i+1 ?> de <?= count($encuesta['preguntas']) ?></div>
                <div class="pregunta-text"><?= htmlspecialchars($p['texto']) ?></div>
                <?php if ($p['tipo'] === 'opcion_multiple'): ?>
                    <?php foreach ($p['opciones'] as $opt): ?>
                    <div class="opcion-row">
                        <input type="radio" id="<?= $p['id'].'_'.md5($opt) ?>" name="respuestas[<?= $p['id'] ?>]" value="<?= htmlspecialchars($opt) ?>" required>
                        <label for="<?= $p['id'].'_'.md5($opt) ?>"><?= htmlspecialchars($opt) ?></label>
                    </div>
                    <?php endforeach; ?>
                <?php elseif ($p['tipo'] === 'verdadero_falso'): ?>
                    <div class="opcion-row">
                        <input type="radio" id="<?= $p['id'] ?>_si" name="respuestas[<?= $p['id'] ?>]" value="Sí" required>
                        <label for="<?= $p['id'] ?>_si">✅ Sí</label>
                    </div>
                    <div class="opcion-row">
                        <input type="radio" id="<?= $p['id'] ?>_no" name="respuestas[<?= $p['id'] ?>]" value="No">
                        <label for="<?= $p['id'] ?>_no">❌ No</label>
                    </div>
                <?php else: /* escala */ ?>
                    <div class="escala-row">
                        <?php for ($s=1;$s<=5;$s++): ?>
                        <div class="escala-opt">
                            <input type="radio" id="<?= $p['id'].'_'.$s ?>" name="respuestas[<?= $p['id'] ?>]" value="<?= $s ?>" required>
                            <label class="escala-btn" for="<?= $p['id'].'_'.$s ?>"><?= $s ?></label>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <div class="escala-labels"><span>Muy malo</span><span>Excelente</span></div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <button type="submit" class="btn-submit">📤 Enviar Respuestas</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>

