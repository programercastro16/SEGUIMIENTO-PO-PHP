<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>➕ Nueva Encuesta</title>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',system-ui,sans-serif;background:#f0f4ff;min-height:100vh;padding:2rem 1rem}
        .container{max-width:720px;margin:0 auto}
        h1{font-size:1.8rem;font-weight:800;color:#1e1b4b;margin-bottom:1.75rem}
        .errores{background:#fef2f2;border-left:4px solid #ef4444;border-radius:10px;padding:1rem 1.25rem;margin-bottom:1.5rem}
        .errores li{color:#b91c1c;margin-left:1.2rem;font-size:.875rem}
        .card{background:#fff;border-radius:16px;padding:1.75rem;box-shadow:0 4px 16px rgba(0,0,0,.08);margin-bottom:1.5rem}
        .card h2{font-size:1rem;font-weight:700;color:#4338ca;margin-bottom:1.25rem}
        .form-group{margin-bottom:1.2rem}
        label{display:block;font-size:.875rem;font-weight:600;color:#374151;margin-bottom:.4rem}
        input[type="text"],textarea,select{width:100%;padding:.75rem 1rem;border:2px solid #c7d2fe;border-radius:10px;font-size:1rem;color:#1f2937;background:#f8f7ff;transition:border-color .2s}
        input:focus,textarea:focus,select:focus{outline:none;border-color:#6366f1;background:#fff}
        textarea{resize:vertical;min-height:80px;font-family:inherit}
        /* Builder */
        #preguntas-container .pregunta-block{background:#f8f7ff;border:2px solid #c7d2fe;border-radius:12px;padding:1.25rem;margin-bottom:1rem;position:relative}
        .pregunta-block .preg-num{font-size:.72rem;font-weight:800;color:#6366f1;text-transform:uppercase;margin-bottom:.6rem}
        .pregunta-block .remove-preg{position:absolute;top:.75rem;right:.75rem;background:#fee2e2;color:#dc2626;border:none;border-radius:8px;padding:.3rem .6rem;cursor:pointer;font-size:.8rem;font-weight:700}
        .opciones-wrap{margin-top:.75rem}
        .opcion-row-build{display:flex;gap:.5rem;margin-bottom:.4rem}
        .opcion-row-build input{flex:1;padding:.5rem .75rem;border:1.5px solid #c7d2fe;border-radius:8px;font-size:.875rem}
        .btn-add-opt{padding:.4rem .8rem;background:#ede9fe;color:#4338ca;border:none;border-radius:8px;cursor:pointer;font-size:.8rem;font-weight:700}
        .btn-remove-opt{padding:.4rem .6rem;background:#fee2e2;color:#dc2626;border:none;border-radius:8px;cursor:pointer;font-size:.8rem}
        .btn-add-preg{width:100%;padding:.85rem;background:rgba(99,102,241,.1);color:#4338ca;border:2px dashed #c7d2fe;border-radius:12px;font-size:.95rem;font-weight:700;cursor:pointer;transition:background .2s}
        .btn-add-preg:hover{background:rgba(99,102,241,.18)}
        .btn-row{display:flex;gap:1rem;margin-top:1.5rem}
        .btn-primary{flex:1;padding:.85rem;background:linear-gradient(135deg,#6366f1,#4f46e5);color:#fff;font-size:1rem;font-weight:700;border:none;border-radius:10px;cursor:pointer}
        .btn-secondary{flex:1;padding:.85rem;background:#f3f4f6;color:#374151;font-size:1rem;font-weight:600;border:2px solid #d1d5db;border-radius:10px;text-decoration:none;text-align:center}
        .btn-secondary:hover{background:#e5e7eb}
    </style>
</head>
<body>
<div class="container">
    <h1>➕ Nueva Encuesta</h1>
    <?php if (!empty($errores)): ?>
        <div class="errores"><ul><?php foreach ($errores as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form action="/?url=encuesta/nueva" method="POST" onsubmit="serializePreguntas()">
        <div class="card">
            <h2>📌 Información de la Encuesta</h2>
            <div class="form-group">
                <label>Título *</label>
                <input type="text" name="titulo" placeholder="Ej: Satisfacción del servicio" required maxlength="150" value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Descripción</label>
                <textarea name="descripcion" placeholder="Breve descripción de la encuesta..."><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
            </div>
        </div>
        <div class="card">
            <h2>❓ Preguntas</h2>
            <div id="preguntas-container"></div>
            <button type="button" class="btn-add-preg" onclick="addPregunta()">+ Agregar Pregunta</button>
        </div>
        <input type="hidden" name="preguntas" id="preguntas-json" value="[]">
        <div class="btn-row">
            <a href="/?url=encuesta/administrar" class="btn-secondary">← Cancelar</a>
            <button type="submit" class="btn-primary">📤 Publicar Encuesta</button>
        </div>
    </form>
</div>
<script>
let pregCounter = 0;
function addPregunta() {
    pregCounter++;
    const id = 'preg_' + pregCounter;
    const div = document.createElement('div');
    div.className = 'pregunta-block';
    div.dataset.id = id;
    div.innerHTML = `
        <div class="preg-num">Pregunta ${pregCounter}</div>
        <button type="button" class="remove-preg" onclick="this.closest('.pregunta-block').remove(); renumberPregs()">✕</button>
        <div class="form-group">
            <label>Texto de la pregunta</label>
            <input type="text" class="preg-texto" placeholder="Escribe la pregunta aquí..." required>
        </div>
        <div class="form-group">
            <label>Tipo</label>
            <select class="preg-tipo" onchange="onTipoChange(this)">
                <option value="opcion_multiple">Opción múltiple</option>
                <option value="verdadero_falso">Verdadero / Falso</option>
                <option value="escala">Escala 1–5</option>
            </select>
        </div>
        <div class="opciones-wrap" style="display:block;">
            <label style="font-size:.8rem;font-weight:600;color:#374151;margin-bottom:.4rem;display:block;">Opciones (mínimo 2)</label>
            <div class="opciones-list">
                <div class="opcion-row-build"><input type="text" placeholder="Opción 1"><button type="button" class="btn-remove-opt" onclick="removeOpt(this)">✕</button></div>
                <div class="opcion-row-build"><input type="text" placeholder="Opción 2"><button type="button" class="btn-remove-opt" onclick="removeOpt(this)">✕</button></div>
            </div>
            <button type="button" class="btn-add-opt" onclick="addOpt(this)">+ Opción</button>
        </div>
    `;
    document.getElementById('preguntas-container').appendChild(div);
}
function renumberPregs() {
    document.querySelectorAll('.pregunta-block').forEach((el,i)=>{
        el.querySelector('.preg-num').textContent = 'Pregunta '+(i+1);
    });
}
function onTipoChange(sel) {
    const wrap = sel.closest('.pregunta-block').querySelector('.opciones-wrap');
    wrap.style.display = sel.value === 'opcion_multiple' ? 'block' : 'none';
}
function addOpt(btn) {
    const list = btn.previousElementSibling;
    if (list.children.length >= 6) return;
    const row = document.createElement('div');
    row.className = 'opcion-row-build';
    row.innerHTML = `<input type="text" placeholder="Opción ${list.children.length+1}"><button type="button" class="btn-remove-opt" onclick="removeOpt(this)">✕</button>`;
    list.appendChild(row);
}
function removeOpt(btn) {
    const list = btn.closest('.opciones-list');
    if (list.children.length > 2) btn.closest('.opcion-row-build').remove();
}
function serializePreguntas() {
    const pregs = [];
    document.querySelectorAll('.pregunta-block').forEach(block => {
        const tipo = block.querySelector('.preg-tipo').value;
        const texto = block.querySelector('.preg-texto').value.trim();
        const opciones = [];
        if (tipo === 'opcion_multiple') {
            block.querySelectorAll('.opciones-list input').forEach(inp => {
                if (inp.value.trim()) opciones.push(inp.value.trim());
            });
        }
        pregs.push({ texto, tipo, opciones });
    });
    document.getElementById('preguntas-json').value = JSON.stringify(pregs);
}
// Add first question by default
addPregunta();
</script>
</body>
</html>

