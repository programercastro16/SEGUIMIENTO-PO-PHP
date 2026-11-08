<?php
/**
 * View: gasto/index.php
 * Lists expenses with month/year filter and summary card.
 */

// Category badge colour map
$badgeColors = [
    'Alimentación'    => '#f97316',
    'Transporte'      => '#3b82f6',
    'Entretenimiento' => '#8b5cf6',
    'Salud'           => '#10b981',
    'Educación'       => '#06b6d4',
    'Hogar'           => '#f59e0b',
    'Ropa'            => '#ec4899',
    'Tecnología'      => '#6366f1',
    'Otros'           => '#78716c',
];

function badgeBg(string $cat, array $map): string {
    return $map[$cat] ?? '#78716c';
}

$mesesNombres = $meses; // passed from controller
$mesActualNombre = $mesesNombres[$mes] ?? '—';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💸 Gestor de Gastos</title>
    <style>
        /* ───── Reset & base ───── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #fff8f0;
            color: #1c1917;
            min-height: 100vh;
        }

        /* ───── Header ───── */
        header {
            background: linear-gradient(135deg, #f97316 0%, #f59e0b 100%);
            color: #fff;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 16px rgba(249,115,22,.35);
        }
        header h1 { font-size: 1.9rem; font-weight: 800; letter-spacing: -.5px; }
        header p  { font-size: .9rem; opacity: .85; margin-top: .2rem; }

        /* ───── Nav bar ───── */
        nav {
            background: #fff;
            border-bottom: 2px solid #fed7aa;
            display: flex;
            gap: .5rem;
            padding: .75rem 2rem;
            flex-wrap: wrap;
        }
        nav a {
            text-decoration: none;
            padding: .45rem 1.1rem;
            border-radius: 2rem;
            font-size: .88rem;
            font-weight: 600;
            color: #9a3412;
            border: 2px solid transparent;
            transition: all .2s;
        }
        nav a:hover, nav a.active {
            background: #f97316;
            color: #fff;
            border-color: #f97316;
        }

        /* ───── Main container ───── */
        main { max-width: 1100px; margin: 2rem auto; padding: 0 1.5rem; }

        /* ───── Flash message ───── */
        .flash {
            padding: .9rem 1.4rem;
            border-radius: .6rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
            font-size: .95rem;
        }
        .flash.exito { background: #dcfce7; color: #166534; border-left: 4px solid #22c55e; }
        .flash.error { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }

        /* ───── Filter card ───── */
        .filter-card {
            background: #fff;
            border: 2px solid #fed7aa;
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.75rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .filter-card label { font-weight: 600; color: #7c2d12; font-size: .9rem; }
        .filter-card select, .filter-card input[type="number"] {
            padding: .45rem .8rem;
            border: 2px solid #fed7aa;
            border-radius: .5rem;
            font-size: .9rem;
            color: #1c1917;
            background: #fff8f0;
            outline: none;
        }
        .filter-card select:focus, .filter-card input[type="number"]:focus {
            border-color: #f97316;
        }
        .btn {
            padding: .5rem 1.3rem;
            border: none;
            border-radius: .5rem;
            font-weight: 700;
            font-size: .9rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            transition: filter .2s, transform .1s;
        }
        .btn:active { transform: scale(.97); }
        .btn-primary { background: #f97316; color: #fff; }
        .btn-primary:hover { filter: brightness(1.1); }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .btn-secondary:hover { background: #d1d5db; }
        .btn-success { background: #22c55e; color: #fff; }
        .btn-success:hover { filter: brightness(1.08); }
        .btn-danger { background: #ef4444; color: #fff; }
        .btn-danger:hover { filter: brightness(1.08); }
        .btn-sm { padding: .3rem .75rem; font-size: .8rem; }
        .btn-info { background: #6366f1; color: #fff; }
        .btn-info:hover { filter: brightness(1.08); }

        /* ───── Summary cards row ───── */
        .cards-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.75rem;
        }
        .card {
            background: #fff;
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            border: 2px solid #fed7aa;
            text-align: center;
        }
        .card-icon { font-size: 2rem; margin-bottom: .4rem; }
        .card-label { font-size: .8rem; text-transform: uppercase; letter-spacing: .05em; color: #9a3412; font-weight: 700; }
        .card-value { font-size: 1.9rem; font-weight: 800; color: #f97316; }
        .card-sub { font-size: .82rem; color: #78716c; margin-top: .2rem; }

        /* ───── Action bar ───── */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: .75rem;
        }
        .action-bar h2 { font-size: 1.1rem; font-weight: 700; color: #7c2d12; }

        /* ───── Table ───── */
        .table-wrap { overflow-x: auto; border-radius: 1rem; border: 2px solid #fed7aa; }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            font-size: .91rem;
        }
        thead tr { background: linear-gradient(90deg, #f97316, #f59e0b); color: #fff; }
        thead th { padding: .9rem 1rem; text-align: left; font-weight: 700; white-space: nowrap; }
        tbody tr { border-bottom: 1px solid #fed7aa; transition: background .15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #fff8f0; }
        tbody td { padding: .75rem 1rem; vertical-align: middle; }

        /* ───── Badge ───── */
        .badge {
            display: inline-block;
            padding: .25rem .7rem;
            border-radius: 2rem;
            font-size: .78rem;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
        }

        /* ───── Monto ───── */
        .monto { font-weight: 700; color: #f97316; font-size: 1rem; }

        /* ───── Empty state ───── */
        .empty {
            text-align: center;
            padding: 3rem 2rem;
            color: #78716c;
        }
        .empty .icon { font-size: 3.5rem; }
        .empty p { margin-top: .5rem; font-size: 1rem; }

        /* ───── Confirm modal ───── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: #fff;
            border-radius: 1rem;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
        }
        .modal h3 { font-size: 1.3rem; margin-bottom: .75rem; }
        .modal p { color: #78716c; margin-bottom: 1.5rem; }
        .modal .btn-row { display: flex; gap: .75rem; justify-content: center; }

        @media (max-width: 600px) {
            header h1 { font-size: 1.4rem; }
            .filter-card { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<header>
    <h1>💸 Gestor de Gastos</h1>
    <p>Control inteligente de tus finanzas personales</p>
</header>

<nav>
    <a href="index.php?url=gasto/index" class="active">📋 Mis Gastos</a>
    <a href="index.php?url=gasto/agregar">➕ Agregar Gasto</a>
    <a href="index.php?url=gasto/resumen">📊 Resumen Mensual</a>
</nav>

<main>

    <?php if ($mensaje): ?>
        <div class="flash <?= htmlspecialchars($tipo) ?>">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <!-- ── Filter ── -->
    <form method="GET" action="index.php" class="filter-card">
        <input type="hidden" name="url" value="gasto/index">
        <label for="mes">🗓️ Mes:</label>
        <select id="mes" name="mes">
            <?php foreach ($mesesNombres as $num => $nombre): ?>
                <option value="<?= $num ?>" <?= $num === $mes ? 'selected' : '' ?>>
                    <?= htmlspecialchars($nombre) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="anio">Año:</label>
        <input type="number" id="anio" name="anio" value="<?= $anio ?>" min="2000" max="2100" style="width:90px;">

        <button type="submit" class="btn btn-primary">🔍 Filtrar</button>
        <a href="index.php?url=gasto/index" class="btn btn-secondary">↺ Hoy</a>
    </form>

    <!-- ── Summary cards ── -->
    <div class="cards-row">
        <div class="card">
            <div class="card-icon">💰</div>
            <div class="card-label">Total del mes</div>
            <div class="card-value">$<?= number_format($resumen['total'], 2, ',', '.') ?></div>
            <div class="card-sub"><?= htmlspecialchars($mesActualNombre) ?> <?= $anio ?></div>
        </div>
        <div class="card">
            <div class="card-icon">📝</div>
            <div class="card-label">Número de gastos</div>
            <div class="card-value"><?= $resumen['count'] ?></div>
            <div class="card-sub">registros encontrados</div>
        </div>
        <?php if ($resumen['count'] > 0): ?>
        <div class="card">
            <div class="card-icon">📈</div>
            <div class="card-label">Gasto promedio</div>
            <div class="card-value">$<?= number_format($resumen['total'] / $resumen['count'], 2, ',', '.') ?></div>
            <div class="card-sub">por transacción</div>
        </div>
        <?php endif; ?>
    </div>

    <!-- ── Action bar ── -->
    <div class="action-bar">
        <h2>🧾 Gastos de <?= htmlspecialchars($mesActualNombre) ?> <?= $anio ?></h2>
        <a href="index.php?url=gasto/agregar" class="btn btn-success">➕ Agregar Gasto</a>
    </div>

    <!-- ── Table ── -->
    <?php if (empty($gastos)): ?>
        <div class="empty">
            <div class="icon">🧾</div>
            <p>No hay gastos registrados para <strong><?= htmlspecialchars($mesActualNombre) ?> <?= $anio ?></strong>.</p>
            <br>
            <a href="index.php?url=gasto/agregar" class="btn btn-primary">➕ Agregar el primer gasto</a>
        </div>
    <?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Monto</th>
                    <th style="text-align:center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gastos as $gasto): ?>
                <tr>
                    <td>
                        <?php
                            $fechaObj = \DateTimeImmutable::createFromFormat('Y-m-d', $gasto['fecha']);
                            echo $fechaObj ? $fechaObj->format('d/m/Y') : htmlspecialchars($gasto['fecha']);
                        ?>
                    </td>
                    <td><?= htmlspecialchars($gasto['descripcion']) ?></td>
                    <td>
                        <span class="badge"
                              style="background:<?= badgeBg($gasto['categoria'], $badgeColors) ?>">
                            <?= htmlspecialchars($gasto['categoria']) ?>
                        </span>
                    </td>
                    <td class="monto">$<?= number_format($gasto['monto'], 2, ',', '.') ?></td>
                    <td style="text-align:center; white-space:nowrap;">
                        <a href="index.php?url=gasto/editar/<?= urlencode($gasto['id']) ?>"
                           class="btn btn-info btn-sm">✏️ Editar</a>
                        <button class="btn btn-danger btn-sm"
                                onclick="confirmarEliminar('<?= htmlspecialchars($gasto['id'], ENT_QUOTES) ?>',
                                                           '<?= htmlspecialchars(addslashes($gasto['descripcion']), ENT_QUOTES) ?>')">
                            🗑️ Eliminar
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

</main>

<!-- ── Delete confirm modal ── -->
<div class="modal-overlay" id="modalEliminar">
    <div class="modal">
        <h3>⚠️ Confirmar eliminación</h3>
        <p>¿Estás seguro de que deseas eliminar <strong id="modalDesc"></strong>?
           Esta acción no se puede deshacer.</p>
        <div class="btn-row">
            <button class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
            <form id="formEliminar" method="POST" action="index.php?url=gasto/eliminar" style="display:inline;">
                <input type="hidden" name="id" id="modalId">
                <button type="submit" class="btn btn-danger">🗑️ Eliminar</button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmarEliminar(id, desc) {
        document.getElementById('modalId').value = id;
        document.getElementById('modalDesc').textContent = desc;
        document.getElementById('modalEliminar').classList.add('open');
    }
    function cerrarModal() {
        document.getElementById('modalEliminar').classList.remove('open');
    }
    // Close on overlay click
    document.getElementById('modalEliminar').addEventListener('click', function(e) {
        if (e.target === this) cerrarModal();
    });
</script>

</body>
</html>
