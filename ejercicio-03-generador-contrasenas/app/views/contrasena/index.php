<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <style>
        /* ── Reset & Base ─────────────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-primary:   #0d1117;
            --bg-secondary: #161b22;
            --bg-card:      #21262d;
            --bg-input:     #0d1117;
            --accent:       #00bcd4;
            --accent-dark:  #0097a7;
            --accent-glow:  rgba(0, 188, 212, 0.25);
            --text-primary: #e6edf3;
            --text-muted:   #8b949e;
            --border:       #30363d;
            --radius:       10px;
            --shadow:       0 4px 24px rgba(0,0,0,0.5);
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 2rem 1rem;
            line-height: 1.6;
        }

        /* ── Layout ───────────────────────────────────────────────────────── */
        .container {
            max-width: 760px;
            margin: 0 auto;
        }

        /* ── Cabecera ─────────────────────────────────────────────────────── */
        header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        header h1 {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, var(--accent) 0%, #80deea 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        header p {
            color: var(--text-muted);
            margin-top: 0.4rem;
            font-size: 0.95rem;
        }

        /* ── Tarjetas ─────────────────────────────────────────────────────── */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ── Formulario ───────────────────────────────────────────────────── */
        .form-group {
            margin-bottom: 1.4rem;
        }

        label.main-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        /* Slider */
        .slider-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        input[type="range"] {
            -webkit-appearance: none;
            appearance: none;
            flex: 1;
            height: 6px;
            border-radius: 3px;
            background: var(--border);
            outline: none;
            cursor: pointer;
        }

        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--accent);
            box-shadow: 0 0 8px var(--accent-glow);
            cursor: pointer;
            transition: transform 0.1s;
        }

        input[type="range"]::-webkit-slider-thumb:hover {
            transform: scale(1.2);
        }

        input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border: none;
            border-radius: 50%;
            background: var(--accent);
            cursor: pointer;
        }

        .slider-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--accent);
            min-width: 42px;
            text-align: center;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 0.2rem 0.5rem;
        }

        /* Checkboxes */
        .checkbox-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }

        .checkbox-item:hover {
            border-color: var(--accent);
            background: var(--accent-glow);
        }

        .checkbox-item input[type="checkbox"] {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid var(--border);
            border-radius: 5px;
            background: var(--bg-input);
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
            transition: background 0.2s, border-color 0.2s;
        }

        .checkbox-item input[type="checkbox"]:checked {
            background: var(--accent);
            border-color: var(--accent);
        }

        .checkbox-item input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 13px;
            font-weight: 700;
        }

        .checkbox-label {
            display: flex;
            flex-direction: column;
        }

        .checkbox-label strong {
            font-size: 0.9rem;
        }

        .checkbox-label span {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-family: 'Courier New', monospace;
        }

        /* ── Botón principal ──────────────────────────────────────────────── */
        .btn-generate {
            width: 100%;
            padding: 0.9rem;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%);
            color: #000;
            font-size: 1rem;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            letter-spacing: 0.5px;
            transition: opacity 0.2s, transform 0.1s, box-shadow 0.2s;
            box-shadow: 0 4px 16px var(--accent-glow);
        }

        .btn-generate:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px var(--accent-glow);
        }

        .btn-generate:active {
            transform: translateY(0);
        }

        /* ── Alertas de error ─────────────────────────────────────────────── */
        .alert-errors {
            background: rgba(244, 67, 54, 0.12);
            border: 1px solid #f44336;
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.25rem;
        }

        .alert-errors p {
            color: #ef9a9a;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .alert-errors ul {
            padding-left: 1.25rem;
        }

        .alert-errors ul li {
            color: #ef9a9a;
            font-size: 0.9rem;
        }

        /* ── Resultado: caja de contraseña ────────────────────────────────── */
        .result-card {
            background: var(--bg-card);
            border: 1px solid var(--accent);
            border-radius: var(--radius);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0 24px var(--accent-glow);
        }

        .password-display-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--bg-secondary);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.25rem;
        }

        .password-text {
            flex: 1;
            font-family: 'Courier New', 'Lucida Console', monospace;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent);
            word-break: break-all;
            letter-spacing: 2px;
        }

        .btn-copy {
            padding: 0.5rem 1rem;
            background: transparent;
            border: 1px solid var(--accent);
            border-radius: 6px;
            color: var(--accent);
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            white-space: nowrap;
            transition: background 0.2s, color 0.2s;
            flex-shrink: 0;
        }

        .btn-copy:hover {
            background: var(--accent);
            color: #000;
        }

        .btn-copy.copied {
            background: #4caf50;
            border-color: #4caf50;
            color: #000;
        }

        /* ── Medidor de fortaleza ─────────────────────────────────────────── */
        .strength-section {
            margin-bottom: 0.5rem;
        }

        .strength-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .strength-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .strength-badge {
            font-size: 0.85rem;
            font-weight: 700;
            padding: 0.2rem 0.75rem;
            border-radius: 20px;
            background: rgba(255,255,255,0.08);
        }

        .strength-bar-bg {
            width: 100%;
            height: 10px;
            background: var(--bg-secondary);
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .strength-bar-fill {
            height: 100%;
            border-radius: 5px;
            transition: width 0.5s ease, background 0.3s;
        }

        .strength-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* ── Tabla de historial ───────────────────────────────────────────── */
        .history-table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        thead th {
            background: var(--bg-secondary);
            color: var(--accent);
            padding: 0.65rem 0.85rem;
            text-align: left;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border);
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        tbody tr:hover {
            background: var(--bg-secondary);
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        td {
            padding: 0.65rem 0.85rem;
            color: var(--text-primary);
        }

        .td-password {
            font-family: 'Courier New', monospace;
            letter-spacing: 1.5px;
            color: var(--accent);
            font-weight: 600;
        }

        .fortaleza-pill {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            background: rgba(255,255,255,0.08);
        }

        .empty-history {
            text-align: center;
            padding: 2.5rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .empty-history .icon {
            font-size: 2.5rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        /* ── Navegación ───────────────────────────────────────────────────── */
        .nav-links {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .nav-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.85rem;
            padding: 0.35rem 0.75rem;
            border: 1px solid var(--border);
            border-radius: 20px;
            transition: color 0.2s, border-color 0.2s;
        }

        .nav-link:hover {
            color: var(--accent);
            border-color: var(--accent);
        }

        /* ── Footer ───────────────────────────────────────────────────────── */
        footer {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

        /* ── Responsive ───────────────────────────────────────────────────── */
        @media (max-width: 540px) {
            header h1  { font-size: 1.5rem; }
            .checkbox-grid { grid-template-columns: 1fr; }
            .password-text { font-size: 1.1rem; }
        }
    </style>
</head>
<body>
<div class="container">

    <!-- ── Cabecera ─────────────────────────────────────────────────────── -->
    <header>
        <h1>🔐 Generador de Contraseñas Seguras</h1>
        <p>Genera contraseñas criptográficamente seguras usando <code>random_int()</code></p>
    </header>

    <!-- ── Navegación ───────────────────────────────────────────────────── -->
    <nav class="nav-links">
        <a href="index.php" class="nav-link">🏠 Inicio</a>
        <a href="index.php?url=contrasena/historial" class="nav-link">📋 Historial</a>
    </nav>

    <!-- ── Errores ──────────────────────────────────────────────────────── -->
    <?php if (!empty($errores)): ?>
        <div class="alert-errors">
            <p>⚠️ Por favor corrige los siguientes errores:</p>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- ── Resultado ────────────────────────────────────────────────────── -->
    <?php if ($resultado): ?>
        <div class="result-card">
            <div class="card-title">✅ Contraseña Generada</div>

            <!-- Caja de contraseña + botón copiar -->
            <div class="password-display-wrapper">
                <span class="password-text" id="passwordOutput">
                    <?= htmlspecialchars($resultado['password']) ?>
                </span>
                <button class="btn-copy" id="btnCopy" onclick="copiarContrasena()">
                    📋 Copiar
                </button>
            </div>

            <!-- Medidor de fortaleza -->
            <div class="strength-section">
                <div class="strength-header">
                    <span class="strength-label">🛡️ Fortaleza</span>
                    <span class="strength-badge" style="color: <?= htmlspecialchars($resultado['color']) ?>;">
                        <?= htmlspecialchars($resultado['fortaleza']) ?>
                    </span>
                </div>
                <div class="strength-bar-bg">
                    <div class="strength-bar-fill"
                         id="strengthBar"
                         style="width: <?= (int)$resultado['puntuacion'] ?>%;
                                background: <?= htmlspecialchars($resultado['color']) ?>;">
                    </div>
                </div>
                <div class="strength-info">
                    <span>Puntuación: <strong><?= (int)$resultado['puntuacion'] ?>/100</strong></span>
                    <span>Longitud: <strong><?= (int)$resultado['longitud'] ?> caracteres</strong></span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- ── Formulario ───────────────────────────────────────────────────── -->
    <div class="card">
        <div class="card-title">⚙️ Configurar Contraseña</div>

        <form method="POST" action="index.php?url=contrasena/generar">

            <!-- Longitud -->
            <div class="form-group">
                <label class="main-label" for="longitud">
                    Longitud: <span id="longitudDisplay"><?= (int)$longitud ?></span> caracteres
                </label>
                <div class="slider-row">
                    <input
                        type="range"
                        id="longitud"
                        name="longitud"
                        min="8"
                        max="128"
                        value="<?= (int)$longitud ?>"
                        oninput="actualizarLongitud(this.value)"
                    >
                    <span class="slider-value" id="sliderValue"><?= (int)$longitud ?></span>
                </div>
            </div>

            <!-- Tipos de caracteres -->
            <div class="form-group">
                <label class="main-label">Tipos de Caracteres</label>
                <div class="checkbox-grid">

                    <label class="checkbox-item">
                        <input type="checkbox" name="mayusculas" <?= $mayusculas ? 'checked' : '' ?>>
                        <span class="checkbox-label">
                            <strong>Mayúsculas</strong>
                            <span>A B C … Z</span>
                        </span>
                    </label>

                    <label class="checkbox-item">
                        <input type="checkbox" name="minusculas" <?= $minusculas ? 'checked' : '' ?>>
                        <span class="checkbox-label">
                            <strong>Minúsculas</strong>
                            <span>a b c … z</span>
                        </span>
                    </label>

                    <label class="checkbox-item">
                        <input type="checkbox" name="numeros" <?= $numeros ? 'checked' : '' ?>>
                        <span class="checkbox-label">
                            <strong>Números</strong>
                            <span>0 1 2 … 9</span>
                        </span>
                    </label>

                    <label class="checkbox-item">
                        <input type="checkbox" name="especiales" <?= $especiales ? 'checked' : '' ?>>
                        <span class="checkbox-label">
                            <strong>Especiales</strong>
                            <span>! @ # $ % ^ &amp; *</span>
                        </span>
                    </label>

                </div>
            </div>

            <!-- Botón generar -->
            <button type="submit" class="btn-generate">
                ⚡ Generar Contraseña Segura
            </button>

        </form>
    </div>

    <!-- ── Historial ─────────────────────────────────────────────────────── -->
    <div class="card">
        <div class="card-title">📋 Historial (últimas 10)</div>

        <?php if (empty($historial)): ?>
            <div class="empty-history">
                <span class="icon">🔑</span>
                Aún no has generado ninguna contraseña.<br>
                ¡Usa el formulario de arriba para comenzar!
            </div>
        <?php else: ?>
            <div class="history-table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Contraseña</th>
                            <th>Long.</th>
                            <th>Fortaleza</th>
                            <th>Puntos</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historial as $i => $item): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td class="td-password">
                                    <?= htmlspecialchars($item['password_mascara']) ?>
                                </td>
                                <td><?= (int)$item['longitud'] ?></td>
                                <td>
                                    <span class="fortaleza-pill"
                                          style="color: <?= htmlspecialchars($item['color']) ?>;">
                                        <?= htmlspecialchars($item['fortaleza']) ?>
                                    </span>
                                </td>
                                <td><?= (int)$item['puntuacion'] ?></td>
                                <td style="color: var(--text-muted); font-size:0.8rem;">
                                    <?= htmlspecialchars($item['fecha']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- ── Footer ───────────────────────────────────────────────────────── -->
    <footer>
        <p>🔐 Generador de Contraseñas Seguras &mdash; Ejercicio 03 PHP MVC</p>
        <p style="margin-top:0.3rem;">Usando <code>random_int()</code> de PHP para generación criptográficamente segura</p>
    </footer>

</div><!-- /.container -->

<!-- ── JavaScript ──────────────────────────────────────────────────────────── -->
<script>
    /**
     * Actualiza el display del slider de longitud.
     * @param {string|number} val
     */
    function actualizarLongitud(val) {
        const num = parseInt(val, 10);
        document.getElementById('longitudDisplay').textContent = num;
        document.getElementById('sliderValue').textContent     = num;
    }

    /**
     * Copia la contraseña mostrada al portapapeles.
     * Muestra retroalimentación visual "¡Copiado!".
     */
    async function copiarContrasena() {
        const passwordEl = document.getElementById('passwordOutput');
        const btnCopy    = document.getElementById('btnCopy');

        if (!passwordEl) return;

        const texto = passwordEl.textContent.trim();

        try {
            await navigator.clipboard.writeText(texto);

            // Feedback visual
            btnCopy.textContent = '✅ ¡Copiado!';
            btnCopy.classList.add('copied');

            setTimeout(() => {
                btnCopy.textContent = '📋 Copiar';
                btnCopy.classList.remove('copied');
            }, 2000);

        } catch (err) {
            // Fallback para navegadores sin soporte de Clipboard API
            const range   = document.createRange();
            const sel     = window.getSelection();
            range.selectNodeContents(passwordEl);
            sel.removeAllRanges();
            sel.addRange(range);
            document.execCommand('copy');
            sel.removeAllRanges();

            btnCopy.textContent = '✅ ¡Copiado!';
            btnCopy.classList.add('copied');
            setTimeout(() => {
                btnCopy.textContent = '📋 Copiar';
                btnCopy.classList.remove('copied');
            }, 2000);
        }
    }

    // Animar la barra de fortaleza al cargar si existe
    window.addEventListener('DOMContentLoaded', () => {
        const bar = document.getElementById('strengthBar');
        if (bar) {
            const target = bar.style.width;
            bar.style.width = '0%';
            requestAnimationFrame(() => {
                setTimeout(() => { bar.style.width = target; }, 50);
            });
        }
    });
</script>
</body>
</html>
