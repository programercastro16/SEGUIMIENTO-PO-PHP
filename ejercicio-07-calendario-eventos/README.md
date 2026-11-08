# Ejercicio 07 - Calendario de Eventos

**Materia:** Programación Orientada a la Web con PHP  
**Patrón:** MVC (Modelo-Vista-Controlador)

## Descripción
Calendario interactivo donde los usuarios pueden agregar, editar y eliminar eventos con funcionalidades de recordatorios y categorías por color.

## Funcionalidades
- 📆 Vista de calendario mensual con navegación
- ➕ Crear, editar y eliminar eventos
- 📋 Vista detallada por día
- 📌 Próximos eventos (7 días)
- 🏷️ Categorías: Trabajo, Personal, Cumpleaños, Reunión, Recordatorio, Festivo, Otro

## Estructura MVC
- **Model:** `EventoModel` - persistencia en JSON con filtros por fecha
- **Views:** `evento/index.php`, `evento/form.php`, `evento/dia.php`
- **Controller:** `EventoController` - CRUD + navegación mensual

## Ejecución
```bash
php -S localhost:8080
# Abrir: http://localhost:8080
```

