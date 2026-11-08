# Ejercicio 11 - Cronometro Online

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Herramienta de cronometraje digital de alta precision, desarrollada con logica de renderizado basada en `requestAnimationFrame` y registro persistente de sesiones.

## Funcionalidades

- Operaciones de inicio, pausa y reinicio de conteo.
- Toma de vueltas y tiempos parciales (Laps) con indicacion de mejores y peores registros.
- Guardado de sesiones con identificador nominal mediante peticiones asincronas JSON.
- Panel de historial de sesiones guardadas.
- Vista desglosada de vueltas por sesion registrada.
- Soporte para atajos de teclado (Barra espaciadora para inicio/pausa, tecla L para vuelta, tecla R para reinicio).

## Componentes MVC

- Modelo: `CronometroModel` (almacenamiento de sesiones cronometradas en `data/sesiones.json`).
- Vistas: `cronometro/index.php`, `cronometro/historial.php` y `cronometro/sesion.php`.
- Controlador: `CronometroController` (endpoints de API para almacenamiento y visualizacion de historiales).

## Ejecucion

```bash
cd ejercicio-11-cronometro-online
php -S localhost:8080
```
Acceso desde el navegador: `http://localhost:8080`.
