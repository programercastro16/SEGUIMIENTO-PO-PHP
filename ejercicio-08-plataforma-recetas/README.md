# Ejercicio 08 - Plataforma de Recetas

**Materia:** Programación Orientada a la Web con PHP  
**Patrón:** MVC (Modelo-Vista-Controlador)

## Descripción
Sitio web para buscar, guardar y compartir recetas de cocina con opciones de filtrado por tipo de comida, ingredientes, tiempo y dificultad.

## Funcionalidades
- 🍳 Listar recetas con vista de tarjetas
- 🔍 Búsqueda por título, descripción e ingredientes
- 🏷️ Filtros: tipo de comida, dificultad, tiempo máximo
- ➕ Crear nuevas recetas con ingredientes e instrucciones
- ✏️ Editar y 🗑️ eliminar recetas
- 📄 Vista detallada con ingredientes y pasos numerados
- 📦 5 recetas de ejemplo precargadas

## Estructura MVC
- **Model:** `RecetaModel` - persistencia en JSON con datos de ejemplo
- **Views:** `receta/index.php`, `receta/ver.php`, `receta/form.php`
- **Controller:** `RecetaController` - CRUD completo con filtros

## Ejecución
```bash
php -S localhost:8080
# Abrir: http://localhost:8080
```

