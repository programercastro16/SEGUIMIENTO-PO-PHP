<?php
/**
 * View: gasto/resumen.php
 * Resumen mensual de gastos con gráfico de barras CSS por categoría.
 */
$totalGastos = array_sum(array_column($resumen, 'total'));
$mesesNombres = $meses;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Resumen Mensual</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #fff8f0;
            color: #1f2937;
            min-height: 100vh;
        }
        header {
            background: linear-gradient(135deg, #78350f, #b45309);
            color: #fff;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        header h1 { font-size: 1.5rem; font-weight: 800; }
        .btn-back {
            background: rgba(255,255,255,.2);
            color: #fff;
            padding: .5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: .875rem;
            font-weight: 600;
            transition: background .2s;
        }
        .btn-back:hover { background: rgba(255,255,255,.35); }
        .container { max-width: 900px; margin: 0 auto; padding: 2rem 1rem; }
        /* Selector de mes */
        .month-filter {
            background: #fff;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,.08);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .month-filter label { font-weight: 600; color: #374151; }
        .month-filter select, .month-filter input[type="number"] {
            padding: .5rem .75rem;
            border: 2px solid #fed7aa;
            border-radius: 8px;
            font-size: .95rem;
            background: #fffbf7;
        }
        .btn-filter {
            padding: .55rem 1.25rem;
            background: #f97316;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
        }
        /* Cards de estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.25rem;
            box-shadow: 0 4px 16px rgba(0,0,0,.08);
            text-align: center;
        }
        .stat-label { font-size: .78rem; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; }
        .stat-value { font-size: 2rem; font-weight: 800; color: #78350f; margin-top: .25rem; }
        .stat-sub { font-size: .8rem; color: #6b7280; margin-top: .2rem; }
        /* Gráfico de barras */
        .chart-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,.08);
            margin-bottom: 1.5rem;
        }
        .chart-card h2 { font-size: 1.1rem; font-weight: 700; color: #78350f; margin-bottom: 1.25rem; }
        .bar-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: .9rem;
        }
        .bar-label {
            width: 130px;
            font-size: .82rem;
            font-weight: 600;
            color: #374151;
            flex-shrink: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .bar-track {
            flex: 1;
            height: 22px;
            background: #f3f4f6;
            border-radius: 50px;
            overflow: hidden;
        }
        .bar-fill {
            height: 100%;
            border-radius: 50px;
            transition: width .6s ease;
        }
        .bar-amount {
            width: 85px;
            text-align: right;
            font-size: .82rem;
            font-weight: 700;
            color: #374151;
            flex-shrink: 0;
        }
        .bar-pct {
            width: 42px;
            text-align: right;
            font-size: .75rem;
            color: #9ca3af;
            flex-shrink: 0;
        }
        /* Empty state */
        .empty {
            text-align: center;
            padding: 3rem;
            color: #9ca3af;
        }
        .empty .icon { font-size: 3rem; }
        .empty p { margin-top: .5rem; }
    </style>
</head>
<body>
<header>
    <div>
        <h1>📊 Resumen Mensual de Gastos</h1>
        <p style="font-size:.85rem;opacity:.85;">
            <?= $mesesNombres[$mes] ?? $mes ?> <?= $anio ?>
        </p>
    </div>
    <a href="/?url=gasto" class="btn-back">← Volver</a>
</header>

<div class="container">

    <!-- Filtro de mes -->
    <form class="month-filter" method="GET" action="/">
        <input type="hidden" name="url" value="gasto/resumen">
        <label>Período:</label>
        <select name="mes">
            <?php foreach ($meses as $num => $nombre): ?>
                <option value="<?= $num ?>" <?= $num == $mes ? 'selected' : '' ?>>
                    <?= $nombre ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="anio" value="<?= $anio ?>" min="2000" max="2099" style="width:90px;">
        <button type="submit" class="btn-filter">Ver</button>
    </form>

    <?php if (empty($resumen)): ?>
    <div class="empty">
        <div class="icon">📭</div>
        <p>No hay gastos registrados para <strong><?= $mesesNombres[$mes] ?? $mes ?> <?= $anio ?></strong>.</p>
    </div>
    <?php else: ?>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total gastado</div>
            <div class="stat-value">$<?= number_format($totalGastos, 2) ?></div>
            <div class="stat-sub"><?= $mesesNombres[$mes] ?? $mes ?> <?= $anio ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Nº de gastos</div>
            <div class="stat-value"><?= array_sum(array_column($resumen, 'cantidad')) ?></div>
            <div class="stat-sub">transacciones</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Categorías</div>
            <div class="stat-value"><?= count($resumen) ?></div>
            <div class="stat-sub">distintas</div>
        </div>
    </div>

    <!-- Gráfico de barras -->
    <?php
    $catColors = [
        'Alimentación'=>'#f97316','Transporte'=>'#3b82f6','Entretenimiento'=>'#8b5cf6',
        'Salud'=>'#10b981','Educación'=>'#06b6d4','Hogar'=>'#f59e0b',
        'Ropa'=>'#ec4899','Tecnología'=>'#6366f1','Otros'=>'#78716c',
    ];
    // Sort by total desc
    usort($resumen, fn($a,$b) => $b['total'] <=> $a['total']);
    ?>
    <div class="chart-card">
        <h2>🏷️ Distribución por Categoría</h2>
        <?php foreach ($resumen as $r):
            $pct  = $totalGastos > 0 ? round($r['total'] / $totalGastos * 100, 1) : 0;
            $color = $catColors[$r['categoria']] ?? '#78716c';
        ?>
        <div class="bar-row">
            <div class="bar-label"><?= htmlspecialchars($r['categoria']) ?></div>
            <div class="bar-track">
                <div class="bar-fill" style="width:<?= $pct ?>%; background:<?= $color ?>;"></div>
            </div>
            <div class="bar-amount">$<?= number_format($r['total'], 2) ?></div>
            <div class="bar-pct"><?= $pct ?>%</div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>
</div>
</body>
</html>

