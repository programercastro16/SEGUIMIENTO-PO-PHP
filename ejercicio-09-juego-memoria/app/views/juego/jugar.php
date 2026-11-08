<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🃏 Jugando — <?= htmlspecialchars($nivelInfo['nombre']) ?></title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e1b4b);
            min-height: 100vh;
            color: #fff;
            padding: 1rem;
        }
        /* HUD */
        .hud {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 900px;
            margin: 0 auto 1.5rem;
            background: rgba(255,255,255,.08);
            border-radius: 14px;
            padding: .9rem 1.5rem;
            flex-wrap: wrap;
            gap: .75rem;
        }
        .hud-item { text-align: center; }
        .hud-label { font-size: .7rem; text-transform: uppercase; letter-spacing: .07em; opacity: .6; font-weight: 700; }
        .hud-value { font-size: 1.5rem; font-weight: 800; color: #a78bfa; }
        .btn-restart {
            padding: .55rem 1.2rem;
            background: rgba(255,255,255,.12);
            border: 2px solid rgba(255,255,255,.2);
            border-radius: 10px;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
            font-size: .9rem;
            text-decoration: none;
            transition: background .2s;
        }
        .btn-restart:hover { background: rgba(255,255,255,.22); }
        /* Board */
        .board {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            gap: .75rem;
            grid-template-columns: repeat(<?= $nivelInfo['cols'] ?>, 1fr);
        }
        @media (max-width: 600px) {
            .board { grid-template-columns: repeat(<?= min($nivelInfo['cols'], 4) ?>, 1fr); gap: .5rem; }
        }
        /* Card 3D flip */
        .card-wrapper {
            aspect-ratio: 1;
            perspective: 600px;
            cursor: pointer;
        }
        .card-inner {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform .4s cubic-bezier(.25,.46,.45,.94);
        }
        .card-wrapper.flipped .card-inner { transform: rotateY(180deg); }
        .card-wrapper.matched .card-inner { transform: rotateY(180deg); }
        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(1.2rem, 4vw, 2.5rem);
            user-select: none;
        }
        .card-front {
            background: linear-gradient(135deg, #4c1d95, #5b21b6);
            border: 2px solid rgba(167,139,250,.3);
            font-size: clamp(1.4rem, 4vw, 2.2rem);
        }
        .card-front::after { content: '❓'; }
        .card-back {
            background: linear-gradient(135deg, #1e1b4b, #312e81);
            border: 2px solid rgba(167,139,250,.5);
            transform: rotateY(180deg);
        }
        .card-wrapper.matched .card-back {
            background: linear-gradient(135deg, #064e3b, #065f46);
            border-color: #34d399;
            animation: matchPulse .4s ease;
        }
        @keyframes matchPulse {
            0%   { transform: rotateY(180deg) scale(1); }
            50%  { transform: rotateY(180deg) scale(1.12); }
            100% { transform: rotateY(180deg) scale(1); }
        }
        /* Win Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.7);
            backdrop-filter: blur(6px);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.show { display: flex; }
        .modal {
            background: linear-gradient(135deg, #1e1b4b, #2d1b69);
            border: 2px solid rgba(167,139,250,.4);
            border-radius: 24px;
            padding: 2.5rem;
            text-align: center;
            max-width: 420px;
            width: 90%;
            animation: slideIn .4s ease;
        }
        @keyframes slideIn { from { transform: scale(.8); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        .modal h2 { font-size: 2.2rem; margin-bottom: .5rem; }
        .modal .stats { display: flex; justify-content: center; gap: 2rem; margin: 1.5rem 0; }
        .modal .stat { text-align: center; }
        .modal .stat .v { font-size: 2rem; font-weight: 800; color: #a78bfa; }
        .modal .stat .l { font-size: .78rem; opacity: .6; text-transform: uppercase; font-weight: 700; }
        .modal input[type="text"] {
            width: 100%; padding: .75rem 1rem;
            border: 2px solid rgba(167,139,250,.4);
            border-radius: 10px;
            background: rgba(255,255,255,.08);
            color: #fff;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        .modal input::placeholder { opacity: .5; }
        .btn-save {
            width: 100%; padding: .85rem;
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            color: #fff; font-size: 1rem; font-weight: 800;
            border: none; border-radius: 10px; cursor: pointer;
            transition: transform .15s;
            margin-bottom: .75rem;
        }
        .btn-save:hover { transform: translateY(-2px); }
        .btn-play-again {
            display: block;
            padding: .65rem;
            background: rgba(255,255,255,.1);
            color: #fff;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

<!-- HUD -->
<div class="hud">
    <div class="hud-item">
        <div class="hud-label">Nivel</div>
        <div class="hud-value"><?= htmlspecialchars($nivelInfo['nombre']) ?></div>
    </div>
    <div class="hud-item">
        <div class="hud-label">Movimientos</div>
        <div class="hud-value" id="moves">0</div>
    </div>
    <div class="hud-item">
        <div class="hud-label">Pares</div>
        <div class="hud-value"><span id="matched">0</span>/<?= $nivelInfo['pares'] ?></div>
    </div>
    <div class="hud-item">
        <div class="hud-label">Tiempo</div>
        <div class="hud-value" id="timer">00:00</div>
    </div>
    <a href="/?url=juego/jugar/<?= $nivel ?>" class="btn-restart" id="btn-restart">🔄 Reiniciar</a>
    <a href="/?url=juego" class="btn-restart">🏠 Inicio</a>
</div>

<!-- Board -->
<div class="board" id="board">
    <?php foreach ($tablero as $i => $card): ?>
    <div class="card-wrapper" data-index="<?= $i ?>" data-emoji="<?= htmlspecialchars($card['emoji']) ?>" onclick="flipCard(this)">
        <div class="card-inner">
            <div class="card-front"></div>
            <div class="card-back"><?= $card['emoji'] ?></div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<!-- Win Modal -->
<div class="modal-overlay" id="winModal">
    <div class="modal">
        <div style="font-size:4rem;">🎉</div>
        <h2>¡Ganaste!</h2>
        <p style="opacity:.7;">Encontraste todos los pares</p>
        <div class="stats">
            <div class="stat"><div class="v" id="finalMoves">0</div><div class="l">Movimientos</div></div>
            <div class="stat"><div class="v" id="finalTime">0:00</div><div class="l">Tiempo</div></div>
        </div>
        <input type="text" id="playerName" placeholder="Tu nombre para el marcador..." maxlength="30">
        <button class="btn-save" onclick="savScore()">🏆 Guardar Puntaje</button>
        <a href="/?url=juego/jugar/<?= $nivel ?>" class="btn-play-again">🔄 Jugar de nuevo</a>
    </div>
</div>

<script>
const TOTAL_PARES = <?= $nivelInfo['pares'] ?>;
const NIVEL       = '<?= $nivel ?>';

let flipped   = [];
let matched   = 0;
let moves     = 0;
let locked    = false;
let started   = false;
let startTime = null;
let timerInterval = null;

function flipCard(card) {
    if (locked) return;
    if (card.classList.contains('flipped') || card.classList.contains('matched')) return;

    if (!started) startTimer();

    card.classList.add('flipped');
    flipped.push(card);

    if (flipped.length === 2) {
        moves++;
        document.getElementById('moves').textContent = moves;
        locked = true;
        checkMatch();
    }
}

function checkMatch() {
    const [a, b] = flipped;
    if (a.dataset.emoji === b.dataset.emoji) {
        // Match!
        setTimeout(() => {
            a.classList.add('matched');
            b.classList.add('matched');
            a.classList.remove('flipped');
            b.classList.remove('flipped');
            flipped = [];
            locked  = false;
            matched++;
            document.getElementById('matched').textContent = matched;
            if (matched === TOTAL_PARES) showWin();
        }, 300);
    } else {
        // No match
        setTimeout(() => {
            a.classList.remove('flipped');
            b.classList.remove('flipped');
            flipped = [];
            locked  = false;
        }, 900);
    }
}

function startTimer() {
    started   = true;
    startTime = Date.now();
    timerInterval = setInterval(() => {
        const secs  = Math.floor((Date.now() - startTime) / 1000);
        const m     = String(Math.floor(secs / 60)).padStart(2, '0');
        const s     = String(secs % 60).padStart(2, '0');
        document.getElementById('timer').textContent = `${m}:${s}`;
    }, 500);
}

function getElapsedSeconds() {
    return startTime ? Math.floor((Date.now() - startTime) / 1000) : 0;
}

function showWin() {
    clearInterval(timerInterval);
    const secs  = getElapsedSeconds();
    const m     = String(Math.floor(secs / 60)).padStart(2, '0');
    const s     = String(secs % 60).padStart(2, '0');
    document.getElementById('finalMoves').textContent = moves;
    document.getElementById('finalTime').textContent  = `${m}:${s}`;
    document.getElementById('winModal').classList.add('show');
}

function savScore() {
    const nombre = document.getElementById('playerName').value.trim() || 'Anónimo';
    const secs   = getElapsedSeconds();
    fetch('/?url=juego/guardarPuntaje', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ nombre, nivel: NIVEL, movimientos: moves, tiempo_segundos: secs })
    })
    .then(r => r.json())
    .then(data => {
        if (data.ok) {
            window.location.href = '/?url=juego/puntajes';
        }
    })
    .catch(() => { window.location.href = '/?url=juego'; });
}
</script>
</body>
</html>

