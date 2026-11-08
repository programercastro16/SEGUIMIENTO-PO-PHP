# Ejercicio 09 - Juego de Memoria

**Materia:** Programación Orientada a la Web con PHP  
**Patrón:** MVC (Modelo-Vista-Controlador)

## Descripción
Juego clásico de memoria con cartas de emojis, animación 3D de volteo, 3 niveles de dificultad y tabla de puntajes.

## Funcionalidades
- 🃏 Tablero generado dinámicamente desde PHP
- 🎴 Animación 3D CSS de volteo de cartas
- 3 niveles: Fácil (6 pares), Medio (10 pares), Difícil (16 pares)
- ⏱️ Contador de movimientos y cronómetro
- 🏆 Tabla de puntajes por nivel (top 10)
- 💾 Guardar puntaje con nombre del jugador (AJAX)
- 🥇🥈🥉 Medallas para el top 3

## Estructura MVC
- **Model:** `JuegoModel` - genera tablero aleatorio y gestiona puntajes en JSON
- **Views:** `juego/index.php`, `juego/jugar.php`, `juego/puntajes.php`
- **Controller:** `JuegoController` - lógica del juego y endpoint AJAX

## Ejecución
```bash
php -S localhost:8080
# Abrir: http://localhost:8080
```

