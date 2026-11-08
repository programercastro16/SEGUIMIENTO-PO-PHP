<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>⏱️ Cronómetro Online</title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:#0a0a0f;color:#e2e8f0;min-height:100vh;display:flex;flex-direction:column}
        /* Header */
        header{padding:1.25rem 2rem;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,.07)}
        header h1{font-size:1.3rem;font-weight:800;color:#34d399}
        .btn-hist{background:rgba(52,211,153,.12);color:#34d399;padding:.5rem 1.1rem;border-radius:8px;text-decoration:none;font-size:.85rem;font-weight:700;border:1px solid rgba(52,211,153,.3)}
        .btn-hist:hover{background:rgba(52,211,153,.22)}
        /* Main */
        main{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem 1rem}
        /* Display */
        .display{font-size:clamp(3.5rem,12vw,8rem);font-weight:900;font-family:'Courier New',monospace;color:#00ff87;text-shadow:0 0 40px rgba(0,255,135,.4),0 0 80px rgba(0,255,135,.15);letter-spacing:2px;margin-bottom:2.5rem;line-height:1;text-align:center}
        .display span.sep{color:rgba(0,255,135,.4)}
        /* Controls */
        .controls{display:flex;gap:1rem;flex-wrap:wrap;justify-content:center;margin-bottom:2.5rem}
        .btn-ctrl{padding:.85rem 2rem;border-radius:14px;font-size:1rem;font-weight:800;border:none;cursor:pointer;transition:transform .15s,box-shadow .15s;min-width:130px;letter-spacing:.03em}
        .btn-ctrl:hover{transform:translateY(-3px)}
        .btn-ctrl:active{transform:translateY(0)}
        #btn-start{background:linear-gradient(135deg,#059669,#10b981);color:#fff;box-shadow:0 6px 25px rgba(16,185,129,.35)}
        #btn-start:hover{box-shadow:0 10px 35px rgba(16,185,129,.5)}
        #btn-pause{background:linear-gradient(135deg,#d97706,#f59e0b);color:#fff;box-shadow:0 6px 25px rgba(245,158,11,.35);display:none}
        #btn-pause:hover{box-shadow:0 10px 35px rgba(245,158,11,.5)}
        #btn-lap{background:rgba(99,102,241,.15);color:#818cf8;border:2px solid rgba(99,102,241,.35);min-width:110px}
        #btn-lap:hover{background:rgba(99,102,241,.25);box-shadow:0 6px 20px rgba(99,102,241,.3)}
        #btn-lap:disabled{opacity:.35;cursor:not-allowed;transform:none}
        #btn-reset{background:rgba(239,68,68,.12);color:#f87171;border:2px solid rgba(239,68,68,.3);min-width:110px}
        #btn-reset:hover{background:rgba(239,68,68,.22);box-shadow:0 6px 20px rgba(239,68,68,.3)}
        /* Shortcuts */
        .shortcuts{font-size:.72rem;color:rgba(255,255,255,.25);text-align:center;margin-bottom:2.5rem;letter-spacing:.05em}
        .shortcuts span{margin:0 .6rem;background:rgba(255,255,255,.07);padding:.15rem .4rem;border-radius:4px}
        /* Laps */
        .laps-section{width:100%;max-width:620px}
        .laps-section h2{font-size:.85rem;font-weight:700;text-transform:uppercase;letter-spacing:.1em;color:rgba(255,255,255,.35);margin-bottom:.75rem;text-align:center}
        #laps-table{width:100%;border-collapse:collapse}
        #laps-table th{font-size:.72rem;text-transform:uppercase;letter-spacing:.07em;color:rgba(255,255,255,.3);padding:.5rem .75rem;text-align:left;border-bottom:1px solid rgba(255,255,255,.07)}
        #laps-table td{padding:.6rem .75rem;font-family:'Courier New',monospace;font-size:.95rem;border-bottom:1px solid rgba(255,255,255,.05)}
        #laps-table tr.fastest td{color:#34d399}
        #laps-table tr.slowest td{color:#f87171}
        /* Save panel */
        .save-panel{display:none;margin-top:2rem;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:16px;padding:1.5rem;width:100%;max-width:620px;text-align:center}
        .save-panel h3{font-size:1rem;font-weight:700;margin-bottom:1rem;color:#34d399}
        .save-panel input{width:100%;padding:.75rem 1rem;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:10px;color:#fff;font-size:1rem;margin-bottom:.75rem}
        .save-panel input::placeholder{color:rgba(255,255,255,.3)}
        .btn-save{padding:.75rem 2rem;background:linear-gradient(135deg,#059669,#10b981);color:#fff;border:none;border-radius:10px;font-size:.95rem;font-weight:700;cursor:pointer;width:100%;transition:opacity .2s}
        .btn-save:hover{opacity:.88}
        .save-msg{font-size:.85rem;color:#34d399;margin-top:.5rem;display:none}
    </style>
</head>
<body>
<header>
    <h1>⏱️ Cronómetro Online</h1>
    <a href="/?url=cronometro/historial" class="btn-hist">📋 Historial</a>
</header>
<main>
    <!-- Display -->
    <div class="display" id="display">00:00<span class="sep">.</span>00</div>

    <!-- Controls -->
    <div class="controls">
        <button class="btn-ctrl" id="btn-start"  onclick="startStop()">▶ Iniciar</button>
        <button class="btn-ctrl" id="btn-pause"  onclick="startStop()">⏸ Pausar</button>
        <button class="btn-ctrl" id="btn-lap"    onclick="recordLap()" disabled>🏁 Vuelta</button>
        <button class="btn-ctrl" id="btn-reset"  onclick="resetTimer()">🔄 Reiniciar</button>
    </div>

    <!-- Keyboard shortcuts -->
    <div class="shortcuts">
        Atajos de teclado:
        <span>Espacio = Iniciar/Pausar</span>
        <span>L = Vuelta</span>
        <span>R = Reiniciar</span>
    </div>

    <!-- Laps -->
    <div class="laps-section">
        <h2 id="laps-title" style="display:none">Vueltas</h2>
        <table id="laps-table">
            <thead id="laps-head" style="display:none">
                <tr><th>#</th><th>Tiempo Vuelta</th><th>Tiempo Total</th></tr>
            </thead>
            <tbody id="laps-body"></tbody>
        </table>
    </div>

    <!-- Save panel -->
    <div class="save-panel" id="save-panel">
        <h3>💾 Guardar esta sesión</h3>
        <input type="text" id="session-name" placeholder="Nombre de la sesión (ej: Carrera 100m)" maxlength="80">
        <button class="btn-save" onclick="saveSesion()">💾 Guardar Sesión</button>
        <div class="save-msg" id="save-msg">✅ Sesión guardada. <a href="/?url=cronometro/historial" style="color:#34d399">Ver historial →</a></div>
    </div>
</main>

<script>
let running      = false;
let startTime    = null;   // Date.now() when started
let elapsed      = 0;      // accumulated ms before current run
let rafId        = null;
let laps         = [];
let lastLapMs    = 0;      // total ms at last lap

// --- DOM refs ---
const display   = document.getElementById('display');
const btnStart  = document.getElementById('btn-start');
const btnPause  = document.getElementById('btn-pause');
const btnLap    = document.getElementById('btn-lap');
const lapsBody  = document.getElementById('laps-body');
const lapsHead  = document.getElementById('laps-head');
const lapsTitle = document.getElementById('laps-title');
const savePanel = document.getElementById('save-panel');

function formatMs(ms) {
    const cs  = Math.floor(ms / 10) % 100;
    const s   = Math.floor(ms / 1000) % 60;
    const m   = Math.floor(ms / 60000) % 60;
    const h   = Math.floor(ms / 3600000);
    if (h > 0) return `${pad(h)}:${pad(m)}:${pad(s)}.${pad(cs)}`;
    return `${pad(m)}:${pad(s)}.${pad(cs)}`;
}
function pad(n) { return String(n).padStart(2,'0'); }

function getElapsed() {
    if (!running) return elapsed;
    return elapsed + (Date.now() - startTime);
}

function tick() {
    const ms = getElapsed();
    const cs  = Math.floor(ms / 10) % 100;
    const s   = Math.floor(ms / 1000) % 60;
    const m   = Math.floor(ms / 60000) % 60;
    const h   = Math.floor(ms / 3600000);
    if (h > 0) {
        display.innerHTML = `${pad(h)}:${pad(m)}:${pad(s)}<span class="sep">.</span>${pad(cs)}`;
    } else {
        display.innerHTML = `${pad(m)}:${pad(s)}<span class="sep">.</span>${pad(cs)}`;
    }
    rafId = requestAnimationFrame(tick);
}

function startStop() {
    if (!running) {
        // Start / Resume
        startTime = Date.now();
        running   = true;
        btnStart.style.display = 'none';
        btnPause.style.display = '';
        btnLap.disabled = false;
        savePanel.style.display = 'none';
        rafId = requestAnimationFrame(tick);
    } else {
        // Pause
        elapsed  += Date.now() - startTime;
        running   = false;
        cancelAnimationFrame(rafId);
        btnStart.style.display = '';
        btnPause.style.display = 'none';
        btnStart.textContent   = '▶ Reanudar';
        // Show save panel if something recorded
        if (elapsed > 0) savePanel.style.display = 'block';
    }
}

function resetTimer() {
    running = false;
    cancelAnimationFrame(rafId);
    elapsed      = 0;
    startTime    = null;
    lastLapMs    = 0;
    laps         = [];
    display.innerHTML = '00:00<span class="sep">.</span>00';
    btnStart.style.display = '';
    btnPause.style.display = 'none';
    btnStart.textContent   = '▶ Iniciar';
    btnLap.disabled        = true;
    lapsBody.innerHTML     = '';
    lapsHead.style.display = 'none';
    lapsTitle.style.display = 'none';
    savePanel.style.display = 'none';
    document.getElementById('save-msg').style.display = 'none';
}

function recordLap() {
    const totalMs  = getElapsed();
    const lapMs    = totalMs - lastLapMs;
    lastLapMs      = totalMs;
    laps.push({ numero: laps.length + 1, vuelta_ms: lapMs, total_ms: totalMs });
    renderLaps();
}

function renderLaps() {
    if (laps.length === 0) return;
    lapsHead.style.display = '';
    lapsTitle.style.display = '';
    // Find fastest and slowest
    const times  = laps.map(l => l.vuelta_ms);
    const minMs  = Math.min(...times);
    const maxMs  = Math.max(...times);
    lapsBody.innerHTML = '';
    // Render in reverse order
    [...laps].reverse().forEach(lap => {
        const tr = document.createElement('tr');
        if (laps.length > 1 && lap.vuelta_ms === minMs) tr.className = 'fastest';
        else if (laps.length > 1 && lap.vuelta_ms === maxMs) tr.className = 'slowest';
        tr.innerHTML = `<td>#${lap.numero}</td><td>${formatMs(lap.vuelta_ms)}</td><td>${formatMs(lap.total_ms)}</td>`;
        lapsBody.appendChild(tr);
    });
}

function saveSesion() {
    const nombre = document.getElementById('session-name').value.trim() || 'Sin nombre';
    const totalMs = getElapsed();
    fetch('/?url=cronometro/guardar', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ nombre_sesion: nombre, tiempo_total_ms: totalMs, vueltas: laps })
    })
    .then(r => r.json())
    .then(data => {
        if (data.ok) {
            document.getElementById('save-msg').style.display = 'block';
        }
    })
    .catch(() => alert('Error al guardar'));
}

// Keyboard shortcuts
document.addEventListener('keydown', e => {
    if (e.target.tagName === 'INPUT') return;
    if (e.code === 'Space') { e.preventDefault(); startStop(); }
    else if (e.code === 'KeyL') { if (!btnLap.disabled) recordLap(); }
    else if (e.code === 'KeyR') resetTimer();
});
</script>
</body>
</html>

