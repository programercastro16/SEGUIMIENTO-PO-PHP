<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disponibilidad de Reservas</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f0f4ff;
            color: #1e293b;
            min-height: 100vh;
        }
        header {
            background: linear-gradient(135deg, #3730a3 0%, #4f46e5 60%, #6366f1 100%);
            color: #fff;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(79, 70, 229, .4);
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
        main { max-width: 900px; margin: 2rem auto; padding: 0 1.5rem; }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,.08);
            margin-bottom: 2rem;
        }
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }
        @media(max-width: 650px) {
            .form-grid { grid-template-columns: 1fr; }
        }
        label {
            display: block;
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: .4rem;
            color: #475569;
        }
        select, input[type="date"] {
            width: 100%;
            padding: .65rem .9rem;
            border: 2px solid #cbd5e1;
            border-radius: 8px;
            font-size: .95rem;
        }
        select:focus, input[type="date"]:focus {
            outline: none;
            border-color: #4f46e5;
        }
        .btn-submit {
            background: #4f46e5;
            color: #fff;
            border: none;
            padding: .75rem 1.4rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-submit:hover { background: #4338ca; }
        .slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .slot-pill {
            padding: 1rem;
            background: #dcfce7;
            color: #166534;
            border: 2px solid #86efac;
            border-radius: 12px;
            text-align: center;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .slot-empty {
            text-align: center;
            padding: 3rem 1rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
<header>
    <div>
        <h1>Consulta de Disponibilidad</h1>
        <p style="font-size: .85rem; opacity: .85; margin-top: .2rem;">Verifica las horas libres para agendar tu servicio</p>
    </div>
    <nav class="header-nav">
        <a href="index.php?url=reserva/nueva" class="btn-header">Nueva Reserva</a>
        <a href="index.php?url=reserva" class="btn-header">Listado General</a>
    </nav>
</header>
<main>
    <div class="card">
        <form method="GET" action="index.php?url=reserva/disponibilidad" class="form-grid">
            <div>
                <label for="servicio_id">Servicio</label>
                <select name="servicio_id" id="servicio_id" required>
                    <option value="">-- Seleccionar servicio --</option>
                    <?php foreach ($servicios as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= $servicioSel == $s['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($s['nombre']) ?> (<?= $s['duracion'] ?> min)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="<?= htmlspecialchars($fechaSel) ?>" min="<?= date('Y-m-d') ?>" required>
            </div>
            <div>
                <button type="submit" class="btn-submit">Consultar</button>
            </div>
        </form>
    </div>

    <div class="card">
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #1e1b4b;">
            Horarios Disponibles para <?= htmlspecialchars($fechaSel) ?>
        </h2>

        <?php if ($buscado): ?>
            <?php if (!empty($slots)): ?>
                <div class="slots-grid">
                    <?php foreach ($slots as $hora): ?>
                        <div class="slot-pill"><?= htmlspecialchars($hora) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="slot-empty">
                    <p>No hay horarios disponibles para esta fecha y servicio seleccionado.</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="slot-empty">
                <p>Selecciona un servicio y una fecha para ver las horas disponibles.</p>
            </div>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
