<?php
$esEdicion = !empty($receta['id']);
$titulo    = $esEdicion ? '✏️ Editar Receta' : '➕ Nueva Receta';
$accion    = $esEdicion ? '/?url=receta/editar/' . $receta['id'] : '/?url=receta/nueva';
$ingText   = $esEdicion ? implode("\n", $receta['ingredientes'] ?? []) : '';
$instText  = $esEdicion ? implode("\n", $receta['instrucciones'] ?? []) : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #fff8f0; min-height: 100vh; padding: 2rem 1rem; }
        .container { max-width: 680px; margin: 0 auto; }
        h1 { font-size: 1.8rem; font-weight: 800; color: #7c2d12; margin-bottom: 1.75rem; }
        .errores { background: #fef2f2; border-left: 4px solid #ef4444; border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; }
        .errores li { color: #b91c1c; font-size: .875rem; margin-left: 1.2rem; }
        .card { background: #fff; border-radius: 16px; padding: 1.75rem; box-shadow: 0 4px 16px rgba(0,0,0,.08); margin-bottom: 1.5rem; }
        .card h2 { font-size: 1rem; font-weight: 700; color: #7c2d12; margin-bottom: 1.25rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        label { display: block; font-size: .875rem; font-weight: 600; color: #374151; margin-bottom: .4rem; }
        input, select, textarea { width: 100%; padding: .75rem 1rem; border: 2px solid #fed7aa; border-radius: 10px; font-size: 1rem; color: #1f2937; background: #fffbf7; transition: border-color .2s, box-shadow .2s; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234,88,12,.12); background: #fff; }
        textarea { resize: vertical; min-height: 120px; font-family: inherit; }
        .hint { font-size: .75rem; color: #9ca3af; margin-top: .3rem; }
        .btn-row { display: flex; gap: 1rem; }
        .btn-primary { flex: 1; padding: .85rem; background: linear-gradient(135deg, #ea580c, #c2410c); color: #fff; font-size: 1rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; transition: transform .15s; }
        .btn-primary:hover { transform: translateY(-2px); }
        .btn-secondary { flex: 1; padding: .85rem; background: #f3f4f6; color: #374151; font-size: 1rem; font-weight: 600; border: 2px solid #d1d5db; border-radius: 10px; text-decoration: none; text-align: center; }
        .btn-secondary:hover { background: #e5e7eb; }
        @media (max-width: 540px) { .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="container">
    <h1><?= $titulo ?></h1>
    <?php if (!empty($errores)): ?>
        <div class="errores"><ul><?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form action="<?= $accion ?>" method="POST">
        <?php if ($esEdicion): ?><input type="hidden" name="id" value="<?= htmlspecialchars($receta['id']) ?>"><?php endif; ?>

        <div class="card">
            <h2>📌 Información General</h2>
            <div class="form-group">
                <label>Título de la receta *</label>
                <input type="text" name="titulo" placeholder="Ej: Arroz con Pollo" value="<?= htmlspecialchars($receta['titulo'] ?? '') ?>" required maxlength="150">
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" placeholder="Breve descripción de la receta..."><?= htmlspecialchars($receta['descripcion'] ?? '') ?></textarea>
            </div>
            <div class="form-row form-group">
                <div>
                    <label>Tipo de comida</label>
                    <select name="tipo_comida">
                        <?php foreach ($tipos as $t): ?>
                            <option value="<?= $t ?>" <?= ($receta['tipo_comida'] ?? '') === $t ? 'selected' : '' ?>><?= $t ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Dificultad</label>
                    <select name="dificultad">
                        <?php foreach ($dificultades as $d): ?>
                            <option value="<?= $d ?>" <?= ($receta['dificultad'] ?? '') === $d ? 'selected' : '' ?>><?= $d ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row form-group">
                <div>
                    <label>Tiempo de preparación (min)</label>
                    <input type="number" name="tiempo_preparacion" min="1" max="1440" value="<?= htmlspecialchars($receta['tiempo_preparacion'] ?? '30') ?>">
                </div>
                <div>
                    <label>Porciones</label>
                    <input type="number" name="porciones" min="1" max="100" value="<?= htmlspecialchars($receta['porciones'] ?? '4') ?>">
                </div>
            </div>
            <div class="form-group">
                <label>Autor</label>
                <input type="text" name="autor" placeholder="Tu nombre o alias" value="<?= htmlspecialchars($receta['autor'] ?? '') ?>" maxlength="80">
            </div>
        </div>

        <div class="card">
            <h2>🧪 Ingredientes *</h2>
            <div class="form-group">
                <textarea name="ingredientes" rows="8" placeholder="Un ingrediente por línea&#10;Ej:&#10;2 tazas de arroz&#10;500g de pollo&#10;1 cebolla"><?= htmlspecialchars($ingText) ?></textarea>
                <p class="hint">✍️ Escribe un ingrediente por línea.</p>
            </div>
        </div>

        <div class="card">
            <h2>📋 Instrucciones *</h2>
            <div class="form-group">
                <textarea name="instrucciones" rows="8" placeholder="Un paso por línea&#10;Ej:&#10;Lavar y trocear el pollo&#10;Sofreír con ajo y cebolla"><?= htmlspecialchars($instText) ?></textarea>
                <p class="hint">✍️ Escribe un paso por línea. Se numerarán automáticamente.</p>
            </div>
        </div>

        <div class="btn-row">
            <a href="/?url=receta" class="btn-secondary">← Cancelar</a>
            <button type="submit" class="btn-primary"><?= $esEdicion ? '💾 Guardar Cambios' : '🍳 Publicar Receta' ?></button>
        </div>
    </form>
</div>
</body>
</html>

