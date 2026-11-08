<?php
$tipoEmojis = ['Desayuno'=>'🌅','Almuerzo'=>'🍽️','Cena'=>'🌙','Snack'=>'🍿',
               'Postre'=>'🍰','Bebida'=>'🥤','Vegetariana'=>'🥗','Vegana'=>'🌱'];
$difColors  = ['Fácil'=>'#22c55e','Media'=>'#f59e0b','Difícil'=>'#ef4444'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🍳 Plataforma de Recetas</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #fff8f0; color: #1f2937; }
        header {
            background: linear-gradient(135deg, #7c2d12, #c2410c, #ea580c);
            color: #fff;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        header h1 { font-size: 1.7rem; font-weight: 800; }
        header p  { font-size: .85rem; opacity: .85; margin-top: .2rem; }
        .btn-add {
            background: rgba(255,255,255,.2);
            color: #fff;
            padding: .6rem 1.2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: .9rem;
            transition: background .2s;
        }
        .btn-add:hover { background: rgba(255,255,255,.35); }
        .container { max-width: 1100px; margin: 0 auto; padding: 2rem 1rem; }
        /* Flash */
        .flash {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            border-left: 4px solid #22c55e; border-radius: 10px;
            padding: .9rem 1.25rem; margin-bottom: 1.5rem;
            font-weight: 600; color: #166534;
        }
        /* Filtros */
        .filters {
            background: #fff;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,.07);
            margin-bottom: 1.75rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }
        .filters label { font-size: .78rem; font-weight: 700; color: #9ca3af; display: block; margin-bottom: .3rem; text-transform: uppercase; }
        .filters select, .filters input[type="text"], .filters input[type="number"] {
            padding: .55rem .9rem;
            border: 2px solid #fed7aa;
            border-radius: 8px;
            font-size: .9rem;
            background: #fffbf7;
        }
        .filters input[type="text"] { min-width: 200px; }
        .btn-filter {
            padding: .6rem 1.4rem;
            background: #ea580c;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-clear {
            padding: .6rem 1rem;
            background: #f3f4f6;
            color: #374151;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            font-size: .9rem;
        }
        /* Cards */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0,0,0,.08);
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }
        .card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,.14); }
        .card-img {
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            background: linear-gradient(135deg, #fed7aa, #fde68a);
        }
        .card-body { padding: 1.25rem; }
        .card-badges { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: .6rem; }
        .badge {
            display: inline-block;
            padding: .2rem .65rem;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 700;
        }
        .badge-tipo { background: #ffedd5; color: #9a3412; }
        .badge-dif  { color: #fff; }
        .card-title { font-size: 1.1rem; font-weight: 800; color: #1f2937; margin-bottom: .4rem; }
        .card-desc  { font-size: .82rem; color: #6b7280; line-height: 1.5; margin-bottom: .75rem;
                      display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .card-meta  { font-size: .78rem; color: #9ca3af; display: flex; gap: 1rem; margin-bottom: 1rem; }
        .btn-ver {
            display: block;
            text-align: center;
            padding: .6rem;
            background: linear-gradient(135deg, #ea580c, #c2410c);
            color: #fff;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: .9rem;
            transition: opacity .2s;
        }
        .btn-ver:hover { opacity: .88; }
        .empty { text-align: center; padding: 4rem 2rem; color: #9ca3af; }
        .empty .icon { font-size: 4rem; }
        .empty p { margin-top: .75rem; font-size: 1rem; }
        @media (max-width: 600px) { .filters { flex-direction: column; } }
    </style>
</head>
<body>
<header>
    <div>
        <h1>🍳 Plataforma de Recetas</h1>
        <p>Busca, guarda y comparte tus recetas favoritas</p>
    </div>
    <a href="/?url=receta/nueva" class="btn-add">➕ Agregar Receta</a>
</header>

<div class="container">
    <?php if (!empty($_SESSION['flash'])): ?>
        <div class="flash"><?= htmlspecialchars($_SESSION['flash']) ?></div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <!-- Filtros -->
    <form class="filters" method="GET" action="/">
        <input type="hidden" name="url" value="receta">
        <div>
            <label>🔍 Buscar</label>
            <input type="text" name="busqueda" placeholder="Ingrediente o título..." value="<?= htmlspecialchars($filtros['busqueda'] ?? '') ?>">
        </div>
        <div>
            <label>🍽️ Tipo</label>
            <select name="tipo">
                <option value="">Todos</option>
                <?php foreach ($tipos as $t): ?>
                    <option value="<?= $t ?>" <?= ($filtros['tipo'] ?? '') === $t ? 'selected' : '' ?>><?= $t ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>⚡ Dificultad</label>
            <select name="dificultad">
                <option value="">Todas</option>
                <?php foreach ($dificultades as $d): ?>
                    <option value="<?= $d ?>" <?= ($filtros['dificultad'] ?? '') === $d ? 'selected' : '' ?>><?= $d ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>⏱️ Tiempo máx (min)</label>
            <input type="number" name="tiempo_max" min="5" max="300" placeholder="Ej: 30" style="width:100px;"
                   value="<?= htmlspecialchars($filtros['tiempo_max'] ?? '') ?>">
        </div>
        <button type="submit" class="btn-filter">Filtrar</button>
        <a href="/?url=receta" class="btn-clear">✕ Limpiar</a>
    </form>

    <!-- Grid de recetas -->
    <?php if (empty($recetas)): ?>
        <div class="empty">
            <div class="icon">🔍</div>
            <p>No se encontraron recetas con los filtros aplicados.</p>
        </div>
    <?php else: ?>
        <div class="grid">
            <?php foreach ($recetas as $r):
                $emoji = $tipoEmojis[$r['tipo_comida']] ?? '🍽️';
                $difColor = $difColors[$r['dificultad']] ?? '#78716c';
            ?>
            <div class="card">
                <div class="card-img"><?= $emoji ?></div>
                <div class="card-body">
                    <div class="card-badges">
                        <span class="badge badge-tipo"><?= htmlspecialchars($r['tipo_comida']) ?></span>
                        <span class="badge badge-dif" style="background:<?= $difColor ?>;"><?= htmlspecialchars($r['dificultad']) ?></span>
                    </div>
                    <div class="card-title"><?= htmlspecialchars($r['titulo']) ?></div>
                    <div class="card-desc"><?= htmlspecialchars($r['descripcion']) ?></div>
                    <div class="card-meta">
                        <span>⏱️ <?= $r['tiempo_preparacion'] ?> min</span>
                        <span>👥 <?= $r['porciones'] ?> porciones</span>
                        <span>🧪 <?= count($r['ingredientes']) ?> ingredientes</span>
                    </div>
                    <a href="/?url=receta/ver/<?= $r['id'] ?>" class="btn-ver">👁️ Ver Receta</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>

