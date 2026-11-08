# Ejercicio 04 - Gestor de Gastos

- Materia: Programacion Orientada a la Web con PHP
- Arquitectura: MVC (Modelo-Vista-Controlador)

## Descripcion

Sistema para el control y seguimiento de gastos personales diarios, organizados por categorias predeterminadas y con consolidado mensual.

## Funcionalidades

- Registro, edicion y eliminacion de transacciones de gasto.
- Clasificacion por categorias (Alimentacion, Transporte, Entretenimiento, Salud, Educacion, Hogar, Ropa, Tecnologia, Otros).
- Filtro por periodo (mes y año).
- Resumen financiero mensual con graficos comparativos de distribucion porcentual por categoria.

## Componentes MVC

- Modelo: `GastoModel` (operaciones CRUD y calculos agregados en `data/gastos.json`).
- Vistas: `gasto/index.php`, `gasto/form.php` y `gasto/resumen.php`.
- Controlador: `GastoController` (administracion de flujos y logica de filtros).

## Ejecucion

```bash
cd ejercicio-04-gestor-gastos
php -S localhost:8080
```
Acceso desde el navegador: `http://localhost:8080`.
