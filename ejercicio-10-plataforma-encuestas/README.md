# Ejercicio 10 - Plataforma de Encuestas

**Materia:** Programación Orientada a la Web con PHP  
**Patrón:** MVC (Modelo-Vista-Controlador)

## Descripción
Aplicación para crear y responder encuestas en línea con análisis visual de resultados mediante gráficos de barras CSS.

## Funcionalidades
- ➕ Crear encuestas con constructor dinámico de preguntas (JS)
- 3 tipos de preguntas: Opción múltiple, Verdadero/Falso, Escala 1-5
- 📝 Responder encuestas (con control de sesión para evitar doble respuesta)
- 📊 Ver resultados con gráficos de barras CSS por pregunta
- 🔒 Cerrar/Activar encuestas
- 🗑️ Eliminar encuestas y sus respuestas
- 📦 2 encuestas de ejemplo precargadas

## Estructura MVC
- **Model:** `EncuestaModel` - gestión de encuestas y respuestas en JSON
- **Views:** `encuesta/index.php`, `encuesta/administrar.php`, `encuesta/form.php`, `encuesta/responder.php`, `encuesta/resultados.php`
- **Controller:** `EncuestaController` - CRUD completo

## Ejecución
```bash
php -S localhost:8080
# Abrir: http://localhost:8080
```

