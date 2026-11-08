<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📝 Lista de Tareas</title>
    <style>
        /* ===== Variables ===== */
        :root {
            --primary:       #6c63ff;
            --primary-dark:  #574fd6;
            --primary-light: #ede9ff;
            --secondary:     #48cfad;
            --danger:        #fc5c65;
            --danger-light:  #ffeaeb;
            --info:          #4fc3f7;
            --info-light:    #e1f5fe;
            --success:       #26de81;
            --success-light: #e8fdf2;
            --warning:       #fed330;
            --text:          #2d3436;
            --text-muted:    #636e72;
            --bg:            #f0eeff;
            --card-bg:       #ffffff;
            --border:        #e0deff;
            --radius:        12px;
            --radius-sm:     8px;
            --shadow:        0 4px 20px rgba(108,99,255,.12);
            --shadow-hover:  0 8px 30px rgba(108,99,255,.22);
            --transition:    all .22s ease;
        }

        /* ===== Reset & Base ===== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        /* ===== Layout ===== */
        .container {
            max-width: 680px;
            margin: 0 auto;
        }

        /* ===== Header ===== */
        .app-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .app-header h1 {
            font-size: 2.4rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
        }
        .app-header p {
            color: var(--text-muted);
            margin-top: .4rem;
            font-size: .95rem;
        }

        /* ===== Card ===== */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 1.75rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border);
        }

        /* ===== Flash message ===== */
        .flash {
            padding: .9rem 1.2rem;
            border-radius: var(--radius-sm);
            margin-bottom: 1.25rem;
            font-size: .92rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: .6rem;
        }
        .flash.success { background: var(--success-light); color: #0a7c3e; border-left: 4px solid var(--success); }
        .flash.error   { background: var(--danger-light);  color: #c0392b; border-left: 4px solid var(--danger); }
        .flash.info    { background: var(--info-light);    color: #0277bd; border-left: 4px solid var(--info); }

        /* ===== Add Form ===== */
        .add-form {
            display: flex;
            gap: .75rem;
        }
        .add-form input[type="text"] {
            flex: 1;
            padding: .75rem 1rem;
            border: 2px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 1rem;
            color: var(--text);
            background: #fafafe;
            transition: var(--transition);
            outline: none;
        }
        .add-form input[type="text"]:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(108,99,255,.12);
        }
        .add-form input[type="text"]::placeholder { color: #b2bec3; }

        /* ===== Buttons ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            padding: .72rem 1.3rem;
            border: none;
            border-radius: var(--radius-sm);
            font-size: .92rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            white-space: nowrap;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), #a78bfa);
            color: #fff;
            box-shadow: 0 4px 14px rgba(108,99,255,.35);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), #9061f9);
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(108,99,255,.4);
        }
        .btn-danger {
            background: transparent;
            color: var(--danger);
            border: 1.5px solid #ffc5c8;
            padding: .45rem .75rem;
            font-size: .8rem;
        }
        .btn-danger:hover {
            background: var(--danger-light);
            border-color: var(--danger);
        }

        /* ===== Stats Bar ===== */
        .stats-bar {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .stat-pill {
            display: flex;
            align-items: center;
            gap: .5rem;
            background: var(--primary-light);
            color: var(--primary-dark);
            border-radius: 999px;
            padding: .45rem 1rem;
            font-size: .88rem;
            font-weight: 600;
        }
        .stat-pill.completadas { background: var(--success-light); color: #0a7c3e; }
        .stat-pill.pendientes  { background: #fff4e0; color: #d68910; }

        /* ===== Filters ===== */
        .filters {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }
        .filter-link {
            padding: .45rem 1rem;
            border-radius: 999px;
            font-size: .88rem;
            font-weight: 600;
            color: var(--text-muted);
            text-decoration: none;
            background: #f0eeff;
            border: 1.5px solid transparent;
            transition: var(--transition);
        }
        .filter-link:hover { background: var(--primary-light); color: var(--primary); }
        .filter-link.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 3px 10px rgba(108,99,255,.3);
        }

        /* ===== Task List ===== */
        .task-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: .65rem;
        }
        .task-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.1rem;
            background: var(--card-bg);
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            transition: var(--transition);
        }
        .task-item:hover {
            box-shadow: var(--shadow-hover);
            border-color: #c5bfff;
            transform: translateY(-1px);
        }
        .task-item.completed {
            background: #fafafe;
            border-color: #e9ecef;
            opacity: .8;
        }

        /* ===== Checkbox Toggle Form ===== */
        .toggle-form { display: flex; align-items: center; }
        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 22px;
            height: 22px;
            border: 2px solid #c5bfff;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            flex-shrink: 0;
            background: #fff;
        }
        .custom-checkbox:checked {
            background: linear-gradient(135deg, var(--primary), #a78bfa);
            border-color: transparent;
        }
        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            left: 5px; top: 2px;
            width: 8px; height: 13px;
            border: 2px solid #fff;
            border-top: none;
            border-left: none;
            transform: rotate(45deg);
        }
        .custom-checkbox:hover:not(:checked) {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108,99,255,.12);
        }

        /* ===== Task Title ===== */
        .task-title {
            flex: 1;
            font-size: .97rem;
            color: var(--text);
            word-break: break-word;
            line-height: 1.4;
        }
        .task-title.done {
            text-decoration: line-through;
            color: var(--text-muted);
        }
        .task-date {
            font-size: .75rem;
            color: #b2bec3;
            white-space: nowrap;
        }

        /* ===== Empty State ===== */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }
        .empty-state .empty-icon { font-size: 3.5rem; margin-bottom: 1rem; }
        .empty-state h3 { font-size: 1.1rem; font-weight: 600; margin-bottom: .4rem; color: var(--text); }
        .empty-state p  { font-size: .9rem; }

        /* ===== Divider ===== */
        .section-label {
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--text-muted);
            margin-bottom: .75rem;
        }

        /* ===== Responsive ===== */
        @media (max-width: 480px) {
            .add-form { flex-direction: column; }
            .btn-primary { width: 100%; }
            .task-date { display: none; }
            .app-header h1 { font-size: 1.9rem; }
        }
    </style>
</head>
<body>
<div class="container">

    <!-- Header -->
    <header class="app-header">
        <h1>📝 Lista de Tareas</h1>
        <p>Organiza tu día, una tarea a la vez</p>
    </header>

    <!-- Flash Message -->
    <?php if ($mensaje): ?>
    <div class="flash <?= htmlspecialchars($tipoMensaje) ?>">
        <?= htmlspecialchars($mensaje) ?>
    </div>
    <?php endif; ?>

    <!-- Add Task Form -->
    <div class="card">
        <p class="section-label">Nueva tarea</p>
        <form action="index.php?url=tareas/agregar" method="POST" class="add-form">
            <input
                type="text"
                name="titulo"
                placeholder="¿Qué necesitas hacer hoy?"
                maxlength="200"
                autocomplete="off"
                autofocus
                required
            >
            <button type="submit" class="btn btn-primary">
                <span>＋</span> Agregar
            </button>
        </form>
    </div>

    <!-- Stats + Filters -->
    <div class="card">
        <div class="stats-bar" style="margin-bottom:1.1rem;">
            <span class="stat-pill">
                📋 <?= $totalTareas ?> total
            </span>
            <span class="stat-pill pendientes">
                ⏳ <?= $pendientes ?> pendiente<?= $pendientes !== 1 ? 's' : '' ?>
            </span>
            <span class="stat-pill completadas">
                ✅ <?= $completadas ?> completada<?= $completadas !== 1 ? 's' : '' ?>
            </span>
        </div>

        <p class="section-label">Filtrar</p>
        <div class="filters">
            <a href="index.php?filter=todas"
               class="filter-link <?= $filterActual === 'todas' ? 'active' : '' ?>">
                🗂️ Todas
            </a>
            <a href="index.php?filter=pendientes"
               class="filter-link <?= $filterActual === 'pendientes' ? 'active' : '' ?>">
                ⏳ Pendientes
            </a>
            <a href="index.php?filter=completadas"
               class="filter-link <?= $filterActual === 'completadas' ? 'active' : '' ?>">
                ✅ Completadas
            </a>
        </div>
    </div>

    <!-- Task List -->
    <div class="card">
        <p class="section-label">
            <?php
            echo match ($filterActual) {
                'pendientes'  => 'Tareas pendientes',
                'completadas' => 'Tareas completadas',
                default       => 'Todas las tareas',
            };
            ?>
        </p>

        <?php if (empty($tareas)): ?>
        <div class="empty-state">
            <div class="empty-icon">
                <?= match ($filterActual) {
                    'completadas' => '🏆',
                    'pendientes'  => '🎉',
                    default       => '📭',
                } ?>
            </div>
            <h3>
                <?= match ($filterActual) {
                    'completadas' => 'Sin tareas completadas aún',
                    'pendientes'  => '¡Todo al día!',
                    default       => 'No hay tareas todavía',
                } ?>
            </h3>
            <p>
                <?= match ($filterActual) {
                    'completadas' => 'Completa algunas tareas y aparecerán aquí.',
                    'pendientes'  => 'No tienes tareas pendientes. ¡Buen trabajo!',
                    default       => 'Agrega tu primera tarea usando el formulario de arriba.',
                } ?>
            </p>
        </div>
        <?php else: ?>
        <ul class="task-list">
            <?php foreach ($tareas as $tarea): ?>
            <li class="task-item <?= $tarea['completed'] ? 'completed' : '' ?>">

                <!-- Toggle Completed -->
                <form action="index.php?url=tareas/completar" method="POST" class="toggle-form">
                    <input type="hidden" name="id"     value="<?= htmlspecialchars($tarea['id']) ?>">
                    <input type="hidden" name="filter" value="<?= htmlspecialchars($filterActual) ?>">
                    <button type="submit" style="background:none;border:none;padding:0;cursor:pointer;">
                        <input
                            type="checkbox"
                            class="custom-checkbox"
                            <?= $tarea['completed'] ? 'checked' : '' ?>
                            onclick="this.form.submit()"
                            readonly
                        >
                    </button>
                </form>

                <!-- Title -->
                <span class="task-title <?= $tarea['completed'] ? 'done' : '' ?>">
                    <?= htmlspecialchars($tarea['titulo']) ?>
                </span>

                <!-- Date -->
                <span class="task-date">
                    <?= date('d/m H:i', strtotime($tarea['created_at'])) ?>
                </span>

                <!-- Delete -->
                <form action="index.php?url=tareas/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($tarea['id']) ?>">
                    <button
                        type="submit"
                        class="btn btn-danger"
                        onclick="return confirm('¿Eliminar esta tarea?')"
                        title="Eliminar tarea"
                    >🗑️</button>
                </form>

            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <p style="text-align:center;color:#b2bec3;font-size:.8rem;margin-top:1.5rem;">
        Programación Orientada a la Web &mdash; Patrón MVC &middot; PHP 8
    </p>

</div>
</body>
</html>
