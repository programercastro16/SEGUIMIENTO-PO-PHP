<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento PO PHP — Thomas Castro</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
            min-height: 100vh;
            color: #f1f5f9;
            padding: 2.5rem 1rem 4rem;
        }
        .container { max-width: 1100px; margin: 0 auto; }
        
        /* Hero */
        .hero {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem 1rem;
        }
        .badge-sub {
            display: inline-block;
            padding: .4rem 1rem;
            background: rgba(99, 102, 241, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.4);
            border-radius: 50px;
            font-size: .85rem;
            font-weight: 700;
            color: #a5b4fc;
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-bottom: 1rem;
        }
        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.2rem);
            font-weight: 900;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #fff 30%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: .75rem;
        }
        .hero p {
            font-size: 1.15rem;
            color: #94a3b8;
            max-width: 650px;
            margin: 0 auto 1.5rem;
            line-height: 1.6;
        }
        .meta-tags {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .meta-tag {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: .4rem .9rem;
            border-radius: 8px;
            font-size: .85rem;
            color: #cbd5e1;
        }

        /* Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }
        .card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            transition: transform .2s ease, border-color .2s ease, background .2s ease, box-shadow .2s ease;
            position: relative;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(165, 180, 252, 0.4);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.35);
        }
        .card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .card-num {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
            box-shadow: 0 6px 16px rgba(79, 70, 229, 0.3);
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: #fff;
        }
        .card-desc {
            color: #94a3b8;
            font-size: .92rem;
            line-height: 1.55;
            margin-bottom: 1.25rem;
            flex: 1;
        }
        .card-tags {
            display: flex;
            gap: .4rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }
        .tag {
            background: rgba(255, 255, 255, 0.06);
            padding: .2rem .6rem;
            border-radius: 6px;
            font-size: .75rem;
            color: #cbd5e1;
            font-weight: 600;
        }
        .card-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .75rem 1rem;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: .92rem;
            transition: opacity .15s ease, transform .15s ease;
        }
        .card-btn:hover {
            opacity: .92;
            transform: scale(1.02);
        }

        /* Footer */
        footer {
            text-align: center;
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            color: #64748b;
            font-size: .9rem;
        }
        footer a {
            color: #a5b4fc;
            text-decoration: none;
            font-weight: 600;
        }
        footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="container">
    <div class="hero">
        <div class="badge-sub">ITM — Programación Orientada a la Web con PHP</div>
        <h1>Seguimiento PO PHP</h1>
        <p>Monorepo de 11 ejercicios prácticos desarrollados con arquitectura <strong>MVC en PHP 8.x puro</strong>, persistencia en JSON y diseño moderno responsive.</p>
        <div class="meta-tags">
            <span class="meta-tag">👨‍💻 Thomas Castro</span>
            <span class="meta-tag">🏛️ ITM</span>
            <span class="meta-tag">🧱 11 Módulos MVC</span>
            <span class="meta-tag">🐘 PHP 8.x</span>
            <span class="meta-tag">⚡ Sin Frameworks</span>
        </div>
    </div>

    <div class="grid">
        <!-- 01 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">📝</div>
                <div class="card-title">01. Lista de Tareas</div>
            </div>
            <p class="card-desc">Crea una aplicación web que permita a los usuarios agregar, eliminar y marcar como completadas tareas de una lista con filtros.</p>
            <div class="card-tags">
                <span class="tag">CRUD</span>
                <span class="tag">Filtros</span>
                <span class="tag">JSON</span>
            </div>
            <a href="ejercicio-01-lista-tareas/" class="card-btn">Abrir Ejercicio →</a>
        </div>

        <!-- 02 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">💰</div>
                <div class="card-title">02. Calculadora de Propinas</div>
            </div>
            <p class="card-desc">Calcula automáticamente la propina según el monto total, porcentaje seleccionado y número de personas, con historial de cálculos.</p>
            <div class="card-tags">
                <span class="tag">Cálculos</span>
                <span class="tag">Historial</span>
                <span class="tag">División de cuenta</span>
            </div>
            <a href="ejercicio-02-calculadora-propinas/" class="card-btn">Abrir Ejercicio →</a>
        </div>

        <!-- 03 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">🔐</div>
                <div class="card-title">03. Generador de Contraseñas</div>
            </div>
            <p class="card-desc">Genera contraseñas criptográficamente seguras con longitud y tipos de caracteres configurables, medidor de fuerza y copiado al portapapeles.</p>
            <div class="card-tags">
                <span class="tag">random_int()</span>
                <span class="tag">Fortaleza</span>
                <span class="tag">Clipboard</span>
            </div>
            <a href="ejercicio-03-generador-contrasenas/" class="card-btn">Abrir Ejercicio →</a>
        </div>

        <!-- 04 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">💸</div>
                <div class="card-title">04. Gestor de Gastos</div>
            </div>
            <p class="card-desc">Registra gastos diarios, categorízalos y consulta resúmenes mensuales con gráficos visuales de barras por categoría en CSS puro.</p>
            <div class="card-tags">
                <span class="tag">Categorías</span>
                <span class="tag">Resumen mensual</span>
                <span class="tag">Gráfico CSS</span>
            </div>
            <a href="ejercicio-04-gestor-gastos/" class="card-btn">Abrir Ejercicio →</a>
        </div>

        <!-- 05 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">📅</div>
                <div class="card-title">05. Sistema de Reservas</div>
            </div>
            <p class="card-desc">Permite reservar citas o servicios en línea, mostrando disponibilidad horaria en tiempo real y confirmación sin traslapes.</p>
            <div class="card-tags">
                <span class="tag">Disponibilidad</span>
                <span class="tag">Horarios</span>
                <span class="tag">Confirmación</span>
            </div>
            <a href="ejercicio-05-sistema-reservas/" class="card-btn">Abrir Ejercicio →</a>
        </div>

        <!-- 06 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">📔</div>
                <div class="card-title">06. Gestor de Notas</div>
            </div>
            <p class="card-desc">Escribe y guarda notas en diferentes categorías, colores personalizables estilo sticky notes y motor de búsqueda integrado.</p>
            <div class="card-tags">
                <span class="tag">Buscador</span>
                <span class="tag">Sticky Notes</span>
                <span class="tag">Colores</span>
            </div>
            <a href="ejercicio-06-gestor-notas/" class="card-btn">Abrir Ejercicio →</a>
        </div>

        <!-- 07 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">📆</div>
                <div class="card-title">07. Calendario de Eventos</div>
            </div>
            <p class="card-desc">Calendario interactivo mensual con cuadrícula generada dinámicamente en PHP, eventos categorizados por color y recordatorios.</p>
            <div class="card-tags">
                <span class="tag">Calendario PHP</span>
                <span class="tag">Eventos</span>
                <span class="tag">Recordatorios</span>
            </div>
            <a href="ejercicio-07-calendario-eventos/" class="card-btn">Abrir Ejercicio →</a>
        </div>

        <!-- 08 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">🍳</div>
                <div class="card-title">08. Plataforma de Recetas</div>
            </div>
            <p class="card-desc">Busca, guarda y comparte recetas de cocina con filtros avanzados por tipo de comida, ingredientes, tiempo y dificultad.</p>
            <div class="card-tags">
                <span class="tag">Filtros</span>
                <span class="tag">Ingredientes</span>
                <span class="tag">5 Recetas Demo</span>
            </div>
            <a href="ejercicio-08-plataforma-recetas/" class="card-btn">Abrir Ejercicio →</a>
        </div>

        <!-- 09 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">🃏</div>
                <div class="card-title">09. Juego de Memoria</div>
            </div>
            <p class="card-desc">Juego clásico de memoria con cartas de emojis, animación 3D CSS de volteo, 3 niveles de dificultad y tabla de mejores puntajes.</p>
            <div class="card-tags">
                <span class="tag">Flip 3D CSS</span>
                <span class="tag">3 Niveles</span>
                <span class="tag">Puntajes AJAX</span>
            </div>
            <a href="ejercicio-09-juego-memoria/" class="card-btn">Abrir Ejercicio →</a>
        </div>

        <!-- 10 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">📊</div>
                <div class="card-title">10. Plataforma de Encuestas</div>
            </div>
            <p class="card-desc">Crea y responde encuestas en línea con constructor dinámico, opciones múltiples, escala 1-5 e informes visuales de resultados.</p>
            <div class="card-tags">
                <span class="tag">Constructor JS</span>
                <span class="tag">Control de Voto</span>
                <span class="tag">Gráficos</span>
            </div>
            <a href="ejercicio-10-plataforma-encuestas/" class="card-btn">Abrir Ejercicio →</a>
        </div>

        <!-- 11 -->
        <div class="card">
            <div class="card-header">
                <div class="card-num">⏱️</div>
                <div class="card-title">11. Cronómetro Online</div>
            </div>
            <p class="card-desc">Cronómetro de precisión a 60fps con funciones de inicio, pausa, reinicio, registro de vueltas (rápida/lenta) y guardado de sesiones.</p>
            <div class="card-tags">
                <span class="tag">requestAnimationFrame</span>
                <span class="tag">Vueltas</span>
                <span class="tag">Atajos de Teclado</span>
            </div>
            <a href="ejercicio-11-cronometro-online/" class="card-btn">Abrir Ejercicio →</a>
        </div>
    </div>

    <footer>
        <p>Trabajo de Seguimiento — Programación Orientada a la Web con PHP</p>
        <p style="margin-top: .4rem;">Repositorio: <a href="https://github.com/programercastro16/SEGUIMIENTO-PO-PHP" target="_blank">github.com/programercastro16/SEGUIMIENTO-PO-PHP</a></p>
    </footer>
</div>
</body>
</html>
