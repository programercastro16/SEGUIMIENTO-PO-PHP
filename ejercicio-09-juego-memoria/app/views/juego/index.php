<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🃏 Juego de Memoria</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: linear-gradient(135deg, #0f172a, #1e1b4b, #312e81); min-height: 100vh; color: #fff; }
        header { padding: 2rem 2rem 1rem; text-align: center; }
        header h1 { font-size: 3rem; font-weight: 900; letter-spacing: -1px; }
        header p  { opacity: .7; margin-top: .5rem; font-size: 1.1rem; }
        .container { max-width: 900px; margin: 0 auto; padding: 1rem 1rem 3rem; }
        .levels { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin: 2rem 0; }
        .level-card {
            background: rgba(255,255,255,.08);
            border: 2px solid rgba(255,255,255,.12);
            border-radius: 20px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: transform .2s, border-color .2s, background .2s;
            text-decoration: none;
            color: #fff;
        }
        .level-card:hover { transform: translateY(-6px); border-color: rgba(167,139,250,.6); background: rgba(255,255,255,.14); }
        .level-card .icon { font-size: 3.5rem; }
        .level-card h2 { font-size: 1.4rem; font-weight: 800; margin: .5rem 0 .25rem; }
        .level-card p  { font-size: .85rem; opacity: .7; }
        .btn-play {
            display: inline-block;
            margin-top: 1rem;
            padding: .65rem 1.75rem;
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            border-radius: 50px;
            font-weight: 700;
            font-size: .95rem;
            color: #fff;
        }
        /* Scores */
        .scores-section { margin-top: 2.5rem; }
        .scores-section h2 { font-size: 1.5rem; font-weight: 800; margin-bottom: 1.25rem; opacity: .9; }
        .scores-tabs { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1rem; }
        .tab { padding: .45rem 1.1rem; border-radius: 50px; cursor: pointer; border: 2px solid rgba(255,255,255,.2); background: transparent; color: #fff; font-size: .85rem; font-weight: 600; transition: all .2s; }
        .tab.active { background: #7c3aed; border-color: #7c3aed; }
        .scores-table { background: rgba(255,255,255,.07); border-radius: 14px; overflow: hidden; }
        .scores-table table { width: 100%; border-collapse: collapse; }
        .scores-table th { background: rgba(255,255,255,.1); padding: .75rem 1rem; text-align: left; font-size: .78rem; text-transform: uppercase; letter-spacing: .05em; opacity: .7; }
        .scores-table td { padding: .7rem 1rem; border-bottom: 1px solid rgba(255,255,255,.07); font-size: .9rem; }
        .scores-table tr:last-child td { border-bottom: none; }
        .medal { font-size: 1.1rem; }
        .empty { text-align: center; padding: 2rem; opacity: .5; }
    </style>
</head>
<body>
<header>
    <h1>🃏 Juego de Memoria</h1>
    <p>Encuentra todos los pares de emojis</p>
</header>
<div class="container">
    <div class="levels">
        <?php
        $icons = ['facil'=>'😊','medio'=>'😤','dificil'=>'🔥'];
        foreach ($niveles as $key => $n):
        ?>
        <div class="level-card">
            <div class="icon"><?= $icons[$key] ?></div>
            <h2><?= $n['nombre'] ?></h2>
            <p><?= $n['pares'] ?> pares · <?= $n['pares']*2 ?> cartas</p>
            <a href="/?url=juego/jugar/<?= $key ?>" class="btn-play">▶ Jugar</a>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Scores -->
    <div class="scores-section">
        <h2>🏆 Tabla de Puntajes</h2>
        <div class="scores-tabs">
            <?php foreach ($niveles as $key => $n): ?>
            <button class="tab <?= $key === 'facil' ? 'active' : '' ?>"
                    onclick="showTab('<?= $key ?>')" id="tab-<?= $key ?>">
                <?= $n['nombre'] ?>
            </button>
            <?php endforeach; ?>
        </div>
        <?php foreach ($niveles as $key => $n): ?>
        <div id="scores-<?= $key ?>" style="display:<?= $key === 'facil' ? 'block' : 'none' ?>;">
            <?php if (empty($puntajes[$key])): ?>
                <div class="empty">🎮 Aún no hay puntajes para <?= $n['nombre'] ?>. ¡Sé el primero!</div>
            <?php else: ?>
            <div class="scores-table">
                <table>
                    <thead><tr><th>#</th><th>Jugador</th><th>Movimientos</th><th>Tiempo</th><th>Fecha</th></tr></thead>
                    <tbody>
                        <?php foreach ($puntajes[$key] as $i => $p): ?>
                        <tr>
                            <td><span class="medal"><?= ['🥇','🥈','🥉'][$i] ?? ($i+1) ?></span></td>
                            <td><?= htmlspecialchars($p['nombre']) ?></td>
                            <td><strong><?= $p['movimientos'] ?></strong> movs</td>
                            <td><?= gmdate('i:s', $p['tiempo_segundos']) ?></td>
                            <td style="opacity:.6;font-size:.8rem;"><?= date('d/m/Y', strtotime($p['fecha'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
function showTab(nivel) {
    document.querySelectorAll('[id^="scores-"]').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.tab').forEach(el => el.classList.remove('active'));
    document.getElementById('scores-' + nivel).style.display = 'block';
    document.getElementById('tab-' + nivel).classList.add('active');
}
</script>
</body>
</html>

