<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💰 Calculadora de Propinas</title>
    <style>
        /* ===== RESET & BASE ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
            color: #1f2937;
        }

        /* ===== LAYOUT ===== */
        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* ===== HEADER ===== */
        .header {
            text-align: center;
            margin-bottom: 2rem;
            color: #fff;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .header p {
            margin-top: .5rem;
            font-size: 1.1rem;
            opacity: .85;
        }

        /* ===== CARD ===== */
        .card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #064e3b;
            margin-bottom: 1.5rem;
            padding-bottom: .75rem;
            border-bottom: 2px solid #d1fae5;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        /* ===== FORM ===== */
        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            font-size: .9rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: .5rem;
        }

        input[type="number"] {
            width: 100%;
            padding: .8rem 1rem;
            border: 2px solid #d1fae5;
            border-radius: 10px;
            font-size: 1rem;
            color: #1f2937;
            transition: border-color .2s, box-shadow .2s;
            background: #f9fafb;
        }

        input[type="number"]:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16,185,129,.15);
            background: #fff;
        }

        /* ===== PORCENTAJE RADIOS ===== */
        .porcentaje-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: .75rem;
        }

        .porcentaje-option {
            position: relative;
        }

        .porcentaje-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .porcentaje-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: .9rem .5rem;
            border: 2px solid #d1fae5;
            border-radius: 12px;
            cursor: pointer;
            background: #f9fafb;
            transition: all .2s;
            user-select: none;
        }

        .porcentaje-label .pct-value {
            font-size: 1.4rem;
            font-weight: 800;
            color: #065f46;
        }

        .porcentaje-label .pct-badge {
            font-size: .65rem;
            font-weight: 700;
            background: #10b981;
            color: #fff;
            padding: .1rem .4rem;
            border-radius: 20px;
            margin-top: .2rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .porcentaje-option input[type="radio"]:checked + .porcentaje-label {
            border-color: #10b981;
            background: #d1fae5;
            box-shadow: 0 0 0 3px rgba(16,185,129,.2);
        }

        .porcentaje-label:hover {
            border-color: #34d399;
            background: #ecfdf5;
        }

        /* ===== BUTTON ===== */
        .btn-primary {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: transform .15s, box-shadow .15s;
            letter-spacing: .02em;
            margin-top: .5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16,185,129,.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* ===== ERRORES ===== */
        .errores {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 4px solid #ef4444;
            border-radius: 10px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .errores p {
            font-size: .9rem;
            font-weight: 600;
            color: #991b1b;
            margin-bottom: .5rem;
        }

        .errores ul {
            padding-left: 1.25rem;
        }

        .errores ul li {
            color: #b91c1c;
            font-size: .875rem;
            margin-bottom: .25rem;
        }

        /* ===== RESULTADO ===== */
        .resultado-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .resultado-item {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 1rem 1.25rem;
        }

        .resultado-item.destacado {
            background: linear-gradient(135deg, #064e3b, #065f46);
            border-color: #064e3b;
            color: #fff;
            grid-column: 1 / -1;
        }

        .resultado-item .r-label {
            font-size: .8rem;
            font-weight: 600;
            color: #065f46;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: .25rem;
        }

        .resultado-item.destacado .r-label {
            color: #a7f3d0;
        }

        .resultado-item .r-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #064e3b;
        }

        .resultado-item.destacado .r-value {
            color: #fff;
            font-size: 2rem;
        }

        .resultado-item .r-sub {
            font-size: .8rem;
            color: #6b7280;
            margin-top: .2rem;
        }

        .resultado-item.destacado .r-sub {
            color: #a7f3d0;
        }

        /* ===== HISTORIAL TABLE ===== */
        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: .88rem;
        }

        thead th {
            background: #064e3b;
            color: #a7f3d0;
            font-weight: 700;
            padding: .75rem 1rem;
            text-align: left;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        thead th:first-child { border-radius: 8px 0 0 0; }
        thead th:last-child  { border-radius: 0 8px 0 0; }

        tbody tr {
            border-bottom: 1px solid #d1fae5;
            transition: background .15s;
        }

        tbody tr:hover { background: #f0fdf4; }

        tbody td {
            padding: .7rem 1rem;
            color: #374151;
        }

        tbody td.money { font-weight: 700; color: #064e3b; }

        tbody tr:last-child { border-bottom: none; }

        /* ===== BADGE ===== */
        .badge {
            display: inline-block;
            padding: .2rem .6rem;
            background: #d1fae5;
            color: #065f46;
            border-radius: 20px;
            font-size: .8rem;
            font-weight: 700;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #9ca3af;
        }

        .empty-state .icon { font-size: 3rem; }
        .empty-state p { margin-top: .5rem; font-size: .95rem; }

        /* ===== NAV LINK ===== */
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

        .nav-link:hover {
            background: #10b981;
            color: #fff;
        }

        /* ===== GRID LAYOUT ===== */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        @media (max-width: 680px) {
            .main-grid { grid-template-columns: 1fr; }
            .porcentaje-grid { grid-template-columns: repeat(2, 1fr); }
            .resultado-grid { grid-template-columns: 1fr; }
            .resultado-item.destacado .r-value { font-size: 1.6rem; }
            .header h1 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>

<div class="container">

    <!-- HEADER -->
    <header class="header">
        <h1>💰 Calculadora de Propinas</h1>
        <p>Calcula fácilmente la propina y divide la cuenta entre amigos</p>
    </header>

    <!-- ERRORES -->
    <?php if (!empty($errores)): ?>
        <div class="errores">
            <p>⚠️ Por favor corrige los siguientes errores:</p>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="main-grid">

        <!-- FORMULARIO -->
        <div class="card">
            <h2 class="card-title">🧾 Datos de la Cuenta</h2>

            <form action="/ejercicio-02-calculadora-propinas/propina/calcular" method="POST" novalidate>

                <!-- Monto -->
                <div class="form-group">
                    <label for="monto">💵 Monto total de la cuenta</label>
                    <input
                        type="number"
                        id="monto"
                        name="monto"
                        min="0.01"
                        step="0.01"
                        placeholder="0.00"
                        value="<?= htmlspecialchars($input['monto'] ?? '') ?>"
                        required
                    >
                </div>

                <!-- Porcentaje -->
                <div class="form-group">
                    <label>📊 Porcentaje de propina</label>
                    <div class="porcentaje-grid">

                        <?php
                        $pcts = [5, 10, 15, 18, 20, 25];
                        $selectedPct = (int)($input['porcentaje'] ?? 15);
                        foreach ($pcts as $pct):
                        ?>
                        <div class="porcentaje-option">
                            <input
                                type="radio"
                                id="pct_<?= $pct ?>"
                                name="porcentaje"
                                value="<?= $pct ?>"
                                <?= $selectedPct === $pct ? 'checked' : '' ?>
                            >
                            <label class="porcentaje-label" for="pct_<?= $pct ?>">
                                <span class="pct-value"><?= $pct ?>%</span>
                                <?php if ($pct === 15): ?>
                                    <span class="pct-badge">⭐ Recomendado</span>
                                <?php endif; ?>
                            </label>
                        </div>
                        <?php endforeach; ?>

                    </div>
                </div>

                <!-- Personas -->
                <div class="form-group">
                    <label for="personas">👥 Número de personas</label>
                    <input
                        type="number"
                        id="personas"
                        name="personas"
                        min="1"
                        step="1"
                        placeholder="1"
                        value="<?= htmlspecialchars($input['personas'] ?? '1') ?>"
                        required
                    >
                </div>

                <button type="submit" class="btn-primary">
                    🧮 Calcular Propina
                </button>

            </form>
        </div>

        <!-- RESULTADO -->
        <div>
            <?php if ($resultado): ?>
            <div class="card">
                <h2 class="card-title">✅ Resultado del Cálculo</h2>

                <div class="resultado-grid">

                    <div class="resultado-item">
                        <div class="r-label">Monto de la cuenta</div>
                        <div class="r-value">$<?= number_format($resultado['monto_total'], 2) ?></div>
                        <div class="r-sub"><?= $resultado['personas'] ?> persona(s)</div>
                    </div>

                    <div class="resultado-item">
                        <div class="r-label">Porcentaje elegido</div>
                        <div class="r-value"><?= $resultado['porcentaje'] ?>%</div>
                        <div class="r-sub">de propina</div>
                    </div>

                    <div class="resultado-item">
                        <div class="r-label">Propina total</div>
                        <div class="r-value">$<?= number_format($resultado['propina_total'], 2) ?></div>
                        <div class="r-sub">sobre la cuenta</div>
                    </div>

                    <div class="resultado-item">
                        <div class="r-label">Propina por persona</div>
                        <div class="r-value">$<?= number_format($resultado['propina_por_persona'], 2) ?></div>
                        <div class="r-sub">cada uno aporta</div>
                    </div>

                    <div class="resultado-item destacado">
                        <div class="r-label">💳 Total a pagar</div>
                        <div class="r-value">$<?= number_format($resultado['total_general'], 2) ?></div>
                        <div class="r-sub">cuenta + propina completa</div>
                    </div>

                    <div class="resultado-item" style="grid-column: 1 / -1; background:#f0fdf4; border-color:#34d399;">
                        <div class="r-label" style="color:#065f46;">👤 Total por persona</div>
                        <div class="r-value" style="font-size:1.8rem;">$<?= number_format($resultado['total_por_persona'], 2) ?></div>
                        <div class="r-sub">cuenta + propina dividida</div>
                    </div>

                </div>
            </div>
            <?php else: ?>
            <div class="card">
                <div class="empty-state">
                    <div class="icon">💡</div>
                    <p>Ingresa los datos de tu cuenta y haz clic en <strong>Calcular Propina</strong> para ver el resultado aquí.</p>
                </div>
            </div>
            <?php endif; ?>

            <!-- ÚLTIMOS CÁLCULOS -->
            <?php if (!empty($historial)): ?>
            <div class="card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
                    <h2 class="card-title" style="margin-bottom:0; border:none; padding:0;">🕐 Últimos Cálculos</h2>
                    <a href="/ejercicio-02-calculadora-propinas/propina/historial" class="nav-link">Ver todos →</a>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Cuenta</th>
                                <th>%</th>
                                <th>Propina</th>
                                <th>Total</th>
                                <th>x Persona</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historial as $h): ?>
                            <tr>
                                <td class="money">$<?= number_format($h['monto_total'], 2) ?></td>
                                <td><span class="badge"><?= $h['porcentaje'] ?>%</span></td>
                                <td class="money">$<?= number_format($h['propina_total'], 2) ?></td>
                                <td class="money">$<?= number_format($h['total_general'], 2) ?></td>
                                <td class="money">$<?= number_format($h['total_por_persona'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div>

</div>

<script>
    // Auto-focus en el campo monto al cargar
    document.getElementById('monto').focus();

    // Formato visual mientras se escribe el monto
    document.getElementById('monto').addEventListener('input', function () {
        if (this.value < 0) this.value = '';
    });

    document.getElementById('personas').addEventListener('input', function () {
        if (this.value < 1) this.value = 1;
        this.value = Math.floor(this.value);
    });
</script>

</body>
</html>
