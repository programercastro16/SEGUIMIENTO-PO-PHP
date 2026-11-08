# Ejercicio 07 - Calendario de Eventos

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Modulo de calendario interactivo para la administracion y planeacion de actividades y compromisos temporales.

## Funcionalidades

- Generacion dinamica de cuadrilla mensual mediante funciones de fecha de PHP.
- Navegacion secuencial entre meses y años.
- Creacion, actualizacion y eliminacion de eventos asociados a fechas y horas especificas.
- Asignacion de categorias (Trabajo, Personal, Cumpleaños, Reunion, Recordatorio, Festivo, Otro).
- Vista individual detallada de actividades por jornada.
- Indicador de eventos con recordatorio habilitado.

## Componentes MVC

- Modelo: `EventoModel` (persistencia JSON y filtrado temporal por rango de fechas).
- Vistas: `evento/index.php`, `evento/form.php` y `evento/dia.php`.
- Controlador: `EventoController` (logica de calendario y operacion de eventos).

## Ejecucion

```bash
cd ejercicio-07-calendario-eventos
php -S localhost:8080
```
Acceso desde el navegador: `http://localhost:8080`.
