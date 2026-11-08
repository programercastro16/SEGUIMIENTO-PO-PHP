# Ejercicio 06 - Gestor de Notas

**Materia:** Programación Orientada a la Web con PHP  
**Patrón:** MVC (Modelo-Vista-Controlador)

## Descripción
Aplicación para escribir y organizar notas personales con categorías, búsqueda y notas de colores estilo sticky notes.

## Funcionalidades
- ✍️ Crear, editar y eliminar notas
- 🎨 Notas con colores personalizables (amarillo, azul, verde, rosa, morado, naranja, gris)
- 📂 Organizar por categorías
- 🔍 Búsqueda en título y contenido
- 👁️ Vista completa de nota

## Estructura MVC
- **Model:** `NotaModel` - persistencia en JSON con búsqueda y filtros
- **Views:** `nota/index.php`, `nota/form.php`, `nota/ver.php`
- **Controller:** `NotaController` - CRUD + búsqueda

## Ejecución
```bash
php -S localhost:8080
# Abrir: http://localhost:8080
```

