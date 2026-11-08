<?php
// ── Helpers ──────────────────────────────────────────────────────────────────
$mesesNombres = [
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
];

$diasEnMes     = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);
$primerDiaSemana = (int) date('w', mktime(0, 0, 0, $mes, 1, $anio)); // 0=Dom
$hoy           = date('Y-m-d');

// navigation
$mesPrev  = $mes - 1; $anioPrev = $anio;
if ($mesPrev < 1)  { $mesPrev = 12; $anioPrev--; }
$mesSig   = $mes + 1; $anioSig  = $anio;
if ($mesSig > 12) { $mesSig = 1;  $anioSig++; }

function colorCategoria(string $cat): string {
    return match($cat) {
        'Trabajo'      => '#7c3aed',
        'Personal'     => '#a855f7',
        'Cumpleaños'   => '#ec4899',
        'Reunión'      => '#6366f1',
        'Recordatorio' => '#f59e0b',
        'Festivo'      => '#10b981',
        default        => '#8b5cf6',
    };
}

function formatHora(string $h): string {
    return date('H:i', strtotime($h));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>📆 Calendario de Eventos</title>
<style>
  :root {
    --purple-50:  #faf5ff;
    --purple-100: #f3e8ff;
    --purple-200: #e9d5ff;
    --purple-300: #d8b4fe;
    --purple-400: #c084fc;
    --purple-500: #a855f7;
    --purple-600: #9333ea;
    --purple-700: #7c3aed;
    --purple-800: #6d28d9;
    --purple-900: #4c1d95;
    --gray-50:  #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-500: #6b7280;
    --gray-700: #374151;
    --gray-900: #111827;
    --radius: 12px;
    --shadow: 0 4px 24px rgba(124,58,237,.12);
  }
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Segoe UI', system-ui, sans-serif;
    background: var(--purple-50);
    color: var(--gray-900);
    min-height: 100vh;
  }

  /* ── Header ── */
  .app-header {
    background: linear-gradient(135deg, var(--purple-700) 0%, var(--purple-500) 100%);
    color: #fff;
    padding: 1.25rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 12px rgba(124,58,237,.4);
  }
  .app-header h1 { font-size: 1.5rem; font-weight: 700; letter-spacing: -.5px; }
  .btn {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1.1rem; border-radius: 8px; font-size: .875rem;
    font-weight: 600; cursor: pointer; text-decoration: none; border: none;
    transition: filter .15s, transform .1s;
  }
  .btn:hover { filter: brightness(1.08); transform: translateY(-1px); }
  .btn-primary { background: #fff; color: var(--purple-700); }
  .btn-outline { background: transparent; color: #fff; border: 2px solid rgba(255,255,255,.6); }
  .btn-sm { padding: .3rem .7rem; font-size: .8rem; }
  .btn-danger  { background: #fee2e2; color: #991b1b; }
  .btn-edit    { background: var(--purple-100); color: var(--purple-700); }

  /* ── Layout ── */
  .layout {
    display: grid;
    grid-template-columns: 1fr 280px;
    gap: 1.5rem;
    max-width: 1200px;
    margin: 1.5rem auto;
    padding: 0 1rem 2rem;
  }
  @media (max-width: 860px) { .layout { grid-template-columns: 1fr; } }

  /* ── Calendar card ── */
  .cal-card {
    background: #fff;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
  }
  .cal-nav {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.25rem;
    background: var(--purple-700);
    color: #fff;
  }
  .cal-nav a {
    color: #fff; text-decoration: none; font-size: 1.3rem; font-weight: bold;
    width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
    border-radius: 50%; background: rgba(255,255,255,.15);
    transition: background .15s;
  }
  .cal-nav a:hover { background: rgba(255,255,255,.3); }
  .cal-nav h2 { font-size: 1.1rem; font-weight: 700; text-transform: capitalize; }

  /* ── Grid ── */
  .cal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
  }
  .cal-dow {
    text-align: center; font-size: .7rem; font-weight: 700;
    color: var(--purple-700); padding: .6rem 0;
    background: var(--purple-100);
    text-transform: uppercase; letter-spacing: .05em;
  }
  .cal-day {
    min-height: 90px;
    padding: .4rem .35rem;
    border-top: 1px solid var(--gray-100);
    border-right: 1px solid var(--gray-100);
    position: relative;
    background: #fff;
    transition: background .1s;
  }
  .cal-day:nth-child(7n) { border-right: none; }
  .cal-day.empty { background: var(--gray-50); }
  .cal-day.today {
    background: var(--purple-50);
  }
  .cal-day.today .day-num {
    background: var(--purple-700); color: #fff;
    border-radius: 50%; width: 26px; height: 26px;
    display: flex; align-items: center; justify-content: center;
  }
  .day-num {
    font-size: .8rem; font-weight: 700; color: var(--gray-700);
    margin-bottom: .25rem;
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 26px; height: 26px;
  }
  .day-num a {
    color: inherit; text-decoration: none; display: flex;
    align-items: center; justify-content: center;
    width: 100%; height: 100%;
  }
  .day-num a:hover { text-decoration: underline; }
  .event-pills { display: flex; flex-direction: column; gap: 2px; }
  .event-pill {
    display: block; font-size: .67rem; font-weight: 600;
    padding: 2px 5px; border-radius: 4px; color: #fff;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    text-decoration: none; cursor: pointer;
    transition: opacity .15s;
  }
  .event-pill:hover { opacity: .85; }
  .more-events {
    font-size: .65rem; color: var(--purple-600);
    font-weight: 600; margin-top: 2px; cursor: pointer; text-decoration: none;
  }
  .more-events:hover { text-decoration: underline; }

  /* ── Sidebar ── */
  .sidebar { display: flex; flex-direction: column; gap: 1rem; }
  .sidebar-card {
    background: #fff; border-radius: var(--radius);
    box-shadow: var(--shadow); overflow: hidden;
  }
  .sidebar-card-header {
    background: var(--purple-700); color: #fff;
    padding: .75rem 1rem; font-weight: 700; font-size: .9rem;
  }
  .proximos-list { padding: .5rem; }
  .proximo-item {
    display: flex; gap: .6rem; align-items: flex-start;
    padding: .55rem .5rem; border-radius: 8px;
    transition: background .1s; text-decoration: none; color: inherit;
  }
  .proximo-item:hover { background: var(--purple-50); }
  .proximo-dot {
    width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; margin-top: 4px;
  }
  .proximo-info { flex: 1; min-width: 0; }
  .proximo-titulo { font-size: .82rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .proximo-meta  { font-size: .72rem; color: var(--gray-500); margin-top: 1px; }
  .proximo-fecha-sep {
    padding: .3rem .5rem; font-size: .7rem; font-weight: 700;
    color: var(--purple-700); background: var(--purple-50);
    border-radius: 6px; margin: .2rem .5rem 0;
  }
  .empty-msg {
    padding: 1.5rem 1rem; text-align: center;
    color: var(--gray-500); font-size: .85rem;
  }

  /* ── Leyenda categorías ── */
  .legend { padding: .75rem 1rem; display: flex; flex-wrap: wrap; gap: .4rem; }
  .legend-item {
    display: flex; align-items: center; gap: .3rem;
    font-size: .72rem; color: var(--gray-700);
  }
  .legend-dot { width: 8px; height: 8px; border-radius: 50%; }
</style>
</head>
<body>

<header class="app-header">
  <h1>📆 Calendario de Eventos</h1>
  <div style="display:flex;gap:.5rem;">
    <a href="<?= BASE_URL ?>/evento/proximos" class="btn btn-outline">📋 Próximos</a>
    <a href="<?= BASE_URL ?>/evento/nuevo" class="btn btn-primary">＋ Nuevo Evento</a>
  </div>
</header>

<div class="layout">

  <!-- ── Calendar ── -->
  <div class="cal-card">
    <div class="cal-nav">
      <a href="<?= BASE_URL ?>/evento/index?mes=<?= $mesPrev ?>&anio=<?= $anioPrev ?>" title="Mes anterior">&#8592;</a>
      <h2><?= $mesesNombres[$mes] ?> <?= $anio ?></h2>
      <a href="<?= BASE_URL ?>/evento/index?mes=<?= $mesSig ?>&anio=<?= $anioSig ?>" title="Mes siguiente">&#8594;</a>
    </div>

    <div class="cal-grid">
      <?php foreach (['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'] as $d): ?>
        <div class="cal-dow"><?= $d ?></div>
      <?php endforeach; ?>

      <?php
      // empty cells before 1st
      for ($e = 0; $e < $primerDiaSemana; $e++):
      ?>
        <div class="cal-day empty"></div>
      <?php endfor; ?>

      <?php for ($dia = 1; $dia <= $diasEnMes; $dia++):
        $fechaStr = sprintf('%04d-%02d-%02d', $anio, $mes, $dia);
        $esHoy    = $fechaStr === $hoy;
        $evsDia   = $eventosPorDia[$fechaStr] ?? [];
        $clases   = 'cal-day' . ($esHoy ? ' today' : '');
      ?>
        <div class="<?= $clases ?>">
          <div class="day-num">
            <?php if (!empty($evsDia)): ?>
              <a href="<?= BASE_URL ?>/evento/dia/<?= $fechaStr ?>"><?= $dia ?></a>
            <?php else: ?>
              <a href="<?= BASE_URL ?>/evento/nuevo?fecha=<?= $fechaStr ?>" style="color:inherit;opacity:.5"><?= $dia ?></a>
            <?php endif; ?>
          </div>
          <?php if (!empty($evsDia)): ?>
          <div class="event-pills">
            <?php $mostrar = array_slice($evsDia, 0, 3); ?>
            <?php foreach ($mostrar as $ev): ?>
              <a class="event-pill"
                 href="<?= BASE_URL ?>/evento/dia/<?= $fechaStr ?>"
                 style="background:<?= htmlspecialchars($ev['color']) ?>"
                 title="<?= htmlspecialchars($ev['titulo']) ?>">
                <?= htmlspecialchars(mb_substr($ev['titulo'], 0, 18)) ?>
              </a>
            <?php endforeach; ?>
            <?php if (count($evsDia) > 3): ?>
              <a class="more-events" href="<?= BASE_URL ?>/evento/dia/<?= $fechaStr ?>">+<?= count($evsDia) - 3 ?> más…</a>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
      <?php endfor; ?>

      <?php
      // fill remaining cells
      $totalCeldas = $primerDiaSemana + $diasEnMes;
      $restantes   = (7 - ($totalCeldas % 7)) % 7;
      for ($r = 0; $r < $restantes; $r++):
      ?>
        <div class="cal-day empty"></div>
      <?php endfor; ?>
    </div>

    <!-- Leyenda -->
    <div class="legend">
      <?php foreach ([
          'Trabajo'=>'#7c3aed','Personal'=>'#a855f7','Cumpleaños'=>'#ec4899',
          'Reunión'=>'#6366f1','Recordatorio'=>'#f59e0b','Festivo'=>'#10b981','Otro'=>'#8b5cf6'
        ] as $cat => $col): ?>
        <span class="legend-item">
          <span class="legend-dot" style="background:<?= $col ?>"></span><?= $cat ?>
        </span>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- ── Sidebar ── -->
  <aside class="sidebar">
    <div class="sidebar-card">
      <div class="sidebar-card-header">🔔 Próximos 7 días</div>
      <div class="proximos-list">
        <?php if (empty($proximos)): ?>
          <p class="empty-msg">No hay eventos próximos.</p>
        <?php else:
          $fechaActual = '';
          foreach ($proximos as $pev):
            if ($pev['fecha'] !== $fechaActual):
              $fechaActual = $pev['fecha'];
              $ts = strtotime($pev['fecha']);
              $esHoyLabel = ($fechaActual === $hoy) ? ' (Hoy)' : '';
              $etiqueta = date('d', $ts) . ' ' . ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'][(int)date('n',$ts)-1] . $esHoyLabel;
        ?>
          <div class="proximo-fecha-sep"><?= $etiqueta ?></div>
        <?php endif; ?>
          <a class="proximo-item" href="<?= BASE_URL ?>/evento/dia/<?= $pev['fecha'] ?>">
            <span class="proximo-dot" style="background:<?= htmlspecialchars($pev['color']) ?>"></span>
            <div class="proximo-info">
              <div class="proximo-titulo"><?= htmlspecialchars($pev['titulo']) ?></div>
              <div class="proximo-meta">
                <?= htmlspecialchars($pev['hora_inicio']) ?> – <?= htmlspecialchars($pev['hora_fin']) ?>
                · <?= htmlspecialchars($pev['categoria']) ?>
                <?= $pev['recordatorio'] ? ' 🔔' : '' ?>
              </div>
            </div>
          </a>
        <?php endforeach; endif; ?>
      </div>
    </div>

    <div class="sidebar-card">
      <div class="sidebar-card-header">➕ Acciones rápidas</div>
      <div style="padding:.75rem;display:flex;flex-direction:column;gap:.5rem;">
        <a href="<?= BASE_URL ?>/evento/nuevo" class="btn btn-primary" style="justify-content:center;background:var(--purple-700);color:#fff;">
          ＋ Nuevo Evento
        </a>
        <a href="<?= BASE_URL ?>/evento/nuevo?fecha=<?= $hoy ?>" class="btn btn-outline" style="color:var(--purple-700);border-color:var(--purple-300);justify-content:center;">
          📅 Evento Hoy
        </a>
        <a href="<?= BASE_URL ?>/evento/dia/<?= $hoy ?>" class="btn btn-outline" style="color:var(--purple-700);border-color:var(--purple-300);justify-content:center;">
          👁 Ver Hoy
        </a>
      </div>
    </div>
  </aside>

</div>
</body>
</html>
