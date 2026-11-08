# Ejercicio 11 - Cronómetro Online

**Materia:** Programación Orientada a la Web con PHP  
**Patrón:** MVC (Modelo-Vista-Controlador)

## Descripción
Cronómetro web de alta precisión con funciones completas: inicio, pausa, reinicio, registro de vueltas y guardado de sesiones.

## Funcionalidades
- ▶️ Iniciar / ⏸ Pausar / 🔄 Reiniciar
- 🏁 Registrar vueltas con tiempo parcial y tiempo total
- 🏆 Vuelta más rápida resaltada en verde
- 🐌 Vuelta más lenta resaltada en rojo
- 💾 Guardar sesión con nombre personalizado (AJAX)
- 📋 Historial de sesiones guardadas
- 👁️ Ver detalle de cada sesión con tabla de vueltas
- ⌨️ Atajos de teclado (Espacio, L, R)
- 🌙 Diseño dark theme con display estilo cronómetro real

## Atajos de Teclado
| Tecla | Acción |
|-------|--------|
| `Espacio` | Iniciar / Pausar |
| `L` | Registrar vuelta |
| `R` | Reiniciar |

## Estructura MVC
- **Model:** `CronometroModel` - persistencia de sesiones y vueltas en JSON
- **Views:** `cronometro/index.php`, `cronometro/historial.php`, `cronometro/sesion.php`
- **Controller:** `CronometroController` - endpoints para guardar/recuperar sesiones (AJAX)

## Precisión
Usa `requestAnimationFrame` + `Date.now()` para actualización a ~60fps sin drift acumulativo.

## Ejecución
```bash
php -S localhost:8080
# Abrir: http://localhost:8080
```
