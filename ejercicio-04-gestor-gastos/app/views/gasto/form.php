<?php
/**
 * View: gasto/form.php
 * Formulario para agregar o editar un gasto.
 * Variables disponibles: $gasto (array|null), $categorias (array), $errores (array)
 */
$esEdicion = !empty($gasto['id']);
$titulo    = $esEdicion ? '✏️ Editar Gasto' : '➕ Agregar Gasto';
$accion    = $esEdicion
    ? '/?url=gasto/editar/' . $gasto['id']
    : '/?url=gasto/agregar';
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
            background: linear-gradient(135deg, #78350f 0%, #92400e 50%, #b45309 100%);
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
            max-width: 520px;
            box-shadow: 0 25px 60px rgba(0,0,0,.3);
        }
        h1 { font-size: 1.8rem; font-weight: 800; color: #78350f; margin-bottom: 1.75rem; }
        .errores {
            background: #fef2f2; border: 1px solid #fecaca;
            border-left: 4px solid #ef4444; border-radius: 10px;
            padding: 1rem 1.25rem; margin-bottom: 1.5rem;
        }
        .errores li { color: #b91c1c; font-size: .875rem; margin-left: 1.2rem; margin-bottom: .2rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: .875rem; font-weight: 600; color: #374151; margin-bottom: .4rem; }
        input, select, textarea {
            width: 100%; padding: .75rem 1rem;
            border: 2px solid #fed7aa; border-radius: 10px;
            font-size: 1rem; color: #1f2937;
            background: #fffbf7;
            transition: border-color .2s, box-shadow .2s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none; border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249,115,22,.15);
            background: #fff;
        }
        .btn-row { display: flex; gap: 1rem; margin-top: 1.5rem; }
        .btn-primary {
            flex: 1; padding: .85rem; background: linear-gradient(135deg, #f97316, #ea580c);
            color: #fff; font-size: 1rem; font-weight: 700;
            border: none; border-radius: 10px; cursor: pointer;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(249,115,22,.4); }
        .btn-secondary {
            flex: 1; padding: .85rem; background: #f3f4f6;
            color: #374151; font-size: 1rem; font-weight: 600;
            border: 2px solid #d1d5db; border-radius: 10px;
            text-decoration: none; text-align: center;
            transition: background .2s;
        }
        .btn-secondary:hover { background: #e5e7eb; }
    </style>
</head>
<body>
<div class="card">
    <h1><?= $titulo ?></h1>

    <?php if (!empty($errores)): ?>
    <div class="errores">
        <ul>
            <?php foreach ($errores as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?= $accion ?>" method="POST">
        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($gasto['id']) ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="descripcion">📝 Descripción</label>
            <input type="text" id="descripcion" name="descripcion" maxlength="200"
                   placeholder="Ej: Almuerzo en restaurante"
                   value="<?= htmlspecialchars($gasto['descripcion'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="monto">💵 Monto</label>
            <input type="number" id="monto" name="monto" min="0.01" step="0.01"
                   placeholder="0.00"
                   value="<?= htmlspecialchars($gasto['monto'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="categoria">🏷️ Categoría</label>
            <select id="categoria" name="categoria" required>
                <option value="">— Selecciona una categoría —</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"
                        <?= (($gasto['categoria'] ?? '') === $cat) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fecha">📅 Fecha</label>
            <input type="date" id="fecha" name="fecha"
                   value="<?= htmlspecialchars($gasto['fecha'] ?? date('Y-m-d')) ?>" required>
        </div>

        <div class="btn-row">
            <a href="/?url=gasto" class="btn-secondary">← Cancelar</a>
            <button type="submit" class="btn-primary">
                <?= $esEdicion ? '💾 Guardar Cambios' : '➕ Agregar Gasto' ?>
            </button>
        </div>
    </form>
</div>
</body>
</html>

