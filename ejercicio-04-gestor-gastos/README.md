# Ejercicio 04 - Gestor de Gastos

**Materia:** Programación Orientada a la Web con PHP  
**Patrón:** MVC (Modelo-Vista-Controlador)

## Descripción
Aplicación web para registrar gastos diarios, categorizarlos y ver un resumen de gastos mensuales con gráfico visual por categoría.

## Funcionalidades
- ➕ Agregar gastos con descripción, monto, categoría y fecha
- ✏️ Editar gastos existentes
- 🗑️ Eliminar gastos
- 📅 Filtrar por mes y año
- 📊 Resumen mensual con gráfico de barras por categoría
- 🏷️ Categorías: Alimentación, Transporte, Entretenimiento, Salud, Educación, Hogar, Ropa, Tecnología, Otros

## Estructura MVC
- **Model:** `GastoModel` - persistencia en JSON con filtros y resumen
- **Views:** `gasto/index.php`, `gasto/form.php`, `gasto/resumen.php`
- **Controller:** `GastoController` - CRUD completo y resumen

## Ejecución
```bash
php -S localhost:8080
# Abrir: http://localhost:8080
```

