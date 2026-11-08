# Ejercicio 09 - Juego de Memoria

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Implementacion del juego de concentracion y emparejamiento de tarjetas en tablero. Incluye control de intentos, temporizador de sesion y registro de mejores desempeños.

## Funcionalidades

- Configuracion de tablero y dispersion de pares generada desde el backend PHP.
- Animacion de volteo de tarjetas mediante transformaciones tridimensionales en CSS.
- Tres niveles de dificultad: Facil (6 pares), Medio (10 pares) y Dificil (16 pares).
- Cronometro y contador de movimientos en tiempo real.
- Ventana de finalizacion con guardado asincrono de puntuaciones (AJAX / Fetch API).
- Cuadro de clasificacion general por nivel.

## Componentes MVC

- Modelo: `JuegoModel` (construccion de tableros y almacenamiento de marcas en `data/puntajes.json`).
- Vistas: `juego/index.php`, `juego/jugar.php` y `juego/puntajes.php`.
- Controlador: `JuegoController` (coordinacion de partidas y recepcion de puntajes).

## Ejecucion

```bash
cd ejercicio-09-juego-memoria
php -S localhost:8080
```
Acceso desde el navegador: `http://localhost:8080`.
