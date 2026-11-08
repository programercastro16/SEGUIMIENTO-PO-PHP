<?php
/**
 * View: nota/form.php - Crear o editar nota
 */
$esEdicion = !empty($nota['id']);
$titulo    = $esEdicion ? '✏️ Editar Nota' : '📝 Nueva Nota';
$accion    = $esEdicion ? '/?url=nota/editar/' . $nota['id'] : '/?url=nota/nueva';

$colores = [
    'amarillo' => ['bg'=>'#fff9c4','border'=>'#f9a825','label'=>'Amarillo'],
    'azul'     => ['bg'=>'#bbdefb','border'=>'#1565c0','label'=>'Azul'],
    'verde'    => ['bg'=>'#c8e6c9','border'=>'#2e7d32','label'=>'Verde'],
    'rosa'     => ['bg'=>'#f8bbd0','border'=>'#c2185b','label'=>'Rosa'],
    'morado'   => ['bg'=>'#e1bee7','border'=>'#6a1b9a','label'=>'Morado'],
    'naranja'  => ['bg'=>'#ffe0b2','border'=>'#e65100','label'=>'Naranja'],
    'gris'     => ['bg'=>'#f5f5f5','border'=>'#424242','label'=>'Gris'],
];
$colorSeleccionado = $nota['color'] ?? 'amarillo';
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
            background: #faf7f2;
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
            max-width: 560px;
            box-shadow: 0 20px 50px rgba(0,0,0,.12);
        }
        h1 { font-size: 1.8rem; font-weight: 800; color: #2d2d2d; margin-bottom: 1.75rem; }
        .errores {
            background: #fef2f2; border-left: 4px solid #ef4444;
            border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 1.5rem;
        }
        .errores li { color: #b91c1c; font-size: .875rem; margin-left: 1.2rem; }
        .form-group { margin-bottom: 1.25rem; }
        label { display: block; font-size: .875rem; font-weight: 600; color: #374151; margin-bottom: .5rem; }
        input[type="text"], select, textarea {
            width: 100%; padding: .75rem 1rem;
            border: 2px solid #e5e7eb; border-radius: 10px;
            font-size: 1rem; color: #1f2937; background: #f9fafb;
            transition: border-color .2s, box-shadow .2s;
        }
        input[type="text"]:focus, select:focus, textarea:focus {
            outline: none; border-color: #ff6b6b;
            box-shadow: 0 0 0 3px rgba(255,107,107,.12); background: #fff;
        }
        textarea { resize: vertical; min-height: 180px; font-family: inherit; }
        /* Color picker */
        .color-grid {
            display: flex;
            gap: .6rem;
            flex-wrap: wrap;
        }
        .color-opt { position: relative; }
        .color-opt input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .color-swatch {
            width: 38px; height: 38px;
            border-radius: 50%;
            border: 3px solid transparent;
            cursor: pointer;
            display: block;
            transition: transform .15s, border-color .15s;
        }
        .color-opt input[type="radio"]:checked + .color-swatch {
            border-color: #1f2937;
            transform: scale(1.2);
        }
        .color-swatch:hover { transform: scale(1.1); }
        .btn-row { display: flex; gap: 1rem; margin-top: 1.5rem; }
        .btn-primary {
            flex: 1; padding: .85rem;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: #fff; font-size: 1rem; font-weight: 700;
            border: none; border-radius: 10px; cursor: pointer;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(255,107,107,.4); }
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
            <?php foreach ($errores as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul></div>
    <?php endif; ?>

    <form action="<?= $accion ?>" method="POST">
        <?php if ($esEdicion): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($nota['id']) ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="titulo">📌 Título</label>
            <input type="text" id="titulo" name="titulo" maxlength="150"
                   placeholder="Título de la nota"
                   value="<?= htmlspecialchars($nota['titulo'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="contenido">📄 Contenido</label>
            <textarea id="contenido" name="contenido" placeholder="Escribe tu nota aquí..." required><?= htmlspecialchars($nota['contenido'] ?? '') ?></textarea>
        </div>

        <div class="form-group">
            <label for="categoria">📂 Categoría</label>
            <select id="categoria" name="categoria">
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"
                        <?= (($nota['categoria'] ?? '') === $cat) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>🎨 Color de la nota</label>
            <div class="color-grid">
                <?php foreach ($colores as $key => $c): ?>
                <div class="color-opt">
                    <input type="radio" name="color" id="color_<?= $key ?>"
                           value="<?= $key ?>"
                           <?= $colorSeleccionado === $key ? 'checked' : '' ?>>
                    <label class="color-swatch" for="color_<?= $key ?>"
                           style="background:<?= $c['bg'] ?>; border-color:<?= $c['border'] ?>;"
                           title="<?= $c['label'] ?>"></label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="btn-row">
            <a href="/?url=nota" class="btn-secondary">← Cancelar</a>
            <button type="submit" class="btn-primary">
                <?= $esEdicion ? '💾 Guardar Cambios' : '📝 Crear Nota' ?>
            </button>
        </div>
    </form>
</div>
</body>
</html>

