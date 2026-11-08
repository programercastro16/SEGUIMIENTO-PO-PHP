<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📋 Historial de Propinas</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
            color: #1f2937;
        }

        .container { max-width: 900px; margin: 0 auto; }

        .header { text-align: center; margin-bottom: 2rem; color: #fff; }
        .header h1 { font-size: 2.2rem; font-weight: 800; text-shadow: 0 2px 8px rgba(0,0,0,.3); }
        .header p { margin-top: .5rem; opacity: .85; }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: .75rem;
            border-bottom: 2px solid #d1fae5;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #064e3b;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            color: #10b981;
            font-weight: 600;
            font-size: .9rem;
            text-decoration: none;
            padding: .5rem 1rem;
            border: 2px solid #10b981;
            border-radius: 8px;
            transition: all .2s;
        }

        .nav-link:hover { background: #10b981; color: #fff; }

        .table-wrapper { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; font-size: .9rem; }

        thead th {
            background: #064e3b;
            color: #a7f3d0;
            font-weight: 700;
            padding: .85rem 1rem;
            text-align: left;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        thead th:first-child { border-radius: 8px 0 0 0; }
        thead th:last-child  { border-radius: 0 8px 0 0; }

        tbody tr { border-bottom: 1px solid #d1fae5; transition: background .15s; }
        tbody tr:hover { background: #f0fdf4; }
        tbody tr:last-child { border-bottom: none; }

        tbody td { padding: .8rem 1rem; color: #374151; }
        tbody td.money { font-weight: 700; color: #064e3b; }

        .badge {
            display: inline-block;
            padding: .2rem .6rem;
            background: #d1fae5;
            color: #065f46;
            border-radius: 20px;
            font-size: .8rem;
            font-weight: 700;
        }

        .timestamp { font-size: .8rem; color: #9ca3af; }

        .empty-state { text-align: center; padding: 3rem; color: #9ca3af; }
        .empty-state .icon { font-size: 4rem; }
        .empty-state p { margin-top: 1rem; font-size: 1rem; }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
        }

        .stat .s-label { font-size: .75rem; font-weight: 600; color: #065f46; text-transform: uppercase; letter-spacing: .05em; }
        .stat .s-value { font-size: 1.4rem; font-weight: 800; color: #064e3b; margin-top: .2rem; }

        @media (max-width: 600px) {
            .stats-bar { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.7rem; }
        }
    </style>
</head>
<body>

<div class="container">

    <header class="header">
        <h1>📋 Historial de Propinas</h1>
        <p>Registro de los últimos 10 cálculos realizados</p>
    </header>

    <div class="card">

        <div class="card-header">
            <h2 class="card-title">🕐 Cálculos Recientes</h2>
            <a href="/ejercicio-02-calculadora-propinas/" class="nav-link">← Volver a la calculadora</a>
        </div>

        <?php if (!empty($historial)): ?>

            <!-- Estadísticas rápidas -->
            <?php
                $totalCuentas  = array_sum(array_column($historial, 'monto_total'));
                $totalPropinas = array_sum(array_column($historial, 'propina_total'));
                $pctPromedio   = count($historial) > 0
                    ? round(array_sum(array_column($historial, 'porcentaje')) / count($historial), 1)
                    : 0;
            ?>

            <div class="stats-bar">
                <div class="stat">
                    <div class="s-label">Total en cuentas</div>
                    <div class="s-value">$<?= number_format($totalCuentas, 2) ?></div>
                </div>
                <div class="stat">
                    <div class="s-label">Total en propinas</div>
                    <div class="s-value">$<?= number_format($totalPropinas, 2) ?></div>
                </div>
                <div class="stat">
                    <div class="s-label">% promedio</div>
                    <div class="s-value"><?= $pctPromedio ?>%</div>
                </div>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha y hora</th>
                            <th>Cuenta</th>
                            <th>%</th>
                            <th>Propina</th>
                            <th>Total</th>
                            <th>Personas</th>
                            <th>c/u paga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historial as $i => $h): ?>
                        <tr>
                            <td style="color:#9ca3af; font-weight:600;"><?= $i + 1 ?></td>
                            <td class="timestamp"><?= htmlspecialchars($h['timestamp']) ?></td>
                            <td class="money">$<?= number_format($h['monto_total'], 2) ?></td>
                            <td><span class="badge"><?= $h['porcentaje'] ?>%</span></td>
                            <td class="money">$<?= number_format($h['propina_total'], 2) ?></td>
                            <td class="money">$<?= number_format($h['total_general'], 2) ?></td>
                            <td style="text-align:center; font-weight:700;"><?= (int)$h['personas'] ?></td>
                            <td class="money">$<?= number_format($h['total_por_persona'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>

            <div class="empty-state">
                <div class="icon">📭</div>
                <p>Aún no hay cálculos guardados.<br>Realiza tu primer cálculo en la calculadora.</p>
            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>
