<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📅 Sistema de Reservas</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #f0f4ff;
            color: #1e293b;
            min-height: 100vh;
        }

        /* ── Header ── */
        header {
            background: linear-gradient(135deg, #3730a3 0%, #4f46e5 60%, #6366f1 100%);
            color: #fff;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(79, 70, 229, .4);
        }
        header h1 { font-size: 1.6rem; font-weight: 700; letter-spacing: -.5px; }
        header p  { font-size: .85rem; opacity: .85; margin-top: .2rem; }
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
            transition: background .2s;
        }
        .btn-header:hover { background: rgba(255,255,255,.32); }

        /* ── Main ── */
        main { max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem; }

        /* ── Alert ── */
        .alert {
            padding: .9rem 1.2rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .alert-exito   { background: #d1fae5; color: #065f46; border-left: 4px solid #10b981; }
        .alert-error   { background: #fee2e2; color: #991b1b; border-left: 4px solid #ef4444; }

        /* ── Toolbar ── */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .filter-group { display: flex; gap: .5rem; flex-wrap: wrap; }
        .filter-btn {
            padding: .45rem 1rem;
            border-radius: 20px;
            border: 2px solid #c7d2fe;
            background: #fff;
            color: #4338ca;
            font-size: .84rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all .18s;
        }
        .filter-btn:hover, .filter-btn.activo {
            background: #4f46e5;
            border-color: #4f46e5;
            color: #fff;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            padding: .55rem 1.3rem;
            border-radius: 8px;
            border: none;
            font-size: .9rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            box-shadow: 0 2px 10px rgba(79,70,229,.35);
            transition: opacity .2s;
        }
        .btn-primary:hover { opacity: .88; }

        /* ── Stats ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 1rem;
            margin-bottom: 1.8rem;
        }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.1rem 1.3rem;
            display: flex;
            flex-direction: column;
            gap: .3rem;
            box-shadow: 0 1px 6px rgba(0,0,0,.07);
            border-top: 4px solid;
        }
        .stat-card.total     { border-color: #6366f1; }
        .stat-card.pendiente { border-color: #f59e0b; }
        .stat-card.confirmado{ border-color: #10b981; }
        .stat-card.cancelado { border-color: #ef4444; }
        .stat-card .num { font-size: 2rem; font-weight: 800; }
        .stat-card .lbl { font-size: .78rem; color: #64748b; text-transform: uppercase; letter-spacing: .5px; }
        .stat-card.total      .num { color: #4f46e5; }
        .stat-card.pendiente  .num { color: #d97706; }
        .stat-card.confirmado .num { color: #059669; }
        .stat-card.cancelado  .num { color: #dc2626; }

        /* ── Table ── */
        .table-wrap {
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,.08);
        }
        table { width: 100%; border-collapse: collapse; }
        thead { background: linear-gradient(90deg, #3730a3, #4f46e5); color: #fff; }
        thead th {
            padding: .9rem 1rem;
            text-align: left;
            font-size: .82rem;
            font-weight: 600;
            letter-spacing: .4px;
            text-transform: uppercase;
        }
        tbody tr { border-bottom: 1px solid #e0e7ff; transition: background .15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f5f7ff; }
        tbody td { padding: .85rem 1rem; font-size: .9rem; vertical-align: middle; }

        /* ── Badge ── */
        .badge {
            display: inline-block;
            padding: .25rem .75rem;
            border-radius: 20px;
            font-size: .76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .badge-pendiente  { background: #fef3c7; color: #92400e; }
        .badge-confirmado { background: #d1fae5; color: #065f46; }
        .badge-cancelado  { background: #fee2e2; color: #991b1b; }

        /* ── Action buttons ── */
        .acciones { display: flex; gap: .4rem; flex-wrap: wrap; }
        .btn-sm {
            padding: .3rem .75rem;
            border-radius: 6px;
            border: none;
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: opacity .18s;
        }
        .btn-sm:hover { opacity: .8; }
        .btn-confirmar { background: #d1fae5; color: #065f46; }
        .btn-cancelar  { background: #fee2e2; color: #991b1b; }

        /* ── Empty ── */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #94a3b8;
        }
        .empty-state .icon { font-size: 3rem; margin-bottom: .8rem; }
        .empty-state p { font-size: 1rem; }

        /* ── Footer ── */
        footer {
            text-align: center;
            padding: 2rem 1rem;
            color: #94a3b8;
            font-size: .82rem;
        }
    </style>
</head>
<body>

<header>
    <div>
        <h1>📅 Sistema de Reservas</h1>
        <p>Gestión de citas y disponibilidad</p>
    </div>
    <nav class="header-nav">
        <a href="<?= BASE_URL ?>/reserva/disponibilidad" class="btn-header">🗓️ Disponibilidad</a>
        <a href="<?= BASE_URL ?>/reserva/nueva" class="btn-header">➕ Nueva Reserva</a>
    </nav>
</header>

<main>

    <?php if ($mensaje): ?>
        <div class="alert alert-<?= htmlspecialchars($tipoMsg) ?>">
            <?= $tipoMsg === 'exito' ? '✅' : '❌' ?>
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <?php
        $todas = $this->model->getAll();
        $cPendiente  = count(array_filter($todas, fn($r) => $r['estado'] === 'pendiente'));
        $cConfirmado = count(array_filter($todas, fn($r) => $r['estado'] === 'confirmado'));
        $cCancelado  = count(array_filter($todas, fn($r) => $r['estado'] === 'cancelado'));
    ?>
    <div class="stats-grid">
        <div class="stat-card total">
            <span class="num"><?= count($todas) ?></span>
            <span class="lbl">Total</span>
        </div>
        <div class="stat-card pendiente">
            <span class="num"><?= $cPendiente ?></span>
            <span class="lbl">Pendientes</span>
        </div>
        <div class="stat-card confirmado">
            <span class="num"><?= $cConfirmado ?></span>
            <span class="lbl">Confirmadas</span>
        </div>
        <div class="stat-card cancelado">
            <span class="num"><?= $cCancelado ?></span>
            <span class="lbl">Canceladas</span>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="filter-group">
            <?php
            $filtros = [
                'todas'      => 'Todas',
                'pendiente'  => '🟡 Pendiente',
                'confirmado' => '🟢 Confirmada',
                'cancelado'  => '🔴 Cancelada',
            ];
            foreach ($filtros as $key => $label): ?>
                <a href="<?= BASE_URL ?>/reserva?estado=<?= $key ?>"
                   class="filter-btn <?= $filtroEstado === $key ? 'activo' : '' ?>">
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
        </div>
        <a href="<?= BASE_URL ?>/reserva/nueva" class="btn-primary">➕ Nueva Reserva</a>
    </div>

    <!-- Table -->
    <div class="table-wrap">
        <?php if (empty($reservas)): ?>
            <div class="empty-state">
                <div class="icon">📭</div>
                <p>No hay reservas<?= $filtroEstado !== 'todas' ? ' con este estado' : '' ?>.</p>
            </div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Servicio</th>
                    <th>Duración</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $r):
                    $srv = $serviciosMap[$r['servicio_id']] ?? null;
                    $fechaFormato = date('d/m/Y', strtotime($r['fecha']));
                ?>
                <tr>
                    <td><strong><?= htmlspecialchars($fechaFormato) ?></strong></td>
                    <td><?= htmlspecialchars($r['hora']) ?></td>
                    <td>
                        <div style="font-weight:600"><?= htmlspecialchars($r['nombre_cliente']) ?></div>
                        <div style="font-size:.78rem;color:#64748b"><?= htmlspecialchars($r['email']) ?></div>
                    </td>
                    <td><?= htmlspecialchars($r['telefono']) ?></td>
                    <td><?= $srv ? htmlspecialchars($srv['nombre']) : 'N/A' ?></td>
                    <td><?= $srv ? $srv['duracion'] . ' min' : '—' ?></td>
                    <td>
                        <span class="badge badge-<?= $r['estado'] ?>">
                            <?= match($r['estado']) {
                                'pendiente'  => '🟡 Pendiente',
                                'confirmado' => '🟢 Confirmada',
                                'cancelado'  => '🔴 Cancelada',
                                default      => $r['estado'],
                            } ?>
                        </span>
                    </td>
                    <td>
                        <div class="acciones">
                            <?php if ($r['estado'] === 'pendiente'): ?>
                                <a href="<?= BASE_URL ?>/reserva/confirmar/<?= urlencode($r['id']) ?>"
                                   class="btn-sm btn-confirmar"
                                   onclick="return confirm('¿Confirmar esta reserva?')">✔ Confirmar</a>
                                <a href="<?= BASE_URL ?>/reserva/cancelar/<?= urlencode($r['id']) ?>"
                                   class="btn-sm btn-cancelar"
                                   onclick="return confirm('¿Cancelar esta reserva?')">✖ Cancelar</a>
                            <?php elseif ($r['estado'] === 'confirmado'): ?>
                                <a href="<?= BASE_URL ?>/reserva/cancelar/<?= urlencode($r['id']) ?>"
                                   class="btn-sm btn-cancelar"
                                   onclick="return confirm('¿Cancelar esta reserva confirmada?')">✖ Cancelar</a>
                            <?php else: ?>
                                <span style="color:#94a3b8;font-size:.8rem">Sin acciones</span>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

</main>

<footer>
    <p>📅 Sistema de Reservas &copy; <?= date('Y') ?> &mdash; Ejercicio 05 PHP MVC</p>
</footer>

</body>
</html>
