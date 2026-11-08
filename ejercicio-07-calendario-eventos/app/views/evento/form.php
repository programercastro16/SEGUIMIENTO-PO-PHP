<?php
/**
 * View: evento/form.php — Crear o editar evento
 */
$esEdicion = !empty($evento['id']);
$titulo    = $esEdicion ? '✏️ Editar Evento' : '➕ Nuevo Evento';
$accion    = $esEdicion ? '/?url=evento/editar/' . $evento['id'] : '/?url=evento/nuevo';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #2d1b69, #5b21b6, #7c3aed);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        .card {
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            width: 100%;
            max-width: 540px;
            box-shadow: 0 25px 60px rgba(0,0,0,.35);
        }
        h1 { font-size: 1.8rem; font-weight: 800; color: #5b21b6; margin-bottom: 1.75rem; }
        .errores {
            background: #fef2f2; border-left: 4px solid #ef4444;
            border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;
        }
        .errores li { color: #b91c1c; font-size: .875rem; margin-left: 1.2rem; }
        .form-group { margin-bottom: 1.2rem; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        label { display: block; font-size: .875rem; font-weight: 600; color: #374151; margin-bottom: .4rem; }
        input, select, textarea {
            width: 100%; padding: .75rem 1rem;
            border: 2px solid #ddd6fe; border-radius: 10px;
            font-size: 1rem; color: #1f2937; background: #f8f5ff;
            transition: border-color .2s, box-shadow .2s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124,58,237,.12); background: #fff;
        }
        textarea { resize: vertical; min-height: 90px; font-family: inherit; }
        .checkbox-row {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .75rem 1rem;
            border: 2px solid #ddd6fe;
            border-radius: 10px;
            background: #f8f5ff;
            cursor: pointer;
        }
        .checkbox-row input[type="checkbox"] { width: 18px; height: 18px; cursor: pointer; accent-color: #7c3aed; }
        .checkbox-row span { font-size: .9rem; font-weight: 600; color: #374151; }
        .btn-row { display: flex; gap: 1rem; margin-top: 1.5rem; }
        .btn-primary {
            flex: 1; padding: .85rem;
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            color: #fff; font-size: 1rem; font-weight: 700;
            border: none; border-radius: 10px; cursor: pointer;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(124,58,237,.4); }
        .btn-secondary {
            flex: 1; padding: .85rem; background: #f3f4f6;
            color: #374151; font-size: 1rem; font-weight: 600;
            border: 2px solid #d1d5db; border-radius: 10px;
            text-decoration: none; text-align: center;
        }
        .btn-secondary:hover { background: #e5e7eb; }
    </style>
</head>
<body>
<div class="card">
    <h1><?= $titulo ?></h1>

    <?php if (!empty($errores)): ?>
        <div class="errores"><ul>
            <?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
        </ul></div>
    <?php endif; ?>

    <form action="<?= $accion ?>" method="POST">
        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($evento['id']) ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="titulo_ev">🎯 Título del evento</label>
            <input type="text" id="titulo_ev" name="titulo" maxlength="150"
                   placeholder="Ej: Reunión de equipo"
                   value="<?= htmlspecialchars($evento['titulo'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="descripcion">📄 Descripción</label>
            <textarea id="descripcion" name="descripcion"
                      placeholder="Detalles del evento..."><?= htmlspecialchars($evento['descripcion'] ?? '') ?></textarea>
        </div>

        <div class="form-row form-group">
            <div>
                <label for="fecha">📅 Fecha</label>
                <input type="date" id="fecha" name="fecha"
                       value="<?= htmlspecialchars($evento['fecha'] ?? $fechaDefault ?? date('Y-m-d')) ?>" required>
            </div>
            <div>
                <label for="categoria">🏷️ Categoría</label>
                <select id="categoria" name="categoria">
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>"
                            <?= (($evento['categoria'] ?? '') === $cat) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row form-group">
            <div>
                <label for="hora_inicio">🕐 Hora inicio</label>
                <input type="time" id="hora_inicio" name="hora_inicio"
                       value="<?= htmlspecialchars($evento['hora_inicio'] ?? '09:00') ?>">
            </div>
            <div>
                <label for="hora_fin">🕐 Hora fin</label>
                <input type="time" id="hora_fin" name="hora_fin"
                       value="<?= htmlspecialchars($evento['hora_fin'] ?? '10:00') ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="checkbox-row" for="recordatorio">
                <input type="checkbox" id="recordatorio" name="recordatorio" value="1"
                       <?= !empty($evento['recordatorio']) ? 'checked' : '' ?>>
                <span>🔔 Activar recordatorio para este evento</span>
            </label>
        </div>

        <div class="btn-row">
            <a href="/?url=evento" class="btn-secondary">← Cancelar</a>
            <button type="submit" class="btn-primary">
                <?= $esEdicion ? '💾 Guardar Cambios' : '➕ Crear Evento' ?>
            </button>
        </div>
    </form>
</div>
</body>
</html>

