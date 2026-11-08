<?php
/**
 * View: reserva/form.php
 * Formulario para crear una nueva reserva.
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Nueva Reserva</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #1e1b4b, #3730a3, #4f46e5);
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
        h1 { font-size: 1.8rem; font-weight: 800; color: #3730a3; margin-bottom: 1.75rem; }
        .msg-ok {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-left: 4px solid #22c55e; border-radius: 10px;
            padding: 1rem 1.25rem; margin-bottom: 1.5rem;
            color: #166534; font-weight: 600;
        }
        .msg-err {
            background: #fef2f2; border: 1px solid #fecaca;
            border-left: 4px solid #ef4444; border-radius: 10px;
            padding: 1rem 1.25rem; margin-bottom: 1.5rem;
        }
        .msg-err ul { padding-left: 1.2rem; }
        .msg-err li { color: #b91c1c; font-size: .875rem; margin-bottom: .2rem; }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; font-size: .875rem; font-weight: 600; color: #374151; margin-bottom: .4rem; }
        input, select {
            width: 100%; padding: .75rem 1rem;
            border: 2px solid #c7d2fe; border-radius: 10px;
            font-size: 1rem; color: #1f2937; background: #f8f9ff;
            transition: border-color .2s, box-shadow .2s;
        }
        input:focus, select:focus {
            outline: none; border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.15); background: #fff;
        }
        .servicio-info {
            margin-top: .4rem; font-size: .8rem;
            color: #6366f1; font-weight: 600;
        }
        .btn-row { display: flex; gap: 1rem; margin-top: 1.5rem; }
        .btn-primary {
            flex: 1; padding: .85rem;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff; font-size: 1rem; font-weight: 700;
            border: none; border-radius: 10px; cursor: pointer;
            transition: transform .15s, box-shadow .15s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(99,102,241,.4); }
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
    <h1>📅 Nueva Reserva</h1>

    <?php if (!empty($_SESSION['flash_ok'])): ?>
        <div class="msg-ok">✅ <?= htmlspecialchars($_SESSION['flash_ok']) ?></div>
        <?php unset($_SESSION['flash_ok']); ?>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <div class="msg-err">
            <ul>
                <?php foreach ($errores as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/?url=reserva/nueva" method="POST">

        <div class="form-group">
            <label for="nombre_cliente">👤 Nombre completo</label>
            <input type="text" id="nombre_cliente" name="nombre_cliente" maxlength="100"
                   placeholder="Tu nombre completo"
                   value="<?= htmlspecialchars($_POST['nombre_cliente'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="email">📧 Correo electrónico</label>
            <input type="email" id="email" name="email"
                   placeholder="correo@ejemplo.com"
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="telefono">📱 Teléfono</label>
            <input type="tel" id="telefono" name="telefono"
                   placeholder="Ej: 300 123 4567"
                   value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="servicio_id">🛎️ Servicio</label>
            <select id="servicio_id" name="servicio_id" required onchange="actualizarInfo()">
                <option value="">— Selecciona un servicio —</option>
                <?php foreach ($servicios as $s): ?>
                    <option value="<?= $s['id'] ?>"
                        data-duracion="<?= $s['duracion'] ?>"
                        data-precio="<?= $s['precio'] ?>"
                        <?= (($_POST['servicio_id'] ?? '') == $s['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['nombre']) ?> (<?= $s['duracion'] ?> min — $<?= number_format($s['precio'], 0) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="servicio-info" id="servicio-info"></div>
        </div>

        <div class="form-group">
            <label for="fecha">📅 Fecha</label>
            <input type="date" id="fecha" name="fecha"
                   min="<?= date('Y-m-d') ?>"
                   value="<?= htmlspecialchars($_POST['fecha'] ?? date('Y-m-d')) ?>" required>
        </div>

        <div class="form-group">
            <label for="hora">🕐 Hora disponible</label>
            <select id="hora" name="hora" required>
                <option value="">— Selecciona la hora —</option>
                <?php
                $horasDisp = $horasDisponibles ?? [];
                $horas = ['09:00','09:30','10:00','10:30','11:00','11:30',
                          '12:00','12:30','13:00','13:30','14:00','14:30',
                          '15:00','15:30','16:00','16:30','17:00','17:30'];
                foreach ($horas as $h):
                    $disponible = empty($horasDisp) || in_array($h, $horasDisp);
                ?>
                    <option value="<?= $h ?>"
                        <?= !$disponible ? 'disabled' : '' ?>
                        <?= (($_POST['hora'] ?? '') === $h) ? 'selected' : '' ?>>
                        <?= $h ?><?= !$disponible ? ' (no disponible)' : '' ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="btn-row">
            <a href="/?url=reserva" class="btn-secondary">← Cancelar</a>
            <button type="submit" class="btn-primary">📅 Reservar</button>
        </div>
    </form>
</div>
<script>
function actualizarInfo() {
    const sel = document.getElementById('servicio_id');
    const opt = sel.options[sel.selectedIndex];
    const info = document.getElementById('servicio-info');
    if (opt.value) {
        info.textContent = `Duración: ${opt.dataset.duracion} min · Precio: $${parseInt(opt.dataset.precio).toLocaleString()}`;
    } else {
        info.textContent = '';
    }
}
</script>
</body>
</html>

