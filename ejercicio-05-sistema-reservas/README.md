# Ejercicio 05 - Sistema de Reservas

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Plataforma orientada al agendamiento de citas y servicios en linea. Incorpora validacion de franjas horarias disponibles para prevenir solapamientos de reservas.

## Funcionalidades

- Listado general de citas con filtrado segun estado (pendiente, confirmada, cancelada).
- Formulario de agendamiento con seleccion de cliente, servicio, fecha y hora.
- Validacion en servidor de cupos y horarios libres.
- Confirmacion y cancelacion de citas existentes.
- Catalogo de servicios definidos con tiempos de duracion y tarifas.

## Componentes MVC

- Modelo: `ReservaModel` (gestion de persistencia de reservas y reglas de disponibilidad).
- Vistas: `reserva/index.php`, `reserva/form.php`.
- Controlador: `ReservaController` (orquestacion de estados y verificaciones).

## Ejecucion

```bash
cd ejercicio-05-sistema-reservas
php -S localhost:8080
```
Acceso desde el navegador: `http://localhost:8080`.
