# Ejercicio 01 - Lista de Tareas

**Materia:** Programación Orientada a la Web con PHP  
**Patrón:** MVC (Modelo-Vista-Controlador)

## Descripción
Aplicación web para gestionar tareas pendientes. Permite agregar, eliminar y marcar tareas como completadas.

## Funcionalidades
- ✅ Agregar nuevas tareas
- 🗑️ Eliminar tareas
- ☑️ Marcar/desmarcar como completada
- 🔍 Filtrar por: Todas / Pendientes / Completadas
- 📊 Contador de tareas

## Estructura MVC
- **Model:** `TareasModel` - gestiona persistencia en JSON (`data/tareas.json`)
- **View:** `tareas/index.php` - interfaz de usuario
- **Controller:** `TareasController` - lógica de negocio

## Estructura de Archivos
```
ejercicio-01-lista-tareas/
├── index.php                        ← Front Controller
├── .htaccess                        ← Rewrite rules
├── README.md
├── app/
│   ├── core/
│   │   ├── App.php                  ← Router
│   │   ├── Controller.php           ← Base Controller
│   │   └── Model.php                ← Base Model
│   ├── controllers/
│   │   └── TareasController.php
│   ├── models/
│   │   └── TareasModel.php
│   └── views/
│       └── tareas/
│           └── index.php            ← Vista principal
├── data/
│   └── tareas.json                  ← Persistencia (auto-generado)
└── public/
    └── css/
        └── style.css
```

## Ejecución con PHP Built-in Server
```bash
cd ejercicio-01-lista-tareas
php -S localhost:8080
```
Luego abrir: **http://localhost:8080**

## Ejecución con Apache / XAMPP
Colocar la carpeta en `htdocs/` y acceder a:  
**http://localhost/ejercicio-01-lista-tareas/**

## Rutas del Controlador
| Método | URL                          | Acción                        |
|--------|------------------------------|-------------------------------|
| GET    | `index.php`                  | Lista todas las tareas        |
| GET    | `index.php?filter=pendientes`| Filtra tareas pendientes      |
| GET    | `index.php?filter=completadas`| Filtra tareas completadas    |
| POST   | `index.php?url=tareas/agregar`| Agrega nueva tarea           |
| POST   | `index.php?url=tareas/eliminar`| Elimina tarea por ID        |
| POST   | `index.php?url=tareas/completar`| Alterna estado completada  |

## Notas Técnicas
- Persistencia en JSON: no requiere base de datos
- Sin JavaScript (formularios HTML puros con POST)
- Mensajes flash con `$_SESSION`
- Validación: título no vacío, máximo 200 caracteres
- IDs únicos con `uniqid()`
