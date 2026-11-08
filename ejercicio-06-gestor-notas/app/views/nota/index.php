<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📔 Gestor de Notas</title>
    <style>
        /* ── Reset & Base ─────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:        #faf7f2;
            --surface:   #ffffff;
            --text:      #2d2d2d;
            --muted:     #888;
            --accent:    #ff6b6b;
            --accent2:   #ffd93d;
            --radius:    14px;
            --shadow:    0 4px 18px rgba(0,0,0,.10);
            --shadow-hover: 0 8px 30px rgba(0,0,0,.18);

            /* Note palette */
            --amarillo:  #fff9c4;
            --amarillo-b:#f9a825;
            --azul:      #bbdefb;
            --azul-b:    #1565c0;
            --verde:     #c8e6c9;
            --verde-b:   #2e7d32;
            --rosa:      #f8bbd0;
            --rosa-b:    #c2185b;
            --morado:    #e1bee7;
            --morado-b:  #6a1b9a;
            --naranja:   #ffe0b2;
            --naranja-b: #e65100;
            --gris:      #eceff1;
            --gris-b:    #455a64;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }

        /* ── Header ───────────────────────────────────────────────── */
        .header {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffd93d 100%);
            color: #fff;
            padding: 1.5rem 2rem;
            box-shadow: 0 3px 12px rgba(255,107,107,.35);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-inner {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .header h1 {
            font-size: 1.9rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            white-space: nowrap;
            text-shadow: 1px 2px 6px rgba(0,0,0,.15);
        }

        /* ── Search bar ───────────────────────────────────────────── */
        .search-form {
            display: flex;
            gap: .5rem;
            flex: 1;
            min-width: 220px;
        }

        .search-form input[type="text"] {
            flex: 1;
            padding: .6rem 1rem;
            border: 2px solid rgba(255,255,255,.6);
            border-radius: 50px;
            background: rgba(255,255,255,.25);
            color: #fff;
            font-size: .95rem;
            outline: none;
            transition: background .2s, border-color .2s;
        }

        .search-form input[type="text"]::placeholder { color: rgba(255,255,255,.8); }
        .search-form input[type="text"]:focus {
            background: rgba(255,255,255,.4);
            border-color: #fff;
        }

        .search-form button {
            padding: .6rem 1.2rem;
            border: none;
            border-radius: 50px;
            background: rgba(255,255,255,.9);
            color: #ff6b6b;
            font-weight: 700;
            cursor: pointer;
            transition: background .2s, transform .1s;
        }

        .search-form button:hover { background: #fff; transform: scale(1.04); }

        /* ── Category pills ───────────────────────────────────────── */
        .cats-wrap {
            background: var(--surface);
            border-bottom: 2px solid #f0ebe2;
            padding: .9rem 2rem;
            overflow-x: auto;
        }

        .cats-inner {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            gap: .6rem;
            align-items: center;
        }

        .cat-pill {
            display: inline-block;
            padding: .4rem 1rem;
            border-radius: 50px;
            font-size: .82rem;
            font-weight: 600;
            text-decoration: none;
            border: 2px solid transparent;
            white-space: nowrap;
            transition: all .18s;
            color: var(--text);
            background: #f0ebe2;
        }

        .cat-pill:hover { background: #ffe0b2; border-color: #ff9800; }
        .cat-pill.active { background: #ff6b6b; color: #fff; border-color: #ff6b6b; }
        .cat-pill.all { background: #ffd93d; border-color: #ffd93d; color: #5a3e00; }
        .cat-pill.all.active { background: #ff6b6b; color: #fff; border-color: #ff6b6b; }

        /* ── Main layout ──────────────────────────────────────────── */
        .main {
            max-width: 1300px;
            margin: 0 auto;
            padding: 2rem 2rem 6rem;
        }

        /* ── Status bar ───────────────────────────────────────────── */
        .status-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .status-bar p { color: var(--muted); font-size: .9rem; }
        .status-bar strong { color: var(--text); }

        .btn-clear {
            padding: .35rem .9rem;
            font-size: .82rem;
            background: #fff3e0;
            color: #e65100;
            border: 1.5px solid #ffcc80;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: background .2s;
        }
        .btn-clear:hover { background: #ffe0b2; }

        /* ── Empty state ──────────────────────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 5rem 1rem;
        }

        .empty-state .emoji { font-size: 5rem; display: block; margin-bottom: 1rem; }
        .empty-state h2 { font-size: 1.5rem; color: var(--muted); margin-bottom: .5rem; }
        .empty-state p { color: var(--muted); margin-bottom: 1.5rem; }

        /* ── Notes grid ───────────────────────────────────────────── */
        .notes-grid {
            columns: 3 320px;
            column-gap: 1.4rem;
        }

        /* ── Note card ────────────────────────────────────────────── */
        .note-card {
            break-inside: avoid;
            margin-bottom: 1.4rem;
            border-radius: var(--radius);
            padding: 1.3rem 1.3rem 1rem;
            box-shadow: var(--shadow);
            transition: transform .2s, box-shadow .2s;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: .6rem;
        }

        .note-card:hover {
            transform: translateY(-4px) rotate(.3deg);
            box-shadow: var(--shadow-hover);
        }

        /* color variants */
        .note-card.amarillo { background: var(--amarillo); border-top: 4px solid var(--amarillo-b); }
        .note-card.azul     { background: var(--azul);     border-top: 4px solid var(--azul-b);     }
        .note-card.verde    { background: var(--verde);    border-top: 4px solid var(--verde-b);    }
        .note-card.rosa     { background: var(--rosa);     border-top: 4px solid var(--rosa-b);     }
        .note-card.morado   { background: var(--morado);   border-top: 4px solid var(--morado-b);   }
        .note-card.naranja  { background: var(--naranja);  border-top: 4px solid var(--naranja-b);  }
        .note-card.gris     { background: var(--gris);     border-top: 4px solid var(--gris-b);     }

        /* pin decoration */
        .note-card::before {
            content: '📌';
            position: absolute;
            top: -10px;
            right: 18px;
            font-size: 1.3rem;
            filter: drop-shadow(0 2px 3px rgba(0,0,0,.2));
        }

        .note-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1.3;
            margin-right: 1.5rem; /* space for pin */
        }

        .note-title a {
            color: inherit;
            text-decoration: none;
        }
        .note-title a:hover { text-decoration: underline; }

        .note-preview {
            font-size: .88rem;
            color: #444;
            line-height: 1.55;
            white-space: pre-wrap;
            word-break: break-word;
        }

        .note-meta {
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-wrap: wrap;
            margin-top: .2rem;
        }

        .cat-badge {
            font-size: .72rem;
            font-weight: 700;
            padding: .18rem .6rem;
            border-radius: 50px;
            background: rgba(0,0,0,.12);
            color: #333;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .note-date {
            font-size: .72rem;
            color: #666;
            margin-left: auto;
        }

        /* card action buttons */
        .note-actions {
            display: flex;
            gap: .5rem;
            justify-content: flex-end;
            margin-top: .2rem;
            opacity: 0;
            transition: opacity .18s;
        }

        .note-card:hover .note-actions { opacity: 1; }

        .btn-sm {
            padding: .3rem .75rem;
            border-radius: 50px;
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: filter .15s, transform .1s;
        }

        .btn-sm:hover { filter: brightness(.9); transform: scale(1.05); }
        .btn-edit   { background: rgba(255,255,255,.8); color: #333; }
        .btn-delete { background: rgba(220,53,69,.15); color: #c0392b; }
        .btn-view   { background: rgba(255,255,255,.8); color: #1565c0; }

        /* ── FAB (Nueva Nota) ──────────────────────────────────────── */
        .fab {
            position: fixed;
            bottom: 2.2rem;
            right: 2.2rem;
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b, #ffd93d);
            color: #fff;
            font-size: 2rem;
            line-height: 62px;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 6px 20px rgba(255,107,107,.55);
            transition: transform .2s, box-shadow .2s;
            z-index: 200;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fab:hover {
            transform: scale(1.12) rotate(90deg);
            box-shadow: 0 10px 30px rgba(255,107,107,.65);
        }

        .fab-label {
            position: fixed;
            bottom: 2.4rem;
            right: 5.5rem;
            background: #333;
            color: #fff;
            font-size: .8rem;
            font-weight: 600;
            padding: .4rem .9rem;
            border-radius: 8px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity .2s;
        }

        .fab:hover ~ .fab-label { opacity: 1; }

        /* ── Responsive ───────────────────────────────────────────── */
        @media (max-width: 700px) {
            .header-inner { gap: .8rem; }
            .header h1 { font-size: 1.4rem; }
            .notes-grid { columns: 1; }
            .main { padding: 1rem 1rem 5rem; }
        }
    </style>
</head>
<body>

<!-- ── Header ─────────────────────────────────────────────────── -->
<header class="header">
    <div class="header-inner">
        <h1>📔 Gestor de Notas</h1>
        <form class="search-form" method="GET" action="<?= BASE_URL ?>/nota/index">
            <?php if (!empty($catActiva)): ?>
                <input type="hidden" name="cat" value="<?= htmlspecialchars($catActiva) ?>">
            <?php endif; ?>
            <input type="text" name="q"
                   placeholder="Buscar notas…"
                   value="<?= htmlspecialchars($busqueda) ?>"
                   autocomplete="off">
            <button type="submit">🔍 Buscar</button>
        </form>
    </div>
</header>

<!-- ── Category filters ───────────────────────────────────────── -->
<nav class="cats-wrap">
    <div class="cats-inner">
        <a href="<?= BASE_URL ?>/nota/index<?= !empty($busqueda) ? '?q=' . urlencode($busqueda) : '' ?>"
           class="cat-pill all <?= empty($catActiva) ? 'active' : '' ?>">
            🗂️ Todas
        </a>
        <?php foreach ($categorias as $cat): ?>
            <?php
                $active = strtolower($catActiva) === strtolower($cat) ? 'active' : '';
                $url    = BASE_URL . '/nota/index?cat=' . urlencode($cat);
                if (!empty($busqueda)) $url .= '&q=' . urlencode($busqueda);
            ?>
            <a href="<?= $url ?>"
               class="cat-pill <?= $active ?>">
                <?= htmlspecialchars($cat) ?>
            </a>
        <?php endforeach; ?>
    </div>
</nav>

<!-- ── Main content ───────────────────────────────────────────── -->
<main class="main">

    <!-- Status bar -->
    <div class="status-bar">
        <p>
            <?php if (!empty($busqueda) || !empty($catActiva)): ?>
                Mostrando <strong><?= count($notas) ?></strong>
                resultado<?= count($notas) !== 1 ? 's' : '' ?>
                <?php if (!empty($busqueda)): ?>
                    para "<strong><?= htmlspecialchars($busqueda) ?></strong>"
                <?php endif; ?>
                <?php if (!empty($catActiva)): ?>
                    en <strong><?= htmlspecialchars($catActiva) ?></strong>
                <?php endif; ?>
            <?php else: ?>
                <strong><?= count($notas) ?></strong> nota<?= count($notas) !== 1 ? 's' : '' ?> guardada<?= count($notas) !== 1 ? 's' : '' ?>
            <?php endif; ?>
        </p>
        <?php if (!empty($busqueda) || !empty($catActiva)): ?>
            <a href="<?= BASE_URL ?>/nota/index" class="btn-clear">✕ Limpiar filtros</a>
        <?php endif; ?>
    </div>

    <!-- Empty state -->
    <?php if (empty($notas)): ?>
        <div class="empty-state">
            <span class="emoji">📭</span>
            <?php if (!empty($busqueda) || !empty($catActiva)): ?>
                <h2>Sin resultados</h2>
                <p>No se encontraron notas con esos criterios.</p>
                <a href="<?= BASE_URL ?>/nota/index" class="btn-clear">Ver todas las notas</a>
            <?php else: ?>
                <h2>¡Aún no hay notas!</h2>
                <p>Haz clic en el botón <strong>+</strong> para crear tu primera nota.</p>
            <?php endif; ?>
        </div>

    <!-- Notes grid -->
    <?php else: ?>
        <div class="notes-grid">
            <?php foreach ($notas as $nota): ?>
                <?php
                    $color   = htmlspecialchars($nota['color'] ?? 'amarillo');
                    $preview = mb_strlen($nota['contenido']) > 100
                        ? mb_substr($nota['contenido'], 0, 100) . '…'
                        : $nota['contenido'];
                    $fecha = date('d/m/Y', strtotime($nota['created_at']));
                ?>
                <article class="note-card <?= $color ?>">
                    <h2 class="note-title">
                        <a href="<?= BASE_URL ?>/nota/ver/<?= urlencode($nota['id']) ?>">
                            <?= htmlspecialchars($nota['titulo']) ?>
                        </a>
                    </h2>
                    <p class="note-preview"><?= htmlspecialchars($preview) ?></p>
                    <div class="note-meta">
                        <span class="cat-badge"><?= htmlspecialchars($nota['categoria']) ?></span>
                        <span class="note-date">📅 <?= $fecha ?></span>
                    </div>
                    <div class="note-actions">
                        <a href="<?= BASE_URL ?>/nota/ver/<?= urlencode($nota['id']) ?>"
                           class="btn-sm btn-view">👁 Ver</a>
                        <a href="<?= BASE_URL ?>/nota/editar/<?= urlencode($nota['id']) ?>"
                           class="btn-sm btn-edit">✏️ Editar</a>
                        <form method="POST"
                              action="<?= BASE_URL ?>/nota/eliminar"
                              onsubmit="return confirm('¿Eliminar esta nota?');"
                              style="display:inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($nota['id']) ?>">
                            <button type="submit" class="btn-sm btn-delete">🗑 Borrar</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<!-- ── FAB ────────────────────────────────────────────────────── -->
<a href="<?= BASE_URL ?>/nota/nueva" class="fab" title="Nueva nota">＋</a>
<span class="fab-label">Nueva Nota</span>

</body>
</html>
